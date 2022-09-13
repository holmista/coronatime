let hamburger = document.getElementById('hamburger')
hamburger.addEventListener('click', () => {
    let littleMenu = document.getElementById('littleMenu')
    let display = littleMenu.style.display === "flex" ? "none" : "flex"
    littleMenu.style.display = display
})
