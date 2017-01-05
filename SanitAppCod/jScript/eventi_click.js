
/*
 * Quando il DOM è pronto, mando in run questa funzione.
 * Tale funzione si pone in attesa di un evento click sull'elemento con 
 * id = registrazione.
 * Quando avviene il click su registrazione, viene eseguita la funzione inviaControllerTask
 */
$(document).ready(function () {
    
    $("#headerMain").on("click", ".homepage", function(){
        inviaController('index.php', '#wrapper');
//        var History = window.history;
//        History.pushState(null, 'home', 'index.php');
    });

    $('#headerMain').on("click", ".mySanitApp", function () {
        
        inviaController('mySanitApp', '#main');
    });
    
    $('#headerMain').on("click", "#registrazioneClinica", function () {
        var  ajaxDiv = '#main';
        if( $("#contenutoAreaPersonale").length  ) 
        {
            ajaxDiv = '#contenutoAreaPersonale';
        }
        inviaControllerTask('registrazione', 'clinica', ajaxDiv);
    });
    $('#headerMain').on("click", "#registrazioneMedico", function () {
        var  ajaxDiv = '#main';
        if( $("#contenutoAreaPersonale").length  ) 
        {
            ajaxDiv = '#contenutoAreaPersonale';
        }
        inviaControllerTask('registrazione', 'medico', ajaxDiv);
    });
    $('#headerMain').on("click", "#registrazioneUtente", function () {
        var  ajaxDiv = '#main';
        if( $("#contenutoAreaPersonale").length  ) 
        {
            ajaxDiv = '#contenutoAreaPersonale';
        }
        alert (ajaxDiv); 
        inviaControllerTask('registrazione', 'utente', ajaxDiv);
    });

    $('#headerMain').on("click", "#recuperaPassword", function () {
        inviaController('recuperaPassword', '#main');
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

    $('#headerMain').on("click", ".scaricaReferto", function () {
        var id = $(this).attr('data-idPrenotazione');
        download(id);
    });
    
    $('#headerMain').on("click", "#recuperaPassword", function () {
        inviaController('recuperaPassword', '#main');
    });
    
    $(function() {
            $(document).tooltip({
                items: 'input.error',
                tooltipClass: 'error',
                position: {
                    my: "center bottom",
                    at: "right top"
                  }

//                content: function(){
//                    return $(this).next('label.error').text();
//                }
            });
         });

});


function inviaController(controller, ajaxdiv)
{
    data={url:controller};
    history.pushState(data, controller, controller);
    $.ajax({
        type: 'GET',
        url: controller,
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
            
            if (controller1==='users' && task1==='bloccati')
            {
                $('.rigaUser').addClass('rigaUserBloccati');// aggiungo la classe rigaUserBloccati alle righe della tabella User
                $('.rigaUserBloccati').removeClass('rigaUser'); // elimino la lcasse rigaUser.
                // in questo modo non ho lo stesso click sulle righe delle diverse tabelle
            }
            if (controller1==='users' && task1==='daValidare')
            {
                $('.rigaUser').addClass('rigaUserDaValidare');// aggiungo la classe rigaUserDaValidare alle righe della tabella User
                $('.rigaUserDaValidare').removeClass('rigaUser'); // elimino la lcasse rigaUser.
                // in questo modo non ho lo stesso click sulle righe delle diverse tabelle
            }
            
            
        },
        complete: function ()
        {
            alert('invia controller e task');
            //la funzione validazione si trova in validazioneDati.js
            validazione(task1, controller1);
            
        }
    });
}

function inviaDatiRegistrazione(id, controller1, task1, ajaxdiv)
{
    $( "#loading" ).show();
   // per ciascun input text all'interno della form, esegui il trim del testo e poi assegnalo al testo dell'elemento di cui si è eseguito il trim
    $(id + " input[type='text']").each(function () {
        $(this).val($(this).val().trim());

    });

    alert($(id + " input[type='password']").val());
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
        },
        complete: function()
        {
            $("#loading").hide();
        }
    });
}

function download(id) {

    $.ajax({
        type: "GET",
        url: "referti/download/" + id,
        success: function (dati) {alert(dati);
            document.location = "referti/download/" + id;
            
        }
    });
}

function dialogBox() {

    $("#dialog").dialog({
        resizable: false,
        height: "auto",
        width: 400,
        modal: true,
        dialogClass: "no-close",
        buttons: [
            {
                text: "OK",
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    });

}

//function createView(stateObject, pushHistory) {
////	document.getElementById('contentBox').innerHTML = '<h1>'+stateObject.title+'</h1>'+boxcontent[stateObject.contentId];
////	currentPage = stateObject.contentId;
// 
//	if (pushHistory) {
//            history.pushState(stateObject, stateObject.title, stateObject.url);
//        }
//}
//Innesca la funzione ogni volta che si clicca su back o forward
window.onpopstate = function(event) {
	// We use false as the second argument below 
	// - state will already be on the stack when going Back/Forwards
        alert('onpopstate');
        //in dati memorizzo in stringa lo stato dell'evento (1° parametro pushstate)
        var dati = JSON.stringify(event.state);
        //rendo oggetto la stringa dati
        var object= JSON.parse(dati);
        // essendo un oggetto, object.url accede alla proprietà url dove ho memorizzato l'url prima di effettuare
        //pushstate, in maniera da avere indipendeza da dove è collocata la cartella
        console.log(event.target);
        console.log(window.location);
//	createView(event.state, false);
        // ricarica la pagina giusta
        try {
                $('#main').load(object.url);
            }
        catch(err) {
            $('#wrapper').load('index.php');
        }
        
};