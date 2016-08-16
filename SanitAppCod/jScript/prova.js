/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$(document).ready(function() {
  $("#bottone").click(function(){
    var controller = $("#controller").val();
    var task = $("#task").val();
    var nome = $("#nome").val();
    var cognome = $("#cognome").val();
    var codice = $("#codiceFiscale").val();
    var indirizzo = $("#indirizzo").val();
    var numeroCivico = $("#numeroCivico").val();
    var CAP = $("#CAP").val();
    var email = $("#email").val();
    var username = $("#usernameUtente").val();
    var password = $("#passwordUtente").val();    
    $.ajax({
      type: "POST",
      url: "registrazione/utente",
      data: "nome=" + nome + "&cognome=" + cognome + "&controller=" + controller
      +"&task=" + task+"&codiceFiscale=" + codice+"&indirizzo=" + indirizzo
      +"&numeroCivico=" + numeroCivico
      +"&CAP=" + CAP+"&email=" + email
      +"&username=" + username+"&password=" + password,
      dataType: "html",
      success: function(msg)
      {
        $("#risultato").html(msg);
      },
      error: function()
      {
        alert("Chiamata fallita, si prega di riprovare...");
      }
    });
  });
});
