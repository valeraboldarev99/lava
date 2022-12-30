<div class="multi-images__field">
    @if(isset($entity->id))
        <div class="multi-images__form">
            {!! MyForm::file($field, (isset($label)) ? $label : trans('AdminPanel::fields.file'), $entity->{$field}, ['accept="image/*"', 'data-field="' . $field . '"']) !!}
            <span class="btn btn-success" style="margin-bottom: 15px;" onclick="openFiles()">@lang('AdminPanel::adminpanel.upload_images')</span>
            <i id="loading__multi-images" class="fa fa-spinner fa-spin fa-2x fa-fw" style="left: 200px;top: 50px;display: none"></i>
            @if(isset($helptext))
                {!! MyForm::helpText($helptext) !!}
            @endif
        </div>

        <div class="multi-images__items" id="multi-images__items">
            @if($entity->images()->count())
                @foreach($entity->images()->get() as $image)
                    <div class="multi-images__item">
                        <img src="{{ $entity->getPathMultiImage($image->name, $field, $show_img_size) }}" alt="{{ $image->multi_images }}">
                        <span   class="js-del-img del-img" 
                                data-href="{!! route($routePrefix . 'deleteMultiImages', ['entity_id' => $entity->id, 'field' => $field, 'image_id' => $image->id]) !!}"
                                data-image_id="{{ $image->id }}"
                                onclick="deleteImage.apply(this)">
                        </span>
                    </div>
                @endforeach
            @else
                <span id="js-no_images">{!! MyForm::helpText(trans('AdminPanel::adminpanel.no_images')) !!}</span>
            @endif
        </div>
    @else
        {!! MyForm::helpText(trans('AdminPanel::adminpanel.save_and_upload_image')) !!}
    @endif
</div>