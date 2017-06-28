$(document).ready(function() {
    $.get("src/nav_user.php", function(data) {
        $(".nav_links").append(data);
    });

    $("#content").load("src/home_page.php");

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

function profilo() {
    $('#card_info').load('src/profile_page.php');
}

function cronologia() {
    $('#card_info').load('src/history_page.php');
}

function metodi() {
    $('#card_info').load('src/methods_page.php');
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

function card_page(numero_carta, saldo_carta) {
    $.post("src/card_page.php", {carta: numero_carta, saldo: saldo_carta}, function(data) {
        $("#card_info").html(data);
    });
}

function trasferisci_denaro(origine, saldo) {
    if($('#quantita').val() == "") {
        alert("Inserire una quantità");
        return;
    }

    if($('#quantita').val() > saldo) {
        alert("Fondi non disponibili");
        return;
    }

    if($('#quantita').val() <= 0) {
        alert("Inserire una quantità valida");
        return;
    }

    if($('#carta_destinazione').val() === "Nessuna carta disponibile") {
        alert("Carta destinazione non valida");
        return;
    }

    $.post("src/trasferimento_denaro.php", {
            carta_origine: origine, 
            carta_destinazione: $('#carta_destinazione').val(), 
            quantita:$('#quantita').val()
        }, 
        function(data) {
            alert(data);
            $('#content').load('src/user_page.php');
        }
    );
}

function rimuovi_carta(carta) {
    $.post("src/rimozione_carta.php", {numero_carta: carta}, function(data) {
        alert(data);
        $('#content').load('src/user_page.php');
    });
}

function carica_denaro(origine) {
    if($('#quantita_ricarica').val() == "") {
        alert("Inserire una quantità");
        return;
    }

    if($('#quantita_ricarica').val() <= 0) {
        alert("Inserire una quantità valida");
        return;
    }

    if($('#metodo_pagamento_ricarica').val() === "Nessun metodo registrato") {
        alert("Metodo di pagamento non valida");
        return;
    }

    $.post("src/carica_denaro.php", {
            carta: origine, 
            metodo_pagameto: $('#metodo_pagamento_ricarica').val(), 
            quantita:$('#quantita_ricarica').val()
        }, 
        function(data) {
            alert(data);
            $('#content').load('src/user_page.php');
        }
    );
}

function method_info(id_metodo) {
    if (confirm('Eliminare il metodo di pagamento?')) {
        $.post("src/remove_method.php", {id: id_metodo}, function(data) {
            alert(data);
            $("#card_info").load('src/methods_page.php');
        });
    }
}

function rimuovi_account(id_cliente) {
    $.post("src/elimina_utente.php", {
            id: id_cliente, 
        }, 
        function(data) {
            alert(data);
            window.location.href='index.html';
        }
    );
}