{{-- controller --}}
{{-- public function related(Request $request)
{
    $q = isset($request->q) ? htmlspecialchars(trim($request->q)) : '';
    $data['items'] = [];
    $news = \DB::table('news')->select('id', 'title')->where('title', 'LIKE', ["%{$q}%"])->limit(10)->get();
    if ($news) {
        $i = 0;
        foreach ($news as $id => $title) {
            $data['items'][$i]['id'] = $title->id;
            $data['items'][$i]['text'] = $title->title;
            $i++;
        }
    }
    echo json_encode($data);
    die;
} --}}

{{-- create additional model with table for related entities .... --}}

{{-- view --}}
{{-- <div class="col-md-6">
    @include('AdminPanel::common.forms.related_entities', [
        'field' => 'related',
        'routes' => 'admin.news.related',
        'related_entities' => $related_entities,
        'label' => trans('AdminPanel::fields.related_entities'),
        'helptext' => trans('AdminPanel::fields.help_related_entities'),
    ])
</div>
 --}}
{{-- route --}}
{{-- Route::get('news/related','IndexController@related')->name('news.related'); --}}

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