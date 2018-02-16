/**
 * Created by djauregui on 14/11/2017.
 */
$('#dateRange').daterangepicker({
    "showDropdowns": true,
    // "autoApply": true,
    "locale": {
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "Desde",
        "toLabel": "A",
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
    },
    ranges: {
        'Hoy': [moment(), moment()],
        'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Ultimos 7 Dias': [moment().subtract(6, 'days'), moment()],
        'Ultimos 30 Dias': [moment().subtract(29, 'days'), moment()],
        'Este Mes': [moment().startOf('month'), moment().endOf('month')],
        'Ultimo Mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
}, cb);

function cb(start, end) {
    var arrayMeses = [
        "Vacio",
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
    ];
    var inicio = arrayMeses[start.format('M')]+' '+start.format('D')+', '+start.format('YYYY');
    var fin = arrayMeses[end.format('M')]+' '+end.format('D')+', '+end.format('YYYY');

    $('#dateRange span').html(inicio + ' - ' + fin);

    getChartUpdate( (start.format('D')+"/"+start.format('M')+"/"+start.format('YYYY') ) , (end.format('D')+"/"+end.format('M')+"/"+end.format('YYYY')) );
}