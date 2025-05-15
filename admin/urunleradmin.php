<?php
$sayfa = "Ürünler";
include('../vt.php');

include('ekler/head.php');
include('ekler/nav.php');
include('ekler/sidebar.php');

if (isset($_POST['sil'])) {
//print_r($_POST);exit();
$silinecekler = implode(', ', $_POST['sil']);

$sorgu = $connect->prepare('select * FROM `urunler` WHERE `id` IN (' . $silinecekler . ')');


    $sorgu->execute();
//sorgu çalıştırılıp veriler alınıyor
while ($sonuc = $sorgu->fetch()) {

        @unlink('../img/' . $sonuc["foto"]);//eski dosya siliniyor. isteğe bağlı
    }

    $sorgu = $connect->prepare('DELETE FROM `urunler` WHERE `id` IN (' . $silinecekler . ')');
    $sorgu->execute();

}


$sorgu = $connect->prepare("SELECT * FROM urunler order by sira");
$sorgu->execute();


?>



    <script language="javascript"> function confirmDel() {
            var agree = confirm("Silmek istediğinizden emin misiniz?\nBu işlem geri alınamaz!");
            if (agree) {
                return true;
            } else {
                return false;
            }
        } </script>
    <script src="js/tumunusil.js"></script>
  
<div class="content">
<div id="content-wrapper">

    <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Ürünler</li>
        </ol>
        <form action="" method="post">
            <a class="btn btn-primary" href="urunEkle.php">Yeni Ürün Ekle</a>

            <a class="btn btn-danger font-18" href="#" data-toggle="modal"
               data-target="#tumunuSil"><i class="fa fa-trash"> Seçilenleri sil</i></a>
            <!-- Logout Modal-->
            <div class="modal fade" id="tumunuSil" tabindex="-1" role="dialog"
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
                        <div class="modal-body">Seçilen tüm ürünler silinecektir.</div>
                        <div class="modal-footer">

                            <button type="submit" class="btn btn-danger font-18"><i class="fa fa-trash"> Seçilenleri
                                    sil</i></button>
                            <button class="btn btn-secondary" type="button"
                                    data-dismiss="modal">Kapat
                            </button>

                        </div>
                    </div>
                </div>
            </div>


            <br><br>

            <!-- DataTables Example -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Ürünler
                </div>
                <div class="card-body">


                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>
                                    <div class="checkbox">
                                        <input type="checkbox" id="select_all" onclick="TumunuSec();" value="">
                                        <label for=""></label>
                                    </div>
                                </th>
                                <th>ID</th>
                                <th>Foto</th>
                                <th>Üst Başlık</th>
                                <th>Başlık</th>
                                <th>İçerik</th>
                                <th>Sıra</th>
                                <th>Aktif</th>
                                <th>Fiyat</th>
                                <th>Düzenle</th>
                                <th>Sil</th>

                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                            <th></th>
                                <th>ID</th>
                                <th>Foto</th>
                                <th>Üst Başlık</th>
                                <th>Başlık</th>
                                <th>İçerik</th>
                                <th>Sıra</th>
                                <th>Aktif</th>
                                <th>Fiyat</th>
                                <th>Düzenle</th>
                                <th>Sil</th>

                            </tr>
                            </tfoot>
                            <tbody>

                            <?php while ($sonuc = $sorgu->fetch()) { ?>
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <input class="chck" type="checkbox" name="sil[]"
                                                   value="<?php echo $sonuc['id']; ?>">
                                            <label for="<?php echo $sonuc['id']; ?>"></label>
                                        </div>
                                    </td>
                                    <td><?= $sonuc["id"] ?></td>
                                    <td><img src="../img/<?= $sonuc["foto"] ?>" width="150px"/></td>
                                    <td contenteditable="true"
                                        onBlur="veriKaydet(this,'ustBaslik','<?= $sonuc["id"] ?>')"
                                        onClick="duzenle(this);"><?= $sonuc["ustBaslik"] ?></td>
                                    <td contenteditable="true" onBlur="veriKaydet(this,'baslik','<?= $sonuc["id"] ?>')"
                                        onClick="duzenle(this);"><?= $sonuc["baslik"] ?></td>
                                    <td>
                                        <a class="btn btn-info" href="#" data-toggle="modal"
                                           data-target="#icerik<?= $sonuc["id"] ?>">Oku</a>
                                        <!-- Logout Modal-->
                                        <div class="modal fade" id="icerik<?= $sonuc["id"] ?>" tabindex="-1"
                                             role="dialog"
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
                                                    <div class="modal-body"><?= $sonuc["icerik"] ?></div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button"
                                                                data-dismiss="modal">Kapat
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                    <td contenteditable="true" onBlur="veriKaydet(this,'sira','<?= $sonuc["id"] ?>')"
                                        onClick="duzenle(this);"><?= $sonuc["sira"] ?></td>
                                    <td>
                                        <label class="switch">
                                            <!-- checkbox a id ve checked bilgilerini ekliyoruz -->
                                            <input type="checkbox" id='<?php echo $sonuc['id'] ?>'
                                                   class="aktifPasif" <?php echo $sonuc['aktif'] == 1 ? 'checked' : '' ?> />
                                            <span class="slider round"></span>
                                        </label></td>
                                        <td contenteditable="true" onBlur="veriKaydet(this,'fiyat','<?= $sonuc["id"] ?>')"
                                        onClick="duzenle(this);"><?= $sonuc["fiyat"] ?></td>
                                  
                                    <td><a class="btn btn" href="urunGuncelle.php?id=<?= $sonuc["id"] ?>"><span
                                                    class="fa fa-edit fa-2x"></span></a></td>
                                    <td>
                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                           data-target="#sil<?= $sonuc["id"] ?>"><span class="fa fa-trash fa-2x"></span></a>


                                        <!-- Logout Modal-->
                                        <div class="modal fade" id="sil<?= $sonuc["id"] ?>" tabindex="-1" role="dialog"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Sil</h5>
                                                        <button class="close" type="button" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">Ürünü silmek istediğinizden emin misiniz?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary pull-left mx-4" type="button"
                                                                data-dismiss="modal">İptal
                                                        </button>
                                                        <a class="btn btn-danger pull-right mx-4"
                                                           href="Sil.php?sayfa=urunler&id=<?= $sonuc["id"] ?>">Sil</a>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </td>
                                </tr>
                                <?php
                            } //while bitimi
                            ?>
                            </tbody>
                        </table>
        </form>
    </div>
