@extends('layouts.layout-dash')
@section('content-data')
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2 style="font-weight: bold; color: black">Users Management</h2>
        </div>
    </div>
</div>


@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif

<div class="card">
    <div class="card-body" >
        <table class="table table-bordered" style="color: black">
            <tr>
   <th style="border-color: black">No</th>
   <th style="border-color: black">Name</th>
   <th style="border-color: black">Email</th>
   <th style="border-color: black">Roles</th>
   <th style="border-color: black" width="280px">Action</th>
 </tr>
 @foreach ($data as $key => $user)
 <tr>
     <td style="border-color: black">{{ ++$i }}</td>
     <td style="border-color: black">{{ $user->name }}</td>
     <td style="border-color: black">{{ $user->email }}</td>
     <td style="border-color: black" style="color: white">
        @if(!empty($user->getRoleNames()))
        @foreach($user->getRoleNames() as $v)
        <label class="badge bg-success">{{ $v }}</label>
        @endforeach
        @endif
    </td>
    <td style="border-color: black" >
        <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
        @can('user-edit')
        <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
        @endcan
        @can('user-delete')
        <form action="{{ route('users.destroy', $user->id) }}" style="display: inline" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                Delete
            </button>
        </form>
        @endcan
    </td>
</tr>
@endforeach
</table>
<h6 style="font-size: 1em; color: black">{{ $data->links() }}</h6>
</div>
</div>


<nav class="navbar" style="background-color: #ffff; border-radius: 20px; height: 40px;" >
    <div class="pull-right mb-4" style="margin-left: 87%" >
        @can('user-create')
        <a  href="{{ route('users.create') }}" style="color: black ">
            <span class="iconify" data-icon="akar-icons:circle-plus-fill" style="font-size: 20px; margin-right: 7px">
            </span>Create New User </a>
            @endcan
        </div>
</nav>

@endsection
@endsection
