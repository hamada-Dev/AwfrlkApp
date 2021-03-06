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

    @component('back-end.partial.table', ['module_name_plural'=>$module_name_plural , 'module_name_singular'=>$module_name_singular])
        @slot('add_button')
            <!-- <div class="col-md-4 text-right">
                <a href="{{route($module_name_plural.'.create')}}" class="btn btn-white btn-round ">
                    @lang('site.add') @lang('site.'.$module_name_singular)
                </a>
            </div> -->
        @endslot
        <div class="table-responsive">
            <table  id="dataTable" class="table">
                <thead class=" text-primary">
                <tr>
                    <th>
                        @lang('site.id')  
                    </th>
                    <th>
                        @lang('site.user_id_emp')  
                    </th>
                    <th>
                        @lang('site.salary')
                    </th>
                    <th>
                        @lang('site.commission')
                    </th>
                    <th>
                        @lang('site.moneyDay')
                    </th>
                    <th class="text-right">
                        @lang('site.actions')
                    </th>
                </tr></thead>
                <tbody>

                @foreach($rows as $row)

                    <tr>

                        <td>
                            {{$row->id}}
                        </td>

                        <td>
                            {{$row->user->name}} {{$row->user->lastName}}
                        </td>

                        <td>
                            {{$row->salary}}
                        </td>

                        <td>
                            {{$row->commission}}
                        </td>

                        <td>
                            {{$row->moneyDay}}
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

