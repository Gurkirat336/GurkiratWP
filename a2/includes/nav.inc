<nav class="navbar navbar-expand-lg navbar-dark navbar-petconnect">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo $basePath; ?>index.php">
            <img src="<?php echo $basePath; ?>assets/images/banner.jpg" height="30" alt="PetConnect">
            PetConnect
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-1 <?php echo ($activePage === 'home') ? 'active' : ''; ?>" href="<?php echo $basePath; ?>index.php">
                        <span class="material-icons icon-sm">home</span> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-1 <?php echo ($activePage === 'pets') ? 'active' : ''; ?>" href="<?php echo $basePath; ?>pets.php">
                        <span class="material-icons icon-sm">list</span> Browse Pets
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-1 <?php echo ($activePage === 'gallery') ? 'active' : ''; ?>" href="<?php echo $basePath; ?>gallery.php">
                        <span class="material-icons icon-sm">photo_library</span> Gallery
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-1 <?php echo ($activePage === 'add') ? 'active' : ''; ?>" href="<?php echo $basePath; ?>add.php">
                        <span class="material-icons icon-sm">add_circle</span> Add Pet
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
