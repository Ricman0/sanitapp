//$(document).ready(function () {
//    //fissa un gestore di submit al form
//
//    $('#headerMain').on("click", '#submitRegistrazioneUtente', function () {
//        inviaDatiRegistrazione('#inserisciUtente', 'registrazione', 'utente', '#main');
//    });
//
//    $('#headerMain').on("click", '#submitRegistrazioneMedico', function () {
//        inviaDatiRegistrazione('#inserisciMedico', 'registrazione', 'medico', '#main');
//    });
//
//    $('#headerMain').on("click", '#submitRegistrazioneClinica', function () {
//        inviaDatiRegistrazione('#inserisciClinica', 'registrazione', 'clinica', '#main');
//    });
//
//});


//function inviaDatiRegistrazione(id, controller1, task1, ajaxdiv)
//{
//
//    //recupera tutti i valori del form automaticamente
//    var dati = $(id).serialize();
//    alert(dati);
//    
//    $.ajax({
//        type: "POST",
//        url: controller1 + "/" + task1,
//        data: dati,
//        dataType: "html",
//        success: function (msg)
//        {
//            alert("Chiamata eseguita");
//            $(ajaxdiv).html(msg);
//        },
//        error: function ()
//        {
//            alert("Chiamata fallita, si prega di riprovare...");
//        }
//    });
//}