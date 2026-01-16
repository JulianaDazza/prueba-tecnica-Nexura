<?php
session_start();

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ ."/../models/user.php";

$database = new Database();
$db = $database->getConnection();
$empleadoModel = new User($db);

// Datos para los selects y los checkbox
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

<h2><?php echo $empleado ? "Editar Empleado" : "Crear Empleado"; ?></h2>

<?php if (isset($_SESSION['error'])): ?>
    <p style="color:red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<form method="POST"
      action="../controllers/EmpleadoController.php?accion=<?php echo $empleado ? 'actualizar' : 'crear'; ?>"
      onsubmit="return validarFormulario();">

    <?php if ($empleado): ?>
        <input type="hidden" name="id" value="<?php echo $empleado['id']; ?>">
    <?php endif; ?>

    <!-- Nombre -->
    <label>Nombre:</label><br>
    <input type="text" name="nombre" value="<?php echo $empleado['nombre'] ?? ''; ?>" required><br><br>

    <!-- Email -->
    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo $empleado['email'] ?? ''; ?>" required><br><br>

    <!-- Descripción -->
    <label>Descripción:</label><br>
    <textarea name="descripcion" required><?php echo $empleado['descripcion'] ?? ''; ?></textarea><br><br>

    <!-- Sexo -->
    <label>Sexo:</label><br>
    <input type="radio" name="sexo" value="M" <?php echo (isset($empleado) && $empleado['sexo'] === 'M') ? 'checked' : ''; ?>> Masculino
    <input type="radio" name="sexo" value="F" <?php echo (isset($empleado) && $empleado['sexo'] === 'F') ? 'checked' : ''; ?>> Femenino
    <br><br>

    <!-- Área -->
    <label>Área:</label><br>
    <select name="area_id" required>
        <option value="">Seleccione un área</option>
        <?php foreach ($areas as $area): ?>
            <option value="<?php echo $area['id']; ?>"
                <?php echo (isset($empleado) && $empleado['area_id'] == $area['id']) ? 'selected' : ''; ?>>
                <?php echo $area['nombre']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <!-- Roles -->
    <label>Roles:</label><br>
    <?php foreach ($roles as $rol): ?>
        <input type="checkbox" name="roles[]"
               value="<?php echo $rol['id']; ?>"
            <?php echo in_array($rol['id'], $rolesEmpleado) ? 'checked' : ''; ?>>
        <?php echo $rol['nombre']; ?><br>
    <?php endforeach; ?>
    <br>

    <!-- Boletín -->
    <label>
        <input type="checkbox" name="boletin" value="1"
            <?php echo (isset($empleado) && $empleado['boletin'] == 1) ? 'checked' : ''; ?>>
        Recibir boletín
    </label>
    <br><br>

    <button type="submit">Guardar</button>
    <a href="listar.php">Cancelar</a>

</form>

</body>
</html>