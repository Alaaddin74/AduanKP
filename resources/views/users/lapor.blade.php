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
  body {
    background-color: #1a3365; /* Biru tua sebagai latar utama */
    color: white;
    font-family: 'Segoe UI', sans-serif;
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
    padding: 30px;
    background-color: #1a3365;
    min-height: 100vh;
  }

  .container-report {
    background: white; 
    padding: 30px;
    max-width: 800px;
    margin: auto;
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
    border-radius: 8px;
    color: #333;
  }

  .container-report h3 {
    color: #333;
  }

  label {
    margin-top: 15px;
    margin-bottom: 5px;
    font-weight: 600;
  }

  .form-control,
  .form-select,
  textarea {
    background-color: #f8f9fa;
    color: #212529;
    border: 1px solid #ced4da;
  }

  .radio-group {
    display: flex;
    gap: 20px;
    margin-bottom: 10px;
  }

  .radio-group label {
    font-weight: normal;
  }

  .lampiran {
    margin-top: 20px;
  }

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
    overflow: hidden;
  }

  .btn-submit {
    background: #3b7ddd;
    color: white;
    border: none;
    padding: 10px 15px;
    font-weight: bold;
    border-radius: 4px;
  }

  .btn-submit:hover {
    background: #2f65b3;
  }

  .btn-back {
    background: #6c757d;
    color: white;
    text-decoration: none;
    border: none;
    padding: 10px 15px;
    border-radius: 4px;
  }

  .btn-back:hover {
    background: #5a6268;
  }

  .note {
    font-size: 12px;
    color: #666;
    margin-top: 5px;
  }

  .alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
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

<!-- Main Form -->
<div class="main">
  <div class="container-report">
    <h3 class="mb-4 text-muted">Formulir Laporan</h3>
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Terjadi kesalahan:</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

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
