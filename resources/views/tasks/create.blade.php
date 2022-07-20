@extends('layouts.layout-dash')
@section('content-data')
@section('content')
    <div>
        <div class="float-start">
            <h4 class="pb-3" style="font-weight: bold; color: black">Create Tasks</h4>
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
        <form action="{{ route('tasks.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @can('title-create-task')
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title">
                </div>
            @endcan
            @cannot('title-create-task')
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" readonly class="form-control" id="title" name="title">
                </div>
            @endcannot
            @can('pic-create-task')
            <div class="mb-3">
                <label for="pic" class="form-label">PIC</label>
                <select name="pic" id="pic" class="form-control">
                <option value="" selected disabled hidden>Choose here</option>
                @foreach ($users as $user)
                    @if ($user->hasPermissionTo('can-be-pic'))
                        <option value="{{ $user->name }}">{{ $user->name }}</option>
                    @endif
                @endforeach
                </select>
            </div>
            @endcan
            @cannot('pic-create-task')
                <div class="mb-3">
                <label for="pic" class="form-label">PIC</label>
                <input type="text" readonly class="form-control" id="pic" name="pic" value="Choose here">
                </select>
            </div>
            @endcannot
            @can('start-create-task')
            <div class="mb-3">
                <label for="start" class="form-label">Start Project</label>
                <input type="date" class="form-control" id="start" name="start">
            </div>
            @endcan
            @cannot('start-create-task')
            <div class="mb-3">
                <label for="start" class="form-label">Start Project</label>
                <input type="date" readonly class="form-control" id="start" name="start">
            </div>
            @endcannot
            @can('deadline-create-task')
            <div class="mb-3">
                <label for="end" class="form-label">Deadline Project</label>
                <input type="date" class="form-control" id="end" name="end">
            </div>
            @endcan
            @cannot('deadline-create-task')
            <div class="mb-3">
                <label for="end" class="form-label">Deadline Project</label>
                <input type="date" readonly class="form-control" id="end" name="end">
            </div>
            @endcannot
            @can('description-create-task')
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea type="text" class="form-control" id="description" name="description" rows="5"></textarea>
            </div>
            @endcan
            @cannot('description-create-task')
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea type="text" readonly class="form-control" id="description" name="description" rows="5"></textarea>
            </div>
            @endcannot
            @can('picdescription-create-task')
            <div class="mb-3">
                <label for="picdescription" class="form-label">PIC Comment</label>
                <textarea type="text" class="form-control" id="picdescription" name="picdescription" rows="5"></textarea>
            </div>
            @endcan
            @cannot('picdescription-create-task')
            <div class="mb-3">
                <label for="picdescription" class="form-label">PIC Comment</label>
                <textarea type="text" readonly class="form-control" id="picdescription" name="picdescription" rows="5"></textarea>
            </div>
            @endcannot
            @can('upload-create-task')
            <div class="mb-3">
                <label for="upload" class="form-label">Upload File</label><br>
                <input type="file" name="file"><br><br>
            </div>
            @endcan
            @cannot('upload-create-task')
            <div class="mb-3">
                <label for="formFileDisabled" class="form-label">Upload File</label><br>
                <input class="form-control" type="file" id="formFileDisabled" disabled><br>
            </div>
            @endcannot
            @can('picupload-create-task')
            <div class="mb-3">
                <label for="upload" class="form-label">PIC Upload File</label><br>
                <input type="file" name="picfile"><br><br>
            </div>
            @endcan
            @cannot('picupload-create-task')
            <div class="mb-3">
                <label for="formFileDisabled" class="form-label">PIC Upload File</label><br>
                <input class="form-control" type="file" id="formFileDisabled" disabled><br>
            </div>
            @endcannot
            @can('status-create-task')
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control">
                    @foreach ($statuses as $status)
                        <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                    @endforeach
                </select>
            </div>
            @endcan
            @cannot('status-create-task')
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                    <input type="text" readonly class="form-control" id="status" name="status">
                </select>
            </div>
            @endcannot
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary mr-2"><i class="fa fa-arrow-left"></i> Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-check"></i> Save
            </button>
          </form>
    </div>
@endsection
@endsection
