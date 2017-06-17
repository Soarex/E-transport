$(document).ready(function() {
    $.get("src/nav_user.php", function(data) {
        $(".nav_links").append(data);
    });
})

function load_user() {
    $("#content").load("src/user_page.php");
}

function logout() {
    window.location.href='src/log_out.php'
}