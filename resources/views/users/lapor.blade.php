<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Layanan Laporan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body { background-color: #f4f6f9; }
    .sidebar {
      height: 100vh;
      background-color: #343a40;
      color: white;
      padding: 20px;
      position: fixed;
      top: 0;
      left: 0;
      width: 250px;
    }
    .sidebar h4 { margin-bottom: 30px; }
    .sidebar a {
      display: block;
      color: #ccc;
      text-decoration: none;
      margin: 15px 0;
    }
    .sidebar a:hover { color: #fff; }
    .main {
      margin-left: 270px;
      padding: 30px;
    }
    .container-report {
      background: #fff;
      padding: 30px;
      max-width: 800px;
      margin: auto;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    label { margin-top: 15px; margin-bottom: 5px; }
    .radio-group {
      display: flex;
      gap: 20px;
      margin-bottom: 10px;
    }
    .lampiran { margin-top: 20px; }
    .preview {
      margin-top: 10px;
      width: 200px;
      height: 150px;
      background: #e9ecef;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      border: 1px solid #ced4da;
      border-radius: 4px;
    }
    .btn-reset, .btn-submit, .btn-back {
      padding: 10px 15px;
      border: none;
    }
    .btn-submit {
      background: #28a745;
      color: white;
    }
    .btn-back {
      background: #6c757d;
      color: white;
      text-decoration: none;
    }
    .note { font-size: 12px; color: #666; margin-top: 5px; }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <h4>Situs Laporan</h4>
  <p>{{ strtoupper(Auth::user()->name ?? 'Pengguna Umum') }}</p>
  <p class="small text-muted">{{ Auth::user()->email ?? 'Tidak Login' }}</p>
  <a href="{{ route('user.dashboard') }}"><i class="bi bi-house"></i> Dashboard</a>
  <a href="{{ route('lapor.create') }}"><i class="bi bi-plus-circle"></i> Buat Ticket</a>
</div>

<!-- Main Form -->
<div class="main">
  <div class="container-report">
    <h3 class="mb-4 text-muted">Formulir Laporan</h3>

    <form method="POST" action="{{ route('lapor.store') }}" enctype="multipart/form-data">
      @csrf

      <!-- Keluhan -->
      <label for="keluhan">Keluhan</label>
      <select name="keluhan" id="keluhan" class="form-select" required>
        <option value="">-- Pilih Keluhan --</option>
        <option value="konten_tidak_pantas">Konten Tidak Pantas</option>
        <option value="menghapus_index">Menghapus Index</option>
        <option value="pornografi">Pornografi</option>
        <option value="judi_online">Judi Online</option>
        <option value="lainnya">Lainnya</option>
      </select>

      <!-- Prioritas -->
      <label>Prioritas</label>
      <div class="radio-group">
        <label><input type="radio" name="prioritas" value="low" required> Low</label>
        <label><input type="radio" name="prioritas" value="medium"> Medium</label>
        <label><input type="radio" name="prioritas" value="high"> High</label>
      </div>

      <!-- Link -->
      <label for="link">Link Situs</label>
      <input type="text" name="link" id="link" class="form-control" placeholder="https://example.com" required>

      <!-- Fakultas -->
      <label for="okupasi">Fakultas / Okupasi</label>
      <select name="okupasi" id="okupasi" class="form-select" required onchange="toggleLainnyaBox(this.value)">
        <option value="">-- Pilih Fakultas / Okupasi --</option>
        @foreach($faculties as $fakultas)
          <option value="{{ $fakultas->name }}">{{ $fakultas->name }}</option>
        @endforeach
        <option value="lainnya">Lainnya</option>
      </select>

      <!-- Input lainnya -->
      <input type="text" name="okupasi_lainnya" id="okupasi_lainnya" class="form-control d-none" placeholder="Isi Okupasi Lainnya...">

      <!-- Email -->
      <label for="email">Email</label>
      <input type="email" name="email" id="email" class="form-control" required>

      <!-- Deskripsi -->
      <label for="description">Catatan</label>
      <textarea name="description" id="description" rows="4" class="form-control" required placeholder="Jelaskan secara rinci masalah Anda..."></textarea>

      <!-- Lampiran -->
      <div class="lampiran">
        <label for="lampiran">Lampiran</label>
        <input type="file" name="lampiran" id="lampiran" class="form-control" accept=".jpeg,.jpg,.png">
        <div class="note">File .JPEG, .JPG, .PNG maksimal 2 MB</div>
        <div class="preview">Preview Gambar</div>
      </div>

      <!-- Tombol Aksi -->
      <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('user.dashboard') }}" class="btn-back btn">← Kembali</a>
        <div>
          <button type="reset" class="btn btn-secondary me-2">Reset</button>
          <button type="submit" class="btn-submit btn">Lapor!</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Script -->
<script>
  // Tampilkan preview gambar
  document.getElementById('lampiran').addEventListener('change', function (e) {
    const preview = document.querySelector('.preview');
    const file = e.target.files[0];

    if (file) {
      const reader = new FileReader();
      reader.onload = function (evt) {
        preview.innerHTML = `<img src="${evt.target.result}" style="max-width: 100%; max-height: 100%;">`;
      };
      reader.readAsDataURL(file);
    } else {
      preview.innerHTML = 'Preview Gambar';
    }
  });

  // Tampilkan input "lainnya"
  function toggleLainnyaBox(value) {
    const input = document.getElementById('okupasi_lainnya');
    if (value === 'lainnya') {
      input.classList.remove('d-none');
      input.required = true;
    } else {
      input.classList.add('d-none');
      input.required = false;
    }
  }
</script>

</body>
</html>
