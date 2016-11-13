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
    
    $('#headerMain').on("click", "#iconaAggiungiPrenotazioneUtente", function(){
        inviaController('ricercaEsami', "#contenutoAreaPersonale");
    });
    
    $('#headerMain').on("click", "#confermaPrenotazioneUtente", function(){
        var id = $('#confermaPrenotazioneUtente').attr('data-idprenotazione');
        alert(id);
        confermaPrenotazioneUtente('prenotazioni', 'conferma', id, "#contenutoAreaPersonale");
    });
    
    
     
    $('#headerMain').on("click", "#modificaIndirizzoUtente", function(){
        clickModificaImpostazioni('impostazioni', 'modifica', 'informazioni', "#informazioniGeneraliUtente");
    });
    
    $('#headerMain').on("click", "#modificaMedicoUtente", function(){
        clickModificaImpostazioni('impostazioni', 'modifica', 'medico', "#medicoCurante");
    });
    
    $('#headerMain').on("click", "#modificaPasswordUtente", function(){
        clickModificaImpostazioni('impostazioni', 'modifica', 'credenziali', "#credenziali");
    });
    
//    $('#headerMain').on("click", "#modificaIndirizzoUtenteFatto", function(){
//        
//    });
    
     $('#headerMain').on("click", "#medicoUtenteModificato", function(){
        inviaDatiModificaImpostazioni('impostazioni', 'modifica', 'medico', "#medicoCurante");
    });
    
//    $('#headerMain').on("click", "inviaNuovaPasswordUtente", function(){
//        inviaDatiModificaImpostazioni('impostazioni', 'modifica', 'credenziali', "#credenziali");
//    });
     
});

function inviaDatiModificaImpostazioni(controller, task, task2, ajaxdiv)
{
//    var dati="";
//    switch(task2)
//    {
//        case 'informazioni':
//            dati = $(".daModificare > input[type='text']").serialize();
//            alert(dati);
//            break;
//            
//        case 'medico':
//            break;  
//        
//        case 'credenziali':
//            break;
//            
//    }
    var dati = $(".daModificare > input[type='text']").serialize();  
    $.ajax({
        type:'POST',
        url: controller + '/' + task  + '/' + task2,
        data: dati,
        success: function(datiRisposta)
        {
            alert(datiRisposta);
            datiRisposta = JSON.parse(datiRisposta);
            if(datiRisposta==true)
            {
                if(task2='informazioni')
                {
                    $('#modificaIndirizzoUtenteFatto').remove();// elimino il tasto OK
//                    $(".daModificare").append("<input type='button' id='modificaIndirizzoUtente' value='Modifica Indirizzo' />");//inserisco il tasto della modifica
                }
                if(task2='credenziali')
                {
                    $('#inviaNuovaPasswordUtente').remove();// elimino il tasto OK

                }
                
                $(".daModificare > input[type='text']").attr("readonly", true); //aggiungo il readonly 
                $("div").removeClass("daModificare");// elimino la classe daModificare al div
            }
        }
    });
}

function clickModificaImpostazioni(controller, task, task2, ajaxdiv)
{
    $.ajax({
        type : 'GET',
        url : controller + '/' + task + '/' + task2  ,
        success: function(datiRisposta)
        {
            alert(datiRisposta);
            $(ajaxdiv).html(datiRisposta);
            $(ajaxdiv + ">div").addClass( "daModificare" );// aggiunge una classe al div in modo che poi è più semplice recuperare i dati 
        },
        complete:function()
        {
            validazione(task, controller, task2);
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





