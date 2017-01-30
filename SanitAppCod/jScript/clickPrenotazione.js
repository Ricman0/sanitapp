
$(document).ready(function (){
    $('#headerMain').on("click", "#aggiungiPrenotazioneButton", function(){
        var id = $("#aggiungiPrenotazioneButton").attr("data-idEsame");
        var codiceFiscale = $("#aggiungiPrenotazioneButton").attr("data-codiceFiscale");
        var ajaxDiv = "#" + $(this).closest('div[id=contenutoAreaPersonale]').prop('id');
        alert(ajaxDiv);
        if(ajaxDiv!=='#contenutoAreaPersonale') // nel caso in cui non esista div con id contenutoAreaPersonale
        {
           ajaxDiv = '#main';
        }
        prenotazione('prenotazione', 'esame', id, codiceFiscale, ajaxDiv); 
    });
    
    $('#headerMain').on("click", "#modificaPrenotazione", function(){
        var idPrenotazione = $("#modificaPrenotazione").attr("data-idPrenotazione");
        $.ajax({
            type: 'GET',
            url : "prenotazione/modifica/" + idPrenotazione ,
            success: function(datiHTMLRisposta)
            {
                alert(datiHTMLRisposta);
                $('#contenutoAreaPersonale').html(datiHTMLRisposta);   
                $('#nextPrenotazioneEsame').attr('data-idPrenotazione', idPrenotazione);
                $("#nextPrenotazioneEsame").prop('value', 'Modifica'); //cambio il testo del bottone versione > 1.6 
                // nascondo il tasto poichè mancano tutte le informazioni necessarie per poter eseguire una prenotazione
                $('#nextPrenotazioneEsame').hide();
                    // prendi il valore dell'input nascosto (in prenotazioneEsame.tpl) partitaIVAClinicaPrenotazioneEsame
                    // e memorizzalo nella variabile partitaIVAClinica
                    var partitaIVAClinica = $("#partitaIVAClinicaPrenotazioneEsame").val();
                    // recupero i giorniNonLavorativi (in formato JSON) dalla clinica  e poi li rendo un oggetto javascript
                    var giorniNonLavorativi = getGiorniNonLavorativiClinica(partitaIVAClinica);
                    // aggiungo il datapicker calendario 
                    $("#calendarioPrenotazioneEsame").datepicker({
                        firstDay:1, //ogni settimana inizia da Lunedì
                        dateFormat: "dd-mm-yy", //formato della data
                        regional: "it", //italia

    //                    beforeShowDay:disabilitaGiorniNonLavorativi
                        beforeShowDay: function (date){
                            return [disabilitaGiorniNonLavorativi(date, giorniNonLavorativi)];
                        },
                        minDate: 1, // la minima data selezionabile ovvero domani

                        /* funzione chiamata quando il datepicker è selezionato. 
                        * La funzione ha come parametri la data (come testo) selezionata  e l'istanza del datepicker
                        */
                        onSelect: function(dateText, inst) { 
                        var data = dateText; //the first parameter of this function
                        //aggiungo la data selezionata nell'attributo data-data del tasto nextPrenotazioneEsame in questo modo ho la data della prenotazione
                        $('#nextPrenotazioneEsame').attr('data-data', data);
    //                    alert(data);//da eliminare

                        // richiamo il metodo getDate() della dataSelezionata del datapicker                     
                        var dataObject = $(this).datepicker( 'getDate' ); //the getDate method
    //                    alert(dataObject);// da eliminare

                        //Formatta la data dataObject in un valore stringa in base al formato specificato come primo parametro. 
                        // in questo caso giorno
                        var nomeGiorno =$.datepicker.formatDate('DD', dataObject);
                        nomeGiorno = nomeGiorno.replace('ì', 'i');
    //                    alert(nomeGiorno);// da eliminare

    //                    alert("PartitaIVA: " + partitaIVAClinica);// da eliminare
                        // prendi il valore dell'input nascosto (in prenotazioneEsame.tpl) idEsame 
                        // e memorizzalo nella variabile idEsame
                        var idEsame = $("#idEsame").val();
                        // cerca le date diposnibili per quella data e quel nome giorno per quell'esame in quella clinica
                        orariDisponibili(partitaIVAClinica, idEsame, nomeGiorno, data);                        

                        }
                    });
                
                

            },
            error:function()
            {
                alert("Sbagliato click prenotaEsame ");
            }
        });
    });

    $('#headerMain').on('click', '.orarioDisponibile', function() {
        $('.orarioSelezionato').removeClass('orarioSelezionato');
        $(this).addClass('orarioSelezionato');
        var orarioSelezionato = $(".orarioSelezionato").text();
        $('#nextPrenotazioneEsame').attr('data-orario', orarioSelezionato);
        $('#nextPrenotazioneEsame').show();
        if(!$('#tornaAreaPersonaleButton').length ) // se non c'è il tasto annulla
        {
            // aggiungo il tasto annulla nel caso in cui l'user ci ripensasse
            $('#nextPrenotazioneEsame').before("<input type='button' class='mySanitApp' id='tornaAreaPersonaleButton'  value='Annulla' />    ");
        }
        
    });
    
    $('#headerMain').on("click", "#nextPrenotazioneEsame", function(){
        var idEsame = $('#nextPrenotazioneEsame').attr('data-idEsame');
        var orarioPrenotazione = $('#nextPrenotazioneEsame').attr('data-orario');
        var dataPrenotazione = $('#nextPrenotazioneEsame').attr('data-data');
        var cfPrenotazione = $('#nextPrenotazioneEsame').attr('data-codiceFiscale');
        var durataEsame = $('#nextPrenotazioneEsame').attr('data-durata');
        var ajaxDiv = "#" + $(this).closest('div[id=contenutoAreaPersonale]').prop('id');
        alert(ajaxDiv);
        if(ajaxDiv!=='#contenutoAreaPersonale') // nel caso in cui non esista div con id contenutoAreaPersonale
        {
           ajaxDiv = '#main';
        }
        var modifica = false;
        var idPrenotazione;
        if($('#nextPrenotazioneEsame').val()==='Modifica')
        {
            modifica = true;
            idPrenotazione = $('#nextPrenotazioneEsame').attr('data-idPrenotazione');
        }
        alert(modifica);
        inviaControllerTaskDati('prenotazione', 'riepilogo',  idEsame , dataPrenotazione, orarioPrenotazione, cfPrenotazione, durataEsame, modifica, ajaxDiv, idPrenotazione);
    });
    
    $('#headerMain').on("click", "#confermaPrenotazione", function(){
        var ajaxDiv = "#" + $(this).closest('div[id=contenutoAreaPersonale]').prop('id');
        alert(ajaxDiv);
        if(ajaxDiv!=='#contenutoAreaPersonale') // nel caso in cui non esista div con id contenutoAreaPersonale
        {
           ajaxDiv = '#main';
        }
        confermaPrenotazione('prenotazione', 'conferma', ajaxDiv);
    });
    
     $('#headerMain').on("click", "#confermaModificaPrenotazione", function(){
        var idPrenotazione = $('#confermaModificaPrenotazione').attr('data-idPrenotazione');
        alert('a');
        alert(idPrenotazione);
        var orarioPrenotazione = $('#orarioPrenotazione').text().trim();
        var dataPrenotazione = $('#dataPrenotazione').text().trim();
        dati ={idPrenotazione : idPrenotazione, orario : orarioPrenotazione, data : dataPrenotazione};
        $.ajax({
            type: 'POST',
            url: 'prenotazione/conferma/modifica',
            data:dati,
            success:function(datiRisposta)
            {
                alert(datiRisposta);
                $('#contenutoAreaPersonale').html(datiRisposta);
            },
            error: function(xhr, status, error) 
            {
                alert(xhr.responseText);
                alert(error);
                alert(" errore nella conferma prenotazione ");
            }
        });
    });
    
    $('#headerMain').on("click", "#cancellaPrenotazione", function(){
        $('#loadingModal').show();
        taskPrenotazione('prenotazione', 'elimina', "#contenutoAreaPersonale");
    });
    
//    $('#headerMain').on("click", "#modificaPrenotazione", function(){
//        taskPrenotazione('prenotazione', 'modifica', "#contenutoAreaPersonale");
//    });

    
    $('#headerMain').on("click", "#prenotazioneEliminata", function(){
        inviaController('mySanitApp', '#main');
    });
});

