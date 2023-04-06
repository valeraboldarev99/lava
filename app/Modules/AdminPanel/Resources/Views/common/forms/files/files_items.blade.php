<div id="files-list__items" class="files-list__items js-files_list__items-{{$field}}">
    @if($files_method->count())
        <div class="files-list__item">
            <div class="files-list__block files-list__name">{{ __('AdminPanel::fields.file_name') }}</div>
            <div class="files-list__block files-list__size">{{ __('AdminPanel::fields.format') }}</div>
            <div class="files-list__block files-list__size">{{ __('AdminPanel::fields.size') }}</div>
            <div class="files-list__block files-list__controls">{{ __('AdminPanel::adminpanel.controls') }}</div>
        </div>
        @foreach($files_method->get() as $file)
            <div id="{{ $field . '_' . $entity->id . '_' . $file->id }}" class="files-list__item">
                <div class="files-list__block files-list__name">{{ $file->saved_name }}</div>
                <div class="files-list__block files-list__size">{{ $file->format }}</div>
                <div class="files-list__block files-list__size">{{ $entity->getFileSize($file->file_size) }}</div>
                <div class="files-list__block files-list__controls">
                    <span id="changeFile" class="btn btn-primary btn-sm" 
                        data-file_id="{{ $file->id }}"
                        data-file_name="{{$file->saved_name}}"
                        data-file_field="{{$field}}"
                        onclick="changeFileNameForm.apply(this)">
                        <i class="fa fa-pencil"></i>
                    </span>
                    <a href="{{$entity->getPathMultiFile($file->file_name, $field) }}" download class="btn btn-primary btn-sm" target="_blank">
                        <i class="fa fa-arrow-down" aria-hidden="true"></i>
                    </a>
                    <span class="btn btn-danger btn-sm js-del-img"
                        data-href="{!! route($routePrefix . 'deleteMultiFiles', ['entity_id' => $entity->id, 'field' => $field, 'file_id' => $file->id]) !!}"
                        data-file_id="{{ $file->id }}"
                        onclick="deleteFile.apply(this)">
                            <i class="fa fa-fw fa-close delete"></i>
                    </span>
                </div>
            </div>
        @endforeach
    @else
        <span id="js-no_images">{!! MyForm::helpText(trans('AdminPanel::adminpanel.no_files')) !!}</span>
    @endif
</div>