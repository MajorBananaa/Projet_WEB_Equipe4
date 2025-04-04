let menu = document.querySelector('#menu-icon');
let navlist = document.querySelector('.navlist'); 

menu.onclick= () => {
    menu.classList.toggle('ri-menu-line');
    navlist.classList.toggle('open');
}