<div id="wrapper">
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
        <li class="nav-item <?php echo $sayfa == 'Ana Sayfa' ? 'active' : '' ?>">
            <a class="nav-link" href="index.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Ana Sayfa</span>
            </a>
        </li>

        <li class="nav-item <?php echo $sayfa == 'Ürünler' ? 'active' : '' ?>">
            <a class="nav-link" href="urunleradmin.php">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Ürünler</span></a>
        </li>
         <li class="nav-item <?php echo $sayfa == 'Mağaza' ? 'active' : '' ?>">
            <a class="nav-link" href="magaza.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Mağaza</span></a>
        </li>
            <li class="nav-item <?php echo $sayfa == 'Kullanıcılar' ? 'active' : '' ?>">
            <a class="nav-link" href="kullanicilar.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Kullanıcılar</span></a>
        </li>
    </ul>