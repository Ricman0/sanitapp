/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function (){
    $('#main').on("click", "#aggiungiPrenotazioneButton", function(){
        var id = $("#aggiungiPrenotazioneButton").attr("data-idEsame");
        prenotazione('prenotazione', 'esame', id, "#contenutoAreaPersonale"); 
    });
});

function prenotazione(controller, task, id, ajaxDiv)
{
    $.ajax({
        type: 'GET',
        url : controller + "/" + task + "/" + id + "/",
        success: function(datiRisposta)
        {
            alert(datiRisposta);
            $(ajaxDiv).html(datiRisposta);
        },
        error:function()
        {
            alert("Sbagliato click prenotaEsame ");
        }
    });
}


