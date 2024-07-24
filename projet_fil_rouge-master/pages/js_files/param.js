function enableInput(button) {
    var input = button.parentNode.querySelector('input');
    input.disabled = !input.disabled;
    // Change button icon
    var icon = button.querySelector('.material-symbols-outlined');
    icon.innerText = input.disabled ? 'edit' : 'done'; // Change the icon based on input state
}

function submitAndRedirect() {
    document.getElementById('modifUser').submit();
    window.location.href = "/pages/parametre/parametre.php";
}