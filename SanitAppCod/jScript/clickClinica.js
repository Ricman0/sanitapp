/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {

    $('#main').on("click", "#serviziAreaPersonaleClinica", function () {
        inviaControllerTask('servizi', 'visualizza', "#contenutoAreaPersonale");
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
    
    $('#main').on("click", "#salvaImpostazioniClinica", function () {
        inviaImpostazioniClinica('#workingPlan','impostazioni', 'clinica', 'workingPlan', "#contenutoAreaPersonale");
    });
    
    $('#main').on("click", "#aggiungiPausaButton", function () {
        formPausa();
    });
    $('#main').on("click", "#scartaPausa", function () {
        
        scartaPausa(this);//this si riferisce al pulsante scartapausa
    });
    
     $('#main').on("click", "#accettaPausa", function () {
        accettaPausa();
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
    var dati = $(id).serialize();
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
function formPausa()
{

    var tr ='<tr><td><form><select name="value">' +
        '<option value="Lunedì" selected="selected">Lunedì</option>' +
        '<option value="Martedì">Martedì</option>' +
        '<option value="Mercoledì">Mercoledì</option>' +
        '<option value="Giovedì">Giovedì</option>' +
        '<option value="Venerdì">Venerdì</option>' +
        '<option value="Sabato">Sabato</option>' +
        '<option value="Domenica">Domenica</option>' +
        '</select></form></td>' +
        '<td><form><input autocomplete="off" id="oraInizio" name="oraInizio" class="time"></form></td>'+
        '<td><form><input autocomplete="off" id="oraFine" name="oraFine" class="time"></form></td>'+
        '<td><div id="azioniPausa"><a id="accettaPausa"><i class="fa fa-check fa-lg faAzzurro"  aria-hidden="true"></i></a> &nbsp'+
        '<a id="scartaPausa"><i class="fa fa-ban fa-lg faAzzurro" aria-hidden="true"></i></a></div></td></tr>';
        $('#aggiungiPausaButton').prop('disabled', true);
        $('#tabellaPause').prepend(tr);
        $('.time').timepicker({
                'timeFormat': 'H:i:s',
                'step': 15
            });
        
        
        
    };
    
    
    function accettaPausa(){
        if( $('#oraFine').val().length ===0 || $('#oraInizio').val().length ===0  ) 
        {
            alert("Inserire gli orari");
      }
      else{

        $('#aggiungiPausaButton').prop('disabled', false);
        $('option:not(:selected)').prop('disabled', true);
        $(".bodyTabellaPause :input").prop('readonly', true);
        $("#azioniPausa").html('<a id="eliminaPausa"><i class="fa fa-close fa-lg faAzzurro"  aria-hidden="true"></i></a>');
        
      }   
    }
    
    function scartaPausa(param){
        $('#aggiungiPausaButton').prop('disabled', false);
        $(param).closest('tr').remove();
        
    }
    
    function eliminaPausa(param)
    {
        
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
