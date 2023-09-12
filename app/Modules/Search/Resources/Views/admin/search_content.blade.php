@if(count($items))
    <div>
        <h2>{{ $title }}</h2>
        <table class="table entities__list">
            <tbody>
                @foreach($items as $item)
                    <tr {!! $item->active == 1 ?: 'style="background:#f2dede;"' !!}>
                        <td>
                            {{ $item->title }}
                        </td>
                        @isset($item->preview)
                            <td>
                                {!! $item->preview !!}
                            </td>
                        @endisset
                        <td class="controls">
                            @include('AdminPanel::controls.entity_all', ['entity' => $item, 'routePrefix' => $item->route_name])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif