<nav class="navbar navbar-expand-lg navbar-dark navbar-petconnect">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo $basePath; ?>index.php">
            <span class="material-icons">pets</span>
            PetConnect
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
                    <a class="nav-link d-flex align-items-center gap-1 <?php echo ($activePage === 'search') ? 'active' : ''; ?>" href="<?php echo $basePath; ?>search.php">
                        <span class="material-icons icon-sm">search</span> Search
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-1" href="<?php echo $basePath; ?>add.php">
                        <span class="material-icons icon-sm">add_circle</span> Add Pet
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-1" href="<?php echo $basePath; ?>owner.php?user_id=<?php echo $_SESSION['user_id']; ?>">
                        <span class="material-icons icon-sm">person</span> <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-1" href="<?php echo $basePath; ?>logout.php">
                        <span class="material-icons icon-sm">logout</span> Logout
                    </a>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-1" href="<?php echo $basePath; ?>login.php">
                        <span class="material-icons icon-sm">login</span> Login
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-1" href="<?php echo $basePath; ?>register.php">
                        <span class="material-icons icon-sm">person_add</span> Register
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
