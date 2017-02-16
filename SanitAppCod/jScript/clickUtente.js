
$(document).ready(function () {
    $('#headerMain').on("click", "#prenotazioniAreaPersonaleUtente", function () {
//        $( "#prenotazioniAreaPersonaleUtente").addClass("Attivo");
        inviaControllerTask('prenotazioni', 'visualizza', "#contenutoAreaPersonale");
    });

    $('#headerMain').on("click", "#impostazioniAreaPersonaleUtente", function () {
        inviaControllerTask('impostazioni', 'visualizza', "#contenutoAreaPersonale");
    });

    $('#headerMain').on("click", "#refertiAreaPersonaleUtente", function () {
        inviaControllerTask('referti', 'visualizza', "#contenutoAreaPersonale");
    });

    $('#headerMain').on("click", "#iconaAggiungiPrenotazioneUtente", function () {
        inviaController('ricercaEsami', "#contenutoAreaPersonale");
    });

    $('#headerMain').on("click", "#confermaPrenotazioneUtente", function () {
        var id = $('#confermaPrenotazioneUtente').attr('data-idprenotazione');
        confermaPrenotazioneUtente('prenotazione', 'conferma', id, "#contenutoAreaPersonale");
    });

    $('#headerMain').on("click", "#modificaIndirizzoUtente", function () {
        clickModificaImpostazioni('impostazioni', 'modifica', 'informazioni', "#informazioniGeneraliUtente");
    });

    // per ottenere la pagina per modificare il medico curante dell'utente
    $('#headerMain').on("click", "#modificaMedicoUtente", function () {
        clickModificaImpostazioni('impostazioni', 'modifica', 'medico', "#medicoCurante", function () {
            $.ajax({
                type: 'GET',
                url: 'users/medico',
                success: function (datiRisposta) {
                    var codiceFiscale = $("#formModificaMedico > input[name='codiceFiscale']").val();
                    var medici = JSON.parse(datiRisposta); // devo controllare che non sia FALS datiRisposta
                    var htmlSelect = "<label class='elementiForm' for='codiceFiscaleMedico'>Codice Fiscale Medico: </label><select id='medicoCuranteSelect' name='codiceFiscaleMedico' class='elementiForm'>";
                    var nome = new Array();
                    var cognome = new Array();
                    var indiceNome;
                    var nomeString = "{\"";
                    var cognomeString = "{\"";
                    $.each(medici, function (indice, medico) {
                        $.each(medico, function (indice, valore) {
                            switch (indice) {
                                case 'CodFiscale':
                                    if (codiceFiscale === valore)
                                    {
                                        htmlSelect += "<option value='" + valore + "' selected>" + valore + "</option>";
                                    } else
                                    {
                                        htmlSelect += "<option value='" + valore + "'>" + valore + "</option>";
                                    }
                                    indiceNome = valore;
                                    break;
                                case 'Nome':
                                    nome[indiceNome] = valore;
                                    nomeString += indiceNome + "\":\"" + valore + "\", \"";

                                    break;
                                case 'Cognome':
                                    cognome[indiceNome] = valore;
                                    cognomeString += indiceNome + "\":\"" + valore + "\", \"";
                                    break;
                                default:

                                    break;
                            }
                        });
                    });
                    nomeString = nomeString.substring(0, nomeString.length - 3) + "}"; // elimino l'ultima virgola, lo spazio, l'apicetto e aggiungo }
                    cognomeString = cognomeString.substring(0, cognomeString.length - 3) + "}";
                    htmlSelect = htmlSelect + "</select><br><input id='medicoUtenteModificato' value='OK' type='button'>";
                    $('#formModificaMedico').replaceWith(htmlSelect);
                    // aggiungo label ed input per visualizzare il nome e il cognome del medico curante scelto.
                    $('#medicoUtenteModificato').before("<label id='labelNomeMedico' for='nomeMedico' class='elementiForm'>Nome Medico :</label><input id='inputNomeMedico' type='text' name='nomeMedico' class='elementiForm' readonly /><br>");
                    $('#medicoUtenteModificato').before("<label id='labelCognomeMedico' for='cognomeMedico' class='elementiForm'>Cognome Medico :</label><input id='inputCognomeMedico'  type='text' name='cognomeMedico' class='elementiForm' readonly  /><br>");
                    // span nascosti dove inserisco i nomi e i cognomi dei medici dell'applicazione
                    $('#medicoUtenteModificato').before("<span id='nomeMedicoCurante'>" + nomeString + "</span>");
                    $('#medicoUtenteModificato').before("<span id='cognomeMedicoCurante'>" + cognomeString + "</span>");
                    $('#nomeMedicoCurante').hide();
                    $('#cognomeMedicoCurante').hide();
                    //recupero il nome e cognome relatico al codice fiscale selezionato e li imposto come valori per gli input.
                    var nomeMedicoSelezionato = nome[codiceFiscale];//recupero il nome relativo al codice fiscale del medico selezionato
                    var cognomeMedicoSelezionato = cognome[codiceFiscale];//recupero il cognome relativo al codice fiscale del medico selezionato
                    $("input[name='nomeMedico']").val(nomeMedicoSelezionato); // imposto il nome del medico selezionato
                    $("input[name='cognomeMedico']").val(cognomeMedicoSelezionato);// imposto il cognome del medico selezionato
                },
                error: function () {}

            });
        });

    });

    // per aggiungere una select con tutti i medici curanti iscritti nell'applicazione 
//    $('#headerMain').on("click", "#formModificaMedico > input[name='codiceFiscale']", function () {
//        $.ajax({
//            type: 'GET',
//            url:  'users/medico',
//            success: function(datiRisposta){
//                var codiceFiscale = $("#formModificaMedico > input[name='codiceFiscale']").val();
//                var medici =  JSON.parse(datiRisposta); // devo controllare che non sia FALS datiRisposta
//                var htmlSelect = "<label class='elementiForm' for='codiceFiscaleMedico'>Codice Fiscale Medico: </label><select id='medicoCuranteSelect' name='codiceFiscaleMedico' class='elementiForm'>";
//                var nome = new Array();
//                var cognome = new Array();
//                var indiceNome;
//                var nomeString = "{\"";
//                var cognomeString = "{\"";
//                $.each(medici, function(indice, medico) {
//                    $.each(medico, function(indice, valore){
//                        switch(indice){
//                            case 'CodFiscale':
//                                if(codiceFiscale === valore)
//                                {
//                                    htmlSelect += "<option value='" + valore + "' selected>" + valore + "</option>";
//                                }
//                                else
//                                {
//                                    htmlSelect += "<option value='" + valore + "'>" + valore + "</option>";
//                                }
//                                indiceNome = valore;
//                                break;
//                            case 'Nome':
//                                nome[indiceNome] = valore;
//                                nomeString  +=  indiceNome + "\":\"" + valore +"\", \"";
//
//                                break;
//                            case 'Cognome':
//                                cognome[indiceNome]= valore;
//                                cognomeString  +=  indiceNome + "\":\"" + valore +"\", \"";
//                                break;
//                            default:
//
//                                break;  
//                            } 
//                    });
//                });
//                nomeString = nomeString.substring(0, nomeString.length-3) + "}"; // elimino l'ultima virgola, lo spazio, l'apicetto e aggiungo }
//                cognomeString = cognomeString.substring(0, cognomeString.length-3) + "}";       
//                htmlSelect = htmlSelect + "</select><br><input id='medicoUtenteModificato' value='OK' type='button'>";
//                $('#formModificaMedico').replaceWith(htmlSelect); 
//                // aggiungo label ed input per visualizzare il nome e il cognome del medico curante scelto.
//                $('#medicoUtenteModificato').before("<label id='labelNomeMedico' for='nomeMedico' class='elementiForm'>Nome Medico :</label><input id='inputNomeMedico' type='text' name='nomeMedico' class='elementiForm' readonly /><br>");
//                $('#medicoUtenteModificato').before("<label id='labelCognomeMedico' for='cognomeMedico' class='elementiForm'>Cognome Medico :</label><input id='inputCognomeMedico'  type='text' name='cognomeMedico' class='elementiForm' readonly  /><br>");  
//                // span nascosti dove inserisco i nomi e i cognomi dei medici dell'applicazione
//                $('#medicoUtenteModificato').before("<span id='nomeMedicoCurante'>" + nomeString + "</span>");
//                $('#medicoUtenteModificato').before("<span id='cognomeMedicoCurante'>" + cognomeString + "</span>");
//                $('#nomeMedicoCurante').hide();
//                $('#cognomeMedicoCurante').hide();
//                //recupero il nome e cognome relatico al codice fiscale selezionato e li imposto come valori per gli input.
//                var nomeMedicoSelezionato = nome[codiceFiscale];//recupero il nome relativo al codice fiscale del medico selezionato
//                var cognomeMedicoSelezionato = cognome[codiceFiscale];//recupero il cognome relativo al codice fiscale del medico selezionato
//                $("input[name='nomeMedico']").val(nomeMedicoSelezionato); // imposto il nome del medico selezionato
//                $("input[name='cognomeMedico']").val(cognomeMedicoSelezionato);// imposto il cognome del medico selezionato
//            },
//            error:function(){}
//            
//        });
//    });


    // per la modifica del medico curante in utente
    $('#headerMain').on("click", "#medicoUtenteModificato", function () {
//        inviaDatiModificaImpostazioni('impostazioni', 'modifica', 'medico', "#contenutoAreaPersonale");
        var codiceFiscaleMedico = $("#medicoCuranteSelect option:selected").val();
        var dati = {codiceFiscale: codiceFiscaleMedico};
        $.ajax({
            type: 'POST',
            url: 'impostazioni/modifica/medico',
            data: dati,
            success: function (datiRisposta)
            {
                try {
                    $.parseJSON(datiRisposta);
                    $('#messaggioDialogBox').empty();
                    $('#messaggioDialogBox').text('Errore. Medico NON modificato!');
                    dialogBox(); //in eventi_click.js
                } catch (error) {// non è json
                    $('#contenutoAreaPersonale').html(datiRisposta);
                    $('#messaggioDialogBox').empty();
                    $('#messaggioDialogBox').text('Medico modificato con successo!');
                    dialogBox(); //in eventi_click.js
                }
            }
        });

    });


    // per aggiungere un medico in impostazioni utente
    $('#headerMain').on("click", "#aggiungiMedicoUtente", function () {
        clickModificaImpostazioni('impostazioni', 'aggiungi', 'medico', "#medicoCurante");
    });



    // quando cambia il codice fiscale del medico, cambiano anche i valori di nome e cognome del medico
    $('#headerMain').on("change", "#medicoCuranteSelect", function () {
        var cfMedico = $("#medicoCuranteSelect option:selected").val(); // recupero il codice fiscale selezionato
        var nomeMedici = $('#nomeMedicoCurante').text(); // recupero i nomi dei medici dallo span nascosto
        var cognomeMedici = $('#cognomeMedicoCurante').text();// recupero i cognomi dei medici dallo span nascosto
        var nome = JSON.parse(nomeMedici); // rendo array la stringa JSON
        var cognome = JSON.parse(cognomeMedici);// rendo array la stringa JSON
        var nomeMedico = nome[cfMedico]; // trovo il nome relativo al codice fiscale selezionato dall'utente
        var cognomeMedico = cognome[cfMedico];// trovo il cognome relativo al codice fiscale selezionato dall'utente
        $("input[name='nomeMedico']").val(nomeMedico); // imposto il nome relativo al codice fiscale selezionato
        $("input[name='cognomeMedico']").val(cognomeMedico);// imposto il cognome relativo al codice fiscale selezionato

    });


    $('#headerMain').on("click", "#salvaMedicoCurante", function () {
        var codice = $("#medicoCuranteSelect option:selected").val();
        var datiPOST = {codice: codice};
        $.ajax({
            type: 'POST',
            url: 'impostazioni/aggiungi/medico',
            data: datiPOST,
            success: function (datiRisposta)
            {
                try {
                    $.parseJSON(datiRisposta);
                    $('#messaggioDialogBox').text('Errore!');
                } catch (error) {// non è json
                    $('#contenutoAreaPersonale').html(datiRisposta);
                    $('#messaggioDialogBox').empty();
                    $('#messaggioDialogBox').text('Medico aggiunto con successo!');
                    dialogBox(); //in eventi_click.js
                }
            }
        });
    });


    $('#headerMain').on("click", "#modificaPassword", function () {
        clickModificaImpostazioni('impostazioni', 'modifica', 'credenziali', "#credenziali");
    });

    $('#headerMain').on("click", "#condividiRefertoButton", function () {
        var idPrenotazione = $('#condividiRefertoButton').attr('data-idPrenotazione');

        $('#infoReferto').append(" <input type='button' id='condividiRefertoUtenteButton'  value='Condividi con Utente' data-idPrenotazione='" + idPrenotazione + "' />");
        $('#condividiRefertoButton').remove();
    });

    $('#headerMain').on("change", "#refertoCondivisoConMedico", function () {
        var idPrenotazione = $('#scaricaRefertoButton2').attr('data-idPrenotazione');
        var condividiConMedico = false;
        if ($(this).is(':checked'))
        {
            condividiConMedico = true;
        }
        var datiPOST = {id: idPrenotazione, condividiConMedico: condividiConMedico};
        inviaControllerTaskPOST('referto', 'condividi', datiPOST, '#contenutoAreaPersonale');

    });




//    $('#headerMain').on("click", "#modificaIndirizzoUtenteFatto", function(){
//        
//    });

//     $('#headerMain').on("click", "#medicoUtenteModificato", function(){
//        inviaDatiModificaImpostazioni('impostazioni', 'modifica', 'medico', "#medicoCurante");
//    });

//    $('#headerMain').on("click", "inviaNuovaPasswordUtente", function(){
//        inviaDatiModificaImpostazioni('impostazioni', 'modifica', 'credenziali', "#credenziali");
//    });

});

