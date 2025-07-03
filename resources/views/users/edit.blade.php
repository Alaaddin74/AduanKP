<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Tiket</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Tiket</h4>
        </div>
        <div class="card-body">

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Notifikasi Error -->
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Edit Tiket -->
            <form action="{{ route('ticket.update', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Keluhan -->
                <div class="mb-3">
                    <label for="category" class="form-label">Keluhan</label>
                    <select name="category" id="category" class="form-select" required>
                        <option value="konten_tidak_pantas" {{ $ticket->category == 'konten_tidak_pantas' ? 'selected' : '' }}>Situs Judi</option>
                        <option value="menghapus_index" {{ $ticket->category == 'menghapus_index' ? 'selected' : '' }}>Pornografi</option>
                        <option value="lainnya" {{ $ticket->category == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <!-- Prioritas -->
                <div class="mb-3">
                    <label class="form-label d-block">Prioritas</label>
                    @foreach (['low', 'medium', 'high'] as $level)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="priority" id="priority_{{ $level }}" value="{{ $level }}" {{ $ticket->priority == $level ? 'checked' : '' }}>
                            <label class="form-check-label" for="priority_{{ $level }}">{{ ucfirst($level) }}</label>
                        </div>
                    @endforeach
                </div>

                <!-- Link Situs -->
                <div class="mb-3">
                    <label for="site_link" class="form-label">Link Situs</label>
                    <input type="text" name="site_link" id="site_link" class="form-control" value="{{ old('site_link', $ticket->site_link) }}" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email Pelapor</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $ticket->email) }}" required>
                </div>

                <!-- Lampiran -->
                <div class="mb-3">
                    <label for="attachment" class="form-label">Lampiran Baru (Opsional)</label>
                    <input type="file" name="attachment" id="attachment" class="form-control" accept=".jpg,.jpeg,.png">
                    @if ($ticket->attachment)
                        <small class="text-muted d-block mt-2">
                            Lampiran sekarang:
                            <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank">Lihat File</a>
                        </small>
                    @endif
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">← Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
