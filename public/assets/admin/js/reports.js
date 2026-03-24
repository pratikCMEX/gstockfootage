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

    //  Date validation - works globally on all pages
    $('#from_date').on('change', function () {
        let fromDate = $(this).val();
        $('#to_date').attr('min', fromDate);
        if ($('#to_date').val() && $('#to_date').val() < fromDate) {
            $('#to_date').val(fromDate);
        }
    });

    $('#to_date').on('change', function () {
        let toDate = $(this).val();
        $('#from_date').attr('max', toDate);
        if ($('#from_date').val() && $('#from_date').val() > toDate) {
            $('#from_date').val(toDate);
        }
    });

    //  Order History Table
    if ($('#orderhistory-table').length) {
        let orderTable = window.LaravelDataTables['orderhistory-table'];
        if (orderTable) {
            $('#from_date, #to_date,#payment_status,#order_status').on('change', function () {
                orderTable.ajax.reload();
            });
        }
    }

    //  User Subscription Table
    if ($('#usersubscriptionreport-table').length) {
        let userSubTable = window.LaravelDataTables['usersubscriptionreport-table'];
        if (userSubTable) {
            $('#from_date, #to_date,#payment_status,#status').on('change', function () {
                userSubTable.ajax.reload();
            });
        }
    }

    //  Most Sold Product Table - uses init.dt because it loads slower
    if ($('#mostsoldproductreport-table').length) {
        $('#mostsoldproductreport-table').on('init.dt', function () {
            let mostSoldTable = window.LaravelDataTables['mostsoldproductreport-table'];
            if (mostSoldTable) {
                $('#from_date, #to_date').on('change', function () {
                    mostSoldTable.ajax.reload();
                });
            }
        });
    }

    // Most Viewed Products Table
    if ($('#mostviewedproductsreport-table').length) {
        $('#mostviewedproductsreport-table').on('init.dt', function () {
            let mostViewedTable = window.LaravelDataTables['mostviewedproductsreport-table'];
            if (mostViewedTable) {
                $('#from_date, #to_date').on('change', function () {
                    mostViewedTable.ajax.reload();
                });
            }
        });
    }

    // Live Cart Report Table
    if ($('#livecartreport-table').length) {
        $('#livecartreport-table').on('init.dt', function () {
            let liveCartTable = window.LaravelDataTables['livecartreport-table'];
            if (liveCartTable) {
                $('#from_date, #to_date').on('change', function () {
                    liveCartTable.ajax.reload();
                });
            }
        });
    }
    //  User Wise Order Report Table
    if ($('#userwiseorderreport-table').length) {
        $('#userwiseorderreport-table').on('init.dt', function () {
            let userWiseTable = window.LaravelDataTables['userwiseorderreport-table'];
            if (userWiseTable) {
                $('#from_date, #to_date').on('change', function () {
                    userWiseTable.ajax.reload();
                });
            }
        });
    }

});