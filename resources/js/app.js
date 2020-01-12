//require('./bootstrap');

window.$ = require('jquery');


window.ajaxSelect = function (trigger, target, source) {
    $(`select[name="${target}"]`).find('option').remove();
    
    var selected_id = $(`select[name="${trigger}"]`).children("option:selected").val()

    var url = source.replace('{id}', selected_id);

    $.get(url, function(data){
      data.forEach(function(entry) {
        $(`select[name="${target}"]`).append(new Option(entry.name, entry.id))
      })
    });
}