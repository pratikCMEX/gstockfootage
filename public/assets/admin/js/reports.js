$.fn.dataTable.ext.buttons.reload = {
    text: '<i class="fa fa-refresh"></i> Reload',
    action: function (e, dt, node, config) {
        dt.ajax.reload();
    }
};

$.fn.dataTable.ext.buttons.resetTable = {
    text: '<i class="fa fa-undo"></i> Reset',
    action: function (e, dt, node, config) {
        $('#from_date').val('');
        $('#to_date').val('');
        dt.ajax.reload();
    }
};

$(document).ready(function () {
    // ✅ Get existing DataTable instance, don't reinitialize
    let table = $('#orderhistory-table').DataTable();

    $('#from_date, #to_date').on('change', function () {
        table.ajax.reload();
    });


    let UserSubscriptiontable = window.LaravelDataTables['usersubscriptionreport-table'];

    $('#from_date, #to_date').on('change', function () {
        UserSubscriptiontable.ajax.reload();
    });
});