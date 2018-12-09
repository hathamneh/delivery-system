@if($notes->count())
    <section id="timeline">

        @foreach($notes as $note)
            <div class="timeline-item" date-is='{{ $note->created_at->format("d-m-Y") }}'>
                <h3 class="mt-0">{{ $note->created_at->toFormattedDateString() }}</h3>
                <p class="font-weight-bold p-3 my-1 border border-info rounded">
                    {!! nl2br($note->text) !!}
                </p>
                <small class="text-muted">Created by {{ $note->user->username }}</small>
            </div>
        @endforeach
    </section>
@else
    <p class="p-5 text-muted text-center">No notes yet!</p>
@endif
