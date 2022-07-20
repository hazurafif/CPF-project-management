@extends('layouts.layout-dash')
@section('content-data')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
            <div class="card">
                <div class="card-header">
                    Ubah Profil
                </div>

                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="/profile" id="image-upload" action="javascript:void(0)">
                        @csrf

                            <div class="form-group row">
                                @if (!$user->image)
                                <div class="col-md-12 mb-2">
                                    <img id="preview-image-before-upload" src=""
                                    alt="preview image" style="max-height: 250px;">
                                </div>

                                @else
                                <div class="col-md-12 mb-2">
                                    <img  id="preview-image-before-upload" src="{{ url('/image/'.$user->image) }}"
                                    alt="preview image" style="max-height: 250px;">
                                </div>
                                @endif

                                <div class="col-md-6">

                                        <div class="form-group row">
                                            <input type="file" name="image" placeholder="Choose image" value = "" id="image">
                                        </div>

                                </div>
                            </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" autocomplete="name" autofocus>

                              
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="Email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="Email" type="email" class="" name="Email" value="{{ old('email', $user->email) }}" autocomplete="email">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Nomor HP" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                            <div class="col-md-6">
                                <input id="Nomor HP" type="text" class="" name="Nomor HP" value="{{ old('phone', $user->phone) }}" autocomplete="phone" autofocus>

                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button id="SIMPAN" type="submit" class="btn btn-primary">
                                    Update Profile
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function (e) {
    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $('#image').change(function(){
    let reader = new FileReader();
    reader.onload = (e) => {
    $('#preview-image-before-upload').attr('src', e.target.result);
    }
    reader.readAsDataURL(this.files[0]);
    });
    $('#image-upload').submit(function(e) {
    // e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
    type:'POST',
    url: "{{ url('profile')}}",
    data: formData,
    cache:false,
    contentType: false,
    processData: false,

    });
    });
    });
</script>
@endsection
@endsection

