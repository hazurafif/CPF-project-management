@extends('layouts.layout-dash')
@section('content-data')
@section('content')
<a href="{{ route('tasks.index') }}" class="btn btn-info">
    <i class="fa fa-arrow-left" style="font-weight: bold; color: black"></i> All Task
</a>
<div class="card mt-3" style="word-wrap: break-word">
    <div class="card-header">
        <div class="h5">{{ $task->title }}</div>
        <span class="badge rounded-pill bg-warning text-dark" style="margin-left: 10px ">
            {{ $task->created_at->diffForHumans() }}
        </span>
    </div>
    <div class="card-body">
        <div class="card-text">
            <div class="float-start">
                <label style="font-weight: bold">Description</label><br>
                {{ $task->description }}
                <br><br>
                <div style="font-weight: bold">Task PIC: <br>{{ $task->pic }}</div>
                <br>
                <label style="font-weight: bold">PIC Comment</label><br>
                {{ $task->picdescription }}
                <br><br>
                Start Project: {{ $task->start }}<br>
                -<br>
                Deadline Project: {{ $task->end }}
                <br><br>
                File: <br>
                @if ($task->file)
                    {{ $task->file }}
                @else
                No file uploaded.
                @endif<br><br>
                PIC File: <br>
                @if ($task->picfile)
                    {{ $task->picfile }}
                @else
                No file uploaded.
                @endif<br><br>
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
                <small>Last Updated - {{ $task->updated_at->diffForHumans() }}</small>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
@endsection