/**
 * Funzione che consente di effettuare una chimata per modificare
 *  o eliminare (in base al valore assunto da task) una prenotazione
 *  
 * @param string controller 
 * @param string task  
 * @param string ajaxDiv Il div in cui inserire la risposta della chiamata
 * @returns mixed
 */
function taskPrenotazione(controller, task, ajaxDiv)
{
    var idPrenotazione = $('#cancellaPrenotazione').attr('data-idPrenotazione');
    var dati ={id : idPrenotazione};
    $.ajax({
        type: 'POST',
        url: controller + '/' + task,
        data: dati,
        success:function(datiRisposta)
            {
                // comportamento da modificare
                alert(datiRisposta);
                $(ajaxDiv).html(datiRisposta);
            },
            error: function(xhr, status, error) 
            {
                alert(xhr.responseText);
                alert(error);
                alert(status);
                alert(" errore nella eliminazione della prenotazione ");
            },
            complete: function(){
                $('#loadingModal').hide();
            }
    })
}

/**
 * Funzione per confermare la prenotazione. Al termine la prenotazione è stata inserita nel DB 
 * ma la conferma vera e propria c'è se la prenotazione è effettuata da un utente o dalla clinica.
 * Nel caso venga effettuato da un medico per un utente, la prenotazione deve essere ulteriormente confermata
 * 
 * @param string controller il controllere
 * @param string task il task
 * @param string ajaxDiv il div ajax in cui inserire i dati della risposta alla chiamata
 * @returns {undefined}
 */
