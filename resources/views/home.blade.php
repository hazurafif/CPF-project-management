@extends('layouts.layout-dash')
@section('content-data')
@section('content')

<h3 style="font-weight: bold; color: black">Dashboard</h3>

<h6 style="margin-left: 100%;font-weight: bold; color: black; font-size: 20px"> Total: |{{ $FinishedCount + $OngoingCount + $DelayedCount }} </h6>
<h6 style="margin-left: 100%;font-weight: bold; color: black; font-size: 20px" >Completed: |{{ $FinishedCount }}</h6>

@foreach ($task_list as $item )
<div class="card" style=" height:100%; width: 18rem; display: inline-block; border-radius: 10%; margin-right: 1.5rem;" >
    <div class="card-body" >
      <h3 class="card-title" style="font-weight: bold; color: black;" >{{ $item->title }}</h3 >
        <h6 style="font-weight: bold; color: black;">{{ $item->start}} </h6>
        <h6 style="font-weight: bold; color: black;">{{ $item->pic }} </h6>
        {{-- <img style="width: 50px;height: 50px; padding: 10px; margin: 0px; border-radius: 100%" src="{{ url('/image/'.::user()->image) }}"> --}}
        @if(!$item->image)
        <img style="width: 4vw;height: 10vh; padding: 5px; margin-right:4%; border-radius: 50%" id="preview-image-before-upload" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif">

        @else
        <img style="width: 3vw;height: 6vh; padding: 5px; margin-right:4%; border-radius: 100%" src="{{ url('/image/'.$item->image) }}">
        @endif

        <small style="font-weight: bold; color: black;font-size: 1em">{{ $item->status }}</small>

    </div>
  </div>

  @endforeach

 <small style="font-weight: bold; color: black;font-size: 16px; margin-left: 10%"> {!! $task_list->render() !!} </small>


     <br>
  <h6 style="margin-left: 100%;font-weight: bold; color: black; font-size: 20px" style="margin-bottom: "> On Going: |{{ $OngoingCount }} </h6> <br>
  <h6 style="margin-left: 100%;font-weight: bold; color: black; font-size: 20px"> Delayed: |{{ $DelayedCount }} </h6>

@endsection
 @endsection


