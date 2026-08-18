<?php

/** @var string $content */
/** @var string|null $pageTitle */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$authErrors = [];
if (!empty($_SESSION['auth_errors'])) {
    $authErrors = (array) $_SESSION['auth_errors'];
    unset($_SESSION['auth_errors']);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'La Merca E-commerce', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="icon" type="image/jpeg" href="/lamerca_web/assets/dist/img/icon.jpg">
    <link rel="stylesheet" href="/lamerca_web/assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/lamerca_web/assets/plugins/fontawesome-free/css/all.min.css">
    <style>
        html,
        body {
            overflow-x: hidden;
        }

        .top-bar {
            background: #070c18;
            color: #f8fafc;
            font-size: 0.95rem;
        }

        .top-bar .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.1em;
            color: #ffffff;
        }

        .top-bar .search-form {
            width: 560px;
            max-width: 100%;
        }

        .top-bar .search-input {
            border-radius: 999px;
            box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.08);
            background: #ffffff;
            color: #111827;
        }

        .top-bar .search-input::placeholder {
            color: #6b7280;
        }

        .top-bar .btn-whatsapp,
        .top-bar .btn-cart,
        .top-bar .btn-access {
            color: #ffffff;
        }

        /* (previously had right-actions spacing here) */


        .top-bar .btn-whatsapp i {
            font-size: 1.25rem;
            margin-right: 0.35rem;
            color: #25d366;
        }

        .top-bar .btn-whatsapp:hover,
        .top-bar .btn-cart:hover,
        .top-bar .btn-access:hover {
            color: #000000;
            background-color: #ffffff;
            border-color: #ffffff;
        }

        .menu-bar {
            background: #ececec;
        }

        .menu-bar .navbar-collapse {
            justify-content: center;
        }

        .menu-bar .navbar-nav {
            width: 100%;
            justify-content: center;
        }

        .menu-bar .dropdown-menu {
            max-height: 280px;
            overflow-y: auto;
        }

        .menu-bar .nav-item {
            margin: 0 0.75rem;
        }

        .menu-bar .nav-link {
            color: #000000;
            font-weight: 600;
            position: relative;
            transition: color 0.2s ease-in-out;
            padding: 0.75rem 1rem;
        }

        .menu-bar .nav-link::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -4px;
            width: 0;
            height: 2px;
            background: #00bfff;
            transition: width 0.25s ease-in-out;
        }

        .menu-bar .nav-link:hover,
        .menu-bar .nav-link.active {
            color: #00bfff;
        }

        .menu-bar .nav-link:hover::after,
        .menu-bar .nav-link.active::after {
            width: 100%;
        }

        .menu-bar .btn-categories {
            background: #1abc9c;
            color: #ffffff;
            font-weight: 600;
        }

        .login-modal .modal-content {
            border: none;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 2rem 3rem rgba(0, 0, 0, 0.25);
            min-height: 420px;
        }

        .login-modal .login-sidebar {
            background: url('/lamerca_web/assets/dist/img/slider1.png') center center / cover no-repeat;
            position: relative;
            min-height: 420px;
        }

        .login-modal .login-sidebar::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
        }

        .login-modal .login-sidebar .sidebar-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: flex-end;
            padding: 1.75rem;
            color: #ffffff;
            z-index: 1;
        }

        .login-modal .login-form {
            padding: 2rem 1.75rem;
        }

        .login-modal .login-form .modal-title {
            letter-spacing: 0.12em;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #343a40;
        }

        /* Botones de acceso y registro: fondo y estilos consistentes */
        .btn-login,
        .btn-register {
            background-color: #1abc9c;
            color: #ffffff;
            border-color: #179986;
            font-weight: 700;
        }

        .btn-login:hover,
        .btn-register:hover {
            background-color: #149073;
            color: #ffffff;
            border-color: #0f695b;
        }

        /* No custom print styles (restored original layout) */
        }

        .home-slider {
            position: relative;
            width: 100vw;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
            margin-top: 0;
            padding-top: 0;
            overflow: hidden;
        }

        .home-slider .carousel-item img {
            width: 100vw;
            height: 80vh;
            object-fit: cover;
        }

        .home-slider .carousel-caption {
            background: rgba(0, 0, 0, 0.35);
            padding: 1.5rem;
            border-radius: 0.75rem;
        }

        .product-card img {
            height: 220px;
            object-fit: cover;
        }

        .main-footer {
            border-top: 1px solid #dee2e6;
            background: #070C18;
            color: #f8fafc;
        }

        .main-footer a {
            color: #f8fafc;
        }

        .main-footer a:hover {
            color: #c7d2fe;
            text-decoration: none;
        }

        .main-footer .footer-title {
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .main-footer .footer-logo {
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: 0.05em;
        }

        .main-footer .footer-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1rem;
            padding: 1.6rem;
        }

        .main-footer .btn-download {
            min-width: 220px;
        }

        .main-footer .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            text-align: none;
            text-decoration: none;
            transition: transform 0.25s ease, box-shadow 0.25s ease, filter 0.25s ease;
        }

        .main-footer .social-links a i {
            font-size: 2rem;
        }

        .main-footer .social-links a:hover {
            transform: translateY(-2px) scale(1.5);
        }

        .main-footer .social-links .fa-tiktok {
            color: #111827;
            background: #f5f5f5;
        }

        .main-footer .social-links .fa-instagram {
            color: #ffffff;
            background: linear-gradient(40deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);

        }

        .main-footer .social-links .fa-facebook {
            color: #1877f2;
        }

        .main-footer .social-links .fa-youtube {
            color: #ff0000;
        }

        .main-footer {
            padding-top: 3rem !important;
            padding-bottom: 1rem !important;
        }

        .content.pt-4.pb-5 {
            padding-top: 0 !important;
        }

        /* No custom print styles */
    </style>
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <header>
            <div class="top-bar py-2 border-bottom border-white-10">
                <div class="container d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-4">
                        <a href="/lamerca_web/" class="navbar-brand mb-0">
                            <img src="/lamerca_web/assets/dist/img/logotipo.jpg" alt="La Merca" style="max-height: 50px; width: auto;">
                        </a>
                        <form class="d-none d-lg-flex align-items-center search-form" action="/lamerca_web/" method="get">
                            <div class="input-group">
                                <input type="search" name="q" class="form-control search-input" placeholder="Buscar productos..." aria-label="Buscar productos" value="<?= htmlspecialchars($q ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                <input type="hidden" name="category" value="<?= htmlspecialchars($categoryName ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                <button class="btn btn-outline-light" type="submit" style="background-color: #fcfcfc;"><i class="fas fa-search" style="color: #9a9a9a;"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <?php if (!empty($_SESSION['usuario_tienda'])): ?>
                            <?php $u = $_SESSION['usuario_tienda'];
                            $displayName = trim((string) ($u['nombre'] ?? $u['email'] ?? 'Usuario')); ?>
                            <div class="dropdown">
                                <button class="btn btn-outline-light dropdown-toggle" type="button" id="userMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i> <?= htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8') ?>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuButton">
                                    <li><a class="dropdown-item" href="/lamerca_web/index.php?route=account/profile">Mi perfil</a></li>
                                    <li><a class="dropdown-item" href="/lamerca_web/index.php?route=account/orders">Mis pedidos</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="/lamerca_web/logout.php">Cerrar sesión</a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <button type="button" class="btn btn-outline-light btn-access" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <i class="fas fa-user"></i> Iniciar Sesión
                            </button>
                        <?php endif; ?>
                        <a href="https://wa.me/59174333434" target="_blank" rel="noreferrer noopener" class="btn btn-outline-light btn-whatsapp">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="/lamerca_web/index.php?route=cart" class="btn btn-outline-light btn-cart">
                            <i class="fas fa-shopping-cart"></i> Carrito <span class="badge bg-success">
                                <?php
                                $cartCount = 0;
                                if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                                    foreach ($_SESSION['cart'] as $cartItem) {
                                        $cartCount += max(1, (int) ($cartItem['qty'] ?? 1));
                                    }
                                }
                                echo $cartCount;
                                ?>
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <nav class="menu-bar navbar navbar-expand-lg py-3">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuBarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="menuBarCollapse">
                        <ul class="navbar-nav align-items-center">
                            <li class="nav-item dropdown me-3">
                                <a href="#" class="btn btn-categories dropdown-toggle px-4 py-2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-bars me-2"></i><?= !empty($selectedCategoryName) ? htmlspecialchars($selectedCategoryName, ENT_QUOTES, 'UTF-8') : 'Todas las categorías' ?>
                                </a>
                                <ul class="dropdown-menu shadow-sm">
                                    <?php if (!empty($categories)): ?>
                                        <li>
                                            <a class="dropdown-item<?= empty($categoryName) ? ' active' : '' ?>" href="/lamerca_web/?<?= !empty($q) ? 'q=' . rawurlencode($q) : '' ?>">
                                                Todas las categorías
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <?php foreach ($categories as $category): ?>
                                            <li>
                                                <a class="dropdown-item<?= isset($categoryName) && $categoryName === $category['name'] ? ' active' : '' ?>" href="/lamerca_web/?category=<?= rawurlencode($category['name']) ?><?= !empty($q) ? '&q=' . rawurlencode($q) : '' ?>">
                                                    <?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li><span class="dropdown-item-text text-muted">No hay categorías disponibles</span></li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="/lamerca_web/" class="nav-link active">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a href="#catalog" class="nav-link">Ofertas <span class="text-warning">🔥</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="#catalog" class="nav-link">Novedades <span class="badge bg-info text-dark">NEW</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="#catalog" class="nav-link">Más vendidos <span class="text-warning">★</span></a>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="btn btn-primary btn-download" data-bs-toggle="modal" data-bs-target="#catalogModal">
                                    <i class="fas fa-download me-2" aria-hidden="true"></i>Catálogo PDF
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <div class="modal fade login-modal" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="row g-0">
                            <div class="col-md-6 login-sidebar">
                                <div class="sidebar-overlay">
                                    <div>
                                        <h5 class="text-white mb-3">Bienvenido de nuevo</h5>
                                        <p class="mb-0">Accede a tu cuenta para ver tus pedidos, ofertas y descuentos exclusivos en la tienda.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="login-form">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div>
                                            <h5 class="modal-title" id="loginModalLabel">Account Login</h5>
                                            <p class="text-muted mb-0">Ingresa tus datos para continuar</p>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <?php if (!empty($authErrors)): ?>
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                <?php foreach ($authErrors as $ae): ?>
                                                    <li><?= htmlspecialchars($ae, ENT_QUOTES, 'UTF-8') ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                    <form action="/lamerca_web/login.php" method="post">
                                        <div class="mb-3">
                                            <label for="loginUsername" class="form-label">Login</label>
                                            <input type="text" class="form-control" id="loginUsername" name="login" placeholder="Usuario o correo" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="loginPassword" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Contraseña" required>
                                        </div>
                                        <button type="submit" class="btn btn-login w-100 mb-3">Sign In</button>
                                    </form>
                                    <div class="login-links d-flex justify-content-between">
                                        <a href="/lamerca_web/forgot-password.php">Forgot your password?</a>
                                    </div>
                                    <div class="login-footer text-center">
                                        ¿Aún no tienes cuenta? <a href="#" data-bs-target="#registerModal" data-bs-toggle="modal" data-bs-dismiss="modal">Regístrate</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade login-modal" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="row g-0">
                            <div class="col-md-6 login-sidebar">
                                <div class="sidebar-overlay">
                                    <div>
                                        <h5 class="text-white mb-3">Únete a La Merca</h5>
                                        <p class="mb-0">Crea tu cuenta para recibir acceso a ofertas exclusivas y seguimiento de pedidos.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="login-form">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div>
                                            <h5 class="modal-title" id="registerModalLabel">Registro</h5>
                                            <p class="text-muted mb-0">Completa el formulario para crear tu cuenta</p>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <form action="/lamerca_web/register.php" method="post">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label for="regNombre" class="form-label">Nombre</label>
                                                <input type="text" class="form-control" id="regNombre" name="nombre" placeholder="Nombre" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="regApellidoPaterno" class="form-label">Apellido paterno</label>
                                                <input type="text" class="form-control" id="regApellidoPaterno" name="apellido_paterno" placeholder="Apellido paterno" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="regApellidoMaterno" class="form-label">Apellido materno</label>
                                                <input type="text" class="form-control" id="regApellidoMaterno" name="apellido_materno" placeholder="Apellido materno">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="regTelefono" class="form-label">Teléfono</label>
                                                <input type="tel" class="form-control" id="regTelefono" name="telefono" placeholder="5512345678">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="regNit" class="form-label">NIT</label>
                                                <input type="text" class="form-control" id="regNit" name="nit" placeholder="NIT">
                                            </div>
                                            <div class="col-12">
                                                <label for="regDireccion" class="form-label">Dirección</label>
                                                <input type="text" class="form-control" id="regDireccion" name="direccion" placeholder="Calle, número, ciudad, país">
                                            </div>
                                            <div class="col-12">
                                                <label for="regEmail" class="form-label">Correo electrónico</label>
                                                <input type="email" class="form-control" id="regEmail" name="email" placeholder="correo@ejemplo.com" required>
                                            </div>
                                            <div class="col-12">
                                                <label for="regPassword" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="regPassword" name="password" placeholder="Contraseña" required>
                                            </div>
                                        </div>
                                        <div class="mt-4 d-grid">
                                            <button type="submit" class="btn btn-login">Registrarme</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="catalogModal" tabindex="-1" aria-labelledby="catalogModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <div>
                            <h5 class="modal-title" id="catalogModalLabel">Descargar catálogo</h5>
                            <p class="mb-0 text-muted">Selecciona una categoría para el catálogo.</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <?php $catalogCategories = $categories ?? []; ?>
                        <?php if (!empty($catalogCategories)): ?>
                            <form action="/lamerca_web/catalog_pdf.php" method="get" target="_blank">
                                <div class="mb-3">
                                    <label for="catalogCategorySelect" class="form-label">Categoría</label>
                                    <select class="form-select" id="catalogCategorySelect" name="category">
                                        <option value="">Todas las categorías</option>
                                        <?php foreach ($catalogCategories as $category): ?>
                                            <option value="<?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-primary">Descargar catálogo</button>
                                </div>
                            </form>
                        <?php else: ?>
                            <p class="text-muted mb-0">No hay categorías disponibles para elegir.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-wrapper">
            <div class="content pt-4 pb-5">
                <div class="container-fluid px-4">
                    <?= $content ?>
                </div>
            </div>
        </div>

        <footer class="main-footer py-5">
            <div class="container">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="footer-card h-100 text-center">
                            <div class="mb-3">
                                <img src="/lamerca_web/assets/dist/img/logotipo.jpg" alt="La Merca" style="max-height: 56px; width: auto;" />
                            </div>
                            <p class="text-secondary">Tu tienda de accesorios y tecnología con los mejores precios.</p>
                            <div class="d-flex gap-3 mt-3 social-links">
                                <a href="https://www.tiktok.com" target="_blank" rel="noreferrer noopener" aria-label="TikTok"><i class="fab fa-tiktok fa-lg"></i></a>
                                <a href="https://www.instagram.com" target="_blank" rel="noreferrer noopener" aria-label="Instagram"><i class="fab fa-instagram fa-lg"></i></a>
                                <a href="https://www.facebook.com" target="_blank" rel="noreferrer noopener" aria-label="Facebook"><i class="fab fa-facebook fa-lg"></i></a>
                                <a href="https://www.youtube.com" target="_blank" rel="noreferrer noopener" aria-label="YouTube"><i class="fab fa-youtube fa-lg"></i></a>
                            </div>
                            <button type="button" class="btn btn-primary btn-download mt-3" data-bs-toggle="modal" data-bs-target="#catalogModal">
                                <i class="fas fa-download me-2" aria-hidden="true"></i>Catálogo PDF
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="footer-card h-100">
                            <div class="footer-title text-center">Contacto</div>
                            <p class="mb-2"><strong>Telefono(s):</strong> 74333434 - 67555547 - 63885388</p>
                            <p class="mb-2"><strong>Email:</strong> contacto@lamerca.com</p>
                            <p class="mb-2"><strong>Horario:</strong> Lun - Sáb: 8:00 AM - 8:00 PM</p>
                            <p class="mb-0 text-secondary">También puedes escribirnos por nuestras redes sociales o visitar la tienda en línea.</p>
                        </div>


                    </div>
                    <div class="col-md-4">
                        <div class="footer-card h-100 text-center">
                            <p class="mb-2"><strong>Dirección</strong></p>
                            <p class="mb-3 text-secondary">Av. Ayacucho entre Heroinas y General Acha, Acera Oeste</p>
                            <p>Cochabamba - Bolivia</p>
                            <a href="https://www.google.com/maps/place/LA+MERCA/@-17.3939867,-66.1628348,16z/data=!4m6!3m5!1s0x93e37300518bfd01:0x4ba13eb754d69051!8m2!3d-17.3931779!4d-66.1588759!16s%2Fg%2F11xmqfs8zw?entry=ttu&g_ep=EgoyMDI2MDgxNi4wIKXMDSoASAFQAw%3D%3D" target="_blank" rel="noreferrer noopener">
                                <img src="/lamerca_web/assets/dist/img/ubicacion.png" alt="Ubicación de La Merca" class="img-fluid rounded mb-3" style="width: 100%; height: 150px;" />
                            </a>
                        </div>
                    </div>
                </div>
                <div class="text-center text-secondary mt-4">
                    © <?= date('Y') ?> La Merca. Todos los derechos reservados.
                </div>

            </div>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php if (!empty($authErrors)): ?>
        <script>
            (function() {
                var loginModalEl = document.getElementById('loginModal');
                if (loginModalEl && typeof bootstrap !== 'undefined') {
                    var m = new bootstrap.Modal(loginModalEl);
                    m.show();
                }
            })();
        </script>
    <?php endif; ?>
    <script src="/lamerca_web/assets/dist/js/adminlte.min.js"></script>
</body>

</html>