function confermaPrenotazione(controller, task, ajaxDiv)
{
        var codice = $('#confermaPrenotazione').attr('data-codice');
        var clinica = $('#confermaPrenotazione').attr('data-idClinica');
        var idEsame = $('#confermaPrenotazione').attr('data-idEsame');
        var orarioPrenotazione = $('#orarioPrenotazione').text().trim();
        var dataPrenotazione = $('#dataPrenotazione').text().trim();
        dati ={id : idEsame, orario : orarioPrenotazione, data : dataPrenotazione, clinica : clinica, codice: codice};
        $.ajax({
            type: 'POST',
            url: controller + '/' + task,
            data:dati,
            success:function(datiRisposta)
            {
                alert(datiRisposta);
                $(ajaxDiv).html(datiRisposta);
            },
            error: function(xhr, status, error) 
            {
                alert(xhr.responseText);
                alert(error);
                alert(" errore nella conferma prenotazione ");
            }
        });
}

function inviaControllerTaskDati(controller, task,  idEsame , dataPrenotazione, orarioPrenotazione, cfPrenotazione, durataEsame, modifica, ajaxDiv, idPrenotazione)
{
    
    var dati = "id=" + idEsame + "&data=" + dataPrenotazione +"&orario=" + orarioPrenotazione +"&codice=" + cfPrenotazione + "&durata=" + durataEsame + "&modifica=" + modifica  ;
    if (modifica===true)
     {
        dati =  dati + "&idPrenotazione=" + idPrenotazione;
     }
    $.ajax({
        
        type: 'POST',
        url: controller + '/' + task ,
        data:dati,   
        success: function (datiRisposta)
        {
            alert(datiRisposta);
            $(ajaxDiv).html(datiRisposta);
        },
        error: function(xhr, status, error) 
        {
            alert(xhr.responseText);
            alert(error);
            alert(" errore nel riepilogo ");
        }
    });
}

