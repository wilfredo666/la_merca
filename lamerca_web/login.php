<?php

declare(strict_types=1);

session_start();
require_once __DIR__ . '/app/Database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /lamerca_web/');
    exit;
}

$login = trim((string) ($_POST['login'] ?? ''));
$password = (string) ($_POST['password'] ?? '');

$errors = [];

if ($login === '' || $password === '') {
    $errors[] = 'Usuario y contraseña son requeridos.';
}

if (empty($errors)) {
    $db = Database::getInstance();

    try {
        $stmt = $db->prepare('SELECT id_usuario_tienda, id_cliente, email, password, estado FROM usuario_tienda WHERE email = :email LIMIT 1');
        $stmt->bindValue(':email', $login, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $errors[] = 'Credenciales incorrectas.';
        } else {
            if (!password_verify($password, (string) $user['password'])) {
                $errors[] = 'Credenciales incorrectas.';
            } else {
                if ((int) $user['estado'] !== 1) {
                    $errors[] = 'Cuenta no activa.';
                } else {
                    // login success
                    session_regenerate_id(true);
                    // fetch cliente name
                    $clienteNombre = '';
                    try {
                        $cstmt = $db->prepare('SELECT nombre_cliente FROM cliente WHERE id_cliente = :id LIMIT 1');
                        $cstmt->bindValue(':id', (int) $user['id_cliente'], PDO::PARAM_INT);
                        $cstmt->execute();
                        $cRow = $cstmt->fetch(PDO::FETCH_ASSOC);
                        if ($cRow && !empty($cRow['nombre_cliente'])) {
                            $clienteNombre = (string) $cRow['nombre_cliente'];
                        }
                    } catch (Throwable $ee) {
                        // ignore — optional: log
                    }

                    $_SESSION['usuario_tienda'] = [
                        'id' => (int) $user['id_usuario_tienda'],
                        'id_cliente' => (int) $user['id_cliente'],
                        'email' => $user['email'],
                        'nombre' => $clienteNombre,
                    ];
                    header('Location: /lamerca_web/');
                    exit;
                }
            }
        }
    } catch (Throwable $e) {
        error_log('Login error: ' . $e->getMessage());
        $errors[] = 'Error al procesar el login.';
    }
}

// If we reach here there was an error — store message in session and redirect back to home to show modal
$_SESSION['auth_errors'] = $errors;
header('Location: /lamerca_web/');
exit;

?>
