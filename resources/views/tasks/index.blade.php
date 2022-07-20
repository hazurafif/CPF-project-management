@extends('layouts.layout-dash')
@section('content-data')
@section('content')

<div class="row"style="margin-bottom: 2%" >
    <div class="col-lg-12 margin-tb" >
        <div class="pull-left">
            <h2 style="font-weight: bold; color: black">Project</h2>
        </div>
        {{-- Expoer new --}}
        <a href="/export{{  request()->exists('term') ? '?' . request()->getQueryString() : '' }}" class="btn btn-success my-3 pull-right" target="_blank">Export Excel</a>
    </div>
</div>

    {{-- <small style="margin-left: 3%;font-weight: bold; color: black; font-size: 16px" >Total Task: |  </small> --}}
    <small style="margin-left: 5vw;font-weight: bold; color: black; font-size: 16px" >Total Task: | {{ $FinishedCount + $OngoingCount + $DelayedCount }} </small>
    <small style="margin-left: 7vw;font-weight: bold; color: black; font-size: 16px">On Going:| {{ $OngoingCount }} </small>
    <small style="margin-left: 9vw;font-weight: bold; color: black; font-size: 16px" >Delayed:  | {{ $DelayedCount }} </small>
    <small style="margin-left: 11vw;font-weight: bold; color: black; font-size: 16px" >Completed: | {{ $FinishedCount }} </small>

    <br>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

<br>
<div class="card">
    <div class="card-body" >
    <table class="table table-bordered" style="color: black" >
        <tr >
            <th style="border-color: black">No</th>
            <th style="border-color: black">Task Name</th>
            <th style="border-color: black">PIC</th>
            <th style="border-color: black">Start Project</th>
            <th style="border-color: black">Deadline Project</th>
            <th style="border-color: black">Delayed Deadline</th>
            <th style="border-color: black">Status</th>
            <th style="border-color: black">Action</th>
        </tr>



	    {{-- @foreach ($tasks as $task)
        @if ($task->status != 'Delayed')
        @php
            $task->delay = null;
        @endphp
        @endif
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $task->title }}</td> --}}
	        {{-- <td>{{ $task->users()->select('name')
                                ->where('id', '=', $task->user_id)
                                ->first()->name}}</td> --}}
            {{-- <td>{{ $task->pic }}</td>
	        <td>{{ $task->start }}</td>
	        <td>{{ $task->end }}</td>
	        <td>
                @if ($task->delay)
                    {{ $task->delay }}
                @else
                    -
                @endif
            </td>
	        <td>
            @if ($task->status === "Ongoing")
                <span class="badge rounded-pill bg-info text-dark">
                    {{ $task->status }}
                </span>
            @elseif ($task->status === "Delayed")
                <span class="badge rounded-pill bg-danger text-white">
                    {{ $task->status }}
                </span>
            @else
                <span class="badge rounded-pill bg-success text-white">
                    {{ $task->status }}
                </span>
            @endif
            </td>
	        <td>
                <form action="{{ route('tasks.destroy',$task->id) }}" method="POST">
                    @if ($task->file)
                        <a href="{{ url('download', $task->file) }}" class="btn btn-secondary">
                        <i class="fa fa-download" style="color: white"></i>
                        </a>
                    @endif
                    <a class="btn btn-info" style="color: white" href="{{ route('tasks.show',$task->id) }}"><i class="fas fa-eye"></i></a>
                    @can('task-edit')
                    <a class="btn btn-primary" href="{{ route('tasks.edit',$task->id) }}"><i class="fa fa-edit"></i></a>
                    @endcan


                    @csrf
                    @method('DELETE')
                    @can('task-delete')
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-trash"></i>
                    </button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table> --}}
    @foreach ($task_list as $item)
        @if ($item->status != 'Delayed')
        @php
            $item->delay = null;
        @endphp
        @endif
	    <tr>
	        <td style="border-color: black">{{ ++$i }}</td>
	        <td style="border-color: black" >{{ $item->title }}</td>
            <td style="border-color: black">
                @if ($item->user_id === 1)
                    -
                @else
                    {{ $item->name }}
                @endif
            </td>
	        <td style="border-color: black">{{ $item->start }}</td>
	        <td style="border-color: black">{{ $item->end }}</td>
	        <td style="border-color: black">
                @if ($item->delay)
                    {{ $item->delay }}
                @else
                    -
                @endif
            </td>
	        <td style="border-color: black">
            @if ($item->status === "Ongoing")
                <span class="badge rounded-pill bg-info text-dark">
                    {{ $item->status }}
                </span>
            @elseif ($item->status === "Delayed")
                <span class="badge rounded-pill bg-danger text-white">
                    {{ $item->status }}
                </span>
            @else
                <span class="badge rounded-pill bg-success text-white">
                    {{ $item->status }}
                </span>
            @endif
            </td>
	        <td style="border-color: black" width="40%">
                <form action="{{ route('tasks.destroy',$item->id) }}" method="POST">
                    @if ($item->file)
                        <a href="{{ url('download', $item->file) }}" class="btn btn-secondary">
                        <i class="fa fa-download" style="color: white"></i>
                        </a>
                    @endif
                    @if ($item->picfile)
                        <a href="{{ url('picdownload', $item->picfile) }}" class="btn btn-danger">
                        <i class="fa fa-download" style="color: white"></i>
                        </a>
                    @endif
                    <a class="btn btn-info" style="color: white" href="{{ route('tasks.show',$item->id) }}"><i class="fas fa-eye"></i></a>
                    @if ($item->name == auth()->user()->name)
                        @if(auth()->user()->can('task-edit') && $item->status != "Finished")
                            <a class="btn btn-primary" href="{{ route('tasks.edit',$item->id) }}"><i class="fa fa-edit"></i></a>
                        @elseif(auth()->user()->can('task-edit') && $item->status = "Finished" && auth()->user()->can('edit-finished-task'))
                            <a class="btn btn-primary" href="{{ route('tasks.edit',$item->id) }}"><i class="fa fa-edit"></i></a>
                        @endif
                    @endif
                    @if(auth()->user()->can('edit-all-task') && auth()->user()->can('task-edit'))
                        <a class="btn btn-primary" href="{{ route('tasks.edit',$item->id) }}"><i class="fa fa-edit"></i></a>
                    @endif

                    @csrf
                    @method('DELETE')
                    @can('task-delete')
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-trash"></i>
                    </button>
                    @endcan
                </form>
	        </td>
	    </tr>

	    @endforeach

    </table>
   <h6 style="font-size: 1em; color: black">{{ $task_list->links() }}</h6>
</div>

</div>


    <nav class="navbar-task " style="background-color: #ffff; border-radius: 20px; height: 40px; ">
        <div class="pull-right mb-4" style="margin-left: 46vw; margin-top: 1vh" >
            @can('task-create')
            <a  href="{{ route('tasks.create') }}" style="color: black ">
            <span class="iconify" data-icon="akar-icons:circle-plus-fill" style="font-size: 20px; margin-right: 1em">
            </span>Create New Task </a>
            @endcan
        </div>
    </nav>
@endsection
@endsection

