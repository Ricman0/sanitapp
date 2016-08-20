/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    $("#ricercaEsamiCerca").submit( function(event) {
        event.preventDefault();
        inviaDatiForm('#formRicercaEsami', 'esami', '#tabellaEsami');
    });
});

function inviaDatiForm(id, controller1, ajaxdiv)
{
    
    //recupera tutti i valori del form automaticamente
    var dati =  $(id).serialize();
    console.log(dati);
//    la riga successiva è una prova
//    dati = dati + "&controller=" + controller1 + "&task=" + task1;
    
    //invia i dati usando il metodo post
    $.ajax({
        
        
        //url della risorsa alla quale viene inviata la richiesta
        // url:  "index.php",
        url: controller1,
        
        //il tipo di richiesta HTTP da effettuare, di default è GET
        type: 'POST',
        
        //che può essere un oggetto del tipo {chiave : valore, chiave2 : valore}, 
        //oppure una stringa del tipo "chiave=valore&chiave2=valore2"
        // contenente dei dati da inviare al server
        
        //data: {datiDaInviare:  dati, controller:controller1, task:task1}, 
        data: dati,
        
        
        //success(data, textStatus, XMLHTTPRequest) : funzione che verrà 
        //eseguita al successo della chiamata. I tre parametri sono, 
        //rispettivamente, l’oggetto della richiesta, lo stato e la 
        //descrizione testuale dell’errore rilevato
        success: function(datiRisposta, dati)
        {
           
           alert("Dati ricerca esame inviati per effettuare la registrazione"); 
           $(ajaxdiv).html(datiRisposta);
           
        },
        error: function()
        {
            alert("Chiamata fallita, si prega di riprovare...  ");
            
        }
        
 });
}
