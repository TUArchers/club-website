<p><em>This is an enquiry made via the <a href="http://tuarchers.org.uk">Teesside University Archers website</a></em></p>

<p>
    <b>{{ $name }}</b> asked: <br>
    <i>"{{ $enquiry }}"</i>
</p>

<p>
    {{ $name }}'s details:
    <br>Email: {{ $email }}
    @if( !is_null($phone) )
        <br>Phone: {{ $phone }}
    @endif
</p>
