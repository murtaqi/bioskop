<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($data['judul']) ? $data['judul'] : 'CinemaTix' ?></title>
    <!-- FontAwesome Icon CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Main Premium Custom CSS -->
    <link rel="stylesheet" href="<?= BASEURL ?>/css/style.css">
    <script>
        const BASEURL = '<?= BASEURL ?>';
    </script>
</head>
<body>

    <header class="app-header">
        <nav class="navbar">
            <a href="<?= BASEURL ?>" class="nav-brand">
                <i class="fas fa-ticket-alt"></i> CINEMA<span>TIX</span>
            </a>
            
            <ul class="nav-links">
                <?php if (!isset($_SESSION['login'])) : ?>
                    <!-- Guest Links -->
                    <li class="nav-item <?= (!empty($data['judul']) && $data['judul'] == 'Bioskop') ? 'active' : '' ?>">
                        <a href="<?= BASEURL ?>"><i class="fas fa-home"></i> Beranda</a>
                    </li>
                    <li class="nav-item <?= (!empty($data['judul']) && $data['judul'] == 'Login') ? 'active' : '' ?>">
                        <a href="<?= BASEURL ?>/auth/login"><i class="fas fa-sign-in-alt"></i> Masuk</a>
                    </li>
                    <li class="nav-item <?= (!empty($data['judul']) && $data['judul'] == 'Register') ? 'active' : '' ?>">
                        <a href="<?= BASEURL ?>/auth/register"><i class="fas fa-user-plus"></i> Daftar</a>
                    </li>
                <?php else : ?>
                    <?php if ($_SESSION['role'] == 'admin') : ?>
                        <!-- Admin Navigation Links -->
                        <li class="nav-item <?= (!empty($data['judul']) && $data['judul'] == 'Dashboard Admin') ? 'active' : '' ?>">
                            <a href="<?= BASEURL ?>/admin"><i class="fas fa-chart-line"></i> Dashboard</a>
                        </li>
                        <li class="nav-item <?= (!empty($data['judul']) && $data['judul'] == 'Kelola Film') ? 'active' : '' ?>">
                            <a href="<?= BASEURL ?>/film"><i class="fas fa-film"></i> Kelola Film</a>
                        </li>
                        <li class="nav-item <?= (!empty($data['judul']) && $data['judul'] == 'Kelola Jadwal') ? 'active' : '' ?>">
                            <a href="<?= BASEURL ?>/jadwal"><i class="fas fa-calendar-alt"></i> Kelola Jadwal</a>
                        </li>
                    <?php else : ?>
                        <!-- Customer Navigation Links -->
                        <li class="nav-item <?= (!empty($data['judul']) && $data['judul'] == 'Bioskop - Dashboard') ? 'active' : '' ?>">
                            <a href="<?= BASEURL ?>/customer"><i class="fas fa-film"></i> Film & Jadwal</a>
                        </li>
                        <li class="nav-item <?= (!empty($data['judul']) && $data['judul'] == 'Riwayat Pemesanan Tiket') ? 'active' : '' ?>">
                            <a href="<?= BASEURL ?>/customer/riwayat"><i class="fas fa-history"></i> Tiket Saya</a>
                        </li>
                    <?php endif; ?>

                    <!-- User Profile & Log Out -->
                    <li class="nav-item">
                        <span class="user-badge">
                            <i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['nama']) ?> 
                            (<?= $_SESSION['role'] == 'admin' ? 'Admin' : 'Pelanggan' ?>)
                        </span>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASEURL ?>/auth/logout" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Keluar</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main class="container">
        <?php Flasher::flash(); ?>
