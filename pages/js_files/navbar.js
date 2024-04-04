function toggler() {
    const icon = document.querySelector('#toggler');
    const menu = document.querySelector('.menu');

    if (icon.innerHTML == "menu") {
        icon.innerHTML = "close";
        menu.style.display = "block";
    } else {
        icon.innerHTML = "menu";
        menu.style.display = "none";
    }
}
