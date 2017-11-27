/**
 * Created by djauregui on 14/11/2017.
 */
$('.fechapicker').daterangepicker({
    singleDatePicker: true,
    "showDropdowns": true,
    "autoApply": true,
    "locale": {
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
        "daysOfWeek": [
            "Dom",
            "Lun",
            "Mar",
            "Mie",
            "Jue",
            "Vie",
            "Sab"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
        "firstDay": 1
        // format: 'DD/MM/YY' //AL AGREGARLO DATE:AFTER no funciona, por el formato que maneja
    }
});

$('.fechapicker-limite').daterangepicker({
    singleDatePicker: true,
    autoUpdateInput: false,
    "showDropdowns": true,
    "autoApply": true,
    "locale": {
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
        "daysOfWeek": [
            "Dom",
            "Lun",
            "Mar",
            "Mie",
            "Jue",
            "Vie",
            "Sab"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
        "firstDay": 1
        // format: 'DD/MM/YY' //AL AGREGARLO DATE:AFTER no funciona, por el formato que maneja
    }
}, function (chosen_date) {
    $('.fechapicker-limite').val(chosen_date.format('YYYY-MM-DD'));
});