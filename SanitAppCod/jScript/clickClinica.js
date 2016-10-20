/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {

    $('#main').on("click", "#serviziAreaPersonaleClinica", function () {
        inviaControllerTask('servizi', 'visualizza', "#contenutoAreaPersonale");
    });
    
    $('#main').on("click", "#prenotazioniAreaPersonaleClinica", function () {
        inviaControllerTask('prenotazioni', 'visualizza', "#contenutoAreaPersonale");
    });
    
    $('#main').on("click", "#refertiAreaPersonaleClinica", function () {
        inviaControllerTask('referti', 'visualizza', "#contenutoAreaPersonale");
    });

    $('#main').on("click", "#iconaAggiungi", function () {
        inviaControllerTask('servizi', 'aggiungi', "#contenutoAreaPersonale");
    });

    $('#main').on("click", "#annullaAggiungiEsame", function () {
        inviaControllerTask('servizi', 'visualizza', "#contenutoAreaPersonale");
    });

    $('#main').on("click", "#impostazioniAreaPersonaleClinica", function () {
        inviaControllerTask('impostazioni', 'clinica', "#contenutoAreaPersonale");
        
    });
    
//    $('#main').on("click", "#salvaImpostazioniClinica", function () {
//        inviaImpostazioniClinica('#workingPlan','#giornoPausa','#inizioPausa','#finePausa','impostazioni', 'clinica', 'workingPlan', "#contenutoAreaPersonale");
//    });
    $('#main').on("click", "#salvaImpostazioniClinica", function () {
        inviaImpostazioniClinica('#workingPlan', 'impostazioni', 'clinica', 'workingPlan', "#contenutoAreaPersonale");
    });
    
    $('#main').on("click", "#aggiungiPausaButton", function () {
        formPausa();
    });
    $('#main').on("click", "#scartaPausa", function () {
        
        scartaPausa(this);//this si riferisce al pulsante scartapausa
    });
    
     $('#main').on("click", "#accettaPausa", function () {
        accettaPausa(this);
    });
    
    $('#main').on("click", "#eliminaPausa", function () {
       
        eliminaPausa(this);
    });

    $('#main').on("click", ".rigaEsame", function () {
        var id = $(this).attr('id');
        var contenitore = "#" + $(this).closest("div").prop("id"); //ritorna l'elemento contenitore sul quale inserire la risposta ajax
        var controller = $("#controllerTabella").attr('value');
        alert(controller);
        if(controller==="servizi")
        {
            clickRiga(controller, 'visualizza', id, contenitore);
        }

    });



});

