
<ul class="notes-list">
    <li class="heading">
        <span class="column-1"><strong>Title</strong></span>
        <span class="column-2"><strong>Created at</strong></span>
        <div class="cleaner"></div>
    </li>
    @foreach($notes as $note)
        <li>
            <span class="column-1"><a href="{{ route('notes-view', ['note_id' => $note->id]) }}">{{ $note->title }}</a></span>
            <span class="column-2">{{ $note->created_at }}</span>
            <div class="cleaner"></div>
        </li>
    @endforeach
</ul>
