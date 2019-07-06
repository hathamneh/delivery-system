@if($notes->count())
    <section id="timeline">

        @foreach($notes as $note)
            <div class="timeline-item {{ $note->isRead() ?: "highlight" }}"
                 date-is='{{ $note->created_at->format("d-m-Y") }}'>
                <div class="d-flex align-items-center">
                    <h3 class="my-0">{{ $note->created_at->toDayDateTimeString() }}</h3>
                    <div class="ml-auto">
                        @if(!$note->isRead())
                            <a href="{{ route('notes.show', [$note]) }}" class="btn btn-link"><i class="fa-check"></i> Mark as Read</a>
                        @endif
                        @can('update', $note)
                            <a href="{{ route('notes.edit', [$note]) }}" class="btn btn-link"><i class="fa-edit"></i>
                                Edit</a>
                        @endcan
                        @can('delete', $note)
                            <button class="btn btn-link" type="button" data-toggle="modal"
                                    data-target="#deleteNote-{{ $note->id }}"><i class="fa-trash"></i> Delete
                            </button>
                        @endcan
                    </div>
                </div>
                <p class="p-3 my-1 border {{ $note->isRead() ? "border-info" : "font-weight-bold" }} rounded">
                    {!! nl2br($note->text) !!}
                </p>
                <small class="text-muted">Created by {{ $note->user->username }}</small>
            </div>
            @component('layouts.components.deleteItem', [
                'name' => 'note',
                'id' => $note->id,
                'action' => route('notes.destroy', [$note]),
            ])@endcomponent
        @endforeach
    </section>
    <div class="my-3 mx-auto d-flex justify-content-center">
        {{ $notes->links() }}
    </div>
@else
    <p class="p-5 text-muted text-center">No notes yet!</p>
@endif
