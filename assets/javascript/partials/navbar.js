(()=>{
    let navbar = document.querySelector('nav');
    let burger = document.querySelector('#navbar-burger');

    if (!navbar || !burger) {
        console.error('Navbar or burger not found');
    }

    burger.addEventListener('click', ()=>{
        navbar.classList.toggle('nav-open');
    });
})();