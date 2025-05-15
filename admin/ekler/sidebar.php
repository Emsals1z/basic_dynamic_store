<div id="wrapper">
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
    <li class="nav-item <?php echo $sayfa == 'Ana Sayfa' ? 'active' : '' ?>">
            <a class="nav-link" href="dashboard.php">
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
            <a class="nav-link" href="siparis.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Siparişler</span></a>
        </li>
        <li class="nav-item <?php echo $sayfa == 'İletisim' ? 'active' : '' ?>">
            <a class="nav-link" href="iletisim.php">
                <i class="fas fa-fw fa-table"></i>
                <span>İletişim</span></a>
        </li>
    </ul>