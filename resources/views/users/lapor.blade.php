<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Layanan Laporan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
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

    label { display: block; margin: 15px 0 5px; }
    select, input[type="text"], input[type="email"], input[type="file"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
    }

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
      background: #ccc;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }

    .btn-reset, .btn-submit, .btn-back {
      padding: 10px 15px;
      margin-top: 10px;
    }

    .btn-submit {
      background: #28a745;
      color: white;
      float: right;
      border: none;
    }

    .btn-back {
      background: #6c757d;
      color: white;
      text-decoration: none;
      border: none;
      padding: 10px 15px;
    }

    .note { font-size: 12px; color: #666; }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <h4>Situs Laporan</h4>
  <p>{{ strtoupper(Auth::user()->name ?? 'Pengguna Umum') }}</p>
  <p class="small text-muted">{{ Auth::user()->email ?? 'Tidak Login' }}</p>
  <a href="{{ route('dashboard') }}"><i class="bi bi-house"></i> Dashboard</a>
  <a href="{{ route('lapor.create') }}"><i class="bi bi-plus-circle"></i> Buat Ticket</a>
</div>

<!-- Main Content -->
<div class="main">
  <div class="container-report">
    <h3 class="mb-4 text-muted">Formulir Laporan</h3>

    <form method="POST" action="{{ route('lapor.store') }}" enctype="multipart/form-data">
      @csrf

      <!-- Keluhan Dropdown -->
      <label for="keluhan">Keluhan</label>
      <select name="keluhan" id="keluhan" required>
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

      <!-- Link Situs -->
      <label for="link">Link Situs</label>
      <input type="text" name="link" id="link" required placeholder="Contoh: https://example.com">

<!-- Okupasi -->
<label for="okupasi">Fakultas / Okupasi</label>
<select name="okupasi" id="okupasi" class="form-select" required>
    <option value="">-- Pilih Fakultas / Okupasi --</option>
    @foreach($faculties as $fakultas)
        <option value="{{ $fakultas->name }}">{{ $fakultas->name }}</option>
    @endforeach
</select>
      <!-- Email -->
      <label for="email">Email</label>
      <input type="email" name="email" id="email" required>

      <!-- Lampiran -->
      <div class="lampiran">
        <label for="lampiran">Lampiran</label>
        <input type="file" name="lampiran" id="lampiran" accept=".jpeg,.jpg,.png">
        <button type="reset" class="btn-reset">Reset</button>
        <div class="note">File .JPEG, .JPG, .PNG - Maks 2 MB</div>
        <div class="preview">Preview Gambar</div>
      </div>

      <!-- Tombol -->
      <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('dashboard') }}" class="btn-back">← Kembali ke Dashboard</a>
        <button type="submit" class="btn-submit">Lapor!</button>
      </div>
    </form>
  </div>
</div>

<script>
  // Preview gambar
  document.getElementById('lampiran').addEventListener('change', function(e) {
    const preview = document.querySelector('.preview');
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(evt) {
        preview.innerHTML = `<img src="${evt.target.result}" style="max-width: 100%; max-height: 100%;">`;
      };
      reader.readAsDataURL(file);
    } else {
      preview.innerHTML = 'Preview Gambar';
    }
  });

  // Tampilkan input manual jika pilih "lainnya"
  function toggleLainnyaBox(value) {
    const lainnyaInput = document.getElementById('okupasi_lainnya');
    if (value === 'lainnya') {
      lainnyaInput.classList.remove('d-none');
      lainnyaInput.required = true;
    } else {
      lainnyaInput.classList.add('d-none');
      lainnyaInput.required = false;
    }
  }
</script>

</body>
</html>
