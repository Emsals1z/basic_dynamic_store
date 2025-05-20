<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php

include('vt.php');

if (!isset($_SESSION['id'])) {
    echo "<script>alert('Giriş yapmalısınız.'); window.location.href = 'login.php';</script>";
    exit;
}

$kullanici_id = intval($_SESSION['id']);

// Sepet verilerini ürün bilgileriyle birlikte al
$sorgu = $connect->prepare("
    SELECT s.adet, u.baslik, u.foto, u.fiyat, u.id as urun_id
    FROM sepet s
    INNER JOIN urunler u ON s.urun_id = u.id
    WHERE s.kullanici_id = ?
");
$sorgu->execute([$kullanici_id]);
$sepet = $sorgu->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include('ekler/head.php'); ?>

  <!-- Sticky WebGL container -->
  <div class="sticky-container" id="stickyContainer" style="height: fit-content;min-height:60vh">
    <div class="webgl-section" id="webglSection" style="height: fit-content;">
      <div class="canvas-container" id="canvasContainer" style="flex-wrap: wrap;height: fit-content;min-height:60vh">
        <canvas id="space"></canvas>
        <div class="container mt-5" style="z-index: 2;justify-content: center;grid-template-columns: repeat(1, 1fr);">
  <h2 class="mb-4">Sepetiniz</h2>

  <?php if (count($sepet) === 0): ?>
    <div class="alert alert-info" style="color: #353535;background-color: #ffffffbd; border-color:#e3e3e3;">Sepetiniz boş.</div>
  <?php else: ?>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Ürün</th>
          <th>Adet</th>
          <th>Fiyat</th>
          <th>Ara Toplam</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
        $toplam = 0;
        foreach ($sepet as $item):
          $araToplam = $item['fiyat'] * $item['adet'];
          $toplam += $araToplam;
        ?>
        <tr>
          <td>
            <img src="img/<?= htmlspecialchars($item['foto']) ?>" style="height: 60px;max-width: 16vw;"> <br>
            <?= htmlspecialchars($item['baslik']) ?>
          </td>
          <td><?= $item['adet'] ?></td>
          <td><?= number_format($item['fiyat'], 2) ?> ₺</td>
          <td><?= number_format($araToplam, 2) ?> ₺</td>
          <td class="text-center">
  <a href="sepet_sil.php?urun_id=<?= $item['urun_id'] ?>" 
     onclick="return confirm('Bu ürünü sepetten silmek istiyor musunuz?')" 
     class="btn btn-danger btn-sm">Sil</a>
</td>


        </tr>
        <?php endforeach; ?>
        <tr>
          <td colspan="3" class="text-end"><strong>Toplam:</strong></td>
          <td><strong><?= number_format($toplam, 2) ?> ₺</strong></td>
        </tr>
        
      </tbody>
    </table>

    <div class="text-end">
      <form method="post" action="satin_al.php">
        <button type="submit" class="btn btn-success">Satın Al</button>
      </form>
    </div>
  <?php endif; ?>
</div>
      </div>
    </div>
  </div>


<?php include('ekler/footer.php'); ?>
