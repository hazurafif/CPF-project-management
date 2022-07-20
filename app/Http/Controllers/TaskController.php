<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Exports\TaskExport;
use App\Exports\TaskExportSearch;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:task-list|task-create|task-edit|task-delete', ['only' => ['index','store']]);
         $this->middleware('permission:task-create', ['only' => ['create','store']]);
         $this->middleware('permission:task-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:task-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $tasks = Task::orderBy('created_at', 'desc')->paginate(6);
        $OngoingCount = Task::where('status', 'Ongoing')->count();
        $DelayedCount = Task::where('status', 'Delayed')->count();
        $FinishedCount = Task::where('status', 'Finished')->count();
        // $now = Carbon::now()->toDateString();
        // foreach($tasks as $task)
        // {
        //     if($now == $task->end)
        //     {
        //         $task->status = 'Ongoing';
        //         $task->update();
        //     }
        //     else if($now > $task->end)
        //     {
        //         $task->status = 'Delayed';
        //         $task->update();
        //     }
        // }
        $task_list = DB::table('tasks')
                    ->select('tasks.id' ,'tasks.title', 'users.name', 'tasks.start', 'tasks.end', 'tasks.delay', 'tasks.status', 'tasks.file', 'tasks.picfile', 'tasks.created_at', 'tasks.user_id')
                    ->join('users', 'tasks.user_id', '=', 'users.id')
                    ->orderBy('created_at', 'desc')
                    ->simplePaginate(5);

        return view('tasks.index', compact('tasks', 'OngoingCount', 'DelayedCount', 'FinishedCount', 'task_list'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function search(Request $request)
    {
        $term =  $request->input('term');
        $tasks = Task::orderBy('created_at', 'desc')->paginate(5);
        $OngoingCount = Task::where(function ($query) use ($request) {
            if (($term = $request->term)) $query->Where('title', 'LIKE', '%' . $term . '%')->orWhere('tasks.pic', 'LIKE', '%' . $term . '%');
        })
            ->Where('status', 'Ongoing')
            ->count();
        $DelayedCount = Task::where(function ($query) use ($request) {
            if (($term = $request->term)) $query->Where('title', 'LIKE', '%' . $term . '%')->orWhere('tasks.pic', 'LIKE', '%' . $term . '%');
        })
            ->where('status', 'Delayed')
            ->count();
        $FinishedCount = Task::where(function ($query) use ($request) {
            if (($term = $request->term)) $query->Where('title', 'LIKE', '%' . $term . '%')->orWhere('tasks.pic', 'LIKE', '%' . $term . '%');
        })
            ->where('status', 'Finished')
            ->count();
        $task_list = DB::table('tasks')
                    ->select('tasks.id' ,'tasks.title', 'users.name', 'tasks.start', 'tasks.end', 'tasks.delay', 'tasks.status', 'tasks.file', 'tasks.picfile', 'tasks.created_at', 'tasks.user_id')
                    ->join('users', 'tasks.user_id', '=', 'users.id')
                    ->where(function ($query) use ($request) {
                        if (($term = $request->term)) $query->orWhere('tasks.title', 'LIKE', '%' . $term . '%')->orWhere('users.name', 'LIKE', '%' . $term . '%');
                    })
                    ->orderBy('created_at', 'desc')
                    ->simplePaginate(5);
                    $task_list->appends(['term' => $term]);

        return view('tasks.index', compact('tasks', 'OngoingCount', 'DelayedCount', 'FinishedCount', 'task_list'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = [
            [
                'label' => 'Ongoing',
                'value' => 'Ongoing',
            ],
            [
                'label' => 'Delayed',
                'value' => 'Delayed',
            ],
            [
                'label' => 'Finished',
                'value' => 'Finished',
            ]
        ];
        $users = User::all();
        return view('tasks.create', compact('statuses', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request ->validate([
            'title' => 'required',
            'start' => 'required',
            'end' => 'required',
            'file' => 'mimes:png,jpg,pdf,doc,docx,xls,ppt,csv,txt',
            'picfile' => 'mimes:png,jpg,pdf,doc,docx,xls,ppt,csv,txt',
        ]);
        $now = Carbon::now()->toDateString();
        $task = new Task();
        $user = new User();
        if($request->hasFile('file'))
        {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $request->file->move('assets', $filename);
            $task->file = $filename;
        }
        if($request->hasFile('picfile'))
        {
            $picfile = $request->file('picfile');
            $filename = $picfile->getClientOriginalName();
            $request->picfile->move('assets', $filename);
            $task->picfile = $filename;
        }
        $task->title = $request->title;
        $task->pic = $request->pic;

        $pic_id = DB::table('users')
                    ->select('id')
                    ->where('name', 'LIKE', $request->pic)
                    ->first();
        $task->user_id = $pic_id->id;

        $task->start = $request->start;
        $task->end = $request->end;
        $task->description = $request->description;
        $task->picdescription = $request->picdescription;
        $task->status = $request->status;
        if($request->status == 'Finished')
        {
            $request->status == 'Finished';
        }
        elseif($now == $task->end)
        {
            $task->status = 'Ongoing';
            $task->save();
        }
        else if($now > $task->end)
        {
            $task->status = 'Delayed';
            $task->save();
        }
        $task->save();
        return redirect()->route('tasks.index')
            ->with('success', 'Product created succesfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('tasks.show',compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $statuses = [
            [
                'label' => 'Ongoing',
                'value' => 'Ongoing',
            ],
            [
                'label' => 'Delayed',
                'value' => 'Delayed',
            ],
            [
                'label' => 'Finished',
                'value' => 'Finished'
            ]
        ];
        $users = User::all();
        return view('tasks.edit', compact('statuses', 'task','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $now = Carbon::now()->toDateString();
        $task = Task::findOrFail($id);
        $request ->validate([
            'title' => 'required',
            'pic' => 'required',
            'start' => 'required',
            'end' => 'required',
            'file' => 'mimes:png,jpg,pdf,doc,docx,xls,ppt,csv,txt',
            'picfile' => 'mimes:png,jpg,pdf,doc,docx,xls,ppt,csv,txt',
        ]);
        if($request->hasFile('file'))
        {
            $datafile = public_path('/assets/').$task->file;
            if(file_exists($datafile))
            {
                @unlink($datafile);
            }
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $request->file->move('assets', $filename);
            $task->file = $filename;
        }
        if($request->hasFile('picfile'))
        {
            $datapicfile = public_path('/assets/').$task->picfile;
            if(file_exists($datapicfile))
            {
                @unlink($datapicfile);
            }
            $picfile = $request->file('picfile');
            $filename = $picfile->getClientOriginalName();
            $request->picfile->move('assets', $filename);
            $task->picfile = $filename;
        }
        $task->title = $request->title;
        $task->pic = $request->pic;
        $pic_id = DB::table('users')
                    ->select('id')
                    ->where('name', 'LIKE', $request->pic)
                    ->first();
        $task->user_id = $pic_id->id;
        $task->start = $request->start;
        $task->end = $request->end;
        $task->delay = $request->delay;
        $task->description = $request->description;
        $task->picdescription = $request->picdescription;
        $task->status = $request->status;
        if($request->status == 'Finished')
        {
            $request->status == 'Finished';
        }
        elseif($now == $task->end)
        {
            $task->status = 'Ongoing';
            $task->update();
        }
        else if($now > $task->end)
        {
            $task->status = 'Delayed';
            $task->update();
        }
        $task->update();
        return redirect()->route('tasks.index')
            ->with('success','Task updated successfully');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        $file = public_path('/assets/').$task->file;
        if(file_exists($file))
        {
            @unlink($file);
        }
        return redirect()->route('tasks.index')
            ->with('success','Task deleted successfully');;
    }
    public function download(Request $request,$file)
    {
        return response()->download(public_path('assets/'.$file));
    }
    public function picdownload(Request $request,$picfile)
    {
        return response()->download(public_path('assets/'.$picfile));
    }
    public function export_excel(Request $request)
    {
        if (($term = $request->term)) {
            return Excel::download(new TaskExportSearch($term), 'project.xlsx');
        } else {
            // dd("test");
            return Excel::download(new TaskExport, 'project.xlsx');
        }
    }
}
