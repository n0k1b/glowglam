@extends('admin.main')
@section('title','Admin | Language')
@section('admin_content')

<section>
    <div class="container-fluid"><span id="general_result"></span></div>

    @include('admin.includes.alert_message')

    <div class="container-fluid mb-3">

        @if (auth()->user()->can('locale-store'))
            <button type="button" class="btn btn-info mb-3" data-toggle="modal" data-target="#createModalForm"><i class="fa fa-plus"></i>{{__('file.Add Language')}}</button>
        @endif

        <div class="table-responsive">
    	<table id="menu_table" class="table ">
    	    <thead>
        	   <tr>

        		    <th scope="col">{{__('file.Language Name')}}</th>
        		    <th scope="col">{{__('file.Locale')}}</th>
        		    <th scope="col">{{__('file.Default')}}</th>
        		    <th  scope="col">{{trans('file.action')}}</th>
        	   </tr>
    	  	</thead>
			<tbody>
				@foreach ($languages as $key=> $item)
					<tr>
						<td>{{ $item->language_name }}</td>
						<td>{{ $item->local }}</td>
						<td>@if($item->default == 1) <span class='p-2 badge badge-success'>{{__('file.Default')}}</span> @else <span class='p-2 badge badge-dark'>@lang('file.None')</span> @endif</td>
						<td>
                            <button type="button" class="btn btn-info"><i class="dripicons-pencil" aria-hidden="true" data-toggle="modal" data-target="#editModalForm-{{$item->local}}"></i></button>
                            @if ($item->default == 1)
                                <a href="" class="btn btn-danger" onclick="return confirm('Please at first set a default language from any one')"><i class="dripicons-trash" aria-hidden="true"></i></a>
                            @else
                                <a href="{{route('admin.setting.language.delete',$item->id)}}" class="btn btn-danger" onclick="return confirm('Are you sure to delete ?')"><i class="dripicons-trash" aria-hidden="true"></i></a>
                            @endif
                        </td>
					</tr>
				@endforeach
			</tbody>

    	</table>
    </div>
    </div>
</section>

    @include('admin.pages.setting.language.create')
    @foreach ($languages as $key=> $item)
        @include('admin.pages.setting.language.edit')
    @endforeach
@endsection
