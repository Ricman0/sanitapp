
/*
 * Quando il DOM è pronto, mando in run questa funzione.
 * Tale funzione si pone in attesa di un evento click sull'elemento con 
 * id = registrazione.
 * Quando avviene il click su registrazione, viene eseguita la funzione inviaControllerTask
 */
$(document).ready(function () {

    $("#registrazioneUtente").click(function () {
        inviaControllerTask('registrazione', 'utente', '#main');
    });

    $("#registrazioneMedico").click(function () {
        inviaControllerTask('registrazione', 'medico', '#main');
    });

    $("#registrazioneClinica").click(function () {
        inviaControllerTask('registrazione', 'clinica', '#main');
    });
    
    $("#mySanitApp").click(function () {
        inviaController('mySanitApp', '#main');
    });
    
});


function inviaController($controller, ajaxdiv)
{
    $.ajax({
        type: 'GET',
        url:$controller,
        success: function(datiRisposta)
        {
            alert(datiRisposta);
            $(ajaxdiv).html(datiRisposta);
        },
        error:function()
        {
            alert("Sbagliato click ");
        }
//        complete:
//            function(){
//                $.getScript("./jScript/clickCercaCliniche");
//            }
    });
}


function clickRiga(controller, task, id, ajaxdiv)
{
    var codiceFiscale = $("#codiceFiscaleUtentePrenotaEsame").val();
    alert(codiceFiscale);
    $.ajax({
        // definisco il tipo della chiamata
        type: 'GET',
        // specifico la URL della risorsa 
        url: controller + '/' + task + '/' + id,

        // imposto azione per il caso di successo
        success: function (datiRisposta)
        {
            
            alert(datiRisposta);
            alert(codiceFiscale);
            $(ajaxdiv).html(datiRisposta);
            
            $('#aggiungiPrenotazioneButton').attr('data-codiceFiscale', codiceFiscale);
                       
            
        }
    });
}


/*
 * 
 * @param string controller
 * @param string task1
 * @param string ajaxdiv
 * @returns {undefined}
 */
function inviaControllerTask(controller1, task1, ajaxdiv)
{
    $('.time').datepicker("destroy");
    $('#ui-datepicker-div').remove();
    $.ajax({
        // definisco il tipo della chiamata
        type: 'GET',
        // specifico la URL della risorsa 
        url: controller1 + '/' + task1,
//        data:{
//            controller:controller1, 
//            task: task1
//            
//        },

        // imposto azione per il caso di successo
        success: function (datiRisposta)
        {
            alert(datiRisposta);
            $(ajaxdiv).html(datiRisposta);
            
            $('.tablesorter').tablesorter({
                theme: 'blue',
                widgets: ["filter"],
                widgetOptions: {
                    // filter_anyMatch replaced! Instead use the filter_external option
                    // Set to use a jQuery selector (or jQuery object) pointing to the
                    // external filter (column specific or any match)
                    filter_external: '.search',
                    // add a default type search to the first name column
                    filter_defaultFilter: {1: '~{query}'},
                    // include column filters
                    filter_columnFilters: true,
                    filter_placeholder: {search: 'Search...'},
                    filter_saveFilters: true,
                    filter_reset: '.reset'
                }

            });
            
            $('.time').timepicker({
                stepMinute: 5
            });

        },
        complete:function()
        {
            //la funzione validazione si trova in validazioneDati.js
            validazione(task1, controller1);
        }
    });
}

function inviaDatiRegistrazione(id, controller1, task1, ajaxdiv)
{

    //recupera tutti i valori del form automaticamente
    var dati = $(id).serialize();
    alert(dati);
   
    
    $.ajax({
        type: "POST",
        url: controller1 + "/" + task1,
        data: dati,
        dataType: "html",
        success: function (msg)
        {
            alert("Chiamata eseguita");
            $(ajaxdiv).html(msg);
        },
        error: function ()
        {
            alert("Chiamata fallita, si prega di riprovare...");
        }
    });
}

