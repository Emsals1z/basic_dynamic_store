<?php
session_start();

if (!isset($_SESSION['giris_yapildi']) || $_SESSION['giris_yapildi'] !== true ) {

    echo "<script>
        alert('Önce giriş yapmalısın!');
        window.location.href = '../login.php';
    </script>";
    exit;
}
if($_SESSION['yetki'] !== "GOD" && $_SESSION['yetki'] !== "ADMIN"){
    echo "<script>
    alert('Adminlere özel bura!');
    window.location.href = '../index.php';
</script>";
exit;   
}

$sayfa = "Ana Sayfa";
include('../vt.php');
include('ekler/head.php');
include('ekler/nav.php');
include('ekler/sidebar.php');


// Sıralama işlemi
$orderby = "id";
if (isset($_GET['sort'])) {
    if ($_GET['sort'] == 'isim') {
        $orderby = "isim";
    } elseif ($_GET['sort'] == 'soyisim') {
        $orderby = "soyisim";
    }
}

$sql = "SELECT * FROM kullanicilar ORDER BY $orderby ASC";
$result = $conn->query($sql);

$sorgu = $connect->prepare("SELECT * FROM anasayfa");
$sorgu->execute();

?>


<div class="content">
    <h2>Dashboard</h2>
    <p>Başarıyla giriş yapıldı ve dashboarda ulaşıldı.</p>

    <div class="card mb-3">
    <h2>Kullanıcı düzenleme</h2>
    <!-- <a href="ekle.php" class="add-button">Yeni Kullanıcı Ekle</a> -->

    <table>
        <thead>
            <tr>
            <th><a href="?sort=username">Username</a></th>
            <th>Yetki</th>
            <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['yetki']) ?></td>
                    <td class="actions">
                        <a href="duzenle.php?id=<?= $row['id'] ?>">Düzenle</a> | 
                        <a href="kullanicisil.php?id=<?= $row['id'] ?>" onclick="return confirm('Emin misin?')">Sil</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">Kayıt bulunamadı.</td></tr>
        <?php endif; ?>
    </tbody>
    </table>
    </div>
    <hr>

    <div class="card mb-3">
    <h2>Ana Sayfa Düzenleme</h2>
<div class="card-body">


    <div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>ID</th>
                <th>Foto</th>
                <th>Üst Başlık</th>
                <th>Üst İçerik</th>
                <th>LİNK</th>
                <th>Alt Başlık</th>
                <th>Alt İçerik</th>
                <th>Düzenle</th>


            </tr>
            </thead>

            <tbody>

            <?php while ($sonuc = $sorgu->fetch()) { ?>
                <tr>
                    <td><?= $sonuc["id"] ?></td>
                    <td><img src="../img/<?= $sonuc["foto"] ?>" width="150px"/></td>
                    <td><?= $sonuc["ustBaslik"] ?></td>
                    <td><a class="btn btn-info" href="#" data-toggle="modal"
                           data-target="#icerik<?= $sonuc["id"] ?>">Oku</a>
                        <!-- Logout Modal-->
                        <div class="modal fade" id="icerik<?= $sonuc["id"] ?>" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">İçerik</h5>
                                        <button class="close" type="button" data-dismiss="modal"
                                                aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body"><?= $sonuc["ustIcerik"] ?></div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button"
                                                data-dismiss="modal">Kapat
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td><?= $sonuc["link"] ?></td>

                    <td><?= $sonuc["altBaslik"] ?></td>
                    <td><a class="btn btn-info" href="#" data-toggle="modal"
                           data-target="#icerik1<?= $sonuc["id"] ?>">Oku</a>
                        <!-- Logout Modal-->
                        <div class="modal fade" id="icerik1<?= $sonuc["id"] ?>" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">İçerik</h5>
                                        <button class="close" type="button" data-dismiss="modal"
                                                aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body"><?= $sonuc["altIcerik"] ?></div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button"
                                                data-dismiss="modal">Kapat
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td><a class="btn btn" href="anasayfaGuncelle.php?id=<?= $sonuc["id"] ?>"><span
                                    class="fa fa-edit fa-2x"></span></a></td>

                </tr>
                <?php
            } //while bitimi
            ?>
            </tbody>
        </table>
    </div>
</div>


    <?php
    include('ekler/footer.php');
    ?>
