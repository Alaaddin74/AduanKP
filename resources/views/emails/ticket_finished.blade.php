<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nomor Tiket Aduan</title>
</head>
<body>
 <p>Yth. {{ $ticket->name }},</p>

<p>Terima kasih telah menghubungi UPT TIK Universitas Lampung.</p>

<p>Dengan ini kami informasikan bahwa tiket Anda telah <strong>selesai diproses</strong>.</p>

<p>Nomor tiket Anda:</p>
<h2>#{{ $ticket->ticket_number }}</h2>

<p>Silakan simpan nomor ini sebagai referensi apabila Anda memerlukan informasi lebih lanjut terkait laporan yang telah diajukan.</p>

<br>
<p>Apabila masih terdapat hal yang ingin ditanyakan atau permasalahan serupa muncul kembali, jangan ragu untuk menghubungi kami melalui kanal layanan resmi UPT TIK.</p>

<br>
<p>Hormat kami,</p>
<p><strong>UPT TIK Universitas Lampung</strong></p>

</body>
</html>
