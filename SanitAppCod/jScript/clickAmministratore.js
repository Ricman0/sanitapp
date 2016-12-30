
$(document).ready(function(){
  $('#headerMain').on('click', '#usersAreaPersonaleAmministratore', function(){
      inviaControllerTask('users', 'visualizza', '#contenutoAreaPersonale');
  }); 
  
  $('#headerMain').on('click', '#bloccatiAreaPersonaleAmministratore', function(){
      inviaControllerTask('users', 'bloccati', '#contenutoAreaPersonale');
  });
  
  $('#headerMain').on('click', '#daValidareAreaPersonaleAmministratore', function(){
      inviaControllerTask('users', 'daValidare', '#contenutoAreaPersonale');
  });
  
   $('#headerMain').on("click", ".rigaUser" , function(){
        var id = $(this).attr('id');
        clickRiga('users', 'visualizza', id, "#contenutoAreaPersonale");
    });
    
    $('#headerMain').on('click', '#bloccaUser', function(){
        var username = $(this).attr('data-username');
        inviaControllerTaskPOST('users', 'blocca', username, '#contenutoAreaPersonale');
    });
    
    $('#headerMain').on('click', '#sbloccaUser', function(){
        var username = $(this).attr('data-username');
        inviaControllerTaskPOST('users', 'sblocca', username, '#contenutoAreaPersonale');
    });
    
    $('#headerMain').on('click', '#validaUser', function(){
        var username = $(this).attr('data-username');
        inviaControllerTaskPOST('users', 'valida', username, '#contenutoAreaPersonale');
    });
    
    $('#headerMain').on('click', '#confermaUser', function(){
        var username = $(this).attr('data-username');
        inviaControllerTaskPOST('users', 'conferma', username, '#contenutoAreaPersonale');
    });
  
});

function inviaControllerTaskPOST(controller,task, id, ajaxdiv)
{
    
    var dati = {id:id};
    $.ajax({
        type: 'POST',
        url: controller + '/' + task ,
        data: dati,
        success: function (datiRisposta)
        {
            alert(datiRisposta);
            $(ajaxdiv).html(datiRisposta);
        },
        error: function ()
        {
            alert("Sbagliato click ");
        }
    });
}
