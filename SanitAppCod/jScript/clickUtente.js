/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    $('#main').on("click", "#prenotazioniAreaPersonaleUtente", function(){
//        $( "#prenotazioniAreaPersonaleUtente").addClass("Attivo");
        inviaControllerTask('prenotazioni', 'visualizza', "#contenutoAreaPersonale"); 
    });
    
    $('#main').on("click", "#refertiAreaPersonaleUtente", function(){
        inviaControllerTask('referti', 'utente', "#contenutoAreaPersonale");
    });
    
    $('#main').on("click", "#impostazioniAreaPersonaleUtente", function(){
        inviaControllerTask('impostazioni', 'utente', "#contenutoAreaPersonale");
    });
    
    $('#main').on("click", "#iconaAggiungiPrenotazione", function(){
        inviaControllerTask('prenotazioni', 'aggiungi', "#contenutoAreaPersonale");
    });
    
    var id = $(this).attr('id');
    $('#main').on("click", ".rigaPrenotazione" , function(){
        clickRiga('prenotazioni', 'visualizza', id, "#contenutoAreaPersonale");
    });
     
    $('#main').on("click", "#modificaIndirizzoUtente", function(){
        clickModificaImpostazioni('impostazioni', 'utente', 'modifica', 'informazioni', "#informazioniGeneraliUtente");
    });
     
});

function clickModificaImpostazioni(controller, task, task2, task3, ajaxdiv)
{
    $.ajax({
        type : 'GET',
        url : controller + '/' + task + '/' + task2 + '/' + task3 + '/',
        success: function(datiRisposta)
        {
            alert(datiRisposta);
            $(ajaxdiv).html(datiRisposta);
        }
    });
}


