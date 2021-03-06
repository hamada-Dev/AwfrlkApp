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
    <a href="{{route($module_name_plural.'.create', request() != NULL ? ['category_id'=> request()->category_id] : ''  ) }}" class="btn btn-white btn-round ">
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
                    @lang('site.category')
                </th>
                <th>
                    @lang('site.unit')
                </th>
                <th>
                    @lang('site.price')
                </th>
                <th>
                    @lang('site.image')
                </th>
                <th>
                    @lang('site.description')
                </th>
                 <th>
                    @lang('site.offer')
                </th>
               
                <th class="text-right">
                    @lang('site.actions')
                </th>
            </tr>
        </thead>
        <tbody>

            @foreach($rows as $row)

            <tr {{ $row->offer == 1 ? "style=background:#8e3a9f2b;"  : ''}}>

                <td>
                    {{$row->id}}
                </td>

                <td>
                    <a href="{{ route('productupdates.index', ['product_id'=> $row->id ]) }}">{{$row->name}}</a> 
                </td>
                <td>
                        {{$row->category->name}}
                </td>


                <td>
                    @lang($row->unitAr())
                </td>

                <td>
                    {{$row->price}} £
                </td>
                <td>
                    <img src="{{$row->image_path}}" alt="category Image" style="height:60px; width:60px"
                        class="img img-thumbnail">
                </td>

                <td>
                    {!! $row->description !!}
                </td>
                
                <td>
                    @if ($row->offer == 1 )
                    <input type='checkbox' disabled class='form-control' checked>
                    @else
                        --
                    @endif
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