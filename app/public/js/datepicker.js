$(function () {
    $('#date').datepicker({
        startDate: new Date(),
        format: "yyyy-mm-dd",
        startView: 0,
        minViewMode: 0,
        maxViewMode: 2,
        multidate: true,
        multidateSeparator: "-",
        autoClose: true,
        beforeShowDay: highlight,
    }).on("changeDate", function (event) {
        var dates = event.dates,
            elem = $('#date');
        if (elem.data("selecteddates") == dates.join(",")) return;
        if (dates.length > 2) dates = dates.splice(dates.length - 1);
        dates.sort(function (a, b) {
            return new Date(a).getTime() - new Date(b).getTime()
        });
        elem.data("selecteddates", dates.join(",")).datepicker('setDates', dates);
        $('#start_date').val(formatDate(dates[0]));
        $('#end_date').val(formatDate(dates[1]));
    });

    function highlight(date) {
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

    const searchParams = new URLSearchParams(window.location.search);
    if (searchParams.has('start_date') && searchParams.has('end_date')) {
        $('#date').datepicker('setDates', [searchParams.get('start_date'), searchParams.get('end_date')]);
        $('#start_date').val(searchParams.get('start_date'));
        $('#end_date').val(searchParams.get('end_date'));
    }
});