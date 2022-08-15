<div class="card">
    <h4 class="card-header p-3"><b>@lang('file.Empty Database')</b></h4>
    <hr>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form action="{{route('empty_database')}}" method="get">
                    @csrf
                    <button type="submit" onclick="return confirm('Are You Sure To Delete ?')" class="btn btn-primary btn-lg">@lang('file.Click here to empty database')</button>
                </form>
            </div>
        </div>

    </div>
</div>