function prenotazione(controller, task, id, codiceFiscale, ajaxDiv)
{
    $.ajax({
        type: 'GET',
        url : controller + "/" + task + "/" + id ,
        success: function(datiHTMLRisposta)
        {
            alert(datiHTMLRisposta);
            $(ajaxDiv).html(datiHTMLRisposta);            
            if(typeof(codiceFiscale)!=='undefined') // se codiceFiscale è definito vuol dire che siamo una clinica o un utente
            {     
                // aggiungo il codiceFiscale dell'utente di cui voglio effettuare la prenotazione nell'attributo data-codiceFiscale del tasto nextPrenotazioneEsame 
                $('#nextPrenotazioneEsame').attr('data-codiceFiscale', codiceFiscale);
                // nascondo il tasto poichè mancano tutte le informazioni necessarie per poter eseguire una prenotazione
                $('#nextPrenotazioneEsame').hide();
                // prendi il valore dell'input nascosto (in prenotazioneEsame.tpl) partitaIVAClinicaPrenotazioneEsame
                // e memorizzalo nella variabile partitaIVAClinica
                var partitaIVAClinica = $("#partitaIVAClinicaPrenotazioneEsame").val();
                // recupero i giorniNonLavorativi (in formato JSON) dalla clinica  e poi li rendo un oggetto javascript
                var giorniNonLavorativi = getGiorniNonLavorativiClinica(partitaIVAClinica);
                // aggiungo il datapicker calendario 
                $("#calendarioPrenotazioneEsame").datepicker({
                    firstDay:1, //ogni settimana inizia da Lunedì
                    dateFormat: "dd-mm-yy", //formato della data
                    regional: "it", //italia
                    
//                    beforeShowDay:disabilitaGiorniNonLavorativi
                    beforeShowDay: function (date){
                        return [disabilitaGiorniNonLavorativi(date, giorniNonLavorativi)];
                    },
                    minDate: 1, // la minima data selezionabile ovvero domani
                    
                    /* funzione chiamata quando il datepicker è selezionato. 
                    * La funzione ha come parametri la data (come testo) selezionata  e l'istanza del datepicker
                    */
                    onSelect: function(dateText, inst) { 
                    $('#nextPrenotazioneEsame').hide();
                    var data = dateText; //the first parameter of this function
                    //aggiungo la data selezionata nell'attributo data-data del tasto nextPrenotazioneEsame in questo modo ho la data della prenotazione
                    $('#nextPrenotazioneEsame').attr('data-data', data);
//                    alert(data);//da eliminare
                    
                    // richiamo il metodo getDate() della dataSelezionata del datapicker                     
                    var dataObject = $(this).datepicker( 'getDate' ); //the getDate method
//                    alert(dataObject);// da eliminare
                    
                    //Formatta la data dataObject in un valore stringa in base al formato specificato come primo parametro. 
                    // in questo caso giorno
                    var nomeGiorno =$.datepicker.formatDate('DD', dataObject);
                    nomeGiorno = nomeGiorno.replace('ì','i');
//                    alert(nomeGiorno);// da eliminare
                    
//                    alert("PartitaIVA: " + partitaIVAClinica);// da eliminare
                    // prendi il valore dell'input nascosto (in prenotazioneEsame.tpl) idEsame 
                    // e memorizzalo nella variabile idEsame
                    var idEsame = $("#idEsame").val();
                    // cerca le date diposnibili per quella data e quel nome giorno per quell'esame in quella clinica
                    orariDisponibili(partitaIVAClinica, idEsame, nomeGiorno, data);
                    
                    
                    }
                });
            }
            else // se l'user è un medico il codice fiscale dell'utente per cui vuole prenotare non è definito
            {
                $("#nextPrenotazioneEsame").hide();
                $("p").hide();
                $('h3').hide();
                $('span').hide();
                $("#divAggiungiPrenotazione").prepend("<form id='ricercaUtente'></form>");//aggiungo la form 
                $("<label for='codiceFiscaleRicercaUtente' class='elementiForm'>Codice Fiscale</label>").appendTo('#ricercaUtente');
                $('#ricercaUtente').append("<input type='text' name='codiceFiscaleRicercaUtente' id='codiceFiscaleRicercaUtente' class='elementiForm' placeholder='DMRCLD89S42G438S' required />");
                $('#ricercaUtente').append("<br>");
                $('#ricercaUtente').append("<div id='submitDivRicercaUtente' ></div>");
                $('#submitDivRicercaUtente').append("<input type='submit' value='OK' id='submitRicercaUtente' />");
                
                $("#divAggiungiPrenotazione").prepend("<br>");
                $("#divAggiungiPrenotazione").prepend("<span>Ricorda che puoi effettuare la prenotazione solo se l'utente è già registrato in SanitApp</span>");
                $("#divAggiungiPrenotazione").prepend("<br>");
                $("#divAggiungiPrenotazione").prepend("<span>Inserisci il codice fiscale dell'utente per cui vuoi effettuare la prenotazione</span>");
                $("#divAggiungiPrenotazione").prepend("<h4>Aggiungi una prenotazione</h4>");                             
                validazioneCodiceFiscale();
                


            }
            
//             $( "#calendarioPrenotazioneEsame .selector" ).datepicker( "dialog", "15/10/2015" );
           


 
//            $.getJSON({
//                
//            })
//            $("#calendarioPrenotazioneEsame").fullCalendar({
//                header:{
//                    left: '',
//                    center: 'title',
//                    right:'today prev, next, '
//                }
////                events: {
////                url: '/myfeed.php',
////                type: 'POST',
////                data: {
////                    custom_param1: 'something',
////                    custom_param2: 'somethingelse'
////                },
////                error: function() {
////                    alert('there was an error while fetching events!');
////                },
////                color: 'yellow',   // a non-ajax option
////                textColor: 'black' // a non-ajax option
//        }
//
//    });  
        
        },
        error:function()
        {
            alert("Sbagliato click prenotaEsame ");
        }
    });
    
    
}


