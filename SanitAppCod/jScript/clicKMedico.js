/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    $('#main').on("click", "#pazientiAreaPersonaleMedico", function(){
        inviaController('pazienti', "#contenutoAreaPersonale");
    });
    
    $('#main').on("click", "#prenotazioniAreaPersonaleMedico", function(){
//        $( "#prenotazioniAreaPersonaleUtente").addClass("Attivo");
        inviaControllerTask('prenotazioni', 'visualizza', "#contenutoAreaPersonale"); 
    });
    
    $('#main').on("click", "#refertiAreaPersonaleMedico", function(){
        inviaControllerTask('referti', 'medico', "#contenutoAreaPersonale");
    });
    
    $('#main').on("click", "#impostazioniAreaPersonaleMedico", function(){
        inviaControllerTask('impostazioni', 'medico', "#contenutoAreaPersonale");
    });
    
    $('#main').on("click", "#iconaAggiungiPrenotazione", function(){
        inviaControllerTask('prenotazioni', 'aggiungi', "#contenutoAreaPersonale");
    });
    
    var id = $(this).attr('id');
    $('#main').on("click", ".rigaPrenotazione" , function(){
        clickRiga('prenotazioni', 'visualizza', id, "#contenutoAreaPersonale");
    });
        
     
});
