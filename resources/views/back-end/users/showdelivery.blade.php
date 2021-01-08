@extends('back-end.layout.app')

@php

@endphp
@section('title')
    @lang('site.delivery')
@endsection

@section('content')

    @component('back-end.layout.nav-bar')

        @slot('nav_title')
            @lang('site.delivery')
        @endslot

    @endcomponent

    @component('back-end.partial.table', ['module_name_plural'=>'delivery' , 'module_name_singular'=>'delivery'])
        @slot('add_button')
            <div class="col-md-4 text-right">
                <a href="{{route($module_name_plural.'.create')}}" class="btn btn-white btn-round ">
                    @lang('site.add') @lang('site.delivery')
                </a>
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
                        @lang('site.email')
                    </th>
                    <th>
                        @lang('site.phone')
                    </th>
                    <th>
                        @lang('site.gender')
                    </th>
                    
                   
                    <th>
                         @lang('site.delivery_status')
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
                            @if($row->delivery_status != 3)
                                <a class="btn btn-dark btn-sm" href="{{route('users.blacklist',$row->id)}}">
                                  @lang('site.add') @lang('site.black_list')
                                </a>
                            @endif
                        </td>

                        <td>
                        <a style='color:blue' href="{{route('usersalaries.index',['user_id'=>$row->id])}}" title="@lang('site.all_salary')">
                            {{$row->name}} {{$row->lastName}}
                            </a>    
                        </td>

                        <td>
                            {{$row->email}}
                        </td>

                        <td>
                            {{$row->phone}}
                        </td>

                        <td>
                            {{$row->gender}}
                        </td>

                      
                       
                        <th>
                            @if($row->delivery_status==0)
                            <a href="{{route('users.deliverystatus',$row->id)}}" class='btn btn-success btn-sm'>
                                @lang('site.busy')
                            </a>
                            @elseif($row->delivery_status==1)
                            <a href="{{route('users.deliverystatus',$row->id)}}" class='btn btn-danger btn-sm'>
                                @lang('site.active')
                            </a>
                            @elseif($row->delivery_status==2)
                            <a href="{{route('users.deliverystatus',$row->id)}}" class='btn btn-primary btn-sm'>
                                @lang('site.notActive')
                            </a>
                             @elseif($row->delivery_status==3)
                            <a href="{{route('users.deliverystatus',$row->id)}}" class='btn btn-alert btn-sm'>
                                @lang('site.black_list')
                            </a>
                            @else
                            @endif
                        </th>
                        <td class="td-actions text-right">
                            @include('back-end.buttons.edit')
                            @include('back-end.buttons.delete')

                            @if(in_array($row->id,$whotakemoney))
                                <a href="" class='btn btn-sm btn-warning'>@lang('site.takeHereMoney')</a>
                            @else
                                <a href="{{route('usersalaries.show',$row->id)}}" class='btn btn-sm btn-primary'>@lang('site.give_money')</a>
                            
                            @endif
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            {{$rows->links()}}
        </div>

    @endcomponent

@endsection