function disabilitaGiorniNonLavorativi(date, giorniNonLavorativi)
{
    var disabilitato=true; // sarà true se il giorno non sarà disabilitato, false altrimenti
    // memorizzo in giornoData il giorno della data
    var giornoData = date.getDay();
    switch(giornoData) {
        case 1:
           giornoData = 'Lunedi';
           break;
        case 2:
           giornoData = 'Martedi';
           break;
        case 3:
           giornoData = 'Mercoledi';
           break;
        case 4:
           giornoData = 'Giovedi';
           break;
        case 5:
           giornoData = 'Venerdi';
           break;
        case 6:
           giornoData = 'Sabato';
           break;        
        default:
            giornoData = 'Domenica';
            break;
    }
//    var giorniNonLavorativi1 = [1,2];
    $.each(giorniNonLavorativi, function( index, value ) {
        
        if(giornoData===value)
        {
            disabilitato = false; // imposto a false la variabile disabilitato in questo modo la funzione tornerà false e disabiliterà il giorno sul datepicker
            return false; // avendo trovato il giorno da disabilitare, esco dal ciclo each con return false
        }
        
//if(key === giornoData)
//            {
//                alert(giornoData + key );
//                return [false] ; 
//            }
//        else
//            {
//                return[true];
//            }           
        });
        return disabilitato;
}

/**
 * Funzione che consente di ottenere i giorni non lavorativi di una clinica
 * 
 * @param string partitaIVAClinica La partita IVA della clinica di cui cercare i giorni non lavorativi
 * @returns Object 
 */
