<table class="table entities__list">
    <thead>
        <tr>
            <th>{{ __('Backuper::adminpanel.date') }}</th>
            <th>{{ __('Backuper::adminpanel.user_info') }}</th>
            @if($type == 'files')
                <th>{{ __('Backuper::adminpanel.time_period') }}</th>
                <th>{{ __('Backuper::adminpanel.folder') }}</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($entities as $entity)
            <tr>
                <td>
                    {{ $entity->datetime->format('H:i:s') }} <br>
                    {{ $entity->datetime->format('Y-m-d') }}
                </td>
                <td>
                    {{ $entity->user_login }} <br>
                    {{ $entity->ip }}
                </td>
                @if($type == 'files')
                    <td>
                        @if($entity->all_time)
                            {{ __('Backuper::adminpanel.all_time') }}
                        @else
                            {{ $entity->date_from->format('Y-m-d') . ' - ' . $entity->date_to->format('Y-m-d') }}
                        @endif
                    </td>
                    <td>
                        @if($entity->folder)
                            {{ $entity->folder }}
                        @else
                            {{ __('Backuper::adminpanel.all_folders') }}
                        @endif
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>