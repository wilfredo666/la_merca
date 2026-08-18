<?php

declare(strict_types=1);

require_once __DIR__ . '/app/Database.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim((string) ($_POST['nombre'] ?? ''));
    $apellidoP = trim((string) ($_POST['apellido_paterno'] ?? ''));
    $apellidoM = trim((string) ($_POST['apellido_materno'] ?? ''));
    $telefono = trim((string) ($_POST['telefono'] ?? ''));
    $nit = trim((string) ($_POST['nit'] ?? ''));
    $direccion = trim((string) ($_POST['direccion'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if ($nombre === '' || $email === '' || $password === '') {
        $errors[] = 'Nombre, correo y contraseña son obligatorios.';
    }

    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Correo inválido.';
    }

    if (empty($errors)) {
        $db = Database::getInstance();

        try {
            // check duplicate email
            $chk = $db->prepare('SELECT id_usuario_tienda FROM usuario_tienda WHERE email = :email');
            $chk->bindValue(':email', $email, PDO::PARAM_STR);
            $chk->execute();
            if ($chk->fetch()) {
                $errors[] = 'El correo ya está registrado.';
            } else {
                $db->beginTransaction();

                // combine name fields into nombre_cliente
                $nombreCompleto = trim($nombre . ' ' . $apellidoP . ' ' . $apellidoM);

                $insertCliente = $db->prepare(
                    'INSERT INTO cliente (nombre_cliente, nit_ci_cliente, direccion_cliente, telefono_cliente, razon_social_cliente, pais_cliente, ciudad_cliente, descuento)
                     VALUES (:nombre_cliente, :nit, :direccion, :telefono, :razon_social, :pais, :ciudad, :descuento)'
                );

                $insertCliente->bindValue(':nombre_cliente', $nombreCompleto, PDO::PARAM_STR);
                $insertCliente->bindValue(':nit', $nit, PDO::PARAM_STR);
                $insertCliente->bindValue(':direccion', $direccion, PDO::PARAM_STR);
                $insertCliente->bindValue(':telefono', $telefono, PDO::PARAM_STR);
                $insertCliente->bindValue(':razon_social', $nombreCompleto, PDO::PARAM_STR);
                $insertCliente->bindValue(':pais', '', PDO::PARAM_STR);
                $insertCliente->bindValue(':ciudad', '', PDO::PARAM_STR);
                $insertCliente->bindValue(':descuento', 0, PDO::PARAM_STR);

                $insertCliente->execute();
                $idCliente = (int) $db->lastInsertId();

                $hashed = password_hash($password, PASSWORD_DEFAULT);

                $insertUser = $db->prepare(
                    'INSERT INTO usuario_tienda (id_cliente, email, password, estado, create_at)
                     VALUES (:id_cliente, :email, :password, :estado, NOW())'
                );

                $insertUser->bindValue(':id_cliente', $idCliente, PDO::PARAM_INT);
                $insertUser->bindValue(':email', $email, PDO::PARAM_STR);
                $insertUser->bindValue(':password', $hashed, PDO::PARAM_STR);
                $insertUser->bindValue(':estado', 1, PDO::PARAM_INT);

                $insertUser->execute();

                $db->commit();
                $success = true;
            }
        } catch (Throwable $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            $errors[] = 'Ocurrió un error al registrar. Intenta de nuevo.';
            error_log('Registro error: ' . $e->getMessage());
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | La Merca</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/lamerca_web/assets/plugins/fontawesome-free/css/all.min.css">
    <style>
        body {
            background: #f5f7fb;
        }
        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .register-card {
            max-width: 900px;
            width: 100%;
            border: none;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 2rem 3rem rgba(0, 0, 0, 0.12);
        }
        .register-card .card-body {
            padding: 2rem;
        }
        .register-sidebar {
            background: url('/lamerca_web/assets/dist/img/slider2.png') center center / cover no-repeat;
            min-height: 100%;
        }
        .register-sidebar-overlay {
            background: rgba(7, 12, 24, 0.55);
            color: #ffffff;
            padding: 2rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .register-card h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .register-card .form-control {
            border-radius: 0.85rem;
            padding: 1rem 1.15rem;
        }
        .register-card .btn-register {
            border-radius: 0.85rem;
            padding: 0.95rem 1.25rem;
            font-weight: 700;
        }
        .register-note {
            font-size: 0.95rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="card register-card shadow-sm">
            <div class="row g-0">
                <div class="col-lg-6 register-sidebar d-none d-lg-block">
                    <div class="register-sidebar-overlay">
                        <h2>Únete a La Merca</h2>
                        <p class="mb-0">Regístrate para obtener envío rápido, ofertas exclusivas y acceso a tu historial de compras.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card-body">
                        <div class="mb-4 text-center">
                            <a href="/lamerca_web" class="text-decoration-none">
                                <img src="/lamerca_web/assets/dist/img/logotipo.jpg" alt="La Merca" style="max-height: 50px; width: auto;">
                            </a>
                            <h1 class="mt-4">Crear cuenta</h1>
                            <p class="text-muted">Complete el formulario para registrarse en la tienda.</p>
                        </div>
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach ($errors as $err): ?>
                                        <li><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php elseif ($success): ?>
                            <div class="alert alert-success">Registro completado correctamente.</div>
                            <div class="mt-3">
                                <a href="/lamerca_web/">Volver a la portada</a>
                            </div>
                        <?php endif; ?>

                        <?php if (!$success): ?>
                        <form action="/lamerca_web/register.php" method="post">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="apellidoPaterno" class="form-label">Apellido paterno</label>
                                    <input type="text" class="form-control" id="apellidoPaterno" name="apellido_paterno" placeholder="Apellido paterno" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="apellidoMaterno" class="form-label">Apellido materno</label>
                                    <input type="text" class="form-control" id="apellidoMaterno" name="apellido_materno" placeholder="Apellido materno">
                                </div>
                                <div class="col-md-6">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="5512345678">
                                </div>
                                <div class="col-md-6">
                                    <label for="nit" class="form-label">NIT</label>
                                    <input type="text" class="form-control" id="nit" name="nit" placeholder="NIT">
                                </div>
                                <div class="col-12">
                                    <label for="direccion" class="form-label">Dirección</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Calle, número, ciudad, pais">
                                </div>
                                <div class="col-12">
                                    <label for="email" class="form-label">Correo electrónico</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="correo@ejemplo.com" required>
                                </div>
                                <div class="col-12">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                                </div>
                            </div>
                            <div class="mt-4 d-grid">
                                <button type="submit" class="btn btn-success btn-register">Registrarme</button>
                            </div>
                        </form>
                        <p class="register-note mt-3">Al registrarte aceptas nuestros términos y condiciones.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
