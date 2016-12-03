/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {

    $('#headerMain').on("click", "#agendaAreaPersonaleClinica", function () {

//        $.ajax({
//            type: 'GET',
////            url: 'agenda/visualizza',
//            url:'agenda',
//            success: function(datiRisposta)
//            {
//                alert(datiRisposta);
                $('#contenutoAreaPersonale').append("<div id='agenda'></div>");
                $('#agenda').fullCalendar({
                header: 
                {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,agendaDay'
                },
                axisFormat: 'HH:mm',
                timeFormat: 'HH:mm{ - HH:mm}',
//                        {
//                agenda: 'H:mm{ - h:mm}'
//                },
                theme: true,
                defaultView: 'agendaDay',
                minTime: "08:00:00" ,
                maxTime:"22:00:00",
                'viewRender': agendaViewDisplay,
//                events:JSON.parse(datiRisposta)// rendo oggetto js i dati json recuperati
                });
                        
                
                
//            }
//        });

    });

    $('#headerMain').on("click", "#serviziAreaPersonaleClinica", function () {
        inviaControllerTask('servizi', 'visualizza', "#contenutoAreaPersonale");
    });

    $('#headerMain').on("click", "#prenotazioniAreaPersonaleClinica", function () {
        inviaControllerTask('prenotazioni', 'visualizza', "#contenutoAreaPersonale");
    });

    $('#headerMain').on("click", "#refertiAreaPersonaleClinica", function () {
        inviaControllerTask('referti', 'visualizza', "#contenutoAreaPersonale");
    });

    $('#headerMain').on("click", "#clientiAreaPersonaleClinica", function () {
        inviaControllerTask('clienti', 'visualizza', "#contenutoAreaPersonale");
    });

    $('#headerMain').on("click", "#iconaAggiungi", function () {
        inviaControllerTask('servizi', 'aggiungi', "#contenutoAreaPersonale");
    });

    $('#headerMain').on("click", "#iconaAggiungiPrenotazioneClinica", function () {
        inviaControllerTask('prenotazioni', 'aggiungi', "#contenutoAreaPersonale");
    });



//    $('#headerMain').on("click", "#submitRicercaUtente", function () {
//        inviaControllerTask('ricerca', 'utente', "#contenutoAreaPersonale");
//    });

    $('#headerMain').on("click", "#annullaAggiungiEsame", function () {
        inviaControllerTask('servizi', 'visualizza', "#contenutoAreaPersonale");
    });

    $('#headerMain').on("click", "#impostazioniAreaPersonaleClinica", function () {
        inviaControllerTask('impostazioni', 'visualizza', "#contenutoAreaPersonale");

    });

//    $('#headerMain').on("click", "#salvaImpostazioniClinica", function () {
//        inviaImpostazioniClinica('#workingPlan','#giornoPausa','#inizioPausa','#finePausa','impostazioni', 'clinica', 'workingPlan', "#contenutoAreaPersonale");
//    });
    $('#headerMain').on("click", "#salvaImpostazioniClinica", function () {
        inviaImpostazioniClinica('#workingPlan', 'impostazioni', 'clinica', 'workingPlan', "#contenutoAreaPersonale");
    });

//    $('#headerMain').on("click", "#aggiungiPausaButton", function () {
//        formPausa();
//    });
//    $('#headerMain').on("click", "#scartaPausa", function () {
//        
//        scartaPausa(this);//this si riferisce al pulsante scartapausa
//    });
//    
//     $('#headerMain').on("click", "#accettaPausa", function () {
//        accettaPausa(this);
//    });
//    
//    $('#headerMain').on("click", "#eliminaPausa", function () {       
//        eliminaPausa(this);
//    });

    $('#headerMain').on("click", ".rigaPrenotazione", function () {
        var id = $(this).attr('id');
        var contenitore = "#" + $(this).closest("div").prop("id"); //ritorna l'elemento contenitore sul quale inserire la risposta ajax
        clickRiga('prenotazioni', 'visualizza', id, contenitore);
    });

    $('#headerMain').on("click", ".rigaEsame", function () {
        var id = $(this).attr('id');
        var contenitore = "#" + $(this).closest("div").prop("id"); //ritorna l'elemento contenitore sul quale inserire la risposta ajax
        var controller = $("#controllerTabella").attr('value');
        alert(controller);
        if (controller === "servizi")
        {
            clickRiga(controller, 'visualizza', id, contenitore);
        }

    });



    $('#headerMain').on("click", ".rigaReferto", function () {
        var id = $(this).attr('id');
        var contenitore = "#" + $(this).closest("div").prop("id"); //ritorna l'elemento contenitore sul quale inserire la risposta ajax
//        var controller = $("#controllerTabella").attr('value');
//        alert(controller);

        clickRiga('referti', 'visualizza', id, contenitore);

    });
    $('#headerMain').on("click", "#aggiungiRefertoButton", function () {
        var id = $("#aggiungiRefertoButton").attr("data-idPrenotazione");
        aggiuntaReferto(id);
    });

//    $('#headerMain').on("click", "#uploadReferto", function(){
//        uploadReferto(); 
//    });



});

