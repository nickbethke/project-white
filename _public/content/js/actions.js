"use strict";

let PWActions = function () {
    this.actions = {};
    /**
     *
     * @param {String} handler
     * @param {function} action
     */
    this.add = function (handler, action) {
        this.actions[handler] = action;
    }
    /**
     *
     * @param {String} handler
     * @returns {boolean}
     */
    this.exists = function (handler) {
        return handler in this.actions;
    }
    /**
     *
     * @param {String} handler
     */
    this.call = function (handler, event) {
        this.exists(handler) && this.actions[handler](handler, event);
    }
};


let actions = new PWActions();
actions.add("logout-prompt", (action, event) => {
    let prompt = new Prompt()
    prompt.setTitle('Logout')
    prompt.setMessage('Logout from project white?')
    prompt.show(a => {
        if (a) {
            window.location.replace(pwOptions.home_url + "/logout.php")
        }
    })
});


(function () {
    let actionHandler = document.querySelectorAll('.pw-action')
    actionHandler.forEach(i => {
        i.addEventListener('click', e => {
            let action = i.getAttribute('action');
            if (actions.exists(action)) {
                e.preventDefault()
                actions.call(action, e);
            } else {
                console.warn("Missing action: " + action)
            }
        })
    })

})()