/**
 * Funzione che permette di inviare i dati per modificare le impostazioni di un user dell'applicazione.
 * 
 * @public
 * @param {string} controller Il controller dell'url
 * @param {string} task Il task dell'url
 * @param {strin} task2 Il secondo task dell'url
 * @param {string} ajaxdiv L'id del div in cui inserire la risposta AJAX
 * @return {HTML+JS|JSON+JS}
 */
function inviaDatiModificaImpostazioni(controller, task, task2, ajaxdiv)
{
    var dati = $("div.daModificare > form").serialize();
    $.ajax({
        type: 'POST',
        url: controller + '/' + task + '/' + task2,
        data: dati,
        success: function (datiRisposta)
        {
            try {
                $.parseJSON(datiRisposta);
                $('#messaggioDialogBox').text('Errore!');
                dialogBox(); //in eventi_click.js
            } catch (error) {// non è json
                $(ajaxdiv).html(datiRisposta);
                $('#messaggioDialogBox').empty();
                switch (task2)
                {
                    case 'credenziali':
                        $('#messaggioDialogBox').text('Credenziali modificate con successo!');
                        break;

                    case 'medico':
                        $('#messaggioDialogBox').text('Medico modificato con successo!');
                        break;

                    case 'alboNum':
                        $('#messaggioDialogBox').text('Provincia Albo e Numero Iscrizione Albo modificati con successo!');
                        break;

                    case 'informazioni':
                        $('#messaggioDialogBox').text('Informazioni modificate con successo!');
                        //                    $('#modificaIndirizzoUtenteFatto').remove();// elimino il tasto OK
                        //                    $(".daModificare").append("<input type='button' id='modificaIndirizzoUtente' value='Modifica Indirizzo' />");//inserisco il tasto della modifica
                        break;

                    default:
                        break;

                }
                dialogBox(); //in eventi_click.js
            }
        }
    });
}


function confermaPrenotazioneUtente(controller, task, id, ajaxDiv)
{
    $.ajax({
        type: 'GET',
        url: controller + '/' + task + '/' + id,
//        dataType:JSON,
        success: function (datiRisposta)
        {
            datiRisposta = JSON.parse(datiRisposta);
            if (datiRisposta === true)
            {
                $('#divConfermaPrenotazioneUtente').empty();// svuoto il div 
                $('#divConfermaPrenotazioneUtente').text('Prenotazione: Confermata');// aggiungo il testo Confermata al div

            }
//            $(ajaxDiv).html(datiRisposta);

        }
    });
}