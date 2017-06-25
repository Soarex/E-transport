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
    $("#content").load("src/tratte_page.html");
    tratte_urbane();
}

function logout() {
    window.location.href='src/log_out.php'
}

function tratte_urbane() {
    $.get("src/tratte_page.php", {tratta: "tratta_urbano"}, function(data) {
        $("#tratte_info").html(data);
    });
}

function tratte_extraurbane() {
    $.get("src/tratte_page.php", {tratta: "tratta_extraurbano"}, function(data) {
        $("#tratte_info").html(data);
    });
}

function tratte_treni() {
    $.get("src/tratte_page.php", {tratta: "tratta_treno"}, function(data) {
        $("#tratte_info").html(data);
    });
}

function tratte_metro() {
    $.get("src/tratte_page.php", {tratta: "tratta_metro"}, function(data) {
        $("#tratte_info").html(data);
    });
}

function tratte_tram() {
    $.get("src/tratte_page.php", {tratta: "tratta_tram"}, function(data) {
        $("#tratte_info").html(data);
    });
}

function tratte_traghetto() {
    $.get("src/tratte_page.php", {tratta: "tratta_traghetto"}, function(data) {
        $("#tratte_info").html(data);
    });
}