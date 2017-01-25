/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {
    
    $('#headerMain').on("click", ".rigaCliente" , function(){
        var id = $(this).attr('id');
        alert(id);
        clickRiga('clienti', 'visualizza', id, "#contenutoAreaPersonale");
    });

   
    
    //click sul tasto Agenda 
    $('#headerMain').on("click", "#agendaAreaPersonaleClinica", function () {
        $('#stampaPrenotazioni').parent().remove();
        $('#contenutoAreaPersonale').empty(); // elimino tutti gli elementi interni al div contenutoAreaPersonale
        $('#divSideNavBar').prepend("<div><input type='button' id='stampaPrenotazioni' value='Stampa Prenotazioni'  /><br><br></div>");
        $('#contenutoAreaPersonale').append("<h1>Appuntamenti</h1>");
        
        
        $('#contenutoAreaPersonale').append("<div id='agenda'></div>");// aggiungo il div agenda per inserire fullcalendar
        $('#contenutoAreaPersonale').append("<div id='contenutoEvento' title='Dettaglio evento'><div id='infoEvento'></div>");
               
    
        
        $('#agenda').fullCalendar({
            header:
                    {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,basicWeek,agendaDay'
                    },
            eventDurationEditable:false,
            allDaySlot:false,
            slotDuration:'00:15:00',
            slotLabelFormat: 'HH:mm',
            slotEventOverlap:true,
            timeFormat: 'HH:mm',
            theme: true,
            defaultView: 'agendaDay',
            minTime: "00:00:00",
            maxTime: "24:00:00",
            'viewRender': agendaViewDisplay,
            'dayClick': agendaDayClick,
            'eventClick': agendaEventClick            
        });


    });

    $('#headerMain').on("click", "#stampaPrenotazioni", function () {
        window.print();
    });

    $('#headerMain').on("click", "#serviziAreaPersonaleClinica", function () {
        $('#stampaPrenotazioni').parent().remove();
        inviaControllerTask('servizi', 'visualizza', "#contenutoAreaPersonale");
    });

    $('#headerMain').on("click", "#prenotazioniAreaPersonaleClinica", function () {
        $('#stampaPrenotazioni').parent().remove();
        inviaControllerTask('prenotazioni', 'visualizza', "#contenutoAreaPersonale");
    });

    $('#headerMain').on("click", "#refertiAreaPersonaleClinica", function () {
        $('#stampaPrenotazioni').parent().remove();
        inviaControllerTask('referti', 'visualizza', "#contenutoAreaPersonale");
    });

    $('#headerMain').on("click", "#clientiAreaPersonaleClinica", function () {
        $('#stampaPrenotazioni').parent().remove();
        inviaControllerTask('clienti', 'visualizza', "#contenutoAreaPersonale");
    });

    $('#headerMain').on("click", "#iconaAggiungiservizi", function () {
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

    $('#headerMain').on('click', '#eliminaRefertoButton', function(){
        var idPrenotazione = $('#eliminaRefertoButton').attr('data-idPrenotazione');
        var datiPOST = {id: idPrenotazione};
        inviaControllerTaskPOST('referto', 'elimina', datiPOST, '#contenutoAreaPersonale');
    });

    $('#headerMain').on("click", "#uploadReferto", function () {        
        validazioneReferto(); // in validazioneDati.js
        if ($("#formUploadReferto").valid()) {
            uploadReferto();
        }
    });

     $('#headerMain').on('click', '#eliminaEsameButton', function(){
        var idClinica = $('#eliminaEsameButton').attr('data-idClinica');
        var idEsame = $('#eliminaEsameButton').attr('data-idEsame');
        var datiPOST = {idClinica: idClinica,  idEsame : idEsame};
        inviaControllerTaskPOST('servizi', 'elimina', datiPOST, '#contenutoAreaPersonale');
        
     });

    $('#headerMain').on('click', '#modificaEsameButton', function(){
        var idClinica = $('#modificaEsameButton').attr('data-idClinica'); 
        var idEsame = $('#modificaEsameButton').attr('data-idEsame');
        // modifico il 'titolo' da INFORMAZIONI a MODIFICA USER
        $('#contenutoAreaPersonale').find('h3').replaceWith("<h3>MODIFICA ESAME</h3>");
        

        $('h3').after("<form id='modificaEsameForm'></form>");
        $('#modificaEsameForm').unwrap();
//        $('#infoEsame').remove();
        var nomeLabel = "";
        $( '#contenutoAreaPersonale > span' ).each(function( index ) {
            
            if(index%2===0)
            { 
                nomeLabel = $( this ).text().trim();
                alert(nomeLabel);
                var lunghezzaLabel = nomeLabel.length;
                nomeLabel = nomeLabel.substring(0, lunghezzaLabel-1); // elimino i ':' finali
                nomeLabel = nomeLabel.toLowerCase(); // tutto minuscolo
                var paroleNomeLabel = nomeLabel.split(" "); // separo le parole di nomeLabel
                nomeLabel = '';
                $.each(paroleNomeLabel ,function(index, value){
                    nomeLabel = nomeLabel + " " + value.substring(0,1).toUpperCase() + value.slice(1);
                    // in questo modo se label è composta da più parole ho una notazione a cammello anche nell'id, ecc..
                }) ;
                nomeLabel = nomeLabel.trim();
                nomeLabel = nomeLabel.substring(0,1).toLowerCase() + nomeLabel.slice(1);
                if(nomeLabel !== '')
                {
                    $( '#modificaEsameForm').append("<label for='" + nomeLabel.replace(" ",'').replace(" ",'')  +  "' class='elementiForm'>" + nomeLabel.toUpperCase() + ": </label>");
                }   
            }
            else
            {
                
                if(nomeLabel ==='categoria')
                {
                    $( '#modificaEsameForm').append("<select name='categoria' id='modificaCategoriaEsame' class='elementiForm' required >"
                            + "<option selected value='" + $(this).text().trim() + "'> " + $(this).text().trim() + " </option>"
                            + "</select><br>");
                    

            
                            
                }
                else if(nomeLabel === 'durata')
                {
                    var valore = $(this).text().trim().substring(0, 5); 
                    $( '#modificaEsameForm').append("<input type='text'  class='elementiForm time hasDatepicker' name='durataEsame' id='modificaDurataEsame' aria-required='true'  value='" + valore + "' required /><br>");
//                    $('.time').timepicker({
//                        stepMinute: 5
//                    });
                }
                else
                {
                    $( '#modificaEsameForm').append("<input type='text' name='" + nomeLabel.replace(" ",'').replace(" ",'')  +"' class='elementiForm' id='" +  nomeLabel.replace(' ','')   + "' value='" + $(this).text().trim() +"' /><br>");
                }
                
                
                
                
            }
        });
        $('#contenutoAreaPersonale > span' ).remove();
        
        $("#contenutoAreaPersonale input[type='button']").remove();
        
        $( '#modificaEsameForm' ).append("<input type='submit' value='Conferma Modifica' id='submitModificaEsame' data-idEsame='" + idEsame + "' data-idClinica='" + idClinica + "' >");
        
        $('#contenutoAreaPersonale > br' ).remove();
        validazioneModificaEsame();
    });
    
    $('#headerMain').on('focus',"#modificaDurataEsame", function(){
        $('#modificaDurataEsame').timepicker({
            stepMinute: 5
        });
    });
    
    $('#headerMain').on('focus',"#modificaCategoriaEsame", function(){
        $('#modificaCategoriaEsame option:not(:selected)').remove();
        $.ajax({
            type: 'GET',
            url: 'categorie',
            success: function (datiRisposta)
            {
                console.log(datiRisposta);
                var categorie = JSON.parse(datiRisposta);
                console.log(categorie);
                $.each(categorie, function(index, categoria) {
                    $.each(categoria, function(indice, valore){
                        var opzioneSelezionata = $('#modificaCategoriaEsame option:selected').text();
                        
                        if (opzioneSelezionata.trim() !== valore.trim())
                        {
                            $('#modificaCategoriaEsame').append("<option value=" + valore +">" + valore + "</option>");
                        }
                    });
                });
                

            },
            error: function ()
            {
                alert("Sbagliato click ");
            }
        });
    });
    
    
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
        },
        complete: function () {
            alert('in click riga');
//            validazioneReferto();
        }
    });

}

