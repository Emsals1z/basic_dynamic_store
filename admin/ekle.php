<?php
$host = "localhost";
$username = "root";
$password = ""; // genellikle şifre yoktur
$database = "test";

// MySQL bağlantısı
$conn = new mysqli($host, $username, $password, $database);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isim = $_POST['isim'];
    $soyisim = $_POST['soyisim'];
    $yas = $_POST['yas'];
    $dogum_tarihi = $_POST['dogum_tarihi'];

    $stmt = $conn->prepare("INSERT INTO users (isim, soyisim, yas, dogum_tarihi) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $isim, $soyisim, $yas, $dogum_tarihi);
    $stmt->execute();

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kullanıcı Ekle</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .header {
            background-color: #333;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
        }

        .login-button a {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
        }

        .login-button a:hover {
            background-color: #45a049;
        }

        .exit-button a {
            background-color:rgb(175, 76, 76);
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
        }

        .exit-button a:hover {
            background-color:rgb(160, 69, 69);
        }

		.content {
            padding: 30px 20px;
        }

        .content h2 {
            color: #333;
        }

        .content p {
            color: #555;
            line-height: 1.6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th a {
            color: #333;
            text-decoration: none;
        }

        th a:hover {
            text-decoration: underline;
        }

        .actions a {
            margin-right: 10px;
            color: #4CAF50;
            text-decoration: none;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        .add-button {
            display: inline-block;
            margin-top: 20px;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .add-button:hover {
            background-color: #45a049;
        }
  </style>
</head>
<body>
<div class="header">
    <div class="logo">Veri ekle</div>
    <div class="exit-button">
        <a href="cikis.php">Çıkış</a>
    </div>
</div>
<div class="content">
<h2>Yeni Kullanıcı Ekle</h2>

<form method="post">
    Username: <input type="text" name="isim" required><br><br>
    Pas: <input type="text" name="soyisim" required><br><br>
    Yaş: <input type="number" name="yas" required><br><br>
    Doğum Tarihi: <input type="date" name="dogum_tarihi" required><br><br>
    <input type="submit" value="Kaydet">
</form>
</div>
</body>
</html>
