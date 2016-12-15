/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    $('#headerMain').on("click", "#modificaIndirizzoMedico", function () {
        clickModificaImpostazioni('impostazioni', 'modifica', 'informazioni', "#informazioniGenerali");
    });

    $('#headerMain').on("click", "#modificaMedico", function () {
        clickModificaImpostazioni('impostazioni', 'modifica', 'alboNum', "#informazioniGenerali");
    });

    $('#headerMain').on("click", "#modificaPassword", function () {
        clickModificaImpostazioni('impostazioni', 'modifica', 'credenziali', "#credenziali");
    });
    
    
    $('#headerMain').on("click", "#pazientiAreaPersonaleMedico", function(){
//        $( "#prenotazioniAreaPersonaleUtente").addClass("Attivo");
        inviaControllerTask('pazienti', 'visualizza', "#contenutoAreaPersonale"); 
    });
    
    $('#headerMain').on("click", "#refertiAreaPersonaleMedico", function () {
        inviaControllerTask('referti', 'visualizza', "#contenutoAreaPersonale");
    });
    
    $('#headerMain').on("click", "#impostazioniAreaPersonaleMedico", function () {
        inviaControllerTask('impostazioni', 'visualizza', "#contenutoAreaPersonale");
    });
    
     
    $('#headerMain').on("click", "#prenotazioniAreaPersonaleMedico", function () {
        inviaControllerTask('prenotazioni', 'visualizza', "#contenutoAreaPersonale");
    });
    
    $('#headerMain').on("click", "#iconaAggiungiPrenotazioneMedico", function () {
        inviaController('ricercaEsami', "#contenutoAreaPersonale");
    });
    
    $('#headerMain').on("click", "#iconaAggiungiPaziente", function () {
        inviaControllerTask('pazienti', 'aggiungi', "#contenutoAreaPersonale");
    });
    
    
//    $('#main').on("click", "#refertiAreaPersonaleUtente", function(){
//        inviaControllerTask('referti', 'utente', "#contenutoAreaPersonale");
//    });
//    
//    $('#main').on("click", "#impostazioniAreaPersonaleUtente", function(){
//        inviaControllerTask('impostazioni', 'utente', "#contenutoAreaPersonale");
//    });
   
    
    
    $('#headerMain').on("click", ".rigaPaziente" , function(){
        var id = $(this).attr('id');
        clickRiga('pazienti', 'visualizza', id, "#contenutoAreaPersonale");
    });
        
       
     
});