$(function () {
    $("#priceRangeSlider").slider({
        range: true,
        min: 0,
        max: 500,
        values: [0, 300],
        create: function (event, ui) {
            $("#price_min").val($(this).slider("values", 0));
            $("#price_max").val($(this).slider("values", 1));
            $('#priceSpan_min').text($(this).slider("values", 0));
            $('#priceSpan_max').text($(this).slider("values", 1));
        },
        slide: function (event, ui) {
            $("#price_min").val(ui.values[0]);
            $("#price_max").val(ui.values[1]);
            $('#priceSpan_min').text(ui.values[0]);
            $('#priceSpan_max').text(ui.values[1]);
        },
        stop: function (event, ui) {
            $(ui.handle).blur();
        }
    });

    $("#personCountSlider").slider({
        min: 1,
        max: 5,
        value: 1,
        step: 1,
        create: function (event, ui) {
            $("#person_count").val($(this).slider("value"));
            $('#personCountSpan').text($(this).slider("value"));
        },
        slide: function (event, ui) {
            $("#person_count").val(ui.value);
            $('#personCountSpan').text(ui.value);
        },
        stop: function (event, ui) {
            $(ui.handle).blur();
        }
    });

    const searchParams = new URLSearchParams(window.location.search);
    if (searchParams.has('price_min') && searchParams.has('price_max') && searchParams.has('person_count')) {
        
        $("#priceRangeSlider").slider("option", "values", [searchParams.get('price_min'), searchParams.get('price_max')]);
        $("#personCountSlider").slider("option", "value", searchParams.get('person_count'));
        
        $('#priceSpan_min').text(searchParams.get('price_min'));
        $('#priceSpan_max').text(searchParams.get('price_max'));
        $('#personCountSpan').text(searchParams.get('person_count'));
        
        $("#price_min").val(searchParams.get('price_min'));
        $("#price_max").val(searchParams.get('price_max'));
        $("#person_count").val(searchParams.get('person_count'));
    }
});