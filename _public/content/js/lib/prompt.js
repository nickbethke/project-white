"use strict";

let Prompt = function () {
    this.title = ""
    this.message = ""
    this.container = null
    this.setTitle = (title) => {
        this.title = title
    }
    this.setMessage = (msg) => {
        this.message = msg
    }
    this.show = (_callback) => {
        this.container = document.createElement("div")
        this.container.classList.add('fixed', 'top-1/2', 'left-1/2', 'min-w-[400px]', 'shadow-2xl')

        this.header = document.createElement('div');
        this.header.classList.add('py-2', 'px-4', 'bg-gray-800', 'text-white', 'uppercase', 'font-bold')
        this.header.innerHTML = this.title;

        this.content = document.createElement('div');
        this.content.classList.add('px-4', 'py-8', 'bg-white')
        this.content.innerHTML = this.message;

        this.footer = document.createElement('div')
        this.footer.classList.add('flex', 'justify-around', 'w-full')

        this.accept = document.createElement('button')
        this.cancel = document.createElement('button')

        this.accept.innerHTML = "OK"
        this.cancel.innerHTML = "Cancel"

        this.accept.classList.add('p-2', 'text-sm', 'bg-gray-800', 'text-white', 'w-1/2', 'border-r', 'hover:bg-gray-600')
        this.cancel.classList.add('p-2', 'text-sm', 'bg-gray-800', 'text-white', 'w-1/2', 'hover:bg-gray-600')

        this.footer.append(this.accept, this.cancel)

        this.container.append(this.header)
        this.container.append(this.content)
        this.container.append(this.footer)

        document.body.append(this.container)

        this.accept.addEventListener('click', () => {
            this.hide();
            typeof _callback == 'function' ? _callback(true) : false;
        })
        this.cancel.addEventListener('click', () => {
            this.hide();
            typeof _callback == 'function' ? _callback(false) : false;
        })
    }
    this.hide = () => {
        this.container.remove()
    }
}