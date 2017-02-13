$(document).ready(function () {
        
        $('#headerMain').on("click", ".loginButton", function () {
            validazione("autenticazione",'#' + $(this).closest("form").prop("id"));
    });
        
        $('#headerMain').on("click", ".logOutButton", function () {
        
        history.pushState(null, 'home', 'index.php');
        $.ajax({
            type: 'GET',
            url: 'logOut',
            success: function (datiRisposta)
            {
                $("#wrapper").html(datiRisposta);
            },
            error: function ()
            {
                alert("Sbagliato click ");
            }
        });
        
    });
});

