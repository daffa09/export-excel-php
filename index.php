<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['images'])) {
  foreach ($_FILES['images']['tmp_name'] as $key => $tmp) {
    $name = $_FILES['images']['name'][$key];
    move_uploaded_file($tmp, "uploads/" . $name);
  }
}

$files = glob("uploads/*.*");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Simulasi Export Gambar ke Excel</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }

    img {
      margin: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      margin-top: 10px;
      padding: 8px 16px;
      cursor: pointer;
    }

    .button-group {
      margin-top: 20px;
    }
  </style>
</head>

<body>
  <h2>Upload Gambar</h2>
  <form method="post" enctype="multipart/form-data">
    <input type="file" name="images[]" multiple required>
    <button type="submit">Upload</button>
  </form>

  <h3>Gambar yang sudah diupload:</h3>
  <?php foreach ($files as $f): ?>
    <img src="<?= $f ?>" width="100">
  <?php endforeach; ?>

  <div class="button-group">
    <form action="export.php" method="post" style="display:inline;">
      <button type="submit">Export ke Excel</button>
    </form>

    <!-- Tombol menuju print.php -->
    <form action="print.php" method="post" target="_blank" style="display:inline;">
      <input type="hidden" name="files" value='<?= json_encode($files) ?>'>
      <button type="submit">Print PDF</button>
    </form>
  </div>
</body>

</html>