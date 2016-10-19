/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function (){
    $('#main').on("click", "#aggiungiPrenotazioneButton", function(){
        var id = $("#aggiungiPrenotazioneButton").attr("data-idEsame");
        prenotazione('prenotazione', 'esame', id, "#main"); 
    });

    $('#main').on('click', '.orarioDisponibile', function() {
        $('.orarioSelezionato').removeClass('orarioSelezionato');
        $(this).addClass('orarioSelezionato');
        var orarioSelezionato = $(".orarioSelezionato").text();
        $('#nextPrenotazioneEsame').attr('data-orario', orarioSelezionato);
        
    });
    
    $('#main').on("click", "#nextPrenotazioneEsame", function(){
        var idEsame = $('#nextPrenotazioneEsame').attr('data-idEsame');
        var orarioPrenotazione = $('#nextPrenotazioneEsame').attr('data-orario');
        var dataPrenotazione = $('#nextPrenotazioneEsame').attr('data-data');
        inviaControllerTaskDati('prenotazione', 'riepilogo',  idEsame , dataPrenotazione, orarioPrenotazione, "#main");
    });
    
    $('#main').on("click", "#confermaPrenotazione", function(){
        confermaPrenotazione('prenotazione', 'conferma', "#main");
    });
    
    $('#main').on("click", "#prenotazioneAggiunta", function(){; 
        inviaController('mySanitApp', '#main');
    });
});

function confermaPrenotazione(controller1, task, ajaxDiv)
{
        var codice = $('#confermaPrenotazione').attr('data-codice');
        var clinica = $('#confermaPrenotazione').attr('data-idClinica');
        var idEsame = $('#confermaPrenotazione').attr('data-idEsame');
        var orarioPrenotazione = $('#orarioPrenotazione').text();
        orarioPrenotazione = orarioPrenotazione.slice(7,12);
        var dataPrenotazione = $('#dataPrenotazione').text();
        dataPrenotazione = dataPrenotazione.slice(5,15);
        dati ={id : idEsame, orario : orarioPrenotazione, data : dataPrenotazione, clinica : clinica, codice: codice};
        $.ajax({
            type: 'POST',
            url: controller1 + '/' + task,
            data:dati,
            success:function(datiRisposta)
            {
                alert(datiRisposta);
                $(ajaxDiv).html(datiRisposta);
            },
            error: function(xhr, status, error) 
            {
                alert(xhr.responseText);
                alert(error);
                alert(" errore nella conferma prenotazione ");
            }
        });
}

function inviaControllerTaskDati(controller, task,  idEsame , dataPrenotazione, orarioPrenotazione, ajaxDiv)
{
    $.ajax({
        
        type: 'GET',
        url: controller + '/' + task + '/' + idEsame +  '/' + dataPrenotazione + '/' + orarioPrenotazione ,
   
        success: function (datiRisposta)
        {
            alert(datiRisposta);
            $(ajaxDiv).html(datiRisposta);
        },
        error: function(xhr, status, error) 
        {
            alert(xhr.responseText);
            alert(error);
            alert(" errore nel riepilogo ");
        }
    });
}

function prenotazione(controller, task, id, ajaxDiv)
{
    $.ajax({
        type: 'GET',
        url : controller + "/" + task + "/" + id ,
        success: function(datiHTMLRisposta)
        {
            alert(datiHTMLRisposta);
            $(ajaxDiv).html(datiHTMLRisposta);
            $("#calendarioPrenotazioneEsame").datepicker({
                    firstDay:1,
                    dateFormat: "dd-mm-yy",
                    regional: "it",
                    minDate: 1,
                    onSelect: function(dateText, inst) { 
                    var data = dateText; //the first parameter of this function
                    $('#nextPrenotazioneEsame').attr('data-data', data);
                    alert(data);
                    
                    var dataObject = $(this).datepicker( 'getDate' ); //the getDate method
                    alert(dataObject);
                    
                    var nomeGiorno =$.datepicker.formatDate('DD', dataObject);
                    alert(nomeGiorno);
                    var partitaIVAClinica = $("#partitaIVAClinicaPrenotazioneEsame").val();
                    alert("PartitaIVA: " + partitaIVAClinica);
                    var idEsame = $("#idEsame").val();
                    dateDisponibili(partitaIVAClinica, idEsame, nomeGiorno, data);
                    
                    
                    }});
//             $( "#calendarioPrenotazioneEsame .selector" ).datepicker( "dialog", "15/10/2015" );
           


 
//            $.getJSON({
//                
//            })
//            $("#calendarioPrenotazioneEsame").fullCalendar({
//                header:{
//                    left: '',
//                    center: 'title',
//                    right:'today prev, next, '
//                }
////                events: {
////                url: '/myfeed.php',
////                type: 'POST',
////                data: {
////                    custom_param1: 'something',
////                    custom_param2: 'somethingelse'
////                },
////                error: function() {
////                    alert('there was an error while fetching events!');
////                },
////                color: 'yellow',   // a non-ajax option
////                textColor: 'black' // a non-ajax option
//        }
//
//    });  
        
        },
        error:function()
        {
            alert("Sbagliato click prenotaEsame ");
        }
    });
    
    
}

function dateDisponibili(partitaIVAClinica, idEsame, nomeGiorno, data)
{
    $.ajax({
        type: 'GET',
        url: "prenotazione/" + partitaIVAClinica + "/" + idEsame + "/" + nomeGiorno + "/" + data,
        dataType: "json",
//        contentType: "application/json; charset=utf-8",
        success:function(datiRisposta)
        {
            $("#orariDisponibili").empty();
            
            alert(datiRisposta);
            // converto i dati risposta json in un oggetto javascript
//            var orariDisponibili = $.parseJSON(datiRisposta);
            var i=1;
            var j =1;
            if(Object.keys(datiRisposta).length > 0)
            {
                $("#orariDisponibili").append('<div id="colonna1" class="colonna"></div>');
                $.each(datiRisposta, function( key, array ) 
                {
                    $.each( array, function( index, value )
                    {       


                            $("#colonna" + i).append( '<span class="orarioDisponibile">' + value + '</span> &nbsp');
                            if(j%11===0)
                            {
                                i++;
                                $("#orariDisponibili").append('<div id="colonna' + i + '" class="colonna"></div>');

                            }
                            j++;


                    });
                });
            }


            
            $("#dateDisponibili").html(datiRisposta);
            
        },
        error: function(xhr, status, error) 
        {
            alert(xhr.responseText);
            alert(error);
            alert(" errore nel ricevere le date disponibili ");
        }
    });
}


