$(document).ready( function(){
    
    $('#submitRegistrazioneUtente').click(function(event){
        event.preventDefault(); 
        inviaDatiRegistrazione('#inserisciUtente','registrazione', 'utente', '#main' );
    });
    
    $('#submitRegistrazioneMedico').click(function(event){
        event.preventDefault();
        inviaDatiRegistrazione('#inserisciMedico', 'registrazione', 'medico', '#main');
    });
    
    $('#submitRegistrazioneClinica').click(function(event){
        event.preventDefault();
        inviaDatiRegistrazione('#inserisciClinica', 'registrazione', 'clinica', '#main');
    });
    
});


function inviaDatiRegistrazione(id, controller1, task1, ajaxdiv)
{
    
    //recupera tutti i valori del form automaticamente
    var dati =  $(id).serialize();
    $.ajax({
        
        //il tipo di richiesta HTTP da effettuare, di default è GET
        type: 'POST',
        //url della risorsa alla quale viene inviata la richiesta
        //url:  "index.php",
        url: controller1 + "/" + task1 + "/",
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
           alert("Dati clinica inviati per effettuare la registrazione"); 
        },
        error: function()
        {
            alert("Chiamata fallita, si prega di riprovare...");
        }
        
 });
}


