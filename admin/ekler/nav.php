<body id="page-top">
<nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="../index.php">Yönetim Paneli</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <!-- <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for..." aria-label="Search"
                   aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div> -->
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
     
        <li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-toggle="dropdown"
       aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-white small">
            <?php echo htmlspecialchars(strtoupper($_SESSION['username'])); ?>
        </span>
        <i class="fas fa-user-circle fa-fw"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
    <h6 class="dropdown-header">
        <?php echo htmlspecialchars($_SESSION['username']); ?>
    </h6>

    <div class="dropdown-divider"></div>
    <a class="dropdown-item text-info" href="../index.php">Ana Sayfa</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#logoutModal">Çıkış</a>
</div>


        </li>
    </ul>

</nav>