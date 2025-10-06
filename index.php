<?php
// Simple upload preview + export button
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

  <form action="export.php" method="post">
    <button type="submit">Export ke Excel</button>
  </form>
</body>

</html>