
document.addEventListener('DOMContentLoaded', function () {
    const tweetButton = document.getElementById('tweetButton');
    const tweetBox = document.getElementById('tweetBox');

    tweetButton.addEventListener('click', function () {
        if (tweetBox.style.display === 'none' || tweetBox.style.display === '') {
            tweetBox.style.display = 'block';
        } else {
            tweetBox.style.display = 'none';
        }
    });
});
function confirmChanges() {
    if (confirm('¿Estás seguro de que deseas guardar los cambios? \n\n\nNota: Si has modificado tu nombre, será necesario iniciar sesión nuevamente para aplicar los cambios.')) {
        checkNameChanged();
        return true; // Continuar con el envío del formulario
    } else {
        return false; // Cancelar el envío del formulario
    }
}

function checkNameChanged() {
    var currentName = "<?php echo $user['Nombre']; ?>";
    var newName = document.getElementById("name").value;

    if (currentName !== newName) {
        setNameChanged();
    }

    // Enviar el formulario
    document.getElementById("profile-edit-form").submit();
}

function setNameChanged() {
    document.getElementById("name_changed").value = "true";
}
