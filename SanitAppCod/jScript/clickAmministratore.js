
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
    
    $('#headerMain').on("click", ".rigaUserBloccati" , function(){
        var id = $(this).attr('id');
        clickRiga('usersBloccati', 'visualizza', id, "#contenutoAreaPersonale");
    });
    
    $('#headerMain').on("click", ".rigaUserDaValidare" , function(){
        var id = $(this).attr('id');
        clickRiga('usersDaValidare', 'visualizza', id, "#contenutoAreaPersonale");
    });
    
    
    $('#headerMain').on('click', '#bloccaUser', function(){
        var username = $(this).attr('data-username');
        var datiPOST = {id:username};
        inviaControllerTaskPOST('users', 'blocca', datiPOST, '#contenutoAreaPersonale');
    });
    
    $('#headerMain').on('click', '#sbloccaUser', function(){
        var username = $(this).attr('data-username');
        var datiPOST = {id:username};
        inviaControllerTaskPOST('users', 'sblocca', datiPOST, '#contenutoAreaPersonale');
    });
    
    $('#headerMain').on('click', '#validaUser', function(){
        var username = $(this).attr('data-username');
        var datiPOST = {id:username };
        inviaControllerTaskPOST('users', 'valida', datiPOST, '#contenutoAreaPersonale');
    });
    
    $('#headerMain').on('click', '#confermaUser', function(){
        var username = $(this).attr('data-username');
        var datiPOST = {id:username };
        inviaControllerTaskPOST('users', 'conferma', datiPOST, '#contenutoAreaPersonale');
    });
    
    $('#headerMain').on('click', '#eliminaUser', function(){
        var username = $(this).attr('data-username');
        var tipoUser = $(this).attr('data-tipoUser');
        var datiPOST = {id:username , tipoUser:tipoUser};
        inviaControllerTaskPOST('users', 'elimina', datiPOST, '#contenutoAreaPersonale');
    });
    
    $('#headerMain').on('click', '#modificaUser', function(){
        var username = $(this).attr('data-username');
        var tipoUser = $(this).attr('data-tipoUser');
        var datiPOST = {id:username , tipoUser:tipoUser};
        inviaControllerTaskPOST('users', 'modifica', datiPOST, '#contenutoAreaPersonale');
    });
    
    $('#headerMain').on('click', '#iconaAggiungiUser', function(){
        $('#iconaAggiungiUser').siblings().remove(); // elimino tutti i fratelli di iconaAggiungiUser
        //aggiungo i tasti dopo l'icona aggiungi (come fratelli non come figli)
        $( "#iconaAggiungiUser" ).after( 
         "<input type=button' id='registrazioneUtente' class='tasti fa-lg' value='&#xf007; Utente' aria-hidden='true' /> "
        +  "<input type=button' id='registrazioneMedico'  class='tasti fa-lg' value='&#xf0f0; Medico' aria-hidden='true' /> "
        +  "<input type=button' id='registrazioneClinica' class='tasti fa-lg' value='&#xf0f8; Clinica' aria-hidden='true' /> " 
//        $('#iconaAggiungiUser').append( "<br><br>"
//        +  "<input type=button' id='registrazioneUtente' class='tasti' value=' Utente' />"
//        +  "<input type=button' id='registrazioneMedico'  class='tasti'value='&#xf0f0; Medico' />"
//        +  "<input type=button' id='registrazioneClinica' class='tasti' value='&#xf0f8; Clinica' />"

//            + "<a id='registrazioneUtente' ><i class='fa fa-user fa-lg' id='icona-esami' aria-hidden='true'></i> Utente</a>"
//            + "<a id='registrazioneMedico' ><i class='fa fa-user-md fa-lg' id='icona-esami' aria-hidden='true'></i> Medico</a>"
//            + "<a id='registrazioneClinica' ><i class='fa fa-hospital-o fa-lg' id='icona-esami' aria-hidden='true'></i> Clinica</a>" 
            + "<br>");
        $( "#iconaAggiungiUser" ).after( "<h4>Clicca su uno dei seguenti tasti per inserire nell'applicazione</h4>"
        +  "<h4>un nuovo utente, un nuovo medico o una nuova clinica.</h4>");
        $( "#iconaAggiungiUser" ).remove();
    
    });
  
    
});

function inviaControllerTaskPOST(controller,task, datiPOST, ajaxdiv)
{
    
    
    $.ajax({
        type: 'POST',
        url: controller + '/' + task ,
        data: datiPOST,
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
