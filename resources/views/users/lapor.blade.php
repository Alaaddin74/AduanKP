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
     .g-recaptcha {
     margin-top: 15px;
    }

    .body {
      background-color: #1a3365;
      color: white;
      font-family: 'Segoe UI', sans-serif;
    }

    .burger-btn {
      display: none;
      background: none;
      border: none;
      color: white;
      font-size: 1.8rem;
      position: fixed;
      top: 15px;
      left: 15px;
      z-index: 1100;
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
      transition: transform 0.3s ease;
      z-index: 1000;
    }

    .sidebar h4 {
      margin-bottom: 30px;
    }

    .sidebar p {
      margin-bottom: 0.2rem;
      color: #cfd8dc;
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
      background-image: linear-gradient(rgba(0, 51, 102, 0.4), rgba(0, 51, 102, 0.4)), url('/attachments/a.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
        min-height: 100vh;
        margin-left: 250px;
        transition: margin-left 0.3s ease;
    }

    .container-report {
      background-color: rgba(255, 255, 255, 0.85); /* putih transparan */
  padding: 30px;
  border-radius: 8px;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
  color: #000; /* teks tetap gelap agar bisa dibaca */
  max-width: 800px;
  margin: auto;
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
      border: none;
      padding: 10px 15px;
      border-radius: 4px;
      text-decoration: none;
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

    @media (max-width: 767.98px) {
  /* Sidebar dan tombol burger */
  .sidebar {
    transform: translateX(-100%);
    z-index: 1000;
    padding-top: 60px;
    justify-content: space-between;
  }

  .sidebar.active {
    transform: translateX(0);
  }

  .burger-btn {
    display: block;
    position: fixed;
    top: 15px;
    left: 15px;
    z-index: 1050;
  }

  /* Konten utama */
  .main {
    margin-left: 0;
    padding: 15px;
  }

  /* Formulir laporan */
  .container-report {
    width: 100%;
    max-width: 100%;
    padding: 20px 15px;
    margin-top: 80px; 
    box-shadow: none;
    border-radius: 0;
  }

  /* Grup radio */
  .radio-group {
    flex-direction: column;
    gap: 10px;
  }

  /* Tombol Reset dan Lapor */
  .d-flex.justify-content-between {
    flex-direction: column;
    gap: 10px;
    margin-top: 10px;
  }

  /* Tombol full width di mobile */
  .btn-back,
  .btn-submit,
  .btn-secondary {
    width: 100%;
    text-align: center;
  }

  /* Preview gambar */
  .preview {
    width: 100%;
    height: auto;
    margin-top: 10px;
  }

  /* Form control */
  .form-control,
  .form-select,
  textarea {
    font-size: 15px;
    padding: 10px;
  }

  /* Spasi antar field */
  .container-report > *:not(:last-child) {
    margin-bottom: 12px;
  }
    .btn-submit,
    .btn-secondary {
      width: 100%;
      text-align: center;
      margin-bottom: 10px;
    }
}
  </style>
  <!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>
<body>

  <!-- Tombol burger -->
  <button class="burger-btn" onclick="toggleSidebar()">
    <i class="bi bi-list"></i>
  </button>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="d-flex align-items-center mb-4">
      <img src="{{ asset('attachments/Logo_UnivLampung.png') }}" alt="Logo Unila" class="logo-unila me-2">
      <h4 class="mb-0">Aduan Konten</h4>
    </div>
    <p>{{ strtoupper('Pengguna Umum') }}</p>
    <a href="{{ route('user.dashboard') }}"><i class="bi bi-house"></i> Dashboard</a>
    <a href="{{ route('lapor.create') }}"><i class="bi bi-plus-circle"></i> Buat Ticket</a>
    <div class="mt-auto text-center pt-4">
      <a href="https://tik.unila.ac.id/" target="_blank" class="copyright-link">© 2025 UPT TIK Unila</a>
    </div>
  </div>

  <!-- Main Form -->
  <div class="main">
      @if(session('success'))
 <div class="alert alert-success alert-dismissible fade show" role="alert">
  <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

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
        
        <label for="nama">Nama<span style="color: red;">*</span></label>
        <input type="text" name="name" class="form-control" required>
        
        <label for="okupasi">Okupasi <span style="color: red;">*</span></label>
        <select name="okupasi" id="okupasi" class="form-select" required onchange="toggleLainnyaBox(this.value)">
          <option value="">-- Pilih Okupasi --</option>
            <option value="mahasiswa">Mahasiswa</option>
            <option value="dosen">Dosen</option>
            <option value="tendik">Tenaga Kependidikan</option>
            <option value="umum">Pengguna Umum</option>
        </select>

        <label for="no  _hp">No HP</label>
        <input type="text" name="phone_number" class="form-control">

        <label for="email">Email <span style="color: red;">*</span></label>
        <input type="email" name="email" id="email" class="form-control" required>

        <label for="keluhan">Kategori <span style="color: red;">*</span></label>
        <select name="category" id="category" class="form-select" required>
          <option value="">-- Pilih Kategori --</option>
          <option value="konten_tidak_pantas">Konten Tidak Pantas</option>
          <option value="menghapus_index">Menghapus Index</option>
          <option value="pornografi">Pornografi</option>
          <option value="judi_online">Judi Online</option>
        </select>
       <label for="link">Link Situs <span style="color: red;">*</span></label>
        <input type="text" name="link" id="link" class="form-control" placeholder="https://example.com" required>

       <label for="description">Catatan <span style="color: red;">*</span></label>
        <textarea name="description" id="description" rows="4" class="form-control" required placeholder="Jelaskan secara rinci masalah Anda..."></textarea>

        <div class="lampiran">
            <label for="lampiran">Lampiran <span style="color: red;">*</span></label>
          <input type="file" name="lampiran" id="lampiran" class="form-control" accept=".jpeg,.jpg,.png">
          <div class="note">File .JPEG, .JPG, .PNG maksimal 2 MB</div>
          <div class="preview">Preview Gambar</div>
        </div>
        
        <div class="mb-3">
          <script src="https://www.google.com/recaptcha/api.js" async defer></script>
          <div class="g-recaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"></div>
          @if ($errors->has('g-recaptcha-response'))
         <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
          @endif
        </div>
            <button type="reset" class="btn btn-secondary me-2">Reset</button>
            <button type="submit" class="btn-submit btn">Lapor!</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Script -->
  <script>
  function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('active');
  }

  document.querySelectorAll('.sidebar a').forEach(link => {
    link.addEventListener('click', () => {
      document.getElementById('sidebar').classList.remove('active');
    });
  });

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


  //Inisialisasi Select2 untuk semua dropdown
  $(document).ready(function () {
    $('select').select2({
      theme: 'bootstrap-5',
      width: '100%',
      placeholder: '-- Pilih --',
      allowClear: true
    });
  });
</script>

  <!-- jQuery dan Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</body>
</html>
