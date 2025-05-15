<?php
include('../vt.php');

if (isset($_POST['id'], $_POST['durum'])) {
    $id = intval($_POST['id']);
    $durum = $_POST['durum'];

    $guncelle = $connect->prepare("UPDATE siparisler SET durum = ? WHERE id = ?");
    $guncelle->execute([$durum, $id]);

    if ($guncelle->rowCount()) {
        echo "ok";
    } else {
        echo "fail";
    }
}
?>
