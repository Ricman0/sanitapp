
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

    $('#headerMain').on('click', '#categorieEsamiAmministratore', function(){
        inviaController('categorie', '#contenutoAreaPersonale');
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
  
  
    $('#headerMain').on('click', '#iconaAggiungiCategoria', function(){
        $('#iconaAggiungiCategoria').siblings().remove(); // elimino tutti i fratelli di iconaAggiungiUser
        //aggiungo i tasti dopo l'icona aggiungi (come fratelli non come figli)
        $('#iconaAggiungiCategoria').after("<form name='aggiungiCategoria' method='post' id='aggiungiCategoria'></form>");
        // aggiungo label e input per il nome
        $( "#aggiungiCategoria" ).append("<label for='nomeCategoria' class='elementiForm'>Nome</label>");
        $( "#aggiungiCategoria" ).append("<input type='text' name='nomeCategoria' id='nomeCategoria' class='elementiForm' required />");  
        $( "#aggiungiCategoria" ).append("<br>"); 
        // aggiungo il tasto  aggiungi
        $( "#aggiungiCategoria" ).append("<span id='aggiungiCategoria' ></span>  ");
        $( "#aggiungiCategoria" ).append("<input type='submit' value='Aggiungi' id='submitAggiungiCategoria'>  ");
        // aggiungo il tasto annulla
        $( "#aggiungiCategoria" ).append("<span id='annullaCategoria' ></span>  ");
        $( "#annullaCategoria" ).append("<input type='button' value='Annulla' id='annullaAggiungiCategoria'>");
        // aggiungo del testo per migliorare la comprensione della pagina
        $( "#iconaAggiungiCategoria" ).after( "<h4>Clicca su 'Annulla' per annullare l'inserimento di una nuova categoria.</h4>");
        $( "#iconaAggiungiCategoria" ).after( "<h4>Clicca su 'Aggiungi' per aggiungere una nuova categoria.</h4>");
        $( "#iconaAggiungiCategoria" ).after( "<h4>Inserisci i dati per aggiungere una nuova categoria.</h4>");
        // elimino il tasto + di aggiungi categoria
        $( "#iconaAggiungiCategoria" ).remove();
        validazioneCategoria();
    });
  
    //click sul tasto annulla aggiunta categoria
    $('#headerMain').on('click', '#annullaAggiungiCategoria', function(){
        inviaController('mySanitApp', '#main');
//        inviaControllerTask('users', 'visualizza', '#contenutoAreaPersonale');
    }); 
    
    $('#headerMain').on("click", ".rigaCategoria" , function(){
        var id = $(this).attr('id');
        var datiPOST = {id:id};
        inviaControllerTaskPOST('categorie', 'elimina', datiPOST, '#contenutoAreaPersonale');
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
