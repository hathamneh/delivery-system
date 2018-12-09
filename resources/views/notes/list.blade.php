@if($notes->count())
    <div class="row">
        @foreach($notes as $note)
            <div class="card">
                <div class="card-body">
                    {{ $note->text }}
                </div>
            </div>
        @endforeach
    </div>
@endif