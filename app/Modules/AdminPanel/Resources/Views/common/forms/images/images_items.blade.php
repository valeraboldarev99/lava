<div class="multi-images__items js-multi-images__items-{{$field}}" id="multi-images__items-{{$field}}">
    @if($images_method->count())
        @foreach($images_method->get() as $image)
            <div    id="{{ $field . '_' . $entity->id . '_' . $image->id }}"
                    class="multi-images__item"
                    data-file_id="{{ $image->id }}"
                    data-field="{{ $field }}">
                <img src="{{ $entity->getPathMultiImage($image->name, $field, $show_img_size) }}" alt="{{ $image->name }}">
                <span   class="js-del-img del-img" 
                        data-href="{!! route($routePrefix . 'deleteMultiFiles', ['entity_id' => $entity->id, 'field' => $field, 'file_id' => $image->id]) !!}"
                        data-file_id="{{ $image->id }}"
                        data-field="{{ $field }}"
                        onclick="deleteImage.apply(this)">
                </span>
                <a href="{{ $entity->getPathMultiImage($image->name, $field, $show_img_size) }}"
                    data-fancybox="gallery" 
                    data-caption="{{ $image->name }}"
                    class="open_image-gallery">
                </a>
            </div>
        @endforeach
    @else
        <span id="js-no_images">{!! MyForm::helpText(trans('AdminPanel::adminpanel.no_images')) !!}</span>
    @endif
</div>