@extends('back-end.layout.app')



@section('content')


<div class="table-responsive">
    <table class="table">
        <thead class=" text-primary">
            <tr>
                <th>
                    @lang('site.id')
                </th>

                <th>
                    @lang('site.status')
                </th>
                <th>
                    @lang("site.created_at")
                </th>
                 <th>
                    @lang("site.updated_at")
                </th>

            </tr>
        </thead>
        <tbody>

            @forelse ($rows as $row)
            <tr>
                <td>
                    {{$row->id}}
                </td>
                <td>
                    @if($row->status==0)
                        @lang('site.busy')
                    @elseif($row->status==1)
                        @lang('site.active')
                    @elseif($row->status==2)
                        @lang('site.notActive')
                    @elseif($row->status==3)
                        @lang('site.black_list')
                    @else
                    @endif
                </td>
                <td>
                    {{date('Y-m-d H:m A',strtotime( $row->created_at))}}
                </td>
                <td>
                    {{date('Y-m-d H:m A',strtotime($row->updated_at)) }}
                </td>
            </tr>
            @empty

            @endforelse

        </tbody>
    </table>
</div>

@endsection