function uploadReferto()
{
    $( "#loadingModal" ).show();
//formData ci permette di costruire un set di coppie chiave/valore che rappresentano i campi della form con i relativi valori
    var dati = new FormData($("#formUploadReferto")[0]); //al posto di serialize il quale non può accedere ad input type="file"
    $.ajax({
        type: 'POST',
        url: 'referto/upload',
//        data: dati,
//        dataType: "html",
//        xhr: function() {  // Custom XMLHttpRequest
//            var myXhr = $.ajaxSettings.xhr();
//            if(myXhr.upload){ // Check if upload property exists
//            }
//            return myXhr;
//        },
        //Ajax events
//        beforeSend: beforeSendHandler,
//        success: completeHandler,
//        error: errorHandler,
        // Form data
        data: dati,
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false,
        success: function (datiRisposta)
        {
            $('#contenutoAreaPersonale').html(datiRisposta);
        },
        complete: function()
        {
            $("#loadingModal").hide();
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
 * Metodo che consente di trasferire automaticamente 
 * 
 * Quando la clinica fa clic su un quadrato di un giorno sul calendario, allora verrà
 *  automaticamente trasferito alla vista giornaliera di quel giorno.
 * @param Moment date La data cliccata
 * @param {type} allDay 
 * @param {type} jsEvent L'evento JavaScript
 * @param {type} view   
 * @return {undefined} 
 */
function agendaDayClick(date, allDay, jsEvent, view) 
{
        if (allDay) 
        {
            $('#agenda').fullCalendar('gotoDate', date);// va alla data cliccata
            $('#agenda').fullCalendar('changeView', 'agendaDay');// cambia la view in agendaDay
        }
}

/**
 * Funzione per visualizzare gli eventi(appuntamenti, pause e giornate non lavorative) sull'agenda
 * 
 * @returns {undefined}
 */
function agendaViewDisplay(view, element)
{
    var agendaView = $('#agenda').fullCalendar('getView'); //memorizzo il View Object in agendaView
    // mi salvo date e orari per passarli durante la chiamata così all'interno di questo range posso trovare gli appuntamenti
    var startDataOra = agendaView.start.format('YYYY-MM-DD') + " " + agendaView.calendar.options.minTime; // data e ora di inizio della view
    var endDataOra = agendaView.end.format('YYYY-MM-DD') + " 00:00:00";// ultima data e ora della view
    // forse i trim sono inutili
    startDataOra = $.trim(startDataOra);// elimino gli eventuali spazi iniziali e finali con la funzione di jquery
    endDataOra = $.trim(endDataOra);
    $.ajax({
        type: 'POST',
//            url: 'agenda/visualizza',
        url: 'agenda',
        data: {start: startDataOra, end: endDataOra},
        success: function (datiRisposta)
        {
            //rendo oggetto JS i dati JSON ricevuti
            datiRisposta = JSON.parse(datiRisposta);
            // aggiungo appuntamenti all'agenda
            var appuntamentiAgenda = [];// array in cui inserirò tutti gli appuntamenti che voglio visualizzare in agenda
            console.log(datiRisposta);
            // ciclo su datiRisposta.appuntamenti(1°paramentro); 2°parametro la funzione che sarà eseguita su ogni oggetto. 
            // La funzione di callback avrà indice e valore associato all'indice che chiamo apputnamento.
            $.each(datiRisposta.appuntamenti, function (indice, appuntamento) {
                var event = {
                    'id': appuntamento['id'],
                    'title': appuntamento['title'],
                    'start': appuntamento['start'] + " " + appuntamento['intervalStart'],
                    'end': appuntamento['end'] + " " + appuntamento['intervalEnd'],
                    'cliente':appuntamento['cliente'],
                    'esame':appuntamento['esame'],
                    'eseguito': appuntamento['eseguito'],
                    'allDay': false,
                    'backgroundColor': 'yellow',
                    'borderColor': 'white',
                    'textColor': 'blue'
                };
                appuntamentiAgenda.push(event); // aggiungo l'evento all'array appuntamentiAgenda

            });
            $('#agenda').fullCalendar('removeEvents'); //rimuove tutti gli eventi dall'agenda se il 2°paramentro (ovvero id appuntamento) è omesso
            $('#agenda').fullCalendar('addEventSource', appuntamentiAgenda);// Aggiunge dinamicamente gli event source
            // .fullCalendar( 'addEventSource', source ) // source può essere Array/URL/Function. Gli eeventi sono immediatamente presi dal source e inseriti nel calendario/agenda


            switch (agendaView.name) // recupero il nome della View
            {
                case 'basicWeek':
                case 'agendaWeek':
                    var currDateStart = agendaView.start;
                    var currDateStartString = currDateStart.format('YYYY-MM-DD'); // recupero la stringa della data da cui inizia il calendario 
                    var currDateEnd = moment(currDateStartString); // creo un moment dalla stringa
                    currDateEnd = currDateEnd.add(1, 'days'); // aggiungo un giorno
                    var currDateEndString = currDateEnd.format('YYYY-MM-DD');
                    $.each(datiRisposta.workingPlan, function (index, workingDay) {

                        if (workingDay === null) {
                            // Add a full day unavailable event.
                            periodoNonDisponibile = {
                                'title': 'GIORNO NON LAVORATIVO',
                                'start': currDateStartString,
                                'end': currDateEndString,
                                'allDay': true,
                                'color': 'light-grey',
//                                'color': '#BEBEBE',
                                'editable': false
                            };
                            $('#agenda').fullCalendar('renderEvent', periodoNonDisponibile, true);
                        } 
                        else
                            {
                                // Aggiungo un periodoNonDisponibile per ogni pausa
                                var breakStart, breakEnd;
                                if(typeof(workingDay.BreakStart)!=='undefined' && typeof(workingDay.BreakEnd)!=='undefined' )
                                {
                                    breakStart = currDateStartString + ' ' + workingDay.BreakStart;
                                    breakEnd = currDateStartString + ' ' + workingDay.BreakEnd;
                                    var pausa = {
                                        'title': 'Pausa',
                                        'start': breakStart,
                                        'end': breakEnd,
                                        'allDay': false,
                                        'color': 'pink',
                                        'editable': true
                                    };
                                    $('#agenda').fullCalendar('renderEvent', pausa, false);
                                }
                            

                            }
                            currDateStart.add(1, 'days');
                            currDateStartString = currDateStart.format('YYYY-MM-DD');
                            currDateEnd.add(1, 'days');
                            });
                            
                            
                        
//                            // aggiungo un periodoNonDisponibile prima dell'orario lavorativo
//                            var startClinicaString = currDateStartString + ' ' + workingDay.Start + ':00';// aggiungo l'orario di inizio 
//                            var startClinica = Date.parse(startClinicaString); // da stringa ad oggetto Date e ritornano i millisecondi tra la stringa passata  e la mezzanotte del 1° Gennaio 1970.
//                            var startAgendaString = currDateStartString + " " + agendaView.calendar.options.minTime;
//                            var startDayAgenda = Date.parse(startAgendaString);
//                            if (startDayAgenda < startClinica)  // se lo start del calendario è < dell'ora di inzio del giorno lavorativo, allora quel tempo è non disponibile quindi aggiungo un altro periodo non disponibile
//                            {
////                                agendaView.calendar.options.minTime;
////                                var minTimeClinica = workingDay.Start + ':00';
////                                $('#agenda').fullCalendar('option', 'minTime', minTimeClinica);
//                                //usando le 8 righe seguenti posso inserire un periodo invece con le 2 righe precedenti riadatto l'orario di inizio attività della clinica
//                                periodoNonDisponibile = {
//                                    'title': 'CLINICA CHIUSA',
//                                    'start': startAgendaString,
//                                    'end': startClinicaString,
//                                    'allDay': false,
//                                    'color': 'red'
//                                };
//                                $('#agenda').fullCalendar('renderEvent', periodoNonDisponibile, false);
//                            }
//                            // aggiungo un periodo non disponibile al termine dell'orario di lavoro
//                            var endDayAgendaString = currDateStartString + " " + agendaView.calendar.options.maxTime; // l'ultima data visibile nella view 
//                            var dataEOraEndString = currDateStartString + ' ' + workingDay.End; //concateno la data end agenda formato string con l'orario di chiusura della clinica
//                            var dataEOraEnd = Date.parse(dataEOraEndString);
//                            var endDayAgenda = Date.parse(endDayAgendaString);
//                            if (endDayAgenda > dataEOraEnd) // se il termine del calendario è > dell'orario di chiusura della clinica allora aggiungo un nuovo periodo non disponibile  
//                            {
////                                var maxTimeClinica = workingPlan[nomeGiorno].End + ':00';
////                                $('#agenda').fullCalendar('option', 'maxTime', maxTimeClinica);
//
//                                var periodoNonDisponibile = {
//                                    'title': 'CLINICA CHIUSA',
//                                    'start': dataEOraEndString,
//                                    'end': endDayAgendaString,
//                                    'allDay': false,
//                                    'color': 'red'
//                                };
//                                $('#agenda').fullCalendar('renderEvent', periodoNonDisponibile, false);
//                            }

/* da decommetare se volessimo fare più pause in una giornata
                            // Aggiungo un periodoNonDisponibile per ogni pausa
                            var breakStart, breakEnd;
                            $.each(workingDay.Pausa, function (index, pausaGiornaliera)
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
                            
                        }
                        currDateStart.add(1, 'days');
                        currDateStartString = currDateStart.format('YYYY-MM-DD');
                        currDateEnd.add(1, 'days');
                    });
                    */
                    

                    break;
                
                case 'month':// visualizzazione mensile
                    var currDateStart = agendaView.start;
                    var currDateStartString = currDateStart.format('YYYY-MM-DD'); // recupero la stringa della data da cui inizia il calendario 
                    var currDateEnd = agendaView.end;
                    var currDateEndString = currDateEnd.format('YYYY-MM-DD');
                    var currDateTempEnd = moment(currDateStartString); // creo un moment dalla stringa //data di fine temporaneo
                    currDateTempEnd = currDateTempEnd.add(1, 'days'); // aggiungo un giorno
                    var currDateTempEndString = currDateTempEnd.format('YYYY-MM-DD');
                    var currDateStartMonth = Date.parse(currDateStartString); // rendo in millisecondi la data di inzio della view mensile
                    var currDateEndMonth = Date.parse(currDateEndString);
                    
                    while ( currDateStartMonth < currDateEndMonth) // non metto <= perchè all'interno c'è il foreach di 7 giorni quindi arriva fino all'ultimo giorno
                    {
                        $.each(datiRisposta.workingPlan, function (index, workingDay) {
                            
                            if (workingDay === null) {
                                // Aggiungo un giorno non lavorativo dato che workingDay è null
                                giornoNonLavorativo = {
                                    'title': 'GIORNO NON LAVORATIVO',
                                    'start': currDateStartString,
                                    'end': currDateStartString,
                                    'allDay': true,
                                    'color': '#BEBEBE',
                                    'editable': false
                                };
                                $('#agenda').fullCalendar('renderEvent', giornoNonLavorativo, true);
                            } 
                            else
                            {
                                // aggiungo una pausa  se presente
                                var breakStart, breakEnd;
                                if(typeof(workingDay.BreakStart)!=='undefined' && typeof(workingDay.BreakEnd)!=='undefined' )
                                {
                                    breakStart = currDateStartString + ' ' + workingDay.BreakStart;
                                    breakEnd = currDateStartString + ' ' + workingDay.BreakEnd;
                                    var pausa = {
                                        'title': 'Pausa',
                                        'start': breakStart,
                                        'end': breakEnd,
                                        'allDay': false,
                                        'color': 'pink',
                                        'editable': true
                                    };
                                    $('#agenda').fullCalendar('renderEvent', pausa, false);
                                }
                               
                                
//                                //Aggiungo una pausa per ogni pausaGiornaliera
//                                var breakStart, breakEnd;
//                                $.each(workingDay.Pausa, function (index, pausaGiornaliera)
//                                {
//                                    breakStart = currDateStartString + ' ' + pausaGiornaliera.Start;
//                                    breakEnd = currDateStartString + ' ' + pausaGiornaliera.End;
//                                    var pausa = {
//                                        'title': 'Pausa',
//                                        'start': breakStart,
//                                        'end': breakEnd,
//                                        'allDay': false,
//                                        'color': 'pink',
//                                        'editable': true
//                                    };
//                                    $('#agenda').fullCalendar('renderEvent', pausa, false);
//                                }); 
                            
                            }
                            currDateStart.add(1, 'days'); // aggiungo un giorno alla giornata di inizio
                            currDateStartString = currDateStart.format('YYYY-MM-DD');
                            currDateTempEnd.add(1, 'days');//aggiungo un giorno alla giornata di fine termporanea
                            currDateTempEndString = currDateTempEnd.format('YYYY-MM-DD');
                            
                        });         
                            currDateStart.add(-1, 'days'); // aggiungo un giorno alla giornata di inizio
                            currDateStartString = currDateStart.format('YYYY-MM-DD');
                            currDateStartMonth = Date.parse(currDateStartString);
                            
                    }
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
                        var dataEOraStartString = startDayAgendaString + ' ' + workingPlan[nomeGiorno].Start;// aggiungo l'orario di inizio 
                        var dataEOraStart = Date.parse(dataEOraStartString); // da stringa ad oggetto Date e ritornano i millisecondi tra la stringa passata  e la mezzanotte del 1° Gennaio 1970.
                        startDayAgendaString = startDayAgendaString + " " + agendaView.calendar.options.minTime;
                        var startDayAgenda = Date.parse(startDayAgendaString);
                        if (startDayAgenda < dataEOraStart)  // se lo start del calendario è < dell'ora di inzio del giorno lavorativo, allora quel tempo è non disponibile quindi aggiungo un altro periodo non disponibile
                        {
                            //                        agendaView.calendar.options.minTime
                            var minTimeClinica = workingPlan[nomeGiorno].Start + ':00';
                            $('#agenda').fullCalendar('option', 'minTime', minTimeClinica);
                            //usando le 8 righe seguenti posso inserire un periodo invece con le 2 righe precedenti riadatto l'orario di inizio attività della clinica
//                            periodoNonDisponibile = {
//                                'title': 'CLINICA CHIUSA',
//                                'start': startDayAgendaString,
//                                'end': dataEOraStartString,
//                                'allDay': false,
//                                'color': 'red'
//                            };
//                            $('#agenda').fullCalendar('renderEvent', periodoNonDisponibile, false);
                        }

                        // aggiungo un periodo non disponibile al termine dell'orario di lavoro
                        var endDayAgendaString = agendaView.start.format('YYYY-MM-DD') + " " + agendaView.calendar.options.maxTime; // l'ultima data visibile nella view 
                        var dataEOraEndString = agendaView.start.format('YYYY-MM-DD') + ' ' + workingPlan[nomeGiorno].End; //concateno la data end agenda formato string con l'orario di chiusura della clinica
                        var dataEOraEnd = Date.parse(dataEOraEndString);
                        var endDayAgenda = Date.parse(endDayAgendaString);
                        if (endDayAgenda > dataEOraEnd) // se il termine del calendario è > dell'orario di chiusura della clinica allora aggiungo un nuovo periodo non disponibile  
                        {
                            var maxTimeClinica = workingPlan[nomeGiorno].End + ':00';
                            $('#agenda').fullCalendar('option', 'maxTime', maxTimeClinica);

//                            var periodoNonDisponibile = {
//                                'title': 'CLINICA CHIUSA',
//                                'start': dataEOraEndString,
//                                'end': endDayAgendaString,
//                                'allDay': false,
//                                'color': 'red'
//                            };
//                            $('#agenda').fullCalendar('renderEvent', periodoNonDisponibile, false);
                        }
                        
                        // aggiungo una pausa se presente
                        var breakStart, breakEnd;
                        if(typeof(workingPlan[nomeGiorno].BreakStart)!== "undefined" && typeof(workingPlan[nomeGiorno].BreakEnd)!== "undefined" )
                        {
                            breakStart = agendaView.start.format('YYYY-MM-DD') + ' ' + workingPlan[nomeGiorno].BreakStart;
                            breakEnd = agendaView.start.format('YYYY-MM-DD') + ' ' + workingPlan[nomeGiorno].BreakEnd;
                            var pausa = {
                                'title': 'Pausa',
                                'start': breakStart,
                                'end': breakEnd,
                                'allDay': false,
                                'color': 'pink',
                                'editable': true
                            };
                            $('#agenda').fullCalendar('renderEvent', pausa, false);
                        }
//                        // Aggiungo un periodoNonDisponibile per ogni pausa
//                        var breakStart, breakEnd;
//                        $.each(workingPlan[nomeGiorno].Pausa, function (index, pausaGiornaliera)
//                        {
//                            breakStart = agendaView.start.format('YYYY-MM-DD') + ' ' + pausaGiornaliera.Start;
//                            breakEnd = agendaView.start.format('YYYY-MM-DD') + ' ' + pausaGiornaliera.End;
//                            var pausa = {
//                                'title': 'Pausa',
//                                'start': breakStart,
//                                'end': breakEnd,
//                                'allDay': false,
//                                'color': 'pink',
//                                'editable': true
//                            };
//                            $('#agenda').fullCalendar('renderEvent', pausa, false);
//                        });
                    }

                    break;
            }
        }



    });
}

/**
 * 
 * @param Event event Oggetto evento che contiene le informazioni dell'evento (data, titolo, ecc)
 * @param {type} jsEvent jsEvent tiene l'evento nativo JavaScript con informazioni di basso livello come ad esempio coordinate click.
 * @param View view contiente la corrente View Object
 * @return {undefined}
 */
function agendaEventClick(event, jsEvent, view)
{
    var title;
   // The Dialog widget fa parte di jQuery UI; 
   // permette di visualizzare il contenuto all'interno di una finestra floating cha hanno un title bar,
   //  un content area, button bar, drag handle eclose button; e può essere mosso, chiuso e ridimensionato
   switch(event.title) 
   {
        case 'CLINICA CHIUSA':
            var descrizione = "<p>La clinica resterà chiusa tutta la giornata</p>";
            $("#infoEvento").append(descrizione);
            title = event.title;
            break;
        case 'Pausa':
            var descrizionePausa = "<p>Inizio Pausa: " + event.start.format('HH:mm')  + "</p><p>Fine Pausa: " + event.end.format('HH:mm') + "</p>";
            $("#infoEvento").append(descrizionePausa);
            title = event.title;
            break;
        default:
            var descrizioneAppuntamento = "<p>Cliente: " + event.cliente  + "</p>";
            descrizioneAppuntamento = descrizioneAppuntamento + "<p>Esame: " + event.esame  + "</p>";
            descrizioneAppuntamento = descrizioneAppuntamento + "<p>ID Prenotazione: " + event.id + "</p>";
            descrizioneAppuntamento = descrizioneAppuntamento + "<p>Start: " + event.start.format('HH:mm')  + "</p><p>End: " + event.end.format('HH:mm') + "</p>" ;
            if(event.eseguito===false)
            {
               descrizioneAppuntamento = descrizioneAppuntamento + "<p>Eseguito: <i class='fa fa-times fa-lg rosso modificaEseguito' aria-hidden='true'></i></p>";
            }
            else
            {
                descrizioneAppuntamento = descrizioneAppuntamento + "<p>Eseguito: <i class='fa fa-check fa-lg verde modificaNonEseguito' aria-hidden='true'></i></p>" ;   
            }
            $("#infoEvento").append(descrizioneAppuntamento);
            title = 'Appuntamento';
            break;
    } 
 
    //per creare una finestra di pop up richiamo il metodo .dialog() su un div
    $("#contenutoEvento").dialog({ 
        modal: true, //impostato a true impesdisce l'interazione con il resto della pagina  mentre è attiva la dialog box 
        title: title ,
        buttons: {   
            'ok': function() {
              $(this).dialog('close');
              $("#infoEvento").html('');
            }
        }
    });
    
    $('.modificaNonEseguito').on('click', function () {
        // apro un'altra finestra
        $('#contenutoAreaPersonale').append("<div id='altroContenutoEventoNonEseguito' title='Dettaglio evento'><div id='nonEseguito'></div>");
        $('#nonEseguito').append('<p>Per modificare la prenotazione in prenotazione non eseguita, clicca su Non Eseguita</p>');
        $("#altroContenutoEventoNonEseguito").dialog({ 
            modal: true, //impostato a true impesdisce l'interazione con il resto della pagina  mentre è attiva la dialog box 
            title: 'Modifica Prenotazione' ,
            buttons: {   
                'Non Eseguita': function() {
                  
                  $.ajax({
                      type:'POST',
                      url: 'prenotazione/modifica/' + event.id,
                      data:{eseguita: false},
                      success: function (datiRisposta)
                      {
                        var obj = JSON.parse(datiRisposta);
                        if(obj==="no")
                        {
                            alert('Prenotazione non eseguita');
                            $('i.modificaNonEseguito').replaceWith("<i class='fa fa-times fa-lg rosso modificaEseguito' aria-hidden='true'></i>");
                        }
                        else
                        {
                           alert('Prenotazione non eseguita errore'); 
                        }
                        $("#altroContenutoEventoNonEseguito").dialog('close');
                        $("#eseguito").html('');
                      }
                  });
                  
                },
                'Annulla': function() {
                    $("#altroContenutoEventoNonEseguito").dialog('close');
                }
            }
        });
        
    });
    
    $('.modificaEseguito').on('click', function () {
        // apro un'altra finestra
        $('#contenutoAreaPersonale').append("<div id='altroContenutoEvento' title='Dettaglio evento'><div id='eseguito'></div>");
        $('#eseguito').append('<p>Per modificare la prenotazione in prenotazione eseguita, clicca su Eseguita</p>');
        $("#altroContenutoEvento").dialog({ 
            modal: true, //impostato a true impesdisce l'interazione con il resto della pagina  mentre è attiva la dialog box 
            title: 'Modifica Prenotazione' ,
            buttons: {   
                'Eseguita': function() {
                  
                  $.ajax({
                      type:'POST',
                      url: 'prenotazione/modifica/' + event.id,
                      data:{eseguita: true},
                      success: function (datiRisposta)
                      {
                        var obj = JSON.parse(datiRisposta);
                        if(obj==="ok")
                        {
                            alert('Prenotazione eseguita');
                            $('i.modificaEseguito').replaceWith("<i class='fa fa-check fa-lg verde modificaNonEseguito' aria-hidden='true'></i>");
                        }
                        else
                        {
                           alert('Prenotazione eseguita errore'); 
                        }
                        $("#altroContenutoEvento").dialog('close');
                        $("#eseguito").html('');
                      }
                  });
                  
                },
                'Annulla': function() {
                    $("#altroContenutoEvento").dialog('close');
                }
            }
        });
        
    });

}
   