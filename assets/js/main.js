const navSlide = () => {
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.nav-links');
    
    if (burger) {
        burger.addEventListener('click', () => {
            nav.classList.toggle('nav-active');
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    navSlide();
});