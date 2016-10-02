/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    $('#main').on("click", "#prenotazioniAreaPersonaleUtente", function(){
//        $( "#prenotazioniAreaPersonaleUtente").addClass("Attivo");
        inviaControllerTask('prenotazioni', 'utente', "#contenutoAreaPersonale"); 
    });
    
    $('#main').on("click", "#refertiAreaPersonaleUtente", function(){
        inviaControllerTask('referti', 'utente', "#contenutoAreaPersonale");
    });
    
    $('#main').on("click", "#impostazioniAreaPersonaleUtente", function(){
        inviaControllerTask('impostazioni', 'utente', "#contenutoAreaPersonale");
    });
    
    $('#contenutoAreaPersonale').on("click", "#iconaAggiungiPrenotazione", function(){
        inviaControllerTask('prenotazioni', 'aggiungi', "#contenutoAreaPersonale");
    });
});


