<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Layanan Laporan</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #e0e0e0;
      padding: 30px;
    }
    .container {
      background: #fff;
      padding: 30px;
      max-width: 700px;
      margin: auto;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
    }
    h2 {
      color: #888;
    }
    label {
      display: block;
      margin: 15px 0 5px;
    }
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
    .lampiran {
      margin-top: 20px;
    }
    .preview {
      margin-top: 10px;
      width: 200px;
      height: 150px;
      background: #ccc;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .btn-reset, .btn-submit, .btn-back {
      padding: 10px 15px;
      margin-top: 10px;
    }
    .btn-submit {
      background: #28a745;
      color: white;
      float: right;
    }
    .btn-back {
      background: #6c757d;
      color: white;
      text-decoration: none;
    }
    .note {
      font-size: 12px;
      color: #666;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Layanan Laporan</h2>

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
<label for="okupasi">Okupasi</label>
<input type="text" name="okupasi" id="okupasi" required placeholder="Masukkan pekerjaan, instansi, atau jabatan">


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
      <div style="margin-top: 30px; display: flex; justify-content: space-between;">
        <a href="{{ route('dashboard') }}" class="btn-back">← Kembali ke Dashboard</a>
        <button type="submit" class="btn-submit">Lapor!</button>
      </div>
    </form>
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
  </script>
</body>
</html>
    