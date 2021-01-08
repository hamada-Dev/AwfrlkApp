@extends('back-end.layout.app')

@php

@endphp
@section('title')
    @lang('site.black_list')
@endsection

@section('content')

    @component('back-end.layout.nav-bar')

        @slot('nav_title')
            @lang('site.black_list')
        @endslot

    @endcomponent

    @component('back-end.partial.table', ['module_name_plural'=>'black_list' , 'module_name_singular'=>'black_list'])
        @slot('add_button')
            <div class="col-md-4 text-right">
                <!-- <a href="{{route($module_name_plural.'.create')}}" class="btn btn-white btn-round ">
                    @lang('site.add') @lang('site.delivery')
                </a> -->
            </div>
        @endslot
        <div class="table-responsive">
            <table class="table">
                <thead class=" text-primary">
                <tr>
                    <th>
                        @lang('site.id')
                    </th>
                    <th>
                        @lang('site.name')
                    </th>
                    <th>
                        @lang('site.group')
                    </th>
                    <th>
                        @lang('site.phone')
                    </th>
                    <th>
                        @lang('site.gender')
                    </th>
                    <th>
                        @lang('site.country')
                    </th>
                   
                    <th>
                         @lang('site.delivery_status')
                    </th>
                    
                    
                </tr></thead>
                <tbody>

                @foreach($rows as $row)

                    <tr>

                        <td>
                            {{$row->id}}
                           
                        </td>

                        <td>
                            {{$row->name}} {{$row->lastName}}
                        </td>

                        <td>
                            {{$row->group}}
                        </td>

                        <td>
                            {{$row->phone}}
                        </td>

                        <td>
                            {{$row->gender}}
                        </td>

                        <td>
                            {{$row->adress}}
                        </td>
                       
                        <th>
                        @if($row->delivery_status == 3)
                            <a class="btn btn-danger btn-sm" href="{{route('users.blacklist',$row->id)}}">
                                  @lang('site.delete') @lang('site.black_list')
                            </a>
                        @endif
                        </th>
                      
                    </tr>
                @endforeach

                </tbody>
            </table>
            {{$rows->links()}}
        </div>

    @endcomponent

@endsection

