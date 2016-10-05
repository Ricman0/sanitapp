/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    $('#main').on("click", "#pazientiAreaPersonaleMedico", function(){
//        $( "#prenotazioniAreaPersonaleUtente").addClass("Attivo");
        inviaControllerTask('pazienti', 'visualizza', "#contenutoAreaPersonale"); 
    });
    
//    $('#main').on("click", "#refertiAreaPersonaleUtente", function(){
//        inviaControllerTask('referti', 'utente', "#contenutoAreaPersonale");
//    });
//    
//    $('#main').on("click", "#impostazioniAreaPersonaleUtente", function(){
//        inviaControllerTask('impostazioni', 'utente', "#contenutoAreaPersonale");
//    });
//    
//    $('#main').on("click", "#iconaAggiungiPrenotazione", function(){
//        inviaControllerTask('prenotazioni', 'aggiungi', "#contenutoAreaPersonale");
//    });
//    
//    var id = $(this).attr('id');
//    $('#main').on("click", ".rigaPrenotazione" , function(){
//        clickRiga('prenotazioni', 'visualizza', id, "#contenutoAreaPersonale");
//    });
        
     
});