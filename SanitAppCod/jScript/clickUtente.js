/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    $('#headerMain').on("click", "#prenotazioniAreaPersonaleUtente", function(){
//        $( "#prenotazioniAreaPersonaleUtente").addClass("Attivo");
        inviaControllerTask('prenotazioni', 'visualizza', "#contenutoAreaPersonale"); 
    });
    
    $('#headerMain').on("click", "#impostazioniAreaPersonaleUtente", function(){
        inviaControllerTask('impostazioni', 'visualizza', "#contenutoAreaPersonale");
    });
    
    $('#headerMain').on("click", "#refertiAreaPersonaleUtente", function () {
        inviaControllerTask('referti', 'visualizza', "#contenutoAreaPersonale");
    });
    
    $('#headerMain').on("click", "#iconaAggiungiPrenotazione", function(){
        inviaControllerTask('prenotazioni', 'aggiungi', "#contenutoAreaPersonale");
    });
    
    $('#headerMain').on("click", "#confermaPrenotazioneUtente", function(){
        var id = $('#confermaPrenotazioneUtente').attr('data-idprenotazione');
        alert(id);
        confermaPrenotazioneUtente('prenotazioni', 'conferma', id, "#contenutoAreaPersonale");
    });
    
    
     
    $('#headerMain').on("click", "#modificaIndirizzoUtente", function(){
        clickModificaImpostazioni('impostazioni', 'utente', 'modifica', 'informazioni', "#informazioniGeneraliUtente");
    });
     
});

function clickModificaImpostazioni(controller, task, task2, task3, ajaxdiv)
{
    $.ajax({
        type : 'GET',
        url : controller + '/' + task + '/' + task2 + '/' + task3 ,
        success: function(datiRisposta)
        {
            alert(datiRisposta);
            $(ajaxdiv).html(datiRisposta);
        }
    });
}

function confermaPrenotazioneUtente(controller, task, id, ajaxDiv)
{
    $.ajax({
        type:'GET',
        url: controller + '/' + task + '/' + id,
//        dataType:JSON,
        success:function(datiRisposta)
        {
            alert("success");
            alert(datiRisposta);
            datiRisposta = JSON.parse(datiRisposta);
            alert(datiRisposta);
            if(datiRisposta==true)
            {
                $('#divConfermaPrenotazioneUtente').empty();// svuoto il div 
                $('#divConfermaPrenotazioneUtente').text('Prenotazione: Confermata');// aggiungo il testo Confermata al div
  
            }
//            $(ajaxDiv).html(datiRisposta);
            
        },
        error: function (xhr, ajaxOptions, thrownError) 
        {
            alert(xhr);
            alert(xhr.status);
            alert(thrownError);
        }
    });
}





