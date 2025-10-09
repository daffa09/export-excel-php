<?php
if (!isset($_POST['files'])) {
  echo "Tidak ada data gambar yang dikirim.";
  exit;
}

$files = json_decode($_POST['files'], true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Print Gambar</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }

    h2 {
      text-align: center;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th,
    td {
      border: 1px solid #333;
      padding: 8px;
      text-align: center;
    }

    th {
      background-color: #f2f2f2;
    }

    img {
      width: 150px;
      border-radius: 4px;
    }

    button {
      margin-top: 20px;
      padding: 10px 16px;
    }

    @media print {
      button {
        display: none;
      }

      body {
        margin: 0;
      }
    }
  </style>
</head>

<body>
  <h2>Daftar Gambar</h2>

  <table>
    <tr>
      <th>Image</th>
      <th>Foto</th>
    </tr>
    <?php foreach ($files as $f): ?>
      <tr>
        <td><?= basename($f) ?></td>
        <td><img src="<?= htmlspecialchars($f) ?>"></td>
      </tr>
    <?php endforeach; ?>
  </table>

</body>
<script>
  window.onload = function() {
    setTimeout(() => {
      window.print();
    }, 500);
  };
</script>

</html>