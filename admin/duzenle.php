<?php
session_start();
include('../vt.php');

if (!isset($_SESSION['giris_yapildi']) || $_SESSION['giris_yapildi'] !== true) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];

// Eski veriyi çek
$stmt = $conn->prepare("SELECT * FROM kullanicilar WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "Kullanıcı bulunamadı.";
    exit;
}

// POST işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isim = $_POST['isim'];
    $sifre = md5(trim($_POST['sifre']));
    
    // Sadece GOD yetkili kullanıcılar yetki güncelleyebilir
    if ($_SESSION['yetki'] == 'GOD') {
        $yetki = $_POST['yetki'];
        $stmt = $conn->prepare("UPDATE kullanicilar SET username=?, password=?, yetki=? WHERE id=?");
        $stmt->bind_param("sssi", $isim, $sifre, $yetki, $id);
    } else {
        $stmt = $conn->prepare("UPDATE kullanicilar SET username=?, password=? WHERE id=?");
        $stmt->bind_param("ssi", $isim, $sifre, $id);
    }

    $stmt->execute();
    header("Location: dashboard.php");
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Kullanıcı Düzenle</title>
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
<h2>Kullanıcıyı Düzenle</h2>

<form method="post">
    Username: <input type="text" name="isim" value="<?= htmlspecialchars($user['username']) ?>" required><br><br>
    Şifre: <input type="text" name="sifre" required><br><br>

    <?php if ($_SESSION['yetki'] == 'GOD'): ?>
        <label>Yetki:</label>
        <select name="yetki" required>
            <option value="USER" <?= $user['yetki'] == 'USER' ? 'selected' : '' ?>>USER</option>
            <option value="ADMIN" <?= $user['yetki'] == 'ADMIN' ? 'selected' : '' ?>>ADMIN</option>
            <option value="GOD" <?= $user['yetki'] == 'GOD' ? 'selected' : '' ?>>GOD</option>
        </select><br><br>
    <?php else: ?>
        <!-- Yetki göster ama değiştirme -->
        <p><strong>Yetki:</strong> <?= htmlspecialchars($user['yetki']) ?> (Değiştirilemez)</p>
    <?php endif; ?>

    <input type="submit" value="Güncelle">
</form>

</div>
</body>
</html>