</div>

</div>

</div>


<?php
include('ekler/footer.php');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#select_all').on('click', function () {
            if ($('#select_all:checked').length == $('#select_all').length) {
                $('input.chck:checkbox').prop('checked', true);
            } else {
                $('input.chck:checkbox').prop('checked', false);

            }
        });
    });
</script>
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
<script>
    function duzenle(deger) {
        $(deger).css("background", "#fffacd");
        //seçilen hücrenin rengini değiştiriyoruz
    }

    function veriKaydet(deger, alan, id) {
        $(deger).css("background", "#FFF url(yukleniyor.gif) no-repeat right");
        //

        $.ajax({
            url: "duzenleKaydet.php", //verileri göndereceğimiz url
            type: "POST", //post ile gönderilecek
            data: 'alan=' + alan + '&deger=' + deger.innerHTML.split('+').join('{0}') + '&id=' + id,
            // verileri alan deger ve id olarak yolluyoruz
            //+ (artı) post edilirken boşluk ile değişiyor 
            //bunu engellemek için + değeri {0} ile değiştirdim 
            //kayıt yaparkende index.php de geri değişimini yapıyoruz 
            success: function (data) {
                if (data == true) {
                    $(deger).css("background", "#fff");
                    // eğer veriler veri tabanına yazılmış ise hücrenin
                    //arka plan rengini beyaza geri döndürüyoruz
                }

                else {
                    $(deger).css("background", "#f00");
                    $("#sonuc").text("Hata veri düzenlenmedi");

                    //Eğer hata varsa hücre rengini kırmızı ve
                    // tablo altında hata mesajı yazdırıyoruz
                }
            }
        });
    }
</script>
<script src="js/aktifcustom.js"></script>
<link rel="stylesheet" type="text/css" href="css/switch.css">
