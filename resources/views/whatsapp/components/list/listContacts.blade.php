<div class="feed-activity-list" id="contacts-list">
    @foreach ($contacts as $contact)
    <div class="feed-element" onclick="verDetalleChat('{{ $contact['uuid'] }}', '{{ $contact['phoneNumber'] }}')">
        <a href="#" class="float-left">
            <img alt="image" class="rounded-circle mr-3" src="{{ $contact['avatarUrl'] ?? 'img/logo/basic_logo.png' }}" width="40" height="40">
            @if ($contact['source'] === 'whatsapp')
                <img alt="overlay" class="overlay-icon" style="" src="img/logo/whatsappicon.png" width="20" height="20">
            @elseif ($contact['source'] === 'telegram')
                <img alt="overlay" class="overlay-icon" style="" src="img/logo/telegramicon.png" width="20" height="20">
            @else
                <img alt="overlay" class="overlay-icon" style="" src="{{ $contact['avatarUrl'] ?? 'img/logo/basic_logo.png' }}" width="20" height="20">
            @endif
        </a>
        <div class="media-body ">
            <small class="float-right">{{ $contact['createdAt'] }}</small>
            <strong>{{ $contact['name'] }}</strong>. <br>
            <small class="text-muted">{{ $contact['assignedUser'] }}</small>
        </div>
    </div>
    @endforeach
</div>
