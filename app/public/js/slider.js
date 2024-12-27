$(function () {
    $("#priceRangeSlider").slider({
        range: true,
        min: 0,
        max: 500,
        values: [0, 300],
        slide: function (event, ui) {
            $("#minPrice").val(ui.values[0]);
            $("#maxPrice").val(ui.values[1]);
            $('#minPriceSpan').text(ui.values[0]);
            $('#maxPriceSpan').text(ui.values[1]);
        },
        stop: function (event, ui) {
            $(ui.handle).blur();
        }
    });
});


$(function () {
    $("#personCountSlider").slider(
        {
            min: 1,
            max: 5,
            value: 1,
            step: 1,
            slide: function (event, ui) {
                $("#personCount").val(ui.value);
                $('#personCountSpan').text(ui.value);
            },
            stop: function (event, ui) {
                $(ui.handle).blur();
            }
        }
    );
});