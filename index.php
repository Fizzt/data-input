<?php
// Sambungkan ke database
$servername = "localhost"; // Ganti sesuai dengan server database Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "mahasiswa";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nim = $_POST["nim"];
  $nama = $_POST["nama"];
  $tempat_lahir = $_POST["tempat_lahir"];
  $tanggal_lahir = $_POST["tanggal_lahir"];
  $alamat = $_POST["alamat"];

  // Validasi apakah NIM sudah ada dalam database
  $check_sql = "SELECT * FROM data_mahasiswa WHERE nim='$nim'";
  $check_result = $conn->query($check_sql);
  if ($check_result->num_rows > 0) {
      echo "<script>alert('Data dengan NIM yang sama sudah ada dalam database.');</script>";
  } else {
      // Masukkan data ke database
      $sql = "INSERT INTO data_mahasiswa (nim, nama, tempat_lahir, tanggal_lahir, alamat) VALUES ('$nim', '$nama', '$tempat_lahir', '$tanggal_lahir', '$alamat')";

      if ($conn->query($sql) === TRUE) {
          // Redirect untuk menghindari resubmission saat merefresh halaman
          header("Location: index.php");
          exit();
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
      }
  }
}

// Ambil data dari database
$sql = "SELECT * FROM data_mahasiswa";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Mahasiswa</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Input Data Mahasiswa</h1>
        <p>Masukkan anda untuk mendaftar di Univers of Human</p>
    </header>
    <div class="container">
        <div class="form-container">
            <h2>Input Data</h2>
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <label for="nim">NIM:</label><br>
                <input type="text" id="nim" name="nim" required><br>
                <label for="nama">Nama:</label><br>
                <input type="text" id="nama" name="nama" required><br>
                <label for="tempat_lahir">Tempat Lahir:</label><br>
                <input type="text" id="tempat_lahir" name="tempat_lahir" required><br>
                <label for="tanggal_lahir">Tanggal Lahir:</label><br>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" required><br>
                <label for="alamat">Alamat:</label><br>
                <textarea id="alamat" name="alamat" required></textarea><br><br>
                <input type="submit" value="Submit">
            </form>
        </div>
        
        <div class="data-container">
            <h2>Data Mahasiswa</h2>
            <table>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["nim"] . "</td>";
                        echo "<td>" . $row["nama"] . "</td>";
                        echo "<td>" . $row["tempat_lahir"] . "</td>";
                        echo "<td>" . $row["tanggal_lahir"] . "</td>";
                        echo "<td>" . $row["alamat"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada data</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>


<?php
// Tutup koneksi database
$conn->close();
?>
