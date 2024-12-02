$(document).ready(function() {
    $("#userTable").tablesorter({
        theme : 'bootstrap',
        widgets : ['uitheme'],
        headerTemplate : '{content} {icon}',
        sortList: [[0,0]]
    });
});
