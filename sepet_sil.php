<?php
session_start();
include("vt.php");

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$kullanici_id = intval($_SESSION['id']);
$urun_id = isset($_GET['urun_id']) ? intval($_GET['urun_id']) : 0;

if ($urun_id > 0) {
    $sil = $connect->prepare("DELETE FROM sepet WHERE kullanici_id = ? AND urun_id = ?");
    $sil->execute([$kullanici_id, $urun_id]);
}

header("Location: sepet.php");
exit;
