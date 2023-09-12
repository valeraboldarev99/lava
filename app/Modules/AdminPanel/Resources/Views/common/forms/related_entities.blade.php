{{-- 
@include('AdminPanel::common.forms.related_entities', [
    'field' => 'related',
    'routes' => 'admin.news.related',
    'related_entities' => $related_entities,
    'label' => trans('AdminPanel::fields.related_entities'),
    'helptext' => trans('AdminPanel::fields.help_related_entities'),
])
 --}}

@push('js')
    <script>
        $(document).ready(function () {
            $(".js-select-{{$field}}").select2({
                cache: true,
                // placeholder: "{{ isset($helptext) ? $helptext : trans('AdminPanel::fields.help_related_entities') }}",
                ajax: {
                    url: "{{ route($routes) }} ",
                    delay: 250,
                    dataType: 'json',
                    data: function (params) {
                        return {
                            q: params.term,
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        return {
                            results: data.items
                        };
                    }
                }
            });
        });
    </script>
@endpush

<div class="form-group">
    <label for="{{ $field }}">{{ (isset($label)) ? $label : trans('AdminPanel::fields.related_entities') }}</label>
    <div class="choose__item">
        <select name="related[]" class="select2 form-control js-select-{{$field}}" id="related" multiple>
            @if (!empty($related_entities))
                @foreach($related_entities as $related_entity)
                    <option value="{{$related_entity->related_id}}" selected>
                        {{$related_entity->title}}
                    </option>
                @endforeach
            @endif
        </select>
    </div>
</div>
@if(isset($helptext))
    {!! MyForm::helpText($helptext) !!}
@endif