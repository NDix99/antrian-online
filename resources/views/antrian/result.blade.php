<div class="ticket-result">
    <img src="{{ $ticket_image }}" alt="Nomor Antrian">
    <div class="actions">
        <button onclick="window.print()">Cetak</button>
        <a href="{{ $ticket_image }}" download="antrian.png">Download</a>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('css/ticket-print.css') }}">
