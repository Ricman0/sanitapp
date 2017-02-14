function inviaController(controller, ajaxdiv)
{
//    data={url:controller};
//    history.pushState(data, controller, controller);
    $.ajax({
        type: 'GET',
        url: controller,
        success: function (datiRisposta)
        {
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
        error: function ()
        {
            alert("Sbagliato click ");
        },
        complete: function()
        {
             if(controller === 'recuperaPassword') 
             {
                validazione(controller);
             }
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
            $(ajaxdiv).html(datiRisposta);
            $('.tablesorter').tablesorter({
                theme: 'blue',
                dateFormat: "ddmmyyyy",
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
            //la funzione validazione si trova in validazioneDati.js
            validazione(task1, controller1);
            
        }
    });
}


function inviaControllerTaskPOST(controller,task, datiPOST, ajaxdiv)
{
    $.ajax({
        type: 'POST',
        url: controller + '/' + task ,
        data: datiPOST,
        success: function (datiRisposta)
        {
            if(controller==='referto' && task === 'condividi' && datiPOST.condividiConMedico!==null)
            {
                $('#messaggioDialogBox').empty();
                if(datiRisposta == "\"OK\"")
                {
                    $('#messaggioDialogBox').text('Referto condiviso con il proprio medico curante');
                }
                else if(datiRisposta == "\"NO\"")
                {
                    $('#messaggioDialogBox').text('Referto NON condiviso con il proprio medico curante');
                }
                else
                {
                    $('#messaggioDialogBox').text('Errore!!');
                }
                    
                dialogBox();
            }
            else
            {
                $(ajaxdiv).html(datiRisposta);
                $("#loadingModal").hide();
            }
        },
        error: function ()
        {
            alert("Sbagliato click ");
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
            if(controller ==='impostazioni' && task ==='aggiungi' && task2==='medico')
            {
                //dopo aver ottenuto tutti i medici curanti dell'applicazione, inserisco una select e le label per sapere codice fiscale e nome e cognome del medico 
                // memorizzo in span nascosti i valori dei nomi e cognomi relativi ai codici fiscali dei medici
                var medici = JSON.parse(datiRisposta) ;
                var htmlSelect = "<label class='elementiForm' for='medicoCurante'>Codice Fiscale Medico: </label><select id='medicoCuranteSelect' class='elementiForm'>";
                var nome = new Array();
                var cognome = new Array();
                var indiceNome;
                var nomeString = "{\"";
                var cognomeString = "{\"";
                $.each(medici, function(index, medico){
                    $.each(medico, function(indice, valore){
                        switch(indice){
                        case 'CodFiscale':
                            htmlSelect += "<option value='" + valore + "'>" + valore + "</option>";
                            indiceNome = valore;
                            break;
                        case 'Nome':
                            nome[indiceNome] = valore;
                            nomeString  +=  indiceNome + "\":\"" + valore +"\", \"";
                            break;
                        case 'Cognome':
                            cognome[indiceNome]= valore;
                            cognomeString  +=  indiceNome + "\":\"" + valore +"\", \"";
                            break;
                        default:
                            
                            break;
                        } 
                    });
                });
                nomeString = nomeString.substring(0, nomeString.length-3) + "}"; // elimino l'ultima virgola, lo spazio, l'apicetto e aggiungo }
                cognomeString = cognomeString.substring(0, cognomeString.length-3) + "}";
                
                htmlSelect = htmlSelect + "</select><br><input id='salvaMedicoCurante' value='Salva' type='button'>";
                $('#aggiungiMedicoUtente').replaceWith(htmlSelect);
                $("#medicoCuranteSelect option:first").attr('selected','selected'); // imposto selected il primo elemento
                // aggiungo label ed input per visualizzare il nome e il cognome del medico curante scelto.
                $('#salvaMedicoCurante').before("<label for='nomeMedico' class='elementiForm'>Nome Medico :</label><input type='text' name='nomeMedico' class='elementiForm' readonly /><br>");
                $('#salvaMedicoCurante').before("<label for='cognomeMedico' class='elementiForm'>Cognome Medico :</label><input type='text' name='cognomeMedico' class='elementiForm' readonly  /><br>");
                //recupero il valore dell'option selezionato
                var cfMedicoSelezionato = $("#medicoCuranteSelect option:selected").val();
                //recupero il nome e cognome relatico al codice fiscale selezionato e li imposto come valori per gli input.
                var nomeMedicoSelezionato = nome[cfMedicoSelezionato];//recupero il nome relativo al codice fiscale del medico selezionato
                var cognomeMedicoSelezionato = cognome[cfMedicoSelezionato];//recupero il cognome relativo al codice fiscale del medico selezionato
                $("input[name='nomeMedico']").val(nomeMedicoSelezionato); // imposto il nome del medico selezionato
                $("input[name='cognomeMedico']").val(cognomeMedicoSelezionato);// imposto il cognome del medico selezionato
//               // span nascosti dove inserisco i nomi e i cognomi dei medici dell'applicazione
                $('#salvaMedicoCurante').before("<span id='nomeMedicoCurante'>" + nomeString + "</span>");
                $('#salvaMedicoCurante').before("<span id='cognomeMedicoCurante'>" + cognomeString + "</span>");
                $('#nomeMedicoCurante').hide();
                $('#cognomeMedicoCurante').hide();
    
            }
            else
            {
                $(ajaxdiv).replaceWith(datiRisposta);
                $(ajaxdiv).addClass("daModificare");// aggiunge una classe al div in modo che poi è più semplice recuperare i dati 
            }
        },
        complete: function ()
        {
            validazione(task, controller, task2);
        }
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
            $(ajaxdiv).html(datiRisposta);
            $('#aggiungiPrenotazioneButton').attr('data-codiceFiscale', codiceFiscale);
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

function download(id) {

    $.ajax({
        type: "GET",
        url: "referti/download/" + id,
        success: function (dati) {
            document.location = "referti/download/" + id;
            
        }
    });
}

function inviaDatiGenerico(id, controller, ajaxdiv)
{
    if(controller==='recuperaPassword'){
        $( "#loadingModal" ).show();
    }
    //recupera tutti i valori del form automaticamente
    var dati =  $(id).serialize();
    $.ajax({
        
        //il tipo di richiesta HTTP da effettuare, di default è GET
        type: 'POST',
        //url della risorsa alla quale viene inviata la richiesta
        //url:  "index.php",
        url: controller,
        //che può essere un oggetto del tipo {chiave : valore, chiave2 : valore}, 
        //oppure una stringa del tipo "chiave=valore&chiave2=valore2"
        // contenente dei dati da inviare al server
        //data: {datiDaInviare:  dati, controller:controller1, task:task1}, 
        data:  dati,
        dataType: "html",
        //success(data, textStatus, XMLHTTPRequest) : funzione che verrà 
        //eseguita al successo della chiamata. I tre parametri sono, 
        //rispettivamente, l’oggetto della richiesta, lo stato e la 
        //descrizione testuale dell’errore rilevato
        success: function(msg)
        {
           $(ajaxdiv).html(msg);
        },
        complete: function(){
            $( "#loadingModal" ).hide();
        },
        error: function(xhr, status, error) 
        {
            alert("Chiamata fallita, si prega di riprovare...");
        }
        
      
    });
}
 
function inviaDatiRegistrazione(id, controller, task, ajaxdiv)
{
    $( "#loadingModal" ).show();
   // per ciascun input text all'interno della form, esegui il trim del testo e poi assegnalo al testo dell'elemento di cui si è eseguito il trim
    $(id + " input[type='text']").each(function () {
        $(this).val($(this).val().trim());
    });
    var dati = $(id).serialize();
    $.ajax({
        type: "POST",
        url: controller + "/" + task,
        data: dati,
        dataType: "html",
        success: function (msg)
        {
            $(ajaxdiv).html(msg);
        },
        error: function ()
        {
            alert("Chiamata fallita, si prega di riprovare...");
        },
        complete: function()
        {
            $("#loadingModal").hide();
        }
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
        //in dati memorizzo in stringa lo stato dell'evento (1° parametro pushstate)
        var dati = JSON.stringify(event.state);
        //rendo oggetto la stringa dati
        var object= JSON.parse(dati);
        // essendo un oggetto, object.url accede alla proprietà url dove ho memorizzato l'url prima di effettuare
        //pushstate, in maniera da avere indipendeza da dove è collocata la cartella
//	createView(event.state, false);
        // ricarica la pagina giusta
        try {
                $('#main').load(object.url);
            }
        catch(err) {
            $('#wrapper').load('index.php');
        }
        
};

/**
 * Controlle se il browser utilizzato è IE oppure no
 * @returns {Boolean} true se il browser è IE, false altrimenti
 */
function checkInternetExplorer(){
    var ms_ie = false;
    var ua = window.navigator.userAgent;
    var old_ie = ua.indexOf('MSIE ');
    var new_ie = ua.indexOf('Trident/');

    if ((old_ie > -1) || (new_ie > -1)) {
        ms_ie = true;
    }
    return ms_ie;
}