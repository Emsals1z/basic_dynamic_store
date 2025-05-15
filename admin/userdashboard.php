<?php
session_start();
include('../vt.php');
$sayfa = "Ayarlar";

include('ekler/head.php');
include('ekler/nav.php');

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$kullanici_id = $_SESSION['id'];

$sorgu = $connect->prepare("SELECT s.*, u.baslik,u.foto FROM siparisler s
JOIN urunler u ON u.id = s.urun_id
WHERE s.kullanici_id = ?
ORDER BY s.id DESC");
$sorgu->execute([$kullanici_id]);
$siparisler = $sorgu->fetchAll(PDO::FETCH_ASSOC);


?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['yeni_ad'])) {
    $yeni_ad = trim($_POST['yeni_ad']);
    $kullanici_id = $_SESSION['id'];
    
    $guncelle = $connect->prepare("UPDATE kullanicilar SET username = ? WHERE id = ?");
    $guncelle->execute([$yeni_ad, $kullanici_id]);

    $_SESSION['username'] = $yeni_ad;
    echo "<script>
    alert('Adınız başarıyla güncellendi!');
        window.location.href = 'userdashboard.php';
</script>";
 
}
$sorgu = $connect->prepare("SELECT username FROM kullanicilar WHERE id = ?");
$sorgu->execute([$_SESSION['id']]);
$kullanici = $sorgu->fetch();
?>


<div class="content">
    <div id="content-wrapper">
        <div class="container-fluid">

            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Ayarlar</a></li>
                <li class="breadcrumb-item active">Ana menü</li>
            </ol>
            <div class="card mb-3">
                <div class="card-header"><i class="fas fa-table"></i> Adınızı Değiştirin</div>
                <div class="card-body">
                <form method="POST">
    <input type="text" name="yeni_ad" value="<?= htmlspecialchars($kullanici['username']) ?>" required>
    <button type="submit">Güncelle</button>
</form>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header"><i class="fas fa-table"></i> Siparişlerin</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered"  id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>Ürün Adı</th>
                                    <th>Adet</th>
                                    <th>Durum</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($siparisler as $siparis): ?>
                                <tr>
                                <td><img src="../img/<?= $siparis['foto'] ?>" width="80"></td>
                                    <td><?= $siparis['baslik'] ?></td>
                                    <td><?= $siparis['adet'] ?></td>
                                    <td><?= $siparis['durum'] ?? 'Beklemede' ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
          
            
   
        </div>
    </div>
</div>

    <?php
    include('ekler/footer.php');
    ?>

    
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            language: {
                info: "_TOTAL_ kayıttan _START_ - _END_ kayıt gösteriliyor.",
                infoEmpty: "Gösterilecek hiç kayıt yok.",
                loadingRecords: "Kayıtlar yükleniyor.",
                zeroRecords: "Tablo boş",
                search: "Arama:",
                sLengthMenu: "Sayfada _MENU_ kayıt göster",
                infoFiltered: "(toplam _MAX_ kayıttan filtrelenenler)",
                buttons: {
                    copyTitle: "Panoya kopyalandı.",
                    copySuccess: "Panoya %d satır kopyalandı",
                    copy: "Kopyala",
                    print: "Yazdır",
                },

                paginate: {
                    first: "İlk",
                    previous: "Önceki",
                    next: "Sonraki",
                    last: "Son"
                },
            }
        });
       
    });

</script>
