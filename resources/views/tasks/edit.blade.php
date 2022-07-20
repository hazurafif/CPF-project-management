@extends('layouts.layout-dash')
@section('content-data')
@section('content')

    <div>
        <div class="float-start">
            <h4 class="pb-3" style="font-weight: bold; color: black">Edit Task <span class="badge bg-info">{{ $task->title }}</span></h4>
        </div>
        <div class="float-end">
            <a href="{{ route('tasks.index') }}" class="btn btn-info">
                <i class="fa fa-arrow-left"></i> All Task
            </a>
        </div>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="clearfix"></div>
    </div>
    <div class="card card-body bg-light p-4">
        <form action="{{ route('tasks.update', $task->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            @if($task->status == 'Finished' && auth()->user()->can('title-edit') && auth()->user()->can('edit-finished-task'))
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $task->title }}">
                </div>
            @elseif($task->status != 'Finished' && auth()->user()->can('title-edit'))
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $task->title }}">
                </div>
            @elseif($task->status == 'Finished' || auth()->user()->cannot('title-edit'))
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" readonly class="form-control" id="title" name="title" value="{{ $task->title }}">
                </div>
            @endif
            @if($task->status == 'Finished' && auth()->user()->can('pic-edit') && auth()->user()->can('edit-finished-task'))
                <div class="mb-3">
                    <label for="pic" class="form-label">PIC</label>
                    <select name="pic" id="pic" class="form-control">
                    <option value="{{ $task->pic }}" selected>{{ $task->pic }}</option>
                    @foreach ($users as $user)
                        @if ($user->hasPermissionTo('can-be-pic') && $user->name != $task->pic)
                            <option value="{{ $user->name }}">{{ $user->name }}</option>
                        @endif
                    @endforeach
                    </select>
                </div>
            @elseif($task->status != 'Finished' && auth()->user()->can('pic-edit'))
                <div class="mb-3">
                    <label for="pic" class="form-label">PIC</label>
                    <select name="pic" id="pic" class="form-control">
                    <option value="{{ $task->pic }}" selected>{{ $task->pic }}</option>
                    @foreach ($users as $user)
                        @if ($user->hasPermissionTo('can-be-pic') && $user->name != $task->pic)
                            <option value="{{ $user->name }}">{{ $user->name }}</option>
                        @endif
                    @endforeach
                    </select>
                </div>
            @elseif($task->status == 'Finished' || auth()->user()->cannot('pic-edit'))
                <div class="mb-3">
                    <label for="pic" class="form-label">PIC</label>
                    <input type="text" readonly class="form-control" id="pic" name="pic" value="{{ $task->pic }}">
                </div>
            @endif
            @if($task->status == 'Finished' && auth()->user()->can('start-edit') && auth()->user()->can('edit-finished-task'))
                <div class="mb-3">
                    <label for="start" class="form-label">Start Project</label>
                    <input type="date" class="form-control" id="start" name="start"  value="{{ $task->start }}">
                </div>
            @elseif ($task->status != 'Finished' && auth()->user()->can('start-edit'))
                <div class="mb-3">
                    <label for="start" class="form-label">Start Project</label>
                    <input type="date" class="form-control" id="start" name="start"  value="{{ $task->start }}">
                </div>
            @elseif ($task->status == 'Finished' || auth()->user()->cannot('start-edit'))
                <div class="mb-3">
                    <label for="start" class="form-label">Start Project</label>
                    <input type="date" readonly class="form-control" id="start" name="start"  value="{{ $task->start }}">
                </div>
            @endif
            @if($task->status == 'Finished' && auth()->user()->can('deadline-edit') && auth()->user()->can('edit-finished-task'))
                <div class="mb-3">
                    <label for="end" class="form-label">Deadline Project</label>
                    <input type="date" class="form-control" id="end" name="end"  value="{{ $task->end }}">
                </div>
            @elseif ($task->status != 'Finished' && auth()->user()->can('deadline-edit'))
                <div class="mb-3">
                    <label for="end" class="form-label">Deadline Project</label>
                    <input type="date" class="form-control" id="end" name="end"  value="{{ $task->end }}">
                </div>
            @elseif ($task->status == 'Finished' || auth()->user()->cannot('deadline-edit'))
                <div class="mb-3">
                    <label for="end" class="form-label">Deadline Project: </label><br>
                    <input type="date" readonly class="form-control" id="end" name="end"  value="{{ $task->end }}">
                </div>
            @endif
            @if ($task->status == 'Delayed' && auth()->user()->can('delay-edit'))
                <div class="mb-3">
                    <label for="delay" class="form-label">Delayed Deadline</label>
                    <input type="date" class="form-control" id="delay" name="delay" value={{ $task->delay }}>
                </div>
            @elseif ($task->status == 'Finished' && auth()->user()->can('delay-edit') && auth()->user()->can('edit-finished-task'))
                <div class="mb-3">
                    <label for="delay" class="form-label">Delayed Deadline</label>
                    <input type="date" class="form-control" id="delay" name="delay" value={{ $task->delay }}>
                </div>
            @elseif ($task->status == 'Finished' && auth()->user()->cannot('edit-finished-task'))
                @if ($task->delay)
                    <div class="mb-3">
                        <label for="delay" class="form-label">Delayed Deadline</label>
                        <input type="date" readonly class="form-control" id="delay" name="delay" value={{ $task->delay }}>
                    </div>
                @endif
            @endif
            @if($task->status == 'Finished' && auth()->user()->can('description-edit') && auth()->user()->can('edit-finished-task'))
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea type="text" class="form-control" id="description" name="description" rows="5">{{ $task->description }}</textarea>
                </div>
            @elseif ($task->status != 'Finished' && auth()->user()->can('description-edit'))
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea type="text" class="form-control" id="description" name="description" rows="5">{{ $task->description }}</textarea>
                </div>
            @elseif ($task->status == 'Finished' || auth()->user()->cannot('description-edit'))
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea type="text" readonly class="form-control" id="description" name="description" rows="5">{{ $task->description }}</textarea>
                </div>
            @endif
            @if($task->status == 'Finished' && auth()->user()->can('picdescription-edit') && auth()->user()->can('edit-finished-task'))
                <div class="mb-3">
                    <label for="picdescription" class="form-label">PIC Comment</label>
                    <textarea type="text" class="form-control" id="picdescription" name="picdescription" rows="5">{{ $task->picdescription }}</textarea>
                </div>
            @elseif ($task->status != 'Finished' && auth()->user()->can('picdescription-edit'))
                <div class="mb-3">
                    <label for="picdescription" class="form-label">PIC Comment</label>
                    <textarea type="text" class="form-control" id="picdescription" name="picdescription" rows="5">{{ $task->picdescription }}</textarea>
                </div>
            @elseif ($task->status == 'Finished' || auth()->user()->cannot('picdescription-edit'))
                <div class="mb-3">
                    <label for="picdescription" class="form-label">PIC Comment</label>
                    <textarea type="text" readonly class="form-control" id="picdescription" name="picdescription" rows="5">{{ $task->picdescription }}</textarea>
                </div>
            @endif
            @if($task->status == 'Finished' && auth()->user()->can('upload-edit') && auth()->user()->can('edit-finished-task'))
                <div class="mb-3">
                    <label for="upload" class="form-label">Upload File</label><br>
                    <input type="file" name="file"><br><br>
                </div>
            @elseif ($task->status != 'Finished' && auth()->user()->can('upload-edit'))
                <div class="mb-3">
                    <label for="upload" class="form-label">Upload File</label><br>
                    <input type="file" name="file"><br><br>
                </div>
            @elseif ($task->status == 'Finished' || auth()->user()->cannot('upload-edit'))
                <div class="mb-3">
                    <label for="formFileDisabled" class="form-label">Upload File</label><br>
                    <input class="form-control" type="file" id="formFileDisabled" disabled><br>
                </div>
            @endif
            <div class="mb-3">
                <label for="upload" class="form-label">Previous File</label><br>
                @if ($task->file)
                    {{ $task->file }}
                @else
                No file uploaded.
                @endif
            </div>
            @if($task->status == 'Finished' && auth()->user()->can('picupload-edit') && auth()->user()->can('edit-finished-task'))
                <div class="mb-3">
                    <label for="upload" class="form-label">PIC Upload File</label><br>
                    <input type="file" name="picfile"><br><br>
                </div>
            @elseif ($task->status != 'Finished' && auth()->user()->can('picupload-edit'))
                <div class="mb-3">
                    <label for="upload" class="form-label">PIC Upload File</label><br>
                    <input type="file" name="picfile"><br><br>
                </div>
            @elseif ($task->status == 'Finished' || auth()->user()->cannot('picupload-edit'))
                <div class="mb-3">
                    <label for="formFileDisabled" class="form-label">PIC Upload File</label><br>
                    <input class="form-control" type="file" id="formFileDisabled" disabled><br>
                </div>
            @endif
            <div class="mb-3">
                <label for="upload" class="form-label">Previous PIC File</label><br>
                @if ($task->picfile)
                    {{ $task->picfile }}
                @else
                No file uploaded.
                @endif
            </div>
            @if($task->status == 'Finished' && auth()->user()->can('status-edit') && auth()->user()->can('edit-finished-task'))
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control">
                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}" {{ $task->status === $status['value'] ? 'selected' : ''}}>{{ $status['label'] }}</option>
                        @endforeach
                    </select>
                </div>
            @elseif ($task->status != 'Finished' && auth()->user()->can('status-edit'))
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control">
                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}" {{ $task->status === $status['value'] ? 'selected' : ''}}>{{ $status['label'] }}</option>
                        @endforeach
                    </select>
                </div>
            @elseif ($task->status == 'Finished' || auth()->user()->cannot('status-edit'))
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <input type="text" readonly class="form-control" id="status" name="status" value="{{ $task->status }}">
                </div>
            @endif

            <button type="submit" class="btn btn-primary">
                <i class="fa fa-check"></i> Save
            </button>
        </form>
    </div>
@endsection
@endsection
