
/*
 * Quando il DOM è pronto, mando in run questa funzione.
 * Tale funzione si pone in attesa di un evento click sull'elemento con 
 * id = registrazione.
 * Quando avviene il click su registrazione, viene eseguita la funzione inviaControllerTask
 */
$(document).ready(function () {
    
    $("#headerMain").on("click", ".homepage", function(){
        inviaController('index.php', '#wrapper');
    });
    
//la funzione seguente viene usata per il click su contatti, privacyPolicy, informazioniValidazione
    $("#wrapper").on("click", "a.soloController", function(){
        var ajaxDiv = '#main';
        if ($('#contenutoAreaPersonale').length) {
            ajaxDiv ='#contenutoAreaPersonale';
          }
        inviaController(this.id, ajaxDiv);
    });
    
    $('#headerMain').on("click", "form span.link", function(){
        var url = 'terminiServizio';
        window.open(url, '_blank');
//        inviaController('terminiServizio', '#main');
    });
    
    $('#headerMain').on("click", ".mySanitApp", function () {
        
        inviaController('mySanitApp', '#main');
    });
    
    // click per avere la form dela registrazione clinica
    $('#headerMain').on("click", "#registrazioneClinica", function () {
        var  ajaxDiv = '#main';
        if( $("#contenutoAreaPersonale").length  ) 
        {
            ajaxDiv = '#contenutoAreaPersonale';
        }
        inviaControllerTask('registrazione', 'clinica', ajaxDiv);
    });
    
    $('#headerMain').on("click", "#registrazioneMedico", function () {
        var  ajaxDiv = '#main';
        if( $("#contenutoAreaPersonale").length  ) 
        {
            ajaxDiv = '#contenutoAreaPersonale';
        }
        inviaControllerTask('registrazione', 'medico', ajaxDiv);
    });
    
    $('#headerMain').on("click", ".registrazioneUtente", function () {
        var  ajaxDiv = '#main';
        if( $("#contenutoAreaPersonale").length  ) 
        {
            ajaxDiv = '#contenutoAreaPersonale';
        }
        inviaControllerTask('registrazione', 'utente', ajaxDiv);
    });
    
    $('#headerMain').on("click", "#submitCodiceConferma", function () {
        var codiceConferma = $('#codiceConferma').val();
        var username = $('#submitCodiceConferma').attr('data-username');
        var datiPOST = {username: username, id:codiceConferma};
        $.ajax({
            type:'POST',
            url: 'registrazione/conferma',
            data:datiPOST,
            success: function (datiRisposta){
                $('#main').html(datiRisposta);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                alert("Sbagliato click ");
            }
            
        });
    });

    $('#headerMain').on("click", "#recuperaPassword", function () {
        inviaController('recuperaPassword', '#main');
    });    

    $('#headerMain').on("click", "#esamiClinicaButton", function () {
        var nomeClinica = $("#esamiClinicaButton").attr('data-nomeClinica');
        var ajaxDiv = '#main';
        //se esiste il div contenutoAreaPersonale
        if ($('#contenutoAreaPersonale').length) {
            ajaxDiv ='#contenutoAreaPersonale';
        }
        inviaController('esami/all/'+nomeClinica, ajaxDiv);
    });
    
    $('#headerMain').on("click", ".rigaClinica", function () {
        var id = $(this).attr('id'); // id della riga che coincide con l'id dell'esame
        var contenitore = "#" + $(this).closest("div").prop("id"); //ritorna l'elemento contenitore sul quale inserire la risposta ajax

        clickRiga('cliniche', 'visualizza', id, contenitore);
    });

    $('#headerMain').on("click", ".scaricaReferto", function () {
        var id = $(this).attr('data-idPrenotazione');
        download(id);
    });

    $(function() { 
            $(document).tooltip({
                items: 'input.error',
                tooltipClass: 'error',
                position: {
                    my: "center bottom",
                    at: "right top"
                  }
            });
         });
});












