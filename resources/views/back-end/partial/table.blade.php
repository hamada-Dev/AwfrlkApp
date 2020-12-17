{{-- Users section--}}
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="card-title ">@lang('site.'.$module_name_plural)</h4>
                        <p class="card-category"> @lang('site.desc') @lang('site.'.$module_name_singular)</p>
                    </div>
                    {{$add_button}}
                </div>

            </div>
            <div class="card-body">
                {{$slot}}
            </div>
        </div>
    </div>
</div>
