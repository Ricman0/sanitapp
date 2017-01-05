
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
    
    $('#headerMain').on('click', '#modificaUser', function(){
        // modifico il 'titolo' da INFORMAZIONI a MODIFICA USER
        $('#contenutoAreaPersonale').find('h3').replaceWith("<h3>MODIFICA USER</h3>");
        var tipoUser = $(this).attr('data-tipoUser');
        tipoUser = tipoUser[0].toUpperCase() + tipoUser.slice(1); //in questo modo ho la prima lettera di tipoUser maiuscola
         if(tipoUser === 'Utente')
        {
            validazioneModificaUtente();
        }
        else if(tipoUser==='Medico')
        {
            validazioneMedico();
        }
        else
        {
            validazioneClinica();
        }
        $('h3').after("<form id='modificaUser" + tipoUser + "'></form>");
        var nomeLabel = "";
        $( '#contenutoAreaPersonale > span' ).each(function( index ) {
            
            if(index%2===0)
            { 
                nomeLabel = $( this ).text().trim();
                var lunghezzaLabel = nomeLabel.length;
                nomeLabel = nomeLabel.substring(0, lunghezzaLabel-1); // elimino i ':' finali
                nomeLabel = nomeLabel.toLowerCase(); // tutto minuscolo
                var paroleNomeLabel = nomeLabel.split(" "); // separo le parole di nomeLabel
                nomeLabel = '';
                $.each(paroleNomeLabel ,function(index, value){
                    nomeLabel = nomeLabel + " " + value.substring(0,1).toUpperCase() + value.slice(1);  // in questo modo se label è composta da più parole ho una notazione a cammello anche nell'id, ecc..
                }) ;
                nomeLabel = nomeLabel.trim();
                nomeLabel = nomeLabel.substring(0,1).toLowerCase() + nomeLabel.slice(1);
                alert(nomeLabel);
                if(nomeLabel !== 'indirizzo')
                { 
                    $( '#modificaUser' + tipoUser).append("<label for='" + nomeLabel.replace(' ','')  + "' class='elementiForm'>" + nomeLabel.toUpperCase() + ": </label>");
                }     
            }
            else
            {
                if( nomeLabel === 'indirizzo')
                {
                    var indirizzo = $(this).text().trim();
                    // indirizzo contene almeno  via, numero civico, cap 
                    indirizzo = indirizzo.split(','); 
                    $( '#modificaUser' + tipoUser).append("<label for='via"   + "' class='elementiForm'>VIA: </label>");
                    $( '#modificaUser' + tipoUser).append("<input type='text' name='via"  +"' class='elementiForm' id='via"   + "' value='" + indirizzo[0].trim() +"' /><br>");
                    $( '#modificaUser' + tipoUser).append("<label for='numeroCivico"   + "' class='elementiForm'>NUMERO CIVICO: </label>");
                    $( '#modificaUser' + tipoUser).append("<input type='text' name='numeroCivico"  +"' class='elementiForm' id='numeroCivico"   + "' value='" + indirizzo[1].trim() +"' /><br>");
                    $( '#modificaUser' + tipoUser).append("<label for='CAP"   + "' class='elementiForm'>CAP: </label>");
                    if (tipoUser === 'Clinica')
                    {
                        var CapLocalitàProvincia = indirizzo[2].trim().split(" ");
                        $( '#modificaUser' + tipoUser).append("<input type='text' name='CAP"  + "' class='elementiForm' id='CAP"   + "' value='" + CapLocalitàProvincia[0].trim() +"' /><br>");
                        $( '#modificaUser' + tipoUser).append("<label for='località"   + "' class='elementiForm'>LOCALITÁ: </label>");
                        $( '#modificaUser' + tipoUser).append("<input type='text' name='località" +"' class='elementiForm' id='località"   + "' value='" + CapLocalitàProvincia[1].trim() +"' /><br>");
                        $( '#modificaUser' + tipoUser).append("<label for='provincia"   + "' class='elementiForm'>PROVINCIA: </label>");
                        $( '#modificaUser' + tipoUser).append("<input type='text' name='provincia"  +"' class='elementiForm' id='provincia"   + "' value='" + CapLocalitàProvincia[2].trim() +"' /><br>");
                    } 
                    else
                    {
                        $('#modificaUser' + tipoUser).append("<input type='text' name='CAP" + "' class='elementiForm' id='CAP"  + "' value='" + indirizzo[2].trim() + "' /><br>"); 
                    }
                }
                else if(nomeLabel === 'confermato' || nomeLabel === 'bloccato' || nomeLabel === 'validato')
                {
                    var valore = $(this).text().trim();
                    if( valore === 'SI')
                    {
                        $("label[for='" +  nomeLabel.replace(' ','')  + "']").append(" <input type='checkbox' checked>"
                       
                       +" <div class='slider round'></div>"
                       +"</label>");
               //<label class='switch'>" 
                      
                    }
                    else
                    {
                       $("label[for='" +  nomeLabel.replace(' ','')  + "']").append("<label class='switch'>" 
                       + " <input type='checkbox' >"
                       + " <div class='slider round'></div>"
                       + " </label>"); 
                    }
                    $("label[for='" +  nomeLabel.replace(' ','') + "']").after("<br>");
                    
                }
                else
                {
                    $( '#modificaUser' + tipoUser).append("<input type='text' name='" + nomeLabel.replace(' ','')  +"' class='elementiForm' id='" +  nomeLabel.replace(' ','') + tipoUser  + "' value='" + $(this).text().trim() +"' /><br>");
                }
            }
        });
        $( '#contenutoAreaPersonale > span' ).remove();
        $('#tastiInfoUser').remove();
       
        $( '#modificaUser' + tipoUser).append("<input type='submit' value='Modifica " + tipoUser +" ' id='submitModifica" + tipoUser + "'>  ");
        $( '#modificaUser' + tipoUser).append("<input type='button' value='Modifica Password " + tipoUser +"' id='modificaPasswordUser" + tipoUser + "' data-tipoUser='" + tipoUser + "'>");
        
       
    });
    
    $('#headerMain').on("click", "#modificaPasswordUser" , function(){
        var tipoUser = $(this).attr('data-tipoUser');
        $( '#modificaUser' + tipoUser).append("<label for='password" + tipoUser + "' class='elementiForm'>PASSWORD: </label>");
        $( '#modificaUser' + tipoUser).append("<input type='password' name='password" + tipoUser + "' class='elementiForm'  id='password" + tipoUser + "' /><br>");
        $("#modificaPasswordUser").remove();
    });
    
    
    
    
   
    
//    $('#headerMain').on("change", "#modificaUserClinica >input[type='text']" , function(){
//        
//        
//        
//        var valoreNuovo = $(this).val();
//        var idElementoInput = $(this).attr("id");
//        var nomeFunzioneDaRichiamare = "valida" + idElementoInput ;
//        // vorrei richiamre una funzione il cui nome viene passato come stringa
////        eval(nomeFunzioneDaRichiamare);
//        
////        [nomeFunzioneDaRichiamare]();
//        var valoreLabel = $("label[for='" + idElementoInput + "']").val().trim();
//        valoreLabel = valoreLabel.substring(0,1).toUpperCase() + valoreLabel.slice(1);
//        $("label[for='" + idElementoInput + "']").wrap( "<form id='" + idElementoInput + "Form'></form>" );
//        $( this ).insertAfter( "label[for='" + idElementoInput + "']" );
//        $(this).after("<input type='submit' value='Modifica "+ valoreLabel + "' id='submitModifica" + idElementoInput + "'>  ");
//    });
//    
    
});

// $("input").prop('required',true) 


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
