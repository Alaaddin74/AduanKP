<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nomor Tiket Aduan</title>
</head>
<body>
    <p>Halo {{ $ticket->name }},</p>
    <p>Bisa cek ticket. Berikut nomor tiket Anda:</p>
    <h2>#{{ $ticket->ticket_number }}</h2>
    <p>Silakan simpan nomor ini untuk memantau status laporan Anda.</p>
    <br>
    <p>Terima kasih,</p>
    <p>UPT TIK Universitas Lampung</p>
</body>
</html>
