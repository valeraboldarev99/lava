@foreach($items as $item)
    <a href="{{ route('news.show', ['id', $item->id]) }}">{{ $item->title }}</a>
    <br>
@endforeach