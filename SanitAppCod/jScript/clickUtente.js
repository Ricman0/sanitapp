/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    $('#headerMain').on("click", "#prenotazioniAreaPersonaleUtente", function () {
//        $( "#prenotazioniAreaPersonaleUtente").addClass("Attivo");
        inviaControllerTask('prenotazioni', 'visualizza', "#contenutoAreaPersonale");
    });

    $('#headerMain').on("click", "#impostazioniAreaPersonaleUtente", function () {
        inviaControllerTask('impostazioni', 'visualizza', "#contenutoAreaPersonale");
    });

    $('#headerMain').on("click", "#refertiAreaPersonaleUtente", function () {
        inviaControllerTask('referti', 'visualizza', "#contenutoAreaPersonale");
    });

    $('#headerMain').on("click", "#iconaAggiungiPrenotazioneUtente", function () {
        inviaController('ricercaEsami', "#contenutoAreaPersonale");
    });

    $('#headerMain').on("click", "#confermaPrenotazioneUtente", function () {
        var id = $('#confermaPrenotazioneUtente').attr('data-idprenotazione');
        alert(id);
        confermaPrenotazioneUtente('prenotazione', 'conferma', id, "#contenutoAreaPersonale");
    });

    $('#headerMain').on("click", "#modificaIndirizzoUtente", function () {
        clickModificaImpostazioni('impostazioni', 'modifica', 'informazioni', "#informazioniGeneraliUtente");
    });

    $('#headerMain').on("click", "#modificaMedicoUtente", function () {
        clickModificaImpostazioni('impostazioni', 'modifica', 'medico', "#medicoCurante");
    });

    $('#headerMain').on("click", "#modificaPassword", function () {
        clickModificaImpostazioni('impostazioni', 'modifica', 'credenziali', "#credenziali");
    });
    
    $('#headerMain').on("click", "#condividiRefertoButton", function () {
        var idPrenotazione = $('#condividiRefertoButton').attr('data-idPrenotazione');
        
        $('#infoReferto').append(" <input type='button' id='condividiRefertoUtenteButton'  value='Condividi con Utente' data-idPrenotazione='" + idPrenotazione + "' />");
        $('#condividiRefertoButton').remove();
    });
    
    $('#headerMain').on("change", "#refertoCondivisoConMedico", function () {
        var idPrenotazione = $('#scaricaRefertoButton2').attr('data-idPrenotazione');
        var condividiConMedico = false;
        if($(this).is(':checked'))
        {
            condividiConMedico = true;
        }
        var datiPOST = {id: idPrenotazione, condividiConMedico: condividiConMedico};
        inviaControllerTaskPOST('referto', 'condividi', datiPOST, '#contenutoAreaPersonale');
        
    });
    
    $('#headerMain').on("click", "#aggiungiMedicoUtente", function () {
        
    });
    

//    $('#headerMain').on("click", "#modificaIndirizzoUtenteFatto", function(){
//        
//    });

//     $('#headerMain').on("click", "#medicoUtenteModificato", function(){
//        inviaDatiModificaImpostazioni('impostazioni', 'modifica', 'medico', "#medicoCurante");
//    });

//    $('#headerMain').on("click", "inviaNuovaPasswordUtente", function(){
//        inviaDatiModificaImpostazioni('impostazioni', 'modifica', 'credenziali', "#credenziali");
//    });

});

/**
 * Funzione che permette di inviare i dati per modificare le impostazioni di un user dell'applicazione.
 * 
 * @public
 * @param {string} controller Il controller dell'url
 * @param {string} task Il task dell'url
 * @param {strin} task2 Il secondo task dell'url
 * @param {string} ajaxdiv L'id del div in cui inserire la risposta AJAX
 * @return {HTML+JS|JSON+JS}
 */
function inviaDatiModificaImpostazioni(controller, task, task2, ajaxdiv)
{
    var dati = $("div.daModificare > form").serialize();
    $.ajax({
        type: 'POST',
        url: controller + '/' + task + '/' + task2,
        data: dati,
        success: function (datiRisposta)
        {
            try {
                $.parseJSON(datiRisposta);
                $('#messaggioDialogBox').text('Errore!');
            } catch(error) {// non è json
                $(ajaxdiv).html(datiRisposta);
                $('#messaggioDialogBox').empty();
                switch (task2)
                {
                    case 'credenziali':
                        $('#messaggioDialogBox').text('Credenziali modificate con successo!');
                        break;

                    case 'medico':
                        $('#messaggioDialogBox').text('Medico cambiato con successo!');
                        break;

                    case 'alboNum':
                        $('#messaggioDialogBox').text('Provincia Albo e Numero Iscrizione Albo modificati con successo!');
                        break;

                    case 'informazioni':
                        $('#messaggioDialogBox').text('Informazioni personali modificate con successo!');
    //                    $('#modificaIndirizzoUtenteFatto').remove();// elimino il tasto OK
    //                    $(".daModificare").append("<input type='button' id='modificaIndirizzoUtente' value='Modifica Indirizzo' />");//inserisco il tasto della modifica
                        break;

                    default:
                        break;

                }
                dialogBox(); //in eventi_click.js
            } 
        }
    });
}

function clickModificaImpostazioni(controller, task, task2, ajaxdiv)
{
    $.ajax({
        type: 'GET',
        url: controller + '/' + task + '/' + task2,
        success: function (datiRisposta)
        {
            alert(datiRisposta);
            $(ajaxdiv).replaceWith(datiRisposta);
            $(ajaxdiv).addClass("daModificare");// aggiunge una classe al div in modo che poi è più semplice recuperare i dati 
        },
        complete: function ()
        {
            validazione(task, controller, task2);
        }
    });
}

function confermaPrenotazioneUtente(controller, task, id, ajaxDiv)
{
    $.ajax({
        type: 'GET',
        url: controller + '/' + task + '/' + id,
//        dataType:JSON,
        success: function (datiRisposta)
        {
            alert("success");
            alert(datiRisposta);
            datiRisposta = JSON.parse(datiRisposta);
            alert(datiRisposta);
            if (datiRisposta === true)
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