/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){

    $('#main').on("click", "#serviziAreaPersonaleClinica", function() {
        inviaControllerTask('servizi', 'visualizza', "#contenutoAreaPersonale");
    });
    
    $('#main').on("click", "#iconaAggiungi", function() {
        inviaControllerTask('servizi', 'aggiungi', "#contenutoAreaPersonale");
    });
    
    $('#main').on("click", "#annullaAggiungiEsame", function() {
        inviaControllerTask('servizi', 'visualizza', "#contenutoAreaPersonale");
    });
    
   
    
    $('#main').on("click", ".rigaEsame", function(event) { 
        var id = $(this).attr('id');
        clickRiga('servizi', 'visualizza', id, "#contenutoAreaPersonale");
        
    });



});

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
