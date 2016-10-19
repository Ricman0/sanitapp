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
    });
    
    
});

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


                            $("#colonna" + i).append( '<span class="orariDisponibili">' + value + '</span> &nbsp <br>');
                            if(Number.isInteger(j/12))
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


