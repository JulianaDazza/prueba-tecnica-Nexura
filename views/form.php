<?php
session_start();

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ ."/../models/user.php";

$database = new Database();
$db = $database->getConnection();
$empleadoModel = new User($db);

$areas = $db->query("SELECT id, nombre FROM areas")->fetchAll(PDO::FETCH_ASSOC);
$roles = $db->query("SELECT id, nombre FROM roles")->fetchAll(PDO::FETCH_ASSOC);

$empleado = null;
$rolesEmpleado = [];

if (isset($_GET['id'])) {
    $empleado = $empleadoModel->getById($_GET['id']);
    $rolesEmpleado = $empleadoModel->getRoles($_GET['id']);
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Formulario Empleado</title>
        <link rel="stylesheet" href="../public/css/styles.css">
        <script src="../public/js/validaciones.js" defer></script>
    </head>

    <body>

        <h2><?php echo $empleado ? "Editar empleado" : "Crear empleado"; ?></h2>

        <div class="alert">
            Los campos con asteriscos (*) son obligatorios
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <p style="color:red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>

        <form method="POST"
            action="../controllers/userController.php?accion=<?php echo $empleado ? 'actualizar' : 'crear'; ?>"
            onsubmit="return validarFormulario();">

            <?php if ($empleado): ?>
                <input type="hidden" name="id" value="<?php echo $empleado['id']; ?>">
            <?php endif; ?>

            <div class="form-group">
                <label>Nombre completo *</label>
                <input type="text" name="nombre"
                    placeholder="Nombre completo del empleado"
                    value="<?php echo $empleado['nombre'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label>Correo electrónico *</label>
                <input type="email" name="email"
                    placeholder="Correo electrónico"
                    value="<?php echo $empleado['email'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label>Sexo *</label>
                <label class="radio">
                    <input type="radio" name="sexo" value="M"
                        <?php echo (isset($empleado) && $empleado['sexo'] === 'M') ? 'checked' : ''; ?>>
                    Masculino
                </label>
                <label class="radio">
                    <input type="radio" name="sexo" value="F"
                        <?php echo (isset($empleado) && $empleado['sexo'] === 'F') ? 'checked' : ''; ?>>
                    Femenino
                </label>
            </div>

            <div class="form-group">
                <label>Área *</label>
                <select name="area_id" required>
                    <option value="">Seleccione un área</option>
                    <?php foreach ($areas as $area): ?>
                        <option value="<?php echo $area['id']; ?>"
                            <?php echo (isset($empleado) && $empleado['area_id'] == $area['id']) ? 'selected' : ''; ?>>
                            <?php echo $area['nombre']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Descripción *</label>
                <textarea name="descripcion"
                        placeholder="Descripción de la experiencia del empleado"
                        required><?php echo $empleado['descripcion'] ?? ''; ?></textarea>
            </div>

            <div class="form-group checkbox">
                <label>
                    <input type="checkbox" name="boletin" value="1"
                        <?php echo (isset($empleado) && $empleado['boletin'] == 1) ? 'checked' : ''; ?>>
                    Deseo recibir boletín informativo
                </label>
            </div>

            <div class="form-group">
                <label>Roles *</label>
                <?php foreach ($roles as $rol): ?>
                    <label class="checkbox">
                        <input type="checkbox" name="roles[]"
                            value="<?php echo $rol['id']; ?>"
                            <?php echo in_array($rol['id'], $rolesEmpleado) ? 'checked' : ''; ?>>
                        <?php echo $rol['nombre']; ?>
                    </label>
                <?php endforeach; ?>
            </div>

            <button type="submit">Guardar</button>
            <a href="list.php" class="cancelar">Cancelar</a>

        </form>

    </body>
</html>
