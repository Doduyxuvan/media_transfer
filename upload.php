<?php
// Periksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Tentukan direktori tempat menyimpan file yang diunggah
    $target_dir = "uploads/";

    // Pastikan direktori ada, jika tidak buat direktori
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Tangkap nama file dan tentukan path lengkapnya
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

    // Variabel untuk memeriksa status upload
    $uploadOk = 1;

    // Periksa apakah file telah diunggah
    if (isset($_POST["submit"])) {
        if (file_exists($target_file)) {
            echo "<p class='error'>Maaf, file sudah ada.</p>";
            $uploadOk = 0;
        }
    }

    // Batasi ukuran file (contoh: 5MB)
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        echo "<p class='error'>Maaf, ukuran file terlalu besar.</p>";
        $uploadOk = 0;
    }

    // Jika tidak ada error, unggah file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "<p class='success'>File " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " berhasil diunggah.</p>";
        } else {
            echo "<p class='error'>Maaf, terjadi kesalahan saat mengunggah file Anda.</p>";
        }
    } else {
        echo "<p class='error'>File tidak diunggah.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unggah dan Unduh File</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        h2 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
        }
        input[type="file"] {
            margin: 10px 0;
            width: 100%;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li a {
            text-decoration: none;
            color: #007BFF;
        }
        li a:hover {
            text-decoration: underline;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }

        /* Responsif */
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            form {
                padding: 10px;
            }
            input[type="submit"] {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
<h2>Form Upload File</h2>
<form action="" method="post" enctype="multipart/form-data">
    Pilih file untuk diunggah:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Unggah File" name="submit">
</form>

<h2>File yang Tersedia</h2>
<ul>
<?php
$dir = "uploads/";
if (is_dir($dir)) {
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            echo '<li><a href="' . $dir . $file . '" download>' . $file . '</a></li>';
        }
    }
}
?>
</ul>
</body>
</html>
