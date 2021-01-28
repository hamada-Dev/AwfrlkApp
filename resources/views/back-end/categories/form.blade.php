{{csrf_field()}}
<div class="row">
    <div class="col-md-12">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.name')</label>
            <input type="text" name="name" value="{{ isset($row) ? $row->name : old('name') }}"
                class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group bmd-form-group">
            <label>@lang('site.choose-category_cat')</label>
            <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                <option value="0">@lang('site.choose-category_cat')</option>

                @forelse(App\Models\Category::where('parent_id',0)->get() as $category)
                <option value="{{$category->id}}" @if((isset($row) && $category->id== $row->parent_id) ||
                    (isset(request()->parent_id) && request()->parent_id == $category->id) || (old('parent_id') ==
                    $category->id)) selected
                    @endif>{{$category->name}} </option>
                @empty

                @endforelse
            </select>
            @error('parent_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>


    <div class="col-md-3">
        <div class="">
            <label>@lang('site.image')</label>
            <input type="file" name="image" class="form-control image @error('image') is-invalid @enderror">
            @error('image')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-3" width="100px" height="60px">
        <div class="">
            <img src="{{isset($row) ?  $row->image_path : asset('uploads/categories_images/default.png')}}"
                width="150px" style="height: 100px" class="img-thumbnail img-preview">
        </div>
    </div>



    <div class="col-md-12">
        <div class="form-group bmd-form-group">
            <label class="bmd-label-floating">@lang('site.description')</label>
            <textarea name="description" class="form-control" cols="30"
                rows="5">{{ isset($row) ? $row->description : old('description') }}</textarea>
            @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>