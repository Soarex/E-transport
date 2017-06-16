$(document).ready(function() {
    $.get("src/nav_user.php", function(data) {
        $(".nav_links").append(data);
    });
})