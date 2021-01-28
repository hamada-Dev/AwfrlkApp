@extends('back-end.layout.app')

@php

@endphp
@section('title')
@lang('site.'.$module_name_plural)
@endsection

@section('content')

@component('back-end.layout.nav-bar')

@slot('nav_title')
@lang('site.'.$module_name_plural)
@endslot

@endcomponent

@component('back-end.partial.table', ['module_name_plural'=>$module_name_plural ,
'module_name_singular'=>$module_name_singular])
@slot('add_button')
<div class="col-md-4 text-right">
    <a href="{{route($module_name_plural.'.create', ['parent_id' => request()->parent_id])}}" class="btn btn-white btn-round ">
        @lang('site.add') @lang('site.'.$module_name_singular)
    </a>
</div>
@endslot

<div class="table-responsive">
    <table id="dataTable" class="table">
        <thead class=" text-primary">
            <tr>
                <th>
                    @lang('site.id')
                </th>
                <th>
                    @lang('site.name')
                </th>
                <th>
                    @lang('site.description')
                </th>

                <th>
                    @lang('site.split_category')
                </th>

                <th>
                    @lang('site.product_number')
                </th>

                <th>
                    @lang('site.image')
                </th>
                <th class="text-right">
                    @lang('site.actions')
                </th>
            </tr>
        </thead>
        <tbody>

            @foreach($rows as $row)

            <tr>

                <td>
                    {{$row->id}}
                </td>

                <td>
                    {{$row->name}}
                </td>

                <td>
                    {!! $row->description !!}
                    {{-- {{  $row->description }} --}}
                </td>

                <td>
                    <a href="{{ route('categories.index', ['parent_id' => $row->id]) }}"> {{$row->getChiledren($row->id)}}</a>
                </td>
                <td>
                    <a href="{{ route('products.index', ['category_id' => $row->id]) }}"> {{$row->product->count()}}</a>
                </td>

                <td>
                    <img src="{{$row->image_path}}" alt="category Image" style="height:60px; width:60px"
                        class="img img-thumbnail">
                </td>


                <td class="td-actions text-right">
                    @include('back-end.buttons.edit')
                    @include('back-end.buttons.delete')
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
    {{$rows->links()}}
</div>

@endcomponent

@endsection