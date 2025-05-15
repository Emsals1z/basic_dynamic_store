<script type="text/javascript" src="../js/sweetalert.min.js"></script>
<?php

$sayfa = "Ürünler";
include('../vt.php');

include('ekler/head.php');
include('ekler/nav.php');
include('ekler/sidebar.php');


$sorgu = $connect->prepare("SELECT * FROM urunler Where id=:id");
$sorgu->execute(['id' => (int)$_GET["id"]]);
$sonuc = $sorgu->fetch();

       if ($_POST) { 
               $baslik = $_POST['baslik']; 
               $icerik = $_POST['icerik'];
               $ustBaslik = $_POST['ustBaslik'];
               $sira = $_POST['sira'];
               $fiyat = $_POST['fiyat'];
               $aktif = 0;
               if (isset($_POST['aktif'])) $aktif = 1;
               $hata = '';



               if ($_FILES["foto"]["name"] != "") {
                $foto = strtolower($_FILES['foto']['name']);
                if (file_exists('images/' . $foto)) {
                    $hata = "$foto diye bir dosya var";
                } else {
                    $boyut = $_FILES['foto']['size'];
                    if ($boyut > (1024 * 1024 * 2)) {
                        $hata = 'Dosya boyutu 2MB den büyük olamaz.';
                    } else {
                        $dosya_tipi = $_FILES['foto']['type'];
                        $dosya_uzanti = explode('.', $foto);
                        $dosya_uzanti = $dosya_uzanti[count($dosya_uzanti) - 1];

                        if (!in_array($dosya_tipi, ['image/png', 'image/jpeg']) || !in_array($dosya_uzanti, ['png', 'jpg'])) {
                    
                            $hata = 'Hata, dosya türü JPEG veya PNG olmalı.';
                        } else {
                            $dosya = $_FILES["foto"]["tmp_name"];
                            copy($dosya, "../img/" . $foto);
                            unlink('../img/' . $sonuc["foto"]); //eski dosya siliniyor.
                        }
                    }
                }
            } else {
                //Eğer kullanıcı fotoğraf seçmedi ise veri tabanındaki resimi değiştirmiyoruz
                $foto = $sonuc["foto"];
            }

            if ($baslik <> "" && $icerik <> "" && $hata == "") {
                //Değişecek veriler
                $satir = [
                 'id' => $_GET['id'],
                 'foto' => $foto,
                 'baslik' => $baslik,
                 'ustBaslik' => $ustBaslik,
                 'sira' => $sira,
                 'fiyat' => $fiyat,
                 'aktif' => $aktif,
                 'icerik' => $icerik,
             ];
                // Veri güncelleme sorgumuzu yazıyoruz.
             $sql = "UPDATE urunler SET foto=:foto, baslik=:baslik,aktif=:aktif,sira=:sira,fiyat=:fiyat, ustBaslik=:ustBaslik, icerik=:icerik WHERE id=:id;";             
             $durum = $connect->prepare($sql)->execute($satir);

             if ($durum)
             {
                echo '<script>swal("Başarılı","Ürün güncellendi","success").then((value)=>{ window.location.href = "urunleradmin.php"});

                </script>';   
            } else {
                    echo 'Düzenleme hatası oluştu: '; 
                }
            } else {
                echo 'Hata oluştu: ' . $hata; 
            }
            if ($hata != "") {
        echo '<script>swal("Hata","' . $hata . '","error");</script>';
    }
        }

?>
<script src="vendor/CKEditor5/ckeditor.js"></script>
<div id="content-wrapper">
    <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Ürün Ekle</li>
        </ol>


        <!-- DataTables Example -->
        <div class="card mb-3">

            <div class="card-body">

                <form method="post" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <img src="../img/<?= $sonuc["foto"] ?>" width="150" alt="">
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" class="form-control-file" id="foto">
                    </div>
                    <div class="form-group">
                        <label>Üst Başlık</label>
                        <input required type="text" value="<?= $sonuc["ustBaslik"] ?>" class="form-control" name="ustBaslik"
                        placeholder="Üst başlık">
                    </div>
                    <div class="form-group">
                        <label>Başlık</label>
                        <input required type="text" value="<?= $sonuc["baslik"] ?>" class="form-control" name="baslik"
                        placeholder="Başlık">
                    </div>

                    <div class="form-group">
                        <label for="icerik">İçerik</label>
                        <textarea  name="icerik" id="icerik">
                            <?= $sonuc["icerik"] ?>
                        </textarea>

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
                        <input required type="text" value="<?= $sonuc["sira"] ?>" class="form-control" name="sira"
                        placeholder="Sıra">
                    </div>
                    <div class="form-group">
                        <label>Fiyat</label>
                        <input required type="text" value="<?= $sonuc["fiyat"] ?>" class="form-control" name="fiyat"
                        placeholder="Fiyat">
                    </div>
                    
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="aktif" id="aktif"
                        <?php
                        if ($sonuc["aktif"] == 1) echo "checked";
                        ?>
                        >
                        <label class="form-check-label" for="aktif">Aktif mi?</label>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Güncelle</button>
                    </div>

                </form>


            </div>
        </div>
     
  

            


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
        <link rel="stylesheet" type="text/css" href="css/switch.css">