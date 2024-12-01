<div id="date"></div>

<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    $('#date').datepicker({
        startDate: new Date(),
        format: "yyyy-mm-dd",
        multidate: true,
        multidateSeparator: "-",
        autoClose: true,
        startView: 0,
        weekStart: 1,
        clearBtn: true,
    }).on("changeDate", function (event) {
        var dates = event.dates, elem = $('#date');
        if (elem.data("selecteddates") == dates.join(",")) return;
        if (dates.length > 2) dates = dates.splice(dates.length - 1);
        dates.sort(function (a, b) { return new Date(a).getTime() - new Date(b).getTime() });
        elem.data("selecteddates", dates.join(",")).datepicker('setDates', dates);
    });

    function getDates() {
        console.log($("#date").datepicker("getDates"));
        console.log($("#date").datepicker("getUTCDates"));
        console.log($("#date").data('datepicker').getFormattedDate('yyyy/mm'));
    } $(document).ready(function () {
        $('.input-daterange').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
    });
</script>



