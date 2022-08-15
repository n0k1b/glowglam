<!-- Error Message -->
@if ($errors->any())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <h4 class="text-center"><strong>@lang('file.Failed') {{ session('error_message')}}!</strong></h4>
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<!-- Error Message -->

