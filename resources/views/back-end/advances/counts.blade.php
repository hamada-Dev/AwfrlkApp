@extends('back-end.layout.app')

@php

@endphp
@section('title')
@lang('site.count')
@endsection
@section('content')
<form action="{{route('advances.totalmoney')}}" method="POST">
@csrf
    <div class='row'>
        <div class="col-md-3">
            <div class="form-group bmd-form-group">
                <label class="bmd-label-floating">@lang('site.from')</label>
                <input type="date"  name="start_date">
             </div>
        </div>

        <div class="col-md-3">
            <div class="form-group bmd-form-group">
                <label class="bmd-label-floating">@lang('site.to')</label>
                <input type="date"  name="end_date">
            </div>
        </div>
        <div class="col-md-2">
            <button id="search_btn" class="btn btn-md btn-primary" type="submit">@lang('site.search')</button>
        </div>
    </div>

</form>
<!-- this is the order data to count moneyy -->

@if(isset($orders))
<hr>
<h3 class='pull-right' style='color:red'>@lang('site.orders')</h3>
<div class="table-responsive">
    <table class="table">
        <thead class=" text-primary">
            <tr>
                
               
                <th>
                    @lang('site.status')
                </th>
                <th>
                    @lang('site.area_id')
                </th>
                <th>
                    @lang('site.delivery_id')
                </th>
                <th>
                    @lang('site.client_id')
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
                
               
            </tr>
        </thead>
        <tbody>
            @php
                $sumdel=0;
            @endphp
            @foreach($orders as $row)

            <tr class='text-center'>
               
            
                <td>
                    @if ($row->status==0)
                        <a href="" class="btn btn-primary btn-sm">@lang("site.waiting")</a>
                    @else    
                        <a href="" class="btn btn-success btn-sm">@lang("site.finished")</a>
                    @endif
                </td>
                <td>
                    {{$row->area->name}}
                </td>
                <td>
                    @foreach ($users as $user)
                        @if($row->delivery_id==$user->id)
                            {{$user->name}} {{$user->lastName}}
                        @endif   
                    @endforeach
                </td>
                <td>
                    @foreach ($users as $user)
                        @if($row->client_id==$user->id)
                            {{$user->name}} {{$user->lastName}}
                        @endif   
                    @endforeach
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
                  {{ $row->delivery_price }}  
                  @php 
                    $sumdel+=$row->delivery_price;
                  @endphp
                </td>
               
            </tr>
            @endforeach
            </tbody>
            
    </table>
</div>
@endif

<!-- this is the offers data to count moneyy-->
@if(isset($offers))
@php $sumofferprice=0; @endphp
<hr>
<h3 class='pull-right' style='color:red'>@lang('site.offers')</h3>
<div class="table-responsive">
    <table class="table">
        <thead class=" text-primary">
            <tr class='text-center'>
                <th>
                    @lang('site.offer_name')
                </th>
                <th>
                    @lang('site.price')
                </th>
                <th>
                    @lang('site.trips_count')
                </th>
                <th>
                    @lang('site.offer_days')
                </th>
                <th>
                    @lang('site.avilable')
                </th>
                <th>
                    @lang('site.area_id')
                </th>
            
            </tr>
        </thead>
        <tbody>

            @foreach($offers as $row)

            <tr class='text-center'>

                <td>
                    {{$row->name}}
                </td>
                <td>
                    {{$row->price}}
                    @php $sumofferprice+=$row->price; @endphp
                </td>
                <td>
                    {{$row->trips_count}}
                </td>


                <td>
                    {{$row->offer_days}}
                </td>

                <td>
                    @if($row->avilable==1)
                         @lang('site.Active')
                    @else
                        @lang('site.NotActive')
                    @endif
                </td>
                <td>
                    {{ $row->area->name}}
                </td>
                
            </tr>
            @endforeach
            
        </tbody>
    </table>
</div>
@endif
<!-- this is the users data to count moneyy-->
@if(isset($salaries))

@php $sumsalary=0; @endphp
<hr>
<h3 class='pull-right' style='color:red'>@lang('site.users')</h3>
<div class="table-responsive">
            <table class="table">
                <thead class=" text-primary">
                <tr class='text-center'>
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
                        @lang('site.commission')
                    </th>
                    <th>
                         @lang('site.salary')
                    </th>

                    <th>
                        @lang('site.salaryAfterCommission')
                    </th>
                   
                </tr></thead>
                <tbody>

                @foreach($salaries as $row)

                    <tr class='text-center'>

                        

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
                            {{$row->commission}}
                        </td>
                        <td>
                            {{$row->salary}}
                        </td>
                        <td>
                            @php 
                                $all=0;
                                if($row->commission > 0)
                                    {
                                        $all=(($row->commission * $row->salary)+$row->salary);
                                    }else{
                                        $all=$row->salary;
                                    }
                                    echo $all;
                                    $sumsalary+=$all;
                            @endphp
                        </td>
                        

                        
                    </tr>
                @endforeach
                    
                </tbody>
            </table>
        </div>
@endif
<hr>
<h3 class='pull-right' style='color:red'>@lang('site.count')</h3>
<table class="table table-bordered table-dark">
  <thead>
    <tr class='text-center'>
      <th scope="col"  class='text-center'>@lang('site.safeAlmaserofat')</th>
      <th scope="col"  class='text-center'>@lang('site.safeofferandorder')</th>
      <th scope="col"  class='text-center'> @lang('site.safearbah')</th>
    </tr>
  </thead>
  <tbody>
    <tr class='text-center'>
      <td>@php echo "<span style='color:white'>" . $sumsalary . "</span>"; @endphp</td>
      <td>@php echo "<span style='color:white'>" . ($sumofferprice+$sumdel) . "</span>"; @endphp</td>
      <td> @php echo "<span style='color:red'>" . (($sumofferprice+$sumdel)-$sumsalary) . "</span>"; @endphp</td>
    </tr>
  </tbody>
</table>
@endsection



