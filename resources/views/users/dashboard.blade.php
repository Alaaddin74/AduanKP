<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pengguna</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body {
        background-color: #1a3365; /* Warna dasar seperti di background utama */
        color: white;
    }

    .sidebar {
    height: 100vh;
    background: linear-gradient(to bottom, #003366, #0055a5);
    color: white;
    padding: 20px;
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;

    display: flex;
    flex-direction: column;
}

    .sidebar h4 {
        margin-bottom: 30px;
        color: white;
    }

    .sidebar p {
        margin-bottom: 0.2rem;
        color: #cfd8dc;
    }

    .sidebar .small {
        font-size: 0.8rem;
        color: #90caf9;
    }

    .sidebar a {
        display: block;
        color: #bbdefb;
        text-decoration: none;
        margin: 15px 0;
        font-weight: 500;
    }

    .sidebar a i {
        margin-right: 8px;
    }

    .sidebar a:hover {
        color: #ffffff;
    }

    .main {
        margin-left: 270px;
        padding: 20px;
        background-color: #1a3365; 
        min-height: 100vh;
    }

    .card {
        background-color: #002b5c; 
        color: white;
        border: none;
    }

    .card .form-control {
        background-color: #0c274a;
        border: 1px solid #4682b4;
        color: white;
    }

    .card .form-control::placeholder {
        color: #b0bec5;
    }

    .btn-primary {
        background-color: #3b7ddd;
        border: none;
    }

    .btn-primary:hover {
        background-color: #2f65b3;
    }

    .table thead {
        background-color: #0d47a1;
        color: white;
    }

    .table td, .table th {
        background-color: #001e3c;
        color: white;
        vertical-align: middle;
    }

    .badge.bg-info {
        background-color: #4fc3f7 !important;
        color: #003366;
    }

    .badge.bg-success {
        background-color: #66bb6a !important;
    }

    .badge.bg-warning {
        background-color: #ffee58 !important;
        color: #333;
    }

    .badge.bg-danger {
        background-color: #ef5350 !important;
    }

    .btn-info {
        background-color: #29b6f6;
        border: none;
    }

    .btn-info:hover {
        background-color: #0288d1;
    }

    .logo-unila {
    width: 32px;
    height: 32px;
    object-fit: contain;
}

.copyright-link {
    color: #90caf9;
    font-size: 0.85rem;
    text-decoration: none;
}
.copyright-link:hover {
    color: #ffffff;
    text-decoration: underline;
}

</style>

</head>
<body>

<div class="sidebar">
    <div class="d-flex align-items-center mb-4">
        <img src="{{ asset('attachments/Logo_UnivLampung.png') }}" alt="Logo Unila" class="logo-unila me-2">
        <h4 class="mb-0">Situs Laporan Unila</h4>
    </div>
    <p>{{ strtoupper('Pengguna Umum') }}</p>
    <a href="{{ route('user.dashboard') }}"><i class="bi bi-house"></i> Dashboard</a>
    <a href="{{ route('lapor.create') }}"><i class="bi bi-plus-circle"></i> Buat Ticket</a>
    <div class="mt-auto text-center pt-4">
        <a href="https://tik.unila.ac.id/" target="_blank" class="copyright-link">
            © 2025 UPT TIK Unila
        </a>
    </div>
</div>

<div class="main">
    <div class="greet">
    <p>Selamat Datang di Layanan Lapor Situs UPT TIK Universitas Lampung.</p>
    </div>
    <!-- Form Pencarian -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="mb-3">Cari Tiket</h5> 
            <form method="GET" action="{{ url()->current() }}" class="row g-2">
                <div class="col-md-10">
                    <input type="text" name="search" class="form-control"
                           placeholder="Cari tiket berdasarkan nomor, kategori, atau status..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(request('search'))
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Hasil Pencarian Tiket</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nomor Tiket</th>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $index => $ticket)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><span class="badge bg-info">#{{ $ticket->ticket_number }}</span></td>
                        <td>{{ $ticket->created_at->format('d-m-Y H:i') }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $ticket->category)) }}</td>
                        <td>{{ strtoupper($ticket->priority) }}</td>
                        <td>
                            @if ($ticket->status == 'done')
                                <span class="badge bg-success">✔ Done</span>
                            @elseif ($ticket->status == 'in_progress')
                                <span class="badge bg-warning text-dark">⏳ In Progress</span>
                            @else
                                <span class="badge bg-danger">⏱ Waiting</span>
                            @endif
                        </td>
                        <td>{{ $ticket->email ?? '-' }}</td>
                        <td>
                            <button class="btn btn-sm btn-info text-white"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailModal"
                                    data-ticket='@json($ticket)'>
                                <i class="bi bi-eye"></i> Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">Tidak ditemukan tiket dengan kata kunci tersebut.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="detailModalLabel">Detail Tiket</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body text-dark">
        <p><strong>Nomor Tiket:</strong> <span id="detail_nomor"></span></p>
        <p><strong>Tanggal Dibuat:</strong> <span id="detail_tanggal"></span></p>
        <p><strong>Tiket Selesai Pada:</strong> <span id="detail_selesai"></span></p>
        <p><strong>Kategori:</strong> <span id="detail_kategori"></span></p>
        <p><strong>Prioritas:</strong> <span id="detail_prioritas"></span></p>
        <p><strong>Status:</strong> <span id="detail_status"></span></p>
        <p><strong>Email Pelapor:</strong> <span id="detail_email"></span></p>
        <p><strong>Okupasi:</strong> <span id="detail_okupasi"></span></p>
        <p><strong>Link Situs:</strong> <a href="#" id="detail_link" target="_blank">Lihat</a></p>
        <p><strong>Catatan:</strong> <span id="detail_deskripsi"></span></p>
        <p><strong>Catatan Admin:</strong> <span id="detail_note"></span></p>
        <div id="lampiran_section">
          <p><strong>Lampiran:</strong></p>
          <a href="#" id="detail_lampiran" target="_blank">Lihat Lampiran</a>
          <img id="lampiran_image" class="img-fluid mt-2 rounded d-none" style="max-height: 300px;">
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('detailModal');
    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const ticket = JSON.parse(button.getAttribute('data-ticket'));

        document.getElementById('detail_nomor').innerText = '#' + ticket.ticket_number;
        document.getElementById('detail_tanggal').innerText = new Date(ticket.created_at).toLocaleString('id-ID');
        document.getElementById('detail_kategori').innerText = ticket.category.replaceAll('_', ' ');
        document.getElementById('detail_prioritas').innerText = ticket.priority.toUpperCase();
        document.getElementById('detail_status').innerText = ticket.status.replaceAll('_', ' ').toUpperCase();
        document.getElementById('detail_email').innerText = ticket.email || '-';
        document.getElementById('detail_deskripsi').innerText = ticket.description || '-';
        document.getElementById('detail_note').innerText = ticket.assignment?.note || '(Belum ada catatan)';

        const selesai = ticket.assignment?.finished_at;
        document.getElementById('detail_selesai').innerText = selesai
            ? new Date(selesai).toLocaleString('id-ID')
            : '(Belum selesai)';

        // Okupasi / Fakultas
        const fakultas = ticket.faculty?.name || ticket.faculty_name || '-';
        document.getElementById('detail_okupasi').innerText = fakultas;

        const link = document.getElementById('detail_link');
        link.href = ticket.site_link;
        link.innerText = ticket.site_link;

        const fileLink = document.getElementById('detail_lampiran');
        const image = document.getElementById('lampiran_image');

        if (ticket.attachment) {
            const fileUrl = `/${ticket.attachment}`;
            fileLink.href = fileUrl;
            fileLink.innerText = 'Lihat Lampiran';

            const ext = ticket.attachment.split('.').pop().toLowerCase();
            if (['jpg', 'jpeg', 'png'].includes(ext)) {
                image.src = fileUrl;
                image.classList.remove('d-none');
            } else {
                image.classList.add('d-none');
            }
        } else {
            fileLink.href = '#';
            fileLink.innerText = '(Tidak ada lampiran)';
            image.classList.add('d-none');
        }
    });
});
</script>

</body>
</html>
