@extends('admin.main')

@section('title','Admin | Profile')

@section('admin_content')
    <section class="forms">
        <div class="container-fluid">

            @include('frontend.includes.alert_message')
            @include('frontend.includes.error_message')

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4>{{__('file.Update Profile')}}</h4>
                        </div>

                        <div class="card-body">

                            @if($user->image)
                                <img src="{{asset('public/'.$user->image)}}" height="120" width="120">
                            @else
                                <img src="{{asset('public/images/admin.png')}}" height="120" width="120" >
                            @endif

                            <p class="italic"><small>{{__('file.The field labels marked with * are required input fields')}}.</small></p>
                            <form method="POST" action="{{route('admin.profile_update')}}" enctype="multipart/form-data">

                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{__('file.Image')}}</label>
                                            <input type="file" name="image" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>{{__('file.First Name')}} *</label>
                                            <input type="text" name="first_name" value="{{$user->first_name}}" required class="form-control @error('first_name') is-invalid @enderror" />
                                            @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{__('file.Last Name')}} *</label>
                                            <input type="text" name="last_name" value="{{$user->last_name}}" required class="form-control @error('last_name') is-invalid @enderror" />
                                            @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{trans('file.Username')}} *</label>
                                            <input type="text" name="username" value="{{$user->username}}" required class="form-control @error('username') is-invalid @enderror" />
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{trans('file.Email')}} *</label>
                                            <input type="email" name="email" value="{{$user->email}}" required class="form-control @error('email') is-invalid @enderror">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>{{trans('file.Phone')}} *</label>
                                            <input type="text" name="phone" value="{{$user->phone}}" required class="form-control @error('phone') is-invalid @enderror" />
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>




                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4>{{__('file.Change Password')}} ({{trans('file.Optional')}})</h4>
                        </div>

                        <div class="card-body">
                            <p class="italic"><small>{{__('file.The field labels marked with * are required input fields')}}.</small></p>
                            <form method="POST" action="{{route('admin.profile_update')}}" >
                                @csrf

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{__('file.New Password')}} *</label>
                                            <input type="password" name="password" required class="form-control" placeholder="{{__('file.min:4 characters')}}">
                                        </div>

                                        <div class="form-group">
                                            <label>{{__('file.Confirm Password')}} *</label>
                                            <input type="password" name="password_confirmation" id="confirm_pass" required class="form-control" placeholder="{{trans('file.Re-Type')}} {{trans('file.Password')}}">
                                        </div>
                                        <div class="form-group">
                                            <div class="registrationFormAlert" id="divCheckPasswordMatch">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



@push('scripts')

@endpush
