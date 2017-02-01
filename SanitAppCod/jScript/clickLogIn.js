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

function inviaDatiGenerico(id, controller, ajaxdiv)
{
    if(controller==='recuperaPassword'){
        $( "#loadingModal" ).show();
    }
    //recupera tutti i valori del form automaticamente
    var dati =  $(id).serialize();
    $.ajax({
        
        //il tipo di richiesta HTTP da effettuare, di default è GET
        type: 'POST',
        //url della risorsa alla quale viene inviata la richiesta
        //url:  "index.php",
        url: controller,
        //che può essere un oggetto del tipo {chiave : valore, chiave2 : valore}, 
        //oppure una stringa del tipo "chiave=valore&chiave2=valore2"
        // contenente dei dati da inviare al server
        //data: {datiDaInviare:  dati, controller:controller1, task:task1}, 
        data:  dati,
        dataType: "html",
        //success(data, textStatus, XMLHTTPRequest) : funzione che verrà 
        //eseguita al successo della chiamata. I tre parametri sono, 
        //rispettivamente, l’oggetto della richiesta, lo stato e la 
        //descrizione testuale dell’errore rilevato
        success: function(msg)
        {
           $(ajaxdiv).html(msg);
        },
        complete: function(){
            $( "#loadingModal" ).hide();
        },
        error: function(xhr, status, error) 
        {
            alert("Chiamata fallita, si prega di riprovare...");
        }
        
      
 });
 }
