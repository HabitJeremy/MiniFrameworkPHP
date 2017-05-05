$(document).ready(function () {

    var menu = $('#ulMenu'),
        btn = $('#btnMenu');

    btn.on('click', function () {
       menu.slideToggle("slow");
    });

});