<form action="{{route($module_name_plural.'.destroy', $row)}}" method="POST" style="display: inline-block">
    {{csrf_field()}}
    {{method_field('DELETE')}}
    <button type="submit" rel="tooltip" title="" class="btn btn-white btn-link btn-sm delete" data-original-title="@lang('site.delete') @lang('site.'.$module_name_singular)">
        <i class="material-icons">close</i>
    </button>
</form>
