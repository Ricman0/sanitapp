
/*
 * Quando il DOM è pronto, mando in run questa funzione.
 * Tale funzione si pone in attesa di un evento click sull'elemento con 
 * id = registrazione.
 * Quando avviene il click su registrazione, viene eseguita la funzione inviaControllerTask
 */
$(document).ready(function () {

    $("#registrazioneUtente").click(function () {
        inviaControllerTask('registrazione', 'utente', '#main');
    });

    $("#registrazioneMedico").click(function () {
        inviaControllerTask('registrazione', 'medico', '#main');
    });

    $("#registrazioneClinica").click(function () {
        inviaControllerTask('registrazione', 'clinica', '#main');
    });
    
    $('#main').on("click", "#mySanitApp", function(){
        inviaController('mySanitApp', "#contenutoAreaPersonale");
    });
});


function inviaController(controller1, ajaxdiv)
{
    $.ajax({
        // definisco il tipo della chiamata
        type: 'GET',
        // specifico la URL della risorsa 
        url: controller1 + '/' ,

        // imposto azione per il caso di successo
        success: function (datiRisposta)
        {
            alert(datiRisposta);
            $(ajaxdiv).html(datiRisposta);
        }
    });
}


function clickRiga(controller1, task1, id, ajaxdiv)
{
    $.ajax({
        // definisco il tipo della chiamata
        type: 'GET',
        // specifico la URL della risorsa 
        url: controller1 + '/' + task1 + '/' + id,

        // imposto azione per il caso di successo
        success: function (datiRisposta)
        {
            alert(datiRisposta);
            $(ajaxdiv).html(datiRisposta);
        }
    });
}


/*
 * 
 * @param string controller
 * @param string task1
 * @param string ajaxdiv
 * @returns {undefined}
 */
function inviaControllerTask(controller1, task1, ajaxdiv)
{
    $.ajax({
        // definisco il tipo della chiamata
        type: 'GET',
        // specifico la URL della risorsa 
        url: controller1 + '/' + task1,
//        data:{
//            controller:controller1, 
//            task: task1
//            
//        },

        // imposto azione per il caso di successo
        success: function (datiRisposta)
        {
            alert(datiRisposta);
            $(ajaxdiv).html(datiRisposta);
            $(".tablesorter").tablesorter();
            

            $('#durataEsame').timepicker({
                'timeFormat': 'H:i:s',
                'step': 15,
                'maxTime': '06:00:00'

            });

        },
        complete:function()
        {
            //la funzione validazione si trova in validazioneDati.js
            validazione(task1);
        }
    });
}

function inviaDatiRegistrazione(id, controller1, task1, ajaxdiv)
{

    //recupera tutti i valori del form automaticamente
    var dati = $(id).serialize();
    alert(dati);
   
    
    $.ajax({
        type: "POST",
        url: controller1 + "/" + task1,
        data: dati,
        dataType: "html",
        success: function (msg)
        {
            alert("Chiamata eseguita");
            $(ajaxdiv).html(msg);
        },
        error: function ()
        {
            alert("Chiamata fallita, si prega di riprovare...");
        }
    });
}

