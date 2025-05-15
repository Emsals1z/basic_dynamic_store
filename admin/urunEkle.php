<script type="text/javascript" src="../js/sweetalert.min.js"></script>
<?php

$sayfa = "Ürünler";
include('../vt.php');

include('ekler/head.php');
include('ekler/nav.php');
include('ekler/sidebar.php');

if ($_POST) { // Sayfada post olup olmadığını kontrol ediyoruz.

    $baslik = $_POST['baslik']; // Sayfa yenilendikten sonra post edilen değerleri değişkenlere atıyoruz
    $icerik = $_POST['icerik'];
    $ustBaslik = $_POST['ustBaslik'];
    $sira = $_POST['sira'];
    $fiyat = $_POST['fiyat'];
    $aktif = 0;
    if (isset($_POST['aktif'])) $aktif = 1;
    $hata = "";

    // Veri alanlarının boş olmadığını kontrol ettiriyoruz. başka kontrollerde yapabilirsiniz.
    if ($baslik <> "" && $icerik <> "" && isset($_FILES['foto'])) {

        if ($_FILES['foto']['error'] != 0) {
            $hata .= 'Dosya yüklenirken hata gerçekleşti lütfen daha sonra tekrar deneyiniz.';
        } else {

            $dosya_adi = strtolower($_FILES['foto']['name']);
            if (file_exists('images/' . $dosya_adi)) {
                $hata .= " $dosya_adi diye bir dosya var";
            } else {
                $boyut = $_FILES['foto']['size'];
                if ($boyut > (1024 * 1024 * 2)) {
                    $hata .= ' Dosya boyutu 2MB den büyük olamaz.';
                } else {
                    $dosya_tipi = $_FILES['foto']['type'];
                    $dosya_uzanti = explode('.', $dosya_adi);
                    $dosya_uzanti = $dosya_uzanti[count($dosya_uzanti) - 1];

                    if (!in_array($dosya_tipi, ['image/png', 'image/jpeg']) || !in_array($dosya_uzanti, ['png', 'jpg'])) {
                        //if (($dosya_tipi != 'image/png' || $dosya_uzanti != 'png' )&&( $dosya_tipi != 'image/jpeg' || $dosya_uzanti != 'jpg')) {
                        $hata .= ' Hata, dosya türü JPEG veya PNG olmalı.';
                    } else {
                        $foto = $_FILES['foto']['tmp_name'];
                        copy($foto, '../img/' . $dosya_adi);


                        //Eklencek veriler diziye ekleniyor
                        $satir = [
                            'foto' => $dosya_adi,
                            'baslik' => $baslik,
                            'ustBaslik' => $ustBaslik,
                            'sira' => $sira,
                            'fiyat' => $fiyat,
                            'aktif' => $aktif,
                            'icerik' => $icerik,
                        ];

                        // Veri ekleme sorgumuzu yazıyoruz.
                        $sql = "INSERT INTO urunler SET foto=:foto, baslik=:baslik,aktif=:aktif,sira=:sira,fiyat=:fiyat, ustBaslik=:ustBaslik, icerik=:icerik;";
                        $durum = $connect->prepare($sql)->execute($satir);

                        if ($durum) {
                            echo '<script>swal("Başarılı","Ürün Eklendi","success").then((value)=>{ window.location.href = "urunleradmin.php"});

</script>';
                        }


                    }
                }
            }
        }
    }
    if($hata!=""){
        echo '<script>swal("Hata","'.$hata.'","error");</script>';
    }
}
?>

<script src="vendor/CKEditor5/ckeditor.js"></script>
<div id="content-wrapper">


        <!-- DataTables Example -->
        <div class="card mb-3">

            <div class="card-body">

                <form method="post" action="urunEkle.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <input required type="file" name="foto" class="form-control-file" id="foto">
                    </div>
                    <div class="form-group">
                        <label>Üst Başlık</label>
                        <input required type="text" class="form-control" name="ustBaslik" placeholder="Üst başlık">
                    </div>
                    <div class="form-group">
                        <label>Başlık</label>
                        <input required type="text" class="form-control" name="baslik" placeholder="Başlık">
                    </div>

                    <div class="form-group">
                        <label for="icerik">İçerik</label>
                        <textarea name="icerik" id="icerik"></textarea>

                        <script>
                            ClassicEditor
                                .create(document.querySelector('#icerik'))
                                .then(editor => {
                                    console.log(editor);
                                })
                                .catch(error => {
                                    console.error(error);
                                });
                        </script>

                    </div>

                    <div class="form-group">
                        <label>Sıra</label>
                        <input required type="text" class="form-control" name="sira" placeholder="Sıra">
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="aktif" id="aktif">
                        <label class="form-check-label" for="aktif">Aktif mi?</label>
                    </div>
                    <div class="form-group">
                        <label>Sıra</label>
                        <input required type="text" class="form-control" name="fiyat" placeholder="Fiyat">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                    </div>

                </form>


            </div>
        </div>
     
   

        <!-- /.container-fluid -->
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
        <script src="js/aktifcustom.js"></script>
     