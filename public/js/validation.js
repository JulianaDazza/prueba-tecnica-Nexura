function validarFormulario() {

    const nombre = document.querySelector('input[name="nombre"]').value.trim();
    const email = document.querySelector('input[name="email"]').value.trim();
    const descripcion = document.querySelector('textarea[name="descripcion"]').value.trim();
    const sexo = document.querySelector('input[name="sexo"]:checked');
    const area = document.querySelector('select[name="area_id"]').value;
    const roles = document.querySelectorAll('input[name="roles[]"]:checked');

    if (nombre === "") {
        alert("El nombre es obligatorio.");
        return false;
    }

    if (email === "") {
        alert("El email es obligatorio.");
        return false;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert("El email no tiene un formato válido.");
        return false;
    }

    if (descripcion === "") {
        alert("La descripción es obligatoria.");
        return false;
    }

    if (!sexo) {
        alert("Debe seleccionar el sexo.");
        return false;
    }

    if (area === "") {
        alert("Debe seleccionar un área.");
        return false;
    }

    if (roles.length === 0) {
        alert("Debe seleccionar al menos un rol.");
        return false;
    }

    return true;
}
