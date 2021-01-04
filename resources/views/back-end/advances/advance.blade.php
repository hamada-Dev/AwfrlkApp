@extends('back-end.layout.app')

@php

@endphp
@section('title')
@lang('site.count')
@endsection

@section('content')

<div class="table-responsive">
    <table class="table table-dark">
    <thead >
        <tr  class='text-center'>
        
            <th scope="col">
                @lang('site.user_delivey')
            </th>
            <th scope="col">
                @lang('site.getmoney')
            </th>
            <th scope="col">
                @lang('site.givemoney')
            </th>
            <th>
                @lang('site.count')
            </th>
        </tr>
  </thead>
  <tbody class='text-center'>
    <tr>
        
        <td>
            {{$advance->user->name}} {{$advance->user->lastName}}
        </td>
        <td>
            {{$advance->getmoney}}
        </td>
        <td>
           <span style='color:red;'>{{$advance->givemoney}}</span>
        </td>
        <td>
        @if($orders->count()>0)
            <a href="{{ route('advances.countmoney',$advance->id)}}" class='btn btn-success'>@lang('site.count')</a>
        @endif
        </td>
    </tr>            
  </tbody>
</table>
</div>

<!-- //orders -->
<div class="table-responsive">
    <table class="table">
        <thead class=" text-primary">
            <tr>
                <th>
                    @lang('site.id')
                </th>
                <th>
                    @lang('site.totalPrice')
                </th>
                <th>
                    @lang('site.status')
                </th>
                <th>
                    @lang('site.area_id')
                </th>
          
                <th>
                    @lang('site.end_shoping_date')
                </th>
                <th>
                    @lang('site.arrival_date')
                </th>
                <th>
                    @lang("site.delivery_price")
                </th>
                <th>
                    @lang("site.details_Orders")
                </th>
               
            </tr>
        </thead>
    <tbody>       
        @forelse($orders as $row)
            <tr>
                <td>
                    {{$row->id}}  
                </td>
                <td>
                    {{$row->orderDetails->sum('price')}}
                    
                </td>
                <td>
                    @if ($row->status==0)
                        @lang("site.waiting")
                    @else    
                        @lang("site.finished")
                    @endif
                </td>
                <td>
                    {{$row->area->name}}
                </td>
                
                <td>
                     @if ($row->end_shoping_date==null)
                        <a href="" class="btn btn-primary btn-sm">@lang("site.not_buy")</a>
                     @else    
                        {{$row->end_shoping_date}}
                    @endif
                </td>
                <td>
                    @if ($row->arrival_date==null)
                        <a href="" class="btn btn-primary btn-sm">@lang("site.not_arrive")</a>
                    @else    
                        {{$row->arrival_date}}
                    @endif
                </td>
                <td>
                <span style='color:yellow'> {{ $row->delivery_price }}  
                  </span>
                </td>
                <td>
                  
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                          @lang("site.details_Orders")
                    </button>
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <div class="modal-body">
                                <table class="table">
                                        <thead class=" text-primary">
                                            <tr>
                                                <th>
                                                    @lang('site.product_id')
                                                </th>
                                                <th>
                                                    @lang('site.amount')
                                                </th>
                                                <th>
                                                    @lang('site.price')
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($row->orderDetails as $detail)
                                                <tr class='text-center'>
                                                    <td>
                                                        {{$detail->product->name}}
                                                    </td>
                                                    <td>
                                                        {{$detail->amount}} 
                                                    </td>
                                                    <td>
                                                        {{$detail->price }}
                                                    </td>
                                                </tr>
                                            @empty
                                                 No DaTa FoR This Order
                                            @endforelse
                                        </tbody>
                                </table>
                        </div>
                        </div>
                    </div>
                    </div>
               </td> 
            </tr>
        @empty
        no data for tasfea
        @endforelse
        </tbody>
            
    </table>
</div>



@endsection




