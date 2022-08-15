@extends('admin.main')

@section('title','Admin | Menus | Items')
@section('admin_content')
    {!!  htmlspecialchars_decode(Menu::render($menuId)) !!}
@endsection


@push('scripts')
    {!! Menu::scripts() !!}
@endpush