function inviaImpostazioniClinica(id, controller1, task1,task2, ajaxdiv)
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
function formPausa()
{
    $('#aggiungiPausaButton').prop('disabled', true);
    $('#salvaImpostazioniClinica').prop('disabled', true);
    var idOraInizio = $.now(); //$.now() ritorna l'istante attuale
    var idOraFine =  idOraInizio + 1;
    
    var tr ='<tr><td class="pausaGiorno"><form><select class="selezioneGiornoPausa" name="value">' +
        '<option value="Lunedi" selected="selected">Lunedi</option>' +
        '<option value="Martedi">Martedi</option>' +
        '<option value="Mercoledi">Mercoledi</option>' +
        '<option value="Giovedi">Giovedi</option>' +
        '<option value="Venerdi">Venerdi</option>' +
        '<option value="Sabato">Sabato</option>' +
        '<option value="Domenica">Domenica</option>' +
        '</select></form></td>' +
        '<td class="pausaInizio"><form><input autocomplete="off" id="' + idOraInizio + '" class="time"></form></td>'+
        '<td class="pausaFine"><form><input autocomplete="off" id="' + idOraFine + '" class="time"></form></td>'+
        '<td><div id="azioniPausa"><a id="accettaPausa"><i class="fa fa-check fa-lg faAzzurro"  aria-hidden="true"></i></a> &nbsp'+
        '<a id="scartaPausa"><i class="fa fa-ban fa-lg faAzzurro" aria-hidden="true"></i></a></div></td></tr>';
        
//        $(tr).appendTo('#tabellaPause');
        $('#tabellaPause').prepend(tr);
        $('.time').timepicker({
                stepMinute: 5
            });
        
        
    };
    
    
    function scartaPausa(param){
        $('#aggiungiPausaButton').prop('disabled', false);
        $('#salvaImpostazioniClinica').prop('disabled', false);
        $(param).closest('tr').remove();  
    }
    // accetta pausa è da modificare
    function accettaPausa(param){
        var oraInizioId= "#" + $(param).closest('tr').find('td.pausaInizio form input').attr('id');
        var oraFineId= "#" + $(param).closest('tr').find('td.pausaFine form input').attr('id');

        alert(oraInizioId +" " +oraFineId);
        if( $(oraFineId).val().length ===0 || $(oraInizioId).val().length ===0  ) 
        {
            alert("Inserire gli orari");
        }
        else
        {

            $('#aggiungiPausaButton').prop('disabled', false);
            $('#salvaImpostazioniClinica').prop('disabled', false);
            $('option:not(:selected)').prop('disabled', true);
            $(oraInizioId).attr('readonly',true).datepicker("option", "showOn", "off");
            $(oraFineId).attr('readonly',true).datepicker("option", "showOn", "off");
            //aggiunto successivamente
            $(".selezioneGiornoPausa > option").each(function() {
            alert(this.value);

             if ($(this).val().length==0)
                            {
                                $('.selezioneGiornoPausa').val( '{"Pause":[{"OraInizio":"' 
                                        + $(".oraInizio").val() + '","OraFine":"' + $(".oraFine").val() + '" }]}');
                            }
                            else
                            {
                                var c = $('.selezioneGiornoPausa').val();
                                i = c.length - 2;
                                c = c.slice(0, i);
                                alert(c);
                                c = c + ', {"OraInizio":"' 
                                        + $(".oraInizio").val() + '","OraFine":"' + $(".oraFine").val() + '" }]}';
                                alert(c);
                                $('#LunediPausa').val(c);
                            }

        });
            
            switch ($(".selezioneGiornoPausa").val())
            {
                case 'Lunedi':
                    if ($('#LunediPausa').val().length==0)
                    {
                        $('#LunediPausa').val( '{"Pause":[{"OraInizio":"' 
                                + $(".oraInizio").val() + '","OraFine":"' + $(".oraFine").val() + '" }]}');
                    }
                    else
                    {
                        var c = $('#LunediPausa').val();
                        i = c.length - 2;
                        c = c.slice(0, i);
                        alert(c);
                        c = c + ', {"OraInizio":"' 
                                + $(".oraInizio").val() + '","OraFine":"' + $(".oraFine").val() + '" }]}';
                        alert(c);
                        $('#LunediPausa').val(c);
                    }
                    
                    break;
                case 'Martedi':
                    if ($('#MartediPausa').val().length==0)
                    {
                        $('#MartediPausa').val( '{"Pause":[{"OraInizio":"' 
                                + $("#oraInizio").val() + '","OraFine":"' + $("#oraFine").val() + '" }]}');
                    }
                    else
                    {
                        var c = $('#MartediPausa').val();
                        i = c.length - 2;
                        c = c.slice(0, i);
                        alert(c);
                        c = c + ', {"OraInizio":"' 
                                + $("#oraInizio").val() + '","oraFine":"' + $("#oraFine").val() + '" }]}';
                        alert(c);
                        $('#MartediPausa').val(c);
                    }
                    break;
                case 'Mercoledi':
                    if ($('#MercolediPausa').val().length==0)
                    {
                        $('#MercolediPausa').val( '{"Pause":[{"OraInizio":"' 
                                + $("#oraInizio").val() + '","OraFine":"' + $("#oraFine").val() + '" }]}');
                    }
                    else
                    {
                        var c = $('#MercolediPausa').val();
                        i = c.length - 2;
                        c = c.slice(0, i);
                        alert(c);
                        c = c + ', {"OraInizio":"' 
                                + $("#oraInizio").val() + '","OraFine":"' + $("#oraFine").val() + '" }]}';
                        alert(c);
                        $('#MercolediPausa').val(c);
                    }
                    break;
                case 'Giovedi':
                    if ($('#GiovediPausa').val().length==0)
                    {
                        $('#GiovediPausa').val( '{"Pause":[{"OraInizio":"' 
                                + $("#oraInizio").val() + '","OraFine":"' + $("#oraFine").val() + '" }]}');
                    }
                    else
                    {
                        var c = $('#GiovediPausa').val();
                        i = c.length - 2;
                        c = c.slice(0, i);
                        alert(c);
                        c = c + ', {"OraInizio":"' 
                                + $("#oraInizio").val() + '","OraFine":"' + $("#oraFine").val() + '" }]}';
                        alert(c);
                        $('#GiovediPausa').val(c);
                    }
                    break;
                case 'Venerdi':
                    if ($('#VenerdiPausa').val().length==0)
                    {
                        $('#VenerdiPausa').val( '{"Pause":[{"OraInizio":"' 
                                + $("#oraInizio").val() + '","OraFine":"' + $("#oraFine").val() + '" }]}');
                    }
                    else
                    {
                        var c = $('#VenerdiPausa').val();
                        i = c.length - 2;
                        c = c.slice(0, i);
                        alert(c);
                        c = c + ', {"OraInizio":"' 
                                + $("#oraInizio").val() + '","OraFine":"' + $("#oraFine").val() + '" }]}';
                        alert(c);
                        $('#VenerdiPausa').val(c);
                    }
                    break;
                case 'Sabato':
                    if ($('#SabatoPausa').val().length==0)
                    {
                        $('#SabatoPausa').val( '{"Pause":[{"OraInizio":"' 
                                + $("#oraInizio").val() + '","OraFine":"' + $("#oraFine").val() + '" }]}');
                    }
                    else
                    {
                        var c = $('#SabatoPausa').val();
                        i = c.length - 2;
                        c = c.slice(0, i);
                        alert(c);
                        c = c + ', {"OraInizio":"' 
                                + $("#oraInizio").val() + '","OraFine":"' + $("#oraFine").val() + '" }]}';
                        alert(c);
                        $('#SabatoPausa').val(c);
                    }
                    break;
                default:
                    if ($('#DomenicaPausa').val().length==0)
                    {
                        $('#DomenicaPausa').val( '{"Pause":[{"OraInizio":"' 
                                + $("#oraInizio").val() + '","OraFine":"' + $("#oraFine").val() + '" }]}');
                    }
                    else
                    {
                        var c = $('#DomenicaPausa').val();
                        i = c.length - 2;
                        c = c.slice(0, i);
                        alert(c);
                        c = c + ', {"OraInizio":"' 
                                + $("#oraInizio").val() + '","OraFine":"' + $("#oraFine").val() + '" }]}';
                        alert(c);
                        $('#DomenicaPausa').val(c);
                    }
                    break;       
            }
            // fine aggiunto successivamente
            $("#azioniPausa").html('<a id="eliminaPausa"><i class="fa fa-close fa-lg faAzzurro"  aria-hidden="true"></i></a>');
        
        }   
    }
    
    
    // elimina pausa è da modificare
    function eliminaPausa(param)
    {
//        nomeSelect.options[nomeSelect.selectedIndex].value;
//        var giorno = giornoPausa.options[giornoPausa.selectedIndex].value;
//         var giorno = $('#nomeGiornoPausa').val();
//        var giorno = $(param).closest('#nomeGiornoPausa').;
//        alert(giorno);
        
//        var inizioPausa =  $(param).closest('tr').closest('#oraInizio').val();
//        var finePausa =  $(param).closest('tr').closest('#oraFine').val();
        var inizioPausa =  $('#oraInizio').val();

        var finePausa =  $('#oraFine').val();

        var giornoPausa = giorno + "Pausa" ;

        giornoPausa = "#" + giornoPausa;

        var pauseGiorno =  $(giornoPausa).val();

//        var obj = $.parseJSON(pauseGiorno);
        var obj = JSON.parse(pauseGiorno);
        var trovato = "FALSE";
        for (i = 0; (i<obj.Pause.length && trovato==="FALSE"); i++) 
        { 
            if ((obj.Pause[0].OraInizio==inizioPausa )&& (obj.Pause[0].OraFine==finePausa))
            {
                trovato="TRUE";
                if(obj.Pause.length==1)
                {
                    delete obj.Pause[i];
                    $(giornoPausa).val("");
                    alert( $(giornoPausa).val());
                }
                else
                {
                    delete obj.Pause[i];
                    alert(obj.Pause.count);
                    alert( $(giornoPausa).val());
                }                
            }
        }
        var text = JSON.stringify(obj);
        alert(text);
        $(giornoPausa).val(text);
        
        $(param).closest("tr").remove();
    }


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
