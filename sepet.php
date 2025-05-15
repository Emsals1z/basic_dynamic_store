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

<!DOCTYPE html>
<html lang="tr" >
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Kayra Saraçoğlu</title>


  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js" integrity="sha256-xH4q8N0pEzrZMaRmd7gQVcTZiFei+HfRTBPJ1OGXC0k=" crossorigin="anonymous"></script>
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


<link href="css/style.css" rel="stylesheet">


</head>

<body>

<div class="footer">
  <div class="container">
    <div class="nav">
      <div class="logo-container">
     <a href="index.php"> <h3>Kayra Saraçoğlu</h3></a>
      </div>
    </div>

    <div class="values">
    <a href="urunler.php"> <h3>Ürünler</h3></a>
   
    </div>

    <div class="contact">
    <a href="iletisim.php"> <h3>İletişim</h3></a>
     
    </div>
    <?php if (isset($_SESSION['username']) && isset($_SESSION['yetki'])): ?>
                 

                    <div class="social">

                 
      <h3>  <?php echo htmlspecialchars(strtoupper($_SESSION['username'])); ?></h3>
      <ul>
      <li><a href="sepet.php">Sepet</a></li>
      <?php if ($_SESSION['yetki'] === 'USER'): ?>
                        <li><a href="admin/userdashboard.php">Ayarlar</a></li>
                    <?php elseif ($_SESSION['yetki'] === 'ADMIN' || $_SESSION['yetki'] === 'GOD'): ?>
                        <li><a href="admin/dashboard.php">Dashboard</a></li>
                    <?php endif; ?>
                    <li><a href="cikis.php">Çıkış Yap</a></li>
      </ul>
    </div>

                <?php else: ?>
                
                    <div class="social">
                        <ul>
                        <a href="login.php"><h3>Giriş Yap</h3></a>
                        </ul>
                    </div>
                <?php endif; ?>
   
  </div>

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



  <div class="dot-grid" id="dotGrid" style="width:100%"></div>
</div>
<!-- partial -->
  <script src='https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/gsap.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/ScrollTrigger.min.js'></script><script  src="js/script.js"></script>

</body>
</html>
