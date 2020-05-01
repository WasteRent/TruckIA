require('./bootstrap');


window.$ = require('jquery');


// var Turbolinks = require("turbolinks")
// Turbolinks.start()

window.ajaxSelect = function(trigger, target, source) {
    $(`select[name="${target}"]`).find('option').remove();

    var selected_id = $(`select[name="${trigger}"]`).children("option:selected").val()

    var url = source.replace('{id}', selected_id);

    $.get(url, function(data) {
        data.forEach(function(entry) {
            $(`select[name="${target}"]`).append(new Option(entry.name, entry.id))
        })
    });
}

window.confirmDelete = function() {
    return confirm("Deseas eliminar este elemento!")
}

import Vue from 'vue'
const files = require.context('./components', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

import VModal from 'vue-js-modal'
Vue.use(VModal)

const app = new Vue({
    el: '#app',
    data: {
        modalVehicles: false,
        modalGarages: false,
    }
});