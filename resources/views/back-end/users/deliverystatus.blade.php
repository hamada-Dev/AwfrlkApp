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
                    <a href="" class='btn btn-success btn-sm'>
                        @lang('site.busy')
                    </a>
                    @elseif($row->status==1)
                    <a href="" class='btn btn-danger btn-sm' rel="tooltip"
                        data-original-title='click to show all status'>
                        @lang('site.active')
                    </a>
                    @elseif($row->status==2)
                    <a href="" class='btn btn-primary btn-sm'>
                        @lang('site.notActive')
                    </a>
                    @elseif($row->status==3)
                    <a href="" class='btn btn-alert btn-sm'>
                        @lang('site.black_list')
                    </a>
                    @else
                    @endif
                </td>
                <td>
                    {{$row->created_at}}
                </td>
            </tr>
            @empty

            @endforelse

        </tbody>
    </table>
</div>

@endsection