function inviaImpostazioniClinica(id, controller1, task1, task2, ajaxdiv)
{

    //recupera tutti i valori del form automaticamente
    //var dati = $(id).serialize() + '&' + $(id2).serialize() + '&' + $(id3).serialize() + '&' + $(id4).serialize();
    var dati = $('form').serialize();
    alert(dati);


    $.ajax({
        type: "POST",
        url: controller1 + "/" + task1 + "/" + task2,
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

/**
 * Metodo che permette di inserire una nuova pausa
 * 
 * @returns {undefined}
 */
//function formPausa()
//{
//    $('#aggiungiPausaButton').prop('disabled', true);
//    $('#salvaImpostazioniClinica').prop('disabled', true);
//    var idOraInizio = $.now(); //$.now() ritorna l'istante attuale
//    var idOraFine =  idOraInizio + 1;
//    
//    var tr ='<tr><td class="pausaGiorno"><form><select class="selezioneGiornoPausa" name="value">' +
//        '<option value="Lunedi" selected="selected">Lunedi</option>' +
//        '<option value="Martedi">Martedi</option>' +
//        '<option value="Mercoledi">Mercoledi</option>' +
//        '<option value="Giovedi">Giovedi</option>' +
//        '<option value="Venerdi">Venerdi</option>' +
//        '<option value="Sabato">Sabato</option>' +
//        '<option value="Domenica">Domenica</option>' +
//        '</select></form></td>' +
//        '<td class="pausaInizio"><form><input autocomplete="off" id="' + idOraInizio + '" class="time"></form></td>'+
//        '<td class="pausaFine"><form><input autocomplete="off" id="' + idOraFine + '" class="time"></form></td>'+
//        '<td><div id="azioniPausa"><a id="accettaPausa"><i class="fa fa-check fa-lg faAzzurro"  aria-hidden="true"></i></a> &nbsp'+
//        '<a id="scartaPausa"><i class="fa fa-ban fa-lg faAzzurro" aria-hidden="true"></i></a></div></td></tr>';
//        
////        $(tr).appendTo('#tabellaPause');
//        $('#tabellaPause').prepend(tr);
//        $('.time').timepicker({
//                stepMinute: 5
//            });
//        
//        
//    };


//    function scartaPausa(param){
//        $('#aggiungiPausaButton').prop('disabled', false);
//        $('#salvaImpostazioniClinica').prop('disabled', false);
//        $(param).closest('tr').remove();  
//    }
// accetta pausa è da modificare
//    function accettaPausa(param){
//        var oraInizioId= "#" + $(param).closest('tr').find('td.pausaInizio form input').attr('id');
//        var oraFineId= "#" + $(param).closest('tr').find('td.pausaFine form input').attr('id');
//
//        alert(oraInizioId +" " +oraFineId);
//        if( $(oraFineId).val().length ===0 || $(oraInizioId).val().length ===0  ) 
//        {
//            alert("Inserire gli orari");
//        }
//        else
//        {
//
//            $('#aggiungiPausaButton').prop('disabled', false);
//            $('#salvaImpostazioniClinica').prop('disabled', false);
//            $('option:not(:selected)').prop('disabled', true);
//            $(oraInizioId).attr('readonly',true).datepicker("option", "showOn", "off");
//            $(oraFineId).attr('readonly',true).datepicker("option", "showOn", "off");
//            //aggiunto successivamente
//            $(".selezioneGiornoPausa > option").each(function() {
//            alert(this.value);
//
//             if ($(this).val().length==0)
//                            {
//                                $('.selezioneGiornoPausa').val( '{"Pause":[{"OraInizio":"' 
//                                        + $(".oraInizio").val() + '","OraFine":"' + $(".oraFine").val() + '" }]}');
//                            }
//                            else
//                            {
//                                var c = $('.selezioneGiornoPausa').val();
//                                i = c.length - 2;
//                                c = c.slice(0, i);
//                                alert(c);
//                                c = c + ', {"OraInizio":"' 
//                                        + $(".oraInizio").val() + '","OraFine":"' + $(".oraFine").val() + '" }]}';
//                                alert(c);
//                                $('#LunediPausa').val(c);
//                            }
//
//        });
//            
//            switch ($(".selezioneGiornoPausa").val())
//            {
//                case 'Lunedi':
//                    if ($('#LunediPausa').val().length==0)
//                    {
//                        $('#LunediPausa').val( '{"Pause":[{"OraInizio":"' 
//                                + $(".oraInizio").val() + '","OraFine":"' + $(".oraFine").val() + '" }]}');
//                    }
//                    else
//                    {
//                        var c = $('#LunediPausa').val();
//                        i = c.length - 2;
//                        c = c.slice(0, i);
//                        alert(c);
//                        c = c + ', {"OraInizio":"' 
//                                + $(".oraInizio").val() + '","OraFine":"' + $(".oraFine").val() + '" }]}';
//                        alert(c);
//                        $('#LunediPausa').val(c);
//                    }
//                    
//                    break;
//                case 'Martedi':
//                    if ($('#MartediPausa').val().length==0)
//                    {
//                        $('#MartediPausa').val( '{"Pause":[{"OraInizio":"' 
//                                + $("#oraInizio").val() + '","OraFine":"' + $("#oraFine").val() + '" }]}');
//                    }
//                    else
//                    {
//                        var c = $('#MartediPausa').val();
//                        i = c.length - 2;
//                        c = c.slice(0, i);
//                        alert(c);
//                        c = c + ', {"OraInizio":"' 
//                                + $("#oraInizio").val() + '","oraFine":"' + $("#oraFine").val() + '" }]}';
//                        alert(c);
//                        $('#MartediPausa').val(c);
//                    }
//                    break;
//                case 'Mercoledi':
//                    if ($('#MercolediPausa').val().length==0)
//                    {
//                        $('#MercolediPausa').val( '{"Pause":[{"OraInizio":"' 
//                                + $("#oraInizio").val() + '","OraFine":"' + $("#oraFine").val() + '" }]}');
//                    }
//                    else
//                    {
//                        var c = $('#MercolediPausa').val();
//                        i = c.length - 2;
//                        c = c.slice(0, i);
//                        alert(c);
//                        c = c + ', {"OraInizio":"' 
//                                + $("#oraInizio").val() + '","OraFine":"' + $("#oraFine").val() + '" }]}';
//                        alert(c);
//                        $('#MercolediPausa').val(c);
//                    }
//                    break;
//                case 'Giovedi':
//                    if ($('#GiovediPausa').val().length==0)
//                    {
//                        $('#GiovediPausa').val( '{"Pause":[{"OraInizio":"' 
//                                + $("#oraInizio").val() + '","OraFine":"' + $("#oraFine").val() + '" }]}');
//                    }
//                    else
//                    {
//                        var c = $('#GiovediPausa').val();
//                        i = c.length - 2;
//                        c = c.slice(0, i);
//                        alert(c);
//                        c = c + ', {"OraInizio":"' 
//                                + $("#oraInizio").val() + '","OraFine":"' + $("#oraFine").val() + '" }]}';
//                        alert(c);
//                        $('#GiovediPausa').val(c);
//                    }
//                    break;
//                case 'Venerdi':
//                    if ($('#VenerdiPausa').val().length==0)
//                    {
//                        $('#VenerdiPausa').val( '{"Pause":[{"OraInizio":"' 
//                                + $("#oraInizio").val() + '","OraFine":"' + $("#oraFine").val() + '" }]}');
//                    }
//                    else
//                    {
//                        var c = $('#VenerdiPausa').val();
//                        i = c.length - 2;
//                        c = c.slice(0, i);
//                        alert(c);
//                        c = c + ', {"OraInizio":"' 
//                                + $("#oraInizio").val() + '","OraFine":"' + $("#oraFine").val() + '" }]}';
//                        alert(c);
//                        $('#VenerdiPausa').val(c);
//                    }
//                    break;
//                case 'Sabato':
//                    if ($('#SabatoPausa').val().length==0)
//                    {
//                        $('#SabatoPausa').val( '{"Pause":[{"OraInizio":"' 
//                                + $("#oraInizio").val() + '","OraFine":"' + $("#oraFine").val() + '" }]}');
//                    }
//                    else
//                    {
//                        var c = $('#SabatoPausa').val();
//                        i = c.length - 2;
//                        c = c.slice(0, i);
//                        alert(c);
//                        c = c + ', {"OraInizio":"' 
//                                + $("#oraInizio").val() + '","OraFine":"' + $("#oraFine").val() + '" }]}';
//                        alert(c);
//                        $('#SabatoPausa').val(c);
//                    }
//                    break;
//                default:
//                    if ($('#DomenicaPausa').val().length==0)
//                    {
//                        $('#DomenicaPausa').val( '{"Pause":[{"OraInizio":"' 
//                                + $("#oraInizio").val() + '","OraFine":"' + $("#oraFine").val() + '" }]}');
//                    }
//                    else
//                    {
//                        var c = $('#DomenicaPausa').val();
//                        i = c.length - 2;
//                        c = c.slice(0, i);
//                        alert(c);
//                        c = c + ', {"OraInizio":"' 
//                                + $("#oraInizio").val() + '","OraFine":"' + $("#oraFine").val() + '" }]}';
//                        alert(c);
//                        $('#DomenicaPausa').val(c);
//                    }
//                    break;       
//            }
//            // fine aggiunto successivamente
//            $("#azioniPausa").html('<a id="eliminaPausa"><i class="fa fa-close fa-lg faAzzurro"  aria-hidden="true"></i></a>');
//        
//        }   
//    }


// elimina pausa è da modificare
//    function eliminaPausa(param)
//    {
////        nomeSelect.options[nomeSelect.selectedIndex].value;
////        var giorno = giornoPausa.options[giornoPausa.selectedIndex].value;
////         var giorno = $('#nomeGiornoPausa').val();
////        var giorno = $(param).closest('#nomeGiornoPausa').;
////        alert(giorno);
//        
////        var inizioPausa =  $(param).closest('tr').closest('#oraInizio').val();
////        var finePausa =  $(param).closest('tr').closest('#oraFine').val();
//        var inizioPausa =  $('#oraInizio').val();
//
//        var finePausa =  $('#oraFine').val();
//
//        var giornoPausa = giorno + "Pausa" ;
//
//        giornoPausa = "#" + giornoPausa;
//
//        var pauseGiorno =  $(giornoPausa).val();
//
////        var obj = $.parseJSON(pauseGiorno);
//        var obj = JSON.parse(pauseGiorno);
//        var trovato = "FALSE";
//        for (i = 0; (i<obj.Pause.length && trovato==="FALSE"); i++) 
//        { 
//            if ((obj.Pause[0].OraInizio==inizioPausa )&& (obj.Pause[0].OraFine==finePausa))
//            {
//                trovato="TRUE";
//                if(obj.Pause.length==1)
//                {
//                    delete obj.Pause[i];
//                    $(giornoPausa).val("");
//                    alert( $(giornoPausa).val());
//                }
//                else
//                {
//                    delete obj.Pause[i];
//                    alert(obj.Pause.count);
//                    alert( $(giornoPausa).val());
//                }                
//            }
//        }
//        var text = JSON.stringify(obj);
//        alert(text);
//        $(giornoPausa).val(text);
//        
//        $(param).closest("tr").remove();
//    }


function inviaDatiEsame(id, controller1, task1, ajaxdiv)
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

function aggiuntaReferto(id)
{
    $.ajax({
        type: 'GET',
        url: "referti/aggiungi/" + id,
        success: function (datiHTMLRisposta)
        {
            alert(datiHTMLRisposta);
            $("#contenutoAreaPersonale").html(datiHTMLRisposta);
        },
        error: function ()
        {
            alert("Sbagliato click aggiuntaReferto ");
        }
    });

}

function uploadReferto()
{
    var dati = $("#formUploadReferto").serialize();
    alert(dati);

    $.ajax({
        type: "POST",
        url: "referto/upload",
        data: dati,
//        dataType: "html",
        success: function (datiRisposta)
        {
            //provo a fare il parse json dei dati risposta
            // ciò genera un errore se non ho json
            alert(datiRisposta);
            $('#contenutoAreaPersonale').html(datiRisposta);
//            try
//            {
//                var dati = JSON.parse(datiRiposta);
//                alert('Referto inserito con successo');
//                $.ajax({
//                    type:'GET',
//                    url: 'mySanitApp', 
//                    success: function(datiRisposta)
//                    {
//                        
////                        //aggiungo il campo nascosto codice fiscale 
////                        $('#contenutoAreaPersonale').append('<form id="formCodiceFiscaleUtentePrenotaEsame" />');
//                    }
//                });
//            }catch(errore)
//                {
//                    alert("Non è stato possibile aggiungere il referto");
//                      $.ajax({
//                          type:'GET',
////                          url: 'mySanitApp',
//                          url: 'prenotazioni/visualizza',
//                          success: function(datiRisposta)
//                          {
//                              $('#contenutoAreaPersonale').html(datiRisposta);
//                          }
//                      });
//                }
        }

    });
}


function inviaCodiceFiscale(controller1, task1, ajaxdiv)
{

    var codiceFiscale = $("form input[type='text']").val();
    alert(codiceFiscale);
    var nomeClinica = $("form input[type='submit']").attr('data-nomeClinica');
    alert(nomeClinica);
    $.ajax({
        type: "GET",
        url: controller1 + "/" + task1 + "/" + codiceFiscale,
        success: function (datiRiposta, status, xhr)
        {
            //provo a fare il parse json dei dati risposta
            // ciò genera un errore se il codice fiscale inserito non esiste tra gli utente del db
            //perchè EUtente fa visualizzare degli errori. il che implica che i dati ritornati non sono solo json
            // quindi ecco qui che si genera l'errore
            try
            {
                var dati = JSON.parse(datiRiposta);
                alert(dati.risultato);
                $.ajax({
                    type: 'GET',
                    url: 'esami/all/' + nomeClinica,
                    success: function (datiRisposta)
                    {
                        $(ajaxdiv).html(datiRisposta);
//                        //aggiungo il campo nascosto codice fiscale 
//                        $('#contenutoAreaPersonale').append('<form id="formCodiceFiscaleUtentePrenotaEsame" />');
//
                        $('<input>').attr({
                            type: 'hidden',
                            id: 'codiceFiscaleUtentePrenotaEsame',
                            name: 'codiceFiscaleUtentePrenotaEsame',
                            value: codiceFiscale
                        }).appendTo('table');
//                        
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

                    }
                });
            } catch (errore)
            {
                alert("Non è registrato alcun utente con quel codice fiscale");
                $.ajax({
                    type: 'GET',
//                          url: 'mySanitApp',
                    url: 'prenotazioni/aggiungi',
                    success: function (datiRisposta)
                    {
                        $(ajaxdiv).html(datiRisposta);
                    }
                });
            }
        },
        error: function ()
        {
            alert("Chiamata fallita, si prega di riprovare...");
        }
    });   
    
}


/**
 * Funzione per visualizzare gli eventi sull'agenda
 * 
 * @returns {undefined}
 */
function agendaViewDisplay(view, element)
{
    var agendaView = $('#agenda').fullCalendar('getView'); //memorizzo il View Object in agendaView
    // mi salvo date e orari per passarli durante la chiamata così all'interno di questo range posso trovare gli appuntamenti
    var startDataOra = agendaView.start.format('YYYY-MM-DD') + " " + agendaView.calendar.options.minTime ; // data e ora di inizio della view
    var endDataOra = agendaView.end.format('YYYY-MM-DD') + " 00:00:00" ;// ultima data e ora della view
    // forse i trim sono inutili
    startDataOra = $.trim(startDataOra);// elimino gli eventuali spazi iniziali e finali con la funzione di jquery
    endDataOra = $.trim(endDataOra);
    $.ajax({
            type: 'POST',
//            url: 'agenda/visualizza',
            url:'agenda',
            data:{start:startDataOra, end: endDataOra},
            success: function(datiRisposta)
            {
                 //rendo oggetto JS i dati JSON ricevuti
            datiRisposta = JSON.parse(datiRisposta);

            console.log(datiRisposta);
            // aggiungo appuntamenti all'agenda
            var appuntamentiAgenda = [];// array in cui inserirò tutti gli appuntamenti che voglio visualizzare in agenda

            // ciclo su datiRisposta.appuntamenti(1°paramentro); 2°parametro la funzione che sarà eseguita su ogni oggetto. 
            // La funzione di callback avrà indice e valore associato all'indice che chiamo apputnamento.
            $.each(datiRisposta.appuntamenti, function(indice, appuntamento) {
                var event = {
                    'id': appuntamento['id'],
                    'title': appuntamento['title'],
                    'start': appuntamento['start'] + " " + appuntamento['intervalStart'] ,
                    'end': appuntamento['end'] + " " + appuntamento['intervalEnd'],
                    'allDay': false,
        //            'data': appuntamento, // Store appointment data for later use.
                    'backgroundColor':'yellow',
                    'borderColor': 'white', 
                    'textColor':  'blue'
                };
                appuntamentiAgenda.push(event); // aggiungo l'evento all'array appuntamentiAgenda
                
            });
            $('#agenda').fullCalendar('removeEvents'); //rimuove tutti gli eventi dall'agenda se il 2°paramentro (ovvero id appuntamento) è omesso
            $('#agenda').fullCalendar('addEventSource', appuntamentiAgenda);// Aggiunge dinamicamente gli event source
        // .fullCalendar( 'addEventSource', source ) // source può essere Array/URL/Function. Gli eeventi sono immediatamente presi dal source e inseriti nel calendario/agenda

            console.log(agendaView.name);

            switch(agendaView.name) // recupero il nome della View
            {
                case 'basicWeek':
                case 'agendaWeek':
                    var currDateStart = agendaView.start;
                    var currDateStartString = currDateStart.format('YYYY-MM-DD'); // recupero la stringa della data da cui inizia il calendario 
                    var currDateEnd = moment(currDateStartString); // creo un moment dalla stringa
                    currDateEnd = currDateEnd.add(1,'days'); // aggiungo un giorno
                    var currDateEndString = currDateEnd.format('YYYY-MM-DD');
                    $.each(datiRisposta.workingPlan, function(index, workingDay) {

                        if (workingDay === null) {
                            // Add a full day unavailable event.
                            periodoNonDisponibile = {
                                'title': 'GIORNO NON LAVORATIVO',
                                'start': currDateStartString,
                                'end': currDateEndString,
                                'allDay': false,
                                'color': '#BEBEBE',
                                'editable': false,
                            };
                            $('#agenda').fullCalendar('renderEvent', periodoNonDisponibile, true);
                            currDateStart.add(1, 'days');
                            currDateStartString = currDateStart.format('YYYY-MM-DD');
                            currDateEnd.add(1, 'days');


                        }
                        else
                        {
                            // aggiungo un periodoNonDisponibile prima dell'orario lavorativo
                            var startClinicaString= currDateStartString + ' ' + workingDay.Start + ':00';// aggiungo l'orario di inizio 
                            var startClinica = Date.parse(startClinicaString); // da stringa ad oggetto Date e ritornano i millisecondi tra la stringa passata  e la mezzanotte del 1° Gennaio 1970.
                            var startAgendaString = currDateStartString + " " + agendaView.calendar.options.minTime;
                            var startDayAgenda = Date.parse(startAgendaString);
                            if (startDayAgenda < startClinica)  // se lo start del calendario è < dell'ora di inzio del giorno lavorativo, allora quel tempo è non disponibile quindi aggiungo un altro periodo non disponibile
                            {
        //                        agendaView.calendar.options.minTime
        //                        var minTimeClinica = workingDay.Start + ':00';
        //                        $('#agenda').fullCalendar('option', 'minTime', minTimeClinica);
                                //usando le 8 righe seguenti posso inserire un periodo invece con le 2 righe precedenti riadatto l'orario di inizio attività della clinica
                                periodoNonDisponibile = {
                                    'title': 'CLINICA CHIUSA',
                                    'start': startAgendaString,
                                    'end': startClinicaString,
                                    'allDay': false,
                                    'color': 'red'
                                };
                                $('#agenda').fullCalendar('renderEvent', periodoNonDisponibile, false); 
                            }
                            // aggiungo un periodo non disponibile al termine dell'orario di lavoro
                            var endDayAgendaString = currDateStartString + " " + agendaView.calendar.options.maxTime ; // l'ultima data visibile nella view 
                            var dataEOraEndString = currDateStartString + ' ' + workingDay.End; //concateno la data end agenda formato string con l'orario di chiusura della clinica
                            var dataEOraEnd = Date.parse(dataEOraEndString);                    
                            var endDayAgenda = Date.parse(endDayAgendaString); 
                            if (endDayAgenda > dataEOraEnd) // se il termine del calendario è > dell'orario di chiusura della clinica allora aggiungo un nuovo periodo non disponibile  
                            {
        //                        var maxTimeClinica = workingPlan[nomeGiorno].End + ':00';
        //                        $('#agenda').fullCalendar('option', 'maxTime', maxTimeClinica);

                                var periodoNonDisponibile = {
                                    'title': 'CLINICA CHIUSA',
                                    'start': dataEOraEndString,
                                    'end': endDayAgendaString,
                                    'allDay': false,
                                    'color': 'red'
                                };
                                $('#agenda').fullCalendar('renderEvent', periodoNonDisponibile, false);
                            }

                            // Aggiungo un periodoNonDisponibile per ogni pausa
                            var breakStart, breakEnd;
                            $.each(workingDay.Pausa, function(index, pausaGiornaliera) 
                            {
                                breakStart = currDateStartString + ' ' + pausaGiornaliera.Start;
                                breakEnd = currDateStartString + ' ' + pausaGiornaliera.End;
                                var pausa = {
                                    'title': 'Pausa',
                                    'start': breakStart,
                                    'end': breakEnd,
                                    'allDay': false,
                                    'color': 'pink',
                                    'editable': true
                                };
                                $('#agenda').fullCalendar('renderEvent', pausa, false);
                            });
                            currDateStart.add(1, 'days');
                            currDateStartString = currDateStart.format('YYYY-MM-DD');
                            currDateEnd.add(1, 'days');
                            }
                        });
                                    
                    break;
                    
                default: // il nome della View è agendaDay
                    
                    var nomeGiorno = agendaView.start.format('dddd'); // della view prendo il moment start e di questo prendo solo il nome del giorno in formato stringa
                    nomeGiorno = nomeGiorno.replace('ì', "i"); // se il nome del giorno contiene la ì, la sostituisco con i
                    var workingPlan = datiRisposta.workingPlan;         
                    
                    //se il giorno è non lavorativo
                    if (workingPlan[nomeGiorno] === null) // se il giorno di cui si vuole prendere visione è null (ovvero non lavorativo)
                    {
                        periodoNonDisponibile = {
                                'title': 'CLINICA CHIUSA',
                                'start': $('#agenda').fullCalendar('getView').start,
                                'end': $('#agenda').fullCalendar('getView').end,
                                'allDay': false,
                                'color': '#BEBEBE'
                            };
                            $('#agenda').fullCalendar('renderEvent', periodoNonDisponibile, true);                        
                    }
                    else
                    {
                        // aggiungo un periodoNonDisponibile prima dell'orario lavorativo
                        var startDayAgendaString = agendaView.start.format('YYYY-MM-DD'); // la data di start della view 
                        var dataEOraStartString= startDayAgendaString + ' ' + workingPlan[nomeGiorno].Start;// aggiungo l'orario di inizio 
                        var dataEOraStart = Date.parse(dataEOraStartString); // da stringa ad oggetto Date e ritornano i millisecondi tra la stringa passata  e la mezzanotte del 1° Gennaio 1970.
                        startDayAgendaString = startDayAgendaString + " " + agendaView.calendar.options.minTime;
                        var startDayAgenda = Date.parse(startDayAgendaString);
                        if (startDayAgenda < dataEOraStart)  // se lo start del calendario è < dell'ora di inzio del giorno lavorativo, allora quel tempo è non disponibile quindi aggiungo un altro periodo non disponibile
                        {
    //                        agendaView.calendar.options.minTime
    //                        var minTimeClinica = workingPlan[nomeGiorno].Start + ':00';
    //                        $('#agenda').fullCalendar('option', 'minTime', minTimeClinica);
                            //usando le 8 righe seguenti posso inserire un periodo invece con le 2 righe precedenti riadatto l'orario di inizio attività della clinica
                            periodoNonDisponibile = {
                                'title': 'CLINICA CHIUSA',
                                'start': startDayAgendaString,
                                'end': dataEOraStartString,
                                'allDay': false,
                                'color': 'red'
                            };
                            $('#agenda').fullCalendar('renderEvent', periodoNonDisponibile, false); 
                        }

                        // aggiungo un periodo non disponibile al termine dell'orario di lavoro
                        var endDayAgendaString = agendaView.start.format('YYYY-MM-DD') + " " + agendaView.calendar.options.maxTime ; // l'ultima data visibile nella view 
                        var dataEOraEndString = agendaView.start.format('YYYY-MM-DD') + ' ' + workingPlan[nomeGiorno].End; //concateno la data end agenda formato string con l'orario di chiusura della clinica
                        var dataEOraEnd = Date.parse(dataEOraEndString);                    
                        var endDayAgenda = Date.parse(endDayAgendaString); 
                        if (endDayAgenda > dataEOraEnd) // se il termine del calendario è > dell'orario di chiusura della clinica allora aggiungo un nuovo periodo non disponibile  
                        {
    //                        var maxTimeClinica = workingPlan[nomeGiorno].End + ':00';
    //                        $('#agenda').fullCalendar('option', 'maxTime', maxTimeClinica);

                            var periodoNonDisponibile = {
                                'title': 'CLINICA CHIUSA',
                                'start': dataEOraEndString,
                                'end': endDayAgendaString,
                                'allDay': false,
                                'color': 'red'
                            };
                            $('#agenda').fullCalendar('renderEvent', periodoNonDisponibile, false);
                        }
                        
                        // fino a qui ok

                        // Aggiungo un periodoNonDisponibile per ogni pausa
                        var breakStart, breakEnd;
                        $.each(workingPlan[nomeGiorno].Pausa, function(index, pausaGiornaliera) 
                        {
                            breakStart = agendaView.start.format('YYYY-MM-DD') + ' ' + pausaGiornaliera.Start;
                            breakEnd = agendaView.start.format('YYYY-MM-DD') + ' ' + pausaGiornaliera.End;
                            var pausa = {
                                'title': 'Pausa',
                                'start': breakStart,
                                'end': breakEnd,
                                'allDay': false,
                                'color': 'pink',
                                'editable': true
                            };
                            $('#agenda').fullCalendar('renderEvent', pausa, false);
                        });
                    }

                    break;
            }
        }
                        
                
                
            });
}
   