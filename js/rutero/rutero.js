/*
 $(document).ready(function () {
 $('#DatosRutero').DataTable({
 initComplete: function () {
 this.api().columns().every(function () {
 var column = this;
 var select = $('<select><option value=""></option></select>')
 .appendTo($(column.footer()).empty())
 .on('change', function () {
 var val = $.fn.dataTable.util.escapeRegex(
 $(this).val()
 );
 
 column
 .search(val ? '^' + val + '$' : '', true, false)
 .draw();
 });
 
 column.data().unique().sort().each(function (d, j) {
 select.append('<option value="' + d + '">' + d + '</option>')
 });
 });
 },
 "pagingType": "full_numbers",
 "bProcessing": true,
 "sPlaceHolder": 'head:before',
 "sAjaxSource": "index.php?r=Rutero/AjaxJsonDetalleRutero",
 "aoColumns": [
 {mData: 'NumeroVisita'},
 {mData: 'CodFrecuencia'},
 {mData: 'R1'},
 {mData: 'R2'},
 {mData: 'R3'},
 {mData: 'R4'},
 {mData: 'CuentaCliente'},
 {mData: 'NombreCliente'},
 {mData: 'DireccionEntrega'},
 {mData: 'Telefono'},
 {mData: 'TelefonoMovil'},
 {mData: 'NombreBarrio'},
 {mData: 'Valorcupo'}
 ]
 });
 });
 
 */$(document).ready(function () {

    $('#DatosRutero').DataTable({
        "aoColumns": [
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}
        ],

    });
    $('#DatosRutero').dataTable().columnFilter({
        sPlaceHolder: 'head:before',
        aoColumns: [{type: "select"},
            {type: "select"},
            {type: "select"},
            {type: "select"},
            {type: "select"},
            {type: "select"},
            {type: "select"},
             null,
            null,
             null,
             null,
            {type: "select"},
            {type: "select"}
        ]
    });
});


$(document).ready(function () {

    $('#DatosPedido').DataTable({
        "aoColumns": [
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}
        ],

    });
    $('#DatosPedido').dataTable().columnFilter({
        sPlaceHolder: 'head:before',
        aoColumns: [{type: "select"},
            {type: "select"},
            {type: "select"},
            {type: "select"}
        ]
    });



});
