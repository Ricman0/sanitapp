
/*
 * Quando il DOM è pronto, mando in run questa funzione.
 * Tale funzione si pone in attesa di un evento click sull'elemento con 
 * id = registrazione.
 * Quando avviene il click su registrazione, viene eseguita la funzione inviaControllerTask
 */
$(document).ready(function () {

$('#headerMain').on("click", "#mySanitApp", function () {
inviaController('mySanitApp', '#main');
        });
        $('#headerMain').on("click", "#registrazioneClinica", function () {
inviaControllerTask('registrazione', 'clinica', '#main');
        });
        $('#headerMain').on("click", "#registrazioneMedico", function () {
inviaControllerTask('registrazione', 'medico', '#main');
        });
        $('#headerMain').on("click", "#registrazioneUtente", function () {
inviaControllerTask('registrazione', 'utente', '#main');
        });
        $('#headerMain').on("click", ".rigaClinica", function () {
var id = $(this).attr('id'); // id della riga che coincide con l'id dell'esame
//        var nomeClinica = $('.rigaNomeClinica').html();
//        alert(nomeClinica);
        var contenitore = "#" + $(this).closest("div").prop("id"); //ritorna l'elemento contenitore sul quale inserire la risposta ajax
//        var controller = $("#controllerTabella").attr("value");
//        if(controller == "esami")
//        {
        clickRiga('cliniche', 'visualizza', id, contenitore);
//        }
        });
// 
//    $('#headerMain').on("click", ".necessarioLogin", function () {
//        modalBoxLogin();
//    });
});
        function inviaController($controller, ajaxdiv)
        {
        $.ajax({
        type: 'GET',
                url: $controller,
                success: function (datiRisposta)
                {
                alert(datiRisposta);
                        $(ajaxdiv).html(datiRisposta);
                },
                error: function ()
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
                complete: function ()
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

$(function () {
$("#dialog-form").dialog({
autoOpen: false,
        modal: true,
        resizable:false,
        height:"auto"
//        buttons: [
//        {
//        text: "Accedi",
//                click: function(){validazione("autenticazione");} ,
//                type: "submit",
//                class: "loginButton"
//        },
//        {
//        text: "Close",
//                click: function() {
//                $(this).dialog("close");
//                }
//        }
//        ]

        });
                $(".necessarioLogin").on("click", function () {
        $("#dialog-form").dialog("open");
        
        });
        $("#submitLogIn2").on("click", function (e) {
//            e.preventDefault();
            alert("ciao");
                   

        validazione("autenticazione", "#loginForm2"); 
        $("#dialog-form").dialog("close");
    });
        });
//function modalBoxLogin(){
//    
//     dialog = $( "#dialog-form" ).dialog({
//      height: 300,
//      width: 280,
//      modal: true,
// buttons: [
//    {
//      text: "Ok",
////      icons: {
////        primary: "ui-icon-heart"
////      },
//      click: function() {
//          validazione("autenticazione");
////        $( this ).dialog( "close" );
//      },
//      Cancel: function() {
////          this.dialog( "close" );
//        }
//
//      // Uncommenting the following line would hide the text,
//      // resulting in the label being used as a tooltip
//      //showText: false
//    }
//    
//  ]
//      
////      ,
////      close: function() {
//////        form[ 0 ].reset();
//////        allFields.removeClass( "ui-state-error" );
////      }
//
//        });
//        }

