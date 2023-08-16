{{-- 
@include('AdminPanel::controls.position', [
    'structure' => true
]) 
--}}

<div style="text-align: center; width: 100%;">
    <span style="display: inline-block;">
        {!! MyForm::open([
            'action' => route($routePrefix . 'position', ['id' => $entity->id, 'direction' => 'up']),
            'method' => 'POST']) !!}

            {!! MyForm::button('submit', '<i class="fa fa-arrow-up"></i>', ['class="btn btn-sm btn-default"','title="up"']) !!}
        
        {!! MyForm::close() !!}
    </span>

    @if(!isset($structure))
        <span class="btn btn-sm">{!! $entity->position !!}</span>
    @endif

    <span style="display: inline-block;">
        {!! MyForm::open([
            'action' => route($routePrefix . 'position', ['id' => $entity->id, 'direction' => 'down']),
            'method' => 'POST']) !!}
        
            {!! MyForm::button('submit', '<i class="fa fa-arrow-down"></i>', ['class="btn btn-sm btn-default"','title="down"']) !!}
        
        {!! MyForm::close() !!}
    </span>
</div>
