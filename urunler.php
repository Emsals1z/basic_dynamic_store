

<?php include('ekler/head.php'); ?>

  <!-- Sticky WebGL container -->
  <div class="sticky-container" id="stickyContainer" style="height: fit-content;">
    <div class="webgl-section" id="webglSection" style="height: fit-content;">
      <div class="canvas-container" id="canvasContainer" style="flex-wrap: wrap;height: fit-content;">
        <canvas id="space"></canvas>
       
<?php

include('vt.php');



$sorgu = $connect->prepare("SELECT * FROM urunler where aktif=1 order by sira");
$sorgu->execute();
$yon = 'sag';

while ($sonuc = $sorgu->fetch()) {
    ?>

<section class="section" style="width:70%;">
    <div class="section-div">
        <div class="product-item row mb-5 align-items-center" style="padding: 10px;">
            <?php if ($yon == 'sag'): ?>
                <div class="col-md-6" style="justify-content: center; display: flex;">
                    <img class="img-fluid rounded" src="img/<?= $sonuc['foto'] ?>" alt="" style="max-height: 26vh;">
                </div>
                <div class="col-md-6" style="text-align: start;">
                    <h2><?= $sonuc['baslik'] ?></h2>
                    <h5 class="text-muted"><?= $sonuc['ustBaslik'] ?></h5>
                    <p><?= $sonuc['icerik'] ?></p>
                    <p><strong>Fiyat:</strong> <?= number_format($sonuc['fiyat'], 2) ?> ₺</p>
                    <button class="btn btn-success sepete-ekle" data-id="<?= $sonuc['id'] ?>">Sepete Ekle</button>
                </div>
            <?php else: ?>
                <div class="col-md-6 order-md-2" style="justify-content: center; display: flex;">
                    <img class="img-fluid rounded" src="img/<?= $sonuc['foto'] ?>" alt="" style="max-height: 26vh;">
                </div>
                <div class="col-md-6 order-md-1" style="text-align: end;">
                    <h2><?= $sonuc['baslik'] ?></h2>
                    <h5 class="text-muted"><?= $sonuc['ustBaslik'] ?></h5>
                    <p><?= $sonuc['icerik'] ?></p>
                    <p><strong>Fiyat:</strong> <?= number_format($sonuc['fiyat'], 2) ?> ₺</p>
                    <button class="btn btn-success sepete-ekle" data-id="<?= $sonuc['id'] ?>">Sepete Ekle</button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>



    <?php
    if ($yon == 'sag') $yon = 'sol';
    else $yon = 'sag';

} //while sonu

?>
      </div>
    </div>
  </div>



  <div class="dot-grid" id="dotGrid" style="width:100%"></div>
</div>
<!-- partial -->
  <script src='https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/gsap.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/ScrollTrigger.min.js'></script><script  src="js/urunscript.js"></script>

</body>
<script>
$(document).on('click', '.sepete-ekle', function () {
    const urunId = $(this).data('id');

    $.ajax({
        url: 'sepet_ekle.php',
        method: 'POST',
        data: { urun_id: urunId },
        success: function (response) {
            alert(response);
        },
        error: function () {
            alert('Bir hata oluştu.');
        }
    });
});

</script>
</html>


