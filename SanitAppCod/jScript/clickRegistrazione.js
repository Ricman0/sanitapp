$(document).ready( function(){
    //fissa un gestore di submit al form
    $('#submitRegistrazioneUtente').submit(function(event){
        //ferma la form dal normale submitting(sottoporre i dati del form)
        event.preventDefault(); 
        
        inviaDatiRegistrazione('#inserisciUtente','registrazione', 'utente', '#main' );
    });
    
    $('#submitRegistrazioneMedico').submit(function(event){
        event.preventDefault();
        inviaDatiRegistrazione('#inserisciMedico', 'registrazione', 'medico', '#main');
    });
    
    $('#submitRegistrazioneClinica').submit(function(event){
        event.preventDefault();
        inviaDatiRegistrazione('#inserisciClinica', 'registrazione', 'clinica', '#main');
    });
    
});


function inviaDatiRegistrazione(id, controller1, task1, ajaxdiv)
{
    
    //recupera tutti i valori del form automaticamente
    var dati =  $(id).serialize();
//    la riga successiva è una prova
//    dati = dati + "&controller=" + controller1 + "&task=" + task1;
    alert (dati);
    //invia i dati usando il metodo post
    $.ajax({
        //il tipo di richiesta HTTP da effettuare, di default è GET
        type: 'POST',
        
        //url della risorsa alla quale viene inviata la richiesta
        // url:  "index.php",
//        url: controller1 + "/" + task1 + "/",
        url: "registrazione/utente",
        
        
        //che può essere un oggetto del tipo {chiave : valore, chiave2 : valore}, 
        //oppure una stringa del tipo "chiave=valore&chiave2=valore2"
        // contenente dei dati da inviare al server
        
        //data: {datiDaInviare:  dati, controller:controller1, task:task1}, 
        data: dati,
        
        
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
            alert("Chiamata fallita, si prega di riprovare...  ");
            
        }
        
 });

//xhr.onreadystatechange = function() { alert(xhr.readyState); };

//$.ajax({
//    url: controller1 + "/" + task1 + "/",
//    type:"POST",
//    data: dati
//})
//        .done(alert("Dati utente inviati per effettuare la registrazione"))
//        .fail(function(xhr, status, errorThrown){
//            alert("sorry");
//            console.log("error: "+ errorThrown);
//            console.log("status: "+ status);
//            console.dir(xhr);
//        })
}


