/**
 * Created by djauregui on 16/2/2018.
 */
$( document ).ready(function() {

    var $rows = $('#tbodySalidas tr');
    $('#txtBuscarSalida').keyup(function() {
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

        $rows.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });

});