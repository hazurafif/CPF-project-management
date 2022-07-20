<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function dash(){
        $data=Task::all();
        $user=User::all();
        $task_list = DB::table('tasks')
                    ->select('tasks.id' ,'tasks.title', 'tasks.pic', 'users.name', 'users.image', 'tasks.start', 'tasks.end', 'tasks.delay', 'tasks.status', 'tasks.file', 'tasks.picfile', 'tasks.created_at')
                    ->join('users', 'tasks.user_id', '=', 'users.id')
                    ->orderBy('created_at', 'desc')
                    ->simplePaginate(6);
        $OngoingCount = Task::where('status', 'Ongoing')->count();
        $DelayedCount = Task::where('status', 'Delayed')->count();
        $FinishedCount = Task::where('status', 'Finished')->count();
        return view('home', compact('OngoingCount', 'DelayedCount', 'FinishedCount', 'task_list'));



    }

    public function search(Request $request)
    {
        $term =  $request->input('term');
        $task_list = DB::table('tasks')
            ->select('tasks.id', 'tasks.title', 'tasks.pic', 'users.name', 'users.image', 'tasks.start', 'tasks.end', 'tasks.delay', 'tasks.status', 'tasks.file', 'tasks.picfile', 'tasks.created_at')
            ->join('users', 'tasks.user_id', '=', 'users.id')
            ->where(function ($query) use ($request) {
                if (($term = $request->term)) $query->orWhere('tasks.title', 'LIKE', '%' . $term . '%')->orWhere('users.name', 'LIKE', '%' . $term . '%');
            })
            ->orderBy('created_at', 'desc')
            ->simplePaginate(6);
        $task_list->appends(['term' => $term]);
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

        return view('home', compact('OngoingCount', 'DelayedCount', 'FinishedCount', 'task_list'));
    }
}
