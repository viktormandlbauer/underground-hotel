<div id="date"></div>
<input type="hidden" name="start_date" id="start_date">
<input type="hidden" name="end_date" id="end_date">

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>

<script>
    $('#date').datepicker({
        starteDate: new Date(),
        format: "yyyy-mm-dd",
        startView: 0,
        minViewMode: 0,
        maxViewMode: 2,
        multidate: true,
        multidateSeparator: "-",
        autoClose: true,
        beforeShowDay: highlightRange,
    }).on("changeDate", function(event) {
        var dates = event.dates,
            elem = $('#date');
        if (elem.data("selecteddates") == dates.join(",")) return;
        if (dates.length > 2) dates = dates.splice(dates.length - 1);
        dates.sort(function(a, b) {
            return new Date(a).getTime() - new Date(b).getTime()
        });
        elem.data("selecteddates", dates.join(",")).datepicker('setDates', dates);
        $('#start_date').val(formatDate(dates[0]));
        $('#end_date').val(formatDate(dates[1]));
    });

    function highlightRange(date) {
        var selectedDates = $('#date').datepicker('getDates');
        if (selectedDates.length === 2 && date >= selectedDates[0] && date <= selectedDates[1]) {
            return 'highlighted';
        }
        return '';
    }

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    }
</script>

<style>
    .highlighted {
        background-color: #99ccff;
    }
</style>