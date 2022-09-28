"use strict";

let items = document.querySelectorAll("[data-collapse-toggle]");
items.forEach(e => {
    let toggle = document.getElementById(e.getAttribute('data-collapse-toggle'));
    if (toggle.classList.contains("hidden")) {
        e.classList.remove('closeable-trigger-open');
    } else {
        e.classList.add('closeable-trigger-open');
    }
    e.addEventListener('click', () => {
        let toggle = document.getElementById(e.getAttribute('data-collapse-toggle'));
        if (toggle.classList.contains("hidden")) {
            e.classList.add('closeable-trigger-open');
        } else {
            e.classList.remove('closeable-trigger-open');
        }
        if (toggle !== null)
            toggle.classList.toggle('hidden');
    })
})


let menuOpener = document.querySelector('#responsive-menu-opener');
let menuCloser = document.querySelector('#responsive-menu-closer');

['click', 'keydown'].forEach(function (e) {
    menuOpener.addEventListener(e, e => {
        e.preventDefault();
        let sidebar = document.querySelector('#sidebar');
        sidebar.classList.add('open');
        let main = document.querySelector('main');
        main.classList.add('sidebar-open');
    });
});

['click', 'keydown'].forEach(function (e) {
    menuCloser.addEventListener(e, e => {
        e.preventDefault();
        let sidebar = document.querySelector('#sidebar');
        sidebar.classList.remove('open');
        let main = document.querySelector('main');
        main.classList.remove('sidebar-open');
    });
});