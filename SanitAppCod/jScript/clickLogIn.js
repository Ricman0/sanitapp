
$(document).ready(function () {

        $("#submitLogIn").click(function () {
            inviaDatiLogIn('#logInForm', '#contenutiAjax' );
        });
});

function inviaUsernamePassword(id, ajaxdiv)
{
    
    //recupera tutti i valori del form automaticamente
    var dati =  $(id).serialize();
    $.ajax({
        
        //il tipo di richiesta HTTP da effettuare, di default è GET
        type: 'POST',
        //url della risorsa alla quale viene inviata la richiesta
        //url:  "index.php",
        url: "logIn",
        //che può essere un oggetto del tipo {chiave : valore, chiave2 : valore}, 
        //oppure una stringa del tipo "chiave=valore&chiave2=valore2"
        // contenente dei dati da inviare al server
        //data: {datiDaInviare:  dati, controller:controller1, task:task1}, 
        data: {datiDaInviare:  dati},
        //success(data, textStatus, XMLHTTPRequest) : funzione che verrà 
        //eseguita al successo della chiamata. I tre parametri sono, 
        //rispettivamente, l’oggetto della richiesta, lo stato e la 
        //descrizione testuale dell’errore rilevato
        success: function()
        {
           alert("Username e password inviati per effettuare il log in"); 
        },
        error: function()
        {
            alert("Chiamata fallita, si prega di riprovare...");
        }
        
 });
 }
