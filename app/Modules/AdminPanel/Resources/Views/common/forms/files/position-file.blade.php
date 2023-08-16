{{-- 
@include('AdminPanel::controls.position', [
    'entity' => $otherEntity,
    'routePrefix' => $otherRoutePrefix,
    'showPosition' => true
]) 
--}}

@push('js')
    <script>
        function changePosition()
        {
            var form_data = new FormData();
            form_data.append('field',  $(this).data('field'));
            form_data.append('direction', $(this).data('direction'));
            form_data.append('file_id', $(this).data('file_id'));
            form_data.append('_token', '{{csrf_token()}}');

            $.ajax({
                url: "{!! route($routePrefix . 'positionFile') !!}",
                data: form_data,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function (data) {
                    //console.log(data);
                    location.reload();
                },
                error: function (xhr, status, error) {
                    alert('ERROR');
                    alert(xhr.responseText);
                }
            });
            
        }
    </script>
@endpush

@php
    isset($showPosition) ? $showPosition = $showPosition : $showPosition = true;
@endphp

<div style="text-align: center; width: 100%;">
    <span style="display: inline-block;">
        {!! MyForm::button('button', '<i class="fa fa-arrow-up"></i>', [
            'class="btn btn-sm btn-default"',
            'title="up"',
            'onclick="changePosition.apply(this)"',
            'data-file_id="' . $entity->id . '"',
            'data-field="' . $field . '"',
            'data-direction="up"'
        ]) !!}
    </span>

    @if($showPosition)
        <span class="btn btn-sm">{!! $entity->position !!}</span>
    @endif

    <span style="display: inline-block;">
        {!! MyForm::button('button', '<i class="fa fa-arrow-down"></i>', [
            'class="btn btn-sm btn-default"',
            'title="down"',
            'onclick="changePosition.apply(this)"',
            'data-file_id="' . $entity->id . '"',
            'data-field="' . $field . '"',
            'data-direction="down"'
        ]) !!}
    </span>
</div>