function getGiorniNonLavorativiClinica(partitaIVAClinica)
{
    var giorniNonLavorativi;
    $.ajax({
        type: 'GET',
        url: 'impostazioni/giorniNonLavorativi/' + partitaIVAClinica,
        async: false,
//        dataType: "json",
        success:function(datiRisposta)
        {        
//            alert(datiRisposta);
            try{
                
                giorniNonLavorativi = JSON.parse(datiRisposta);
                
                
            }
            catch (error)
            {
                $('#contenutoAreaPersonale').empty();
                $('#contenutoAreaPersonale').append("<h4>C'è stato un errore. Se il problema si ripresenta, contatti l'aministratore.</h4><h4>Clicca su ok per tornare alla pagina personale.</h4>\n\
                    <input type='button' class='mySanitApp' id='tornaAreaPersonaleButton'  value='OK' />");
            }
//            alert('ciao');
//            alert(giorniNonLavorativi.toString());
//console.log(giorniNonLavorativi);
        },
        error: function(xhr, status, error) 
        {
            alert(xhr.responseText);
            alert(error);
            alert(" errore nel ricevere i giorni non lavorativi della clinica ");
            
        }
    });
    return giorniNonLavorativi;
    
}

/**
 * Funzione che permette di cercare gli orari disponibili  di un esame (idEsame ) di una clinica (la cui 
 * partita IVA è passata come primo parametro),  per quella data e giorno
 * 
 * @param string partitaIVAClinica La partita IVA della clinica in cui cercare
 * @param string idEsame L'id dell'esame
 * @param string nomeGiorno Il nome del giorno della data(Lunedi, Martedi,...)
 * @param string data La data in cui cercare gli orari
 * @returns json
 */
function orariDisponibili(partitaIVAClinica, idEsame, nomeGiorno, data)
{
    $.ajax({
        type: 'GET',
        url: "prenotazione/" + partitaIVAClinica + "/" + idEsame + "/" + nomeGiorno + "/" + data,
        dataType: "json",
//        contentType: "application/json; charset=utf-8",
        success:function(datiRisposta)
        {
            
            // elimino tutti i nodi figli nel div orariDisponibili
            $("#orariDisponibili").empty();
            
            alert(datiRisposta);
            // converto i dati risposta json in un oggetto javascript
//            var orariDisponibili = $.parseJSON(datiRisposta);
            var i=1;
            var j=1;
            // Object.keys(datiRisposta).length conta il numero di elementi/key in datiRisposta 
            if(Object.keys(datiRisposta).length > 0)// se esiste almeno un elemento in datiRisposta
            {
                // aggiungo il div  id="colonna1"
                $("#orariDisponibili").append('<div id="colonna1" class="colonna"></div>');
                // $.each funzione di un generico iteratore di oggetti e array. 
                // per ogni elementi di datiRisposta coppia chiave Array
                $.each(datiRisposta, function( key, array ) 
                {
                    // per ogni Array di un elemento datiRisposta
                    $.each( array, function( index, value )
                    {       
                        // aggiungo alla colonna i-esima il valore value   
                        $("#colonna" + i).append( '<span class="orarioDisponibile">' + value + '</span> &nbsp');
                        if(Number.isInteger(j/11)) // se j/11 è senza resto quindi un intero
                        {
                            i++; //incrementa i
                            // aggiungi una colonna nel div orariDispoinibili
                            $("#orariDisponibili").append('<div id="colonna' + i + '" class="colonna"></div>');

                        }
                        j++;// incrementa j
                    });
                });
            }
            else // se non ci sono elementi in datiRisposta
            {
                // aggiungo due paragrafi per far capire all'user che non ci sono orari e che deve scegliere un'altra data 
                $("#orariDisponibili").append('<p>Non sono disponibili orari per questa data</p>');
                $("#orariDisponibili").append('<br>');
                $("#orariDisponibili").append("<p>Seleziona un'altra data per poter effettuare la prenotazione</p>");
                
            }


            
            $("#dateDisponibili").html(datiRisposta);
            
        },
        error: function(xhr, status, error) 
        {
            alert(xhr.responseText);
            alert(error);
            alert(" errore nel ricevere gli orari disponibili ");
            $('#contenutoAreaPersonale').empty();
            $('#contenutoAreaPersonale').append("<h4>C'è stato un errore. Se il problema si ripresenta, contatti l'aministratore.</h4><h4>Clicca su ok per tornare alla pagina personale.</h4>\n\
                <input type='button' class='mySanitApp' id='tornaAreaPersonaleButton'  value='OK' />");
        }
    });
}


