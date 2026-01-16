<?php
session_start();

require_once __DIR__ ."/../config/database.php";
require_once __DIR__ ."/../models/user.php";

$database = new Database();
$db = $database->getConnection();
$empleado = new User($db);

// Acción recibida
$accion = $_GET['accion'] ?? '';

try {
    /* CREAR EMPLEADO */

    if($accion === 'crear' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        //validaciones
        if(
            empty($_POST['nombre']) ||
            empty($_POST['email']) ||
            empty($_POST['sexo']) ||
            empty($_POST['area_id']) ||
            empty($_POST['descripcion']) ||
            !isset($_POST['roles'])
        ){
            $_SESSION['error'] = "Todos los campos obligatorios deben completarse";
            header("Location: ../views/form.php");
            exit;
        }

        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $_SESSION['error'] = "El correo electronico no es valido";
            header("Location: ../views/form.php");
            exit;
        }

        $data = [
            'nombre' => trim($_POST['nombre']),
            'email' => trim($_POST['email']),
            'sexo' => $_POST['sexo'],
            'area_id' => (int) $_POST['area_id'],
            'boletin' => isset($_POST['boletin']) ? 1 : 0,
            'descripcion' => trim($_POST['descripcion']),
            'roles' => $_POST['roles']
        ];

        if ($empleado->create($data)) {
            $_SESSION['success'] = "Empleado creado correctamente.";
        } else {
            $_SESSION['error'] = "Error al crear el empleado.";
        }

        header("Location: ../views/list.php");
        exit;

    }

    /* ACTUALIZAR EMPLEADO */
    if($accion === 'actualizar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];

        if(empty($id)) {
            $_SESSION['error'] = "Empleado no encontrado";
            header("Location: ../views/list.php");
            exit;
        }

        $data = [
            'nombre' => trim($_POST['nombre']),
            'email' => trim($_POST['email']),
            'sexo' => $_POST['sexo'],
            'area_id' => (int) $_POST['area_id'],
            'boletin' => isset($_POST['boletin']) ? 1 : 0,
            'descripcion' => trim($_POST['descripcion']),
            'roles' => $_POST['roles']
        ];

        if ($empleado->update($id,$data)) {
            $_SESSION['success'] = "Empleado actualizado correctamente.";
        } else {
            $_SESSION['error'] = "Error al actualizar el empleado.";
        }

        header("Location: ../views/list.php");
        exit;
    }

    /* ELIMINAR EMPLEADO */
    if($accion === 'eliminar'){
        $id = $_GET['id'] ?? null;

        if($id && $empleado->delete($id)) {
             $_SESSION['success'] = "Empleado eliminado correctamente.";
        } else {
            $_SESSION['error'] = "Error al eliminar el empleado.";
        }

        header("Location: ../views/list.php");
        exit;
    }

} catch(Exception $e) {
    $_SESSION["error"] = "Error inesperado:" . $e->getMessage();
    header("Location: ../views/list.php");
    exit;
}