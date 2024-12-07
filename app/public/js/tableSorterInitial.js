$(document).ready(function() {
    $("#sortedTable").tablesorter({
        theme : 'bootstrap',
        widgets : ['uitheme'],
        headerTemplate : '{content} {icon}',
        sortList: [[0,0]]
    });
});
