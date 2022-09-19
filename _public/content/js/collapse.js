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
