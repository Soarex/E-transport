$(document).ready(function() {
    $.get("src/nav_user.php", function(data) {
        $(".nav_links").append(data);
    });

    $("#info_link").click(load_info);
    $("#home_link").click(load_home);
    $("#logo").click(load_home);
    $("#tratte_link").click(load_tratte);
})

function load_user() {
    $("#content").load("src/user_page.php");
}

function load_info() {
    $("#content").load("src/info_page.php");
}

function load_home() {
    $("#content").load("src/home_page.php");
}

function load_tratte() {
    $("#content").load("src/tratte_page.php");
}

function logout() {
    window.location.href='src/log_out.php'
}