<?php
session_start();
$sayfa = "Siparişler";
include('../vt.php');
include('ekler/head.php');
include('ekler/nav.php');
include('ekler/sidebar.php');

$sorgu = $connect->prepare("
    SELECT 
        s.id AS siparis_id,
        s.adet,
        s.siparis_tarihi,
        u.username,
        ur.baslik AS urun_adi,
        ur.fiyat,
        ur.foto,
        s.durum
    FROM siparisler s
    JOIN kullanicilar u ON s.kullanici_id = u.id
    JOIN urunler ur ON s.urun_id = ur.id
    ORDER BY s.siparis_tarihi DESC
");
$sorgu->execute();


require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$dosya = '../sepet.xlsx';



// Silme işlemi
if (isset($_GET['sil'])) {
    $silSatir = (int)$_GET['sil'];
    $spreadsheet = IOFactory::load($dosya);
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->removeRow($silSatir, 1);

    $writer = new Xlsx($spreadsheet);
    $writer->save($dosya);
    echo "<script>window.location.href='siparis.php';</script>";
    exit;
}


// Listeleme işlemi
$spreadsheet = IOFactory::load($dosya);
$sheet = $spreadsheet->getActiveSheet();
?>
<div class="content">
    <div id="content-wrapper">
        <div class="container-fluid">

            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Siparişler</li>
            </ol>

            <div class="card mb-3">
                <div class="card-header"><i class="fas fa-table"></i> Sipariş Listesi</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered"  id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Sipariş ID</th>
                                    <th>Sipariş Foto</th>
                                    <th>Ürün Adı</th>
                                    <th>Kullanıcı Adı</th>
                                    <th>Adet</th>
                                    <th>Ürün Fiyat</th>
                                    <th>Toplam</th>
                                    <th>Sipariş Tarihi</th>
                                    <th>Durum</th>
                                </tr>
                            </thead>
                            <tbody>
                       <?php while ($siparis = $sorgu->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <tr>
                                        <td><?= $siparis['siparis_id'] ?></td>
                                        <td><img src="../img/<?= $siparis['foto'] ?>" width="80"></td>
                                        <td><?= htmlspecialchars($siparis['urun_adi']) ?></td>
                                        <td><?= htmlspecialchars($siparis['username']) ?></td>
                                        <td><?= $siparis['adet'] ?></td>
                                        <td><?= number_format($siparis['fiyat'], 2) ?> ₺</td>
                                        <td><?= number_format($siparis['fiyat'] * $siparis['adet'], 2) ?> ₺</td>
                                        <td><?= date("d.m.Y H:i", strtotime($siparis['siparis_tarihi'])) ?></td>
                                        <td>
                                            <select class="form-control durumSelect" data-id="<?= $siparis['siparis_id'] ?>">
                                            <option value="hazırlanıyor" <?= $siparis['durum'] == 'hazırlanıyor' ? 'selected' : '' ?>>Hazırlanıyor</option>
                                            <option value="kargolandı" <?= $siparis['durum'] == 'kargolandı' ? 'selected' : '' ?>>Kargolandı</option>
                                            <option value="tamamlandı" <?= $siparis['durum'] == 'tamamlandı' ? 'selected' : '' ?>>Tamamlandı</option>
                                        </select>
                                    </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
               
            
            <div class="card mb-3">
            <div class="card-header"><i class="fas fa-table"></i> Sepet Geçmişi</div>
            <div class="card-body">
            <div class="table-responsive">
            <table class="table table-bordered"  id="dataTable2" width="100%" cellspacing="0">
            <thead>
    <tr>
        <th>Siparis İd</th>
        <th>Kullnaııc Adı</th>
        <th>Ürün ID</th>
        <th>Ürün Adı</th>
        <th>Adet</th>
        <th>Fiyat</th>
        <th>Toplam</th>
        <th>Sil</th>
    </tr>
    </thead>
    <tbody>
    <?php
      $toplamSatir = $sheet->getHighestRow();
      if ($toplamSatir >= 2) {
          foreach ($sheet->getRowIterator(2) as $row) {
              $rowIndex = $row->getRowIndex();
              $sid = $sheet->getCell('A' . $rowIndex)->getValue();
              $ad = $sheet->getCell('B' . $rowIndex)->getValue();
              $uid = $sheet->getCell('C' . $rowIndex)->getValue();
              $uad = $sheet->getCell('D' . $rowIndex)->getValue();
              $adet = $sheet->getCell('E' . $rowIndex)->getValue();
              $fiyat = $sheet->getCell('F' . $rowIndex)->getValue();
              $toplam = $sheet->getCell('G' . $rowIndex)->getValue();
              if ($sid || $ad) {
                  echo "<tr>";
                  echo "<form method='post'>";
                  echo "<td>$sid</td>";
                  echo "<td>$ad</td>";
                  echo "<td>$uid</td>";
                  echo "<td>$uad</td>";
                  echo "<td>$adet</td>";
                  echo "<td>$fiyat</td>";
                  echo "<td>$toplam</td>";
                  echo "<td>
                  <input type='hidden' name='satir' value='$rowIndex'>
                  <a href='?sil=$rowIndex' onclick='return confirm(\"Silmek istediğinize emin misiniz?\")'>Sil</a>
                  </td>";
                  echo "</form>";
                  echo "</tr>";
                }
            }
            
        }
        
        ?>
         </tbody>
        </table>
        </div>
        </div>
        </div>
        </div>
    </div>
</div>

<?php include('ekler/footer.php'); ?>


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
        $('#dataTable2').DataTable({
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
<script>
$(document).ready(function () {
    $(".durumSelect").change(function () {
        var durum = $(this).val();
        var siparisId = $(this).data("id");

        $.ajax({
            url: "siparisDurumGuncelle.php",
            method: "POST",
            data: {
                id: siparisId,
                durum: durum
            },
            success: function (response) {
                alert("Durum güncellendi:", response);
            
            },
            error: function () {
                alert("Durum güncellenirken hata oluştu.");
            }
        });
    });
});
</script>
