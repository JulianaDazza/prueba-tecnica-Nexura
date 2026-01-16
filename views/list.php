<?php
session_start();

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/user.php";

$database = new Database();
$db = $database->getConnection();
$empleadoModel = new User($db);

$stmt = $empleadoModel->getAll();
$empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Lista de Empleados</title>

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Tu CSS -->
        <link rel="stylesheet" href="../public/css/styles.css">
    </head>

    <body>

        <div class="container mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Lista de empleados</h3>

                <a href="form.php" class="btn btn-primary">
                    <i class="bi bi-person-plus"></i> Crear
                </a>
            </div>

            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['success']; ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION['error']; ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th><i class="bi bi-person"></i> Nombre</th>
                        <th><i class="bi bi-at"></i> Email</th>
                        <th><i class="bi bi-gender-ambiguous"></i> Sexo</th>
                        <th><i class="bi bi-briefcase"></i> Área</th>
                        <th><i class="bi bi-envelope"></i> Boletín</th>
                        <th class="text-center">Modificar</th>
                        <th class="text-center">Eliminar</th>
                    </tr>
                </thead>
                <tbody>

                <?php if (count($empleados) === 0): ?>
                    <tr>
                        <td colspan="7" class="text-center">No hay empleados registrados.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($empleados as $emp): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($emp['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($emp['email']); ?></td>
                            <td><?php echo $emp['sexo'] === 'M' ? 'Masculino' : 'Femenino'; ?></td>
                            <td><?php echo htmlspecialchars($emp['area']); ?></td>
                            <td><?php echo $emp['boletin'] ? 'Sí' : 'No'; ?></td>

                            <td class="text-center">
                                <a href="form.php?id=<?php echo $emp['id']; ?>" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>

                            <td class="text-center">
                                <a href="../controllers/userController.php?accion=eliminar&id=<?php echo $emp['id']; ?>"
                                class="btn btn-outline-danger btn-sm"
                                onclick="return confirm('¿Está seguro de eliminar este empleado?');">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>

                </tbody>
            </table>

        </div>

        <script>
            setTimeout(() => {
                const alerts = document.querySelectorAll('.flash-message');
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';

                    setTimeout(() => alert.remove(), 500);
                });
            }, 3000); // 3 segundos
        </script>

    </body>
</html>
