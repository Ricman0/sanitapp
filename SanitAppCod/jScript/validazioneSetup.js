$(document).ready(function () {

    validazioneInstallazione();

    $(function () {
        $(document).tooltip({
            items: 'input.error'
        });
    });

    $("#dialog").dialog({
        autoOpen: false,
        resizable: false,
        height: "auto",
        width: 600,
        modal: true,
        dialogClass: "no-close"
    });

});

function validazioneInstallazione() {
    //aggiungo un metodo di validazione per poter validare correttamente la password
    // il nome della classe, la funzione per validare e il messaggio in caso di errore
    jQuery.validator.addMethod("passwordMethod", function (valore) {
        //espressione regolare per la password
        var regex = /(((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])).{6,10})/;
        return valore.match(regex);
    }, "Inserire da 6 a 10 caratteri che contengano almeno un numero, una lettera \n\
        maiuscola,una lettera minuscola");

    jQuery.validator.addMethod("username", function (valore) {
        var regex = /[0-9a-zA-Z\_\-]{4,15}/;
        return valore.match(regex);
    }, "Deve contenere almeno 4 caratteri al massimo 15. Può contenere numeri, lettere maiuscole o minuscole");

    jQuery.validator.addMethod("domainName", function (valore) {
        var regex = /^(?=.{1,255}$)[0-9A-Za-z](?:(?:[0-9A-Za-z]|-){0,61}[0-9A-Za-z])?(?:\.[0-9A-Za-z](?:(?:[0-9A-Za-z]|-){0,61}[0-9A-Za-z])?)*\.?$/;
        return valore.match(regex);
    }, "Inserire un valore valido");

    $("#formInstallazione").validate({
        /*
         * Il plugin di default invia una richiesta ajax  per la regola remote
         * ogni volta che rilasciamo un tasto (key up) causando molte richieste ajax.
         * Per cui per disattivare questà funzionalità imposto onkeyup:false. 
         * in questo modo limput che richiama la regola remote sarà validata con una sola chiamata ajax
         * una volta che abbiamo terminato di digitare l'input.
         */
        onkeyup: false, //turn off auto validate whilst typing
        rules:
                {
                    host:
                            {
                                required: true,
                                domainName: true
                            },
                    userDb:
                            {
                                required: true,
                                username: true
                            },
                    passwordDb:
                            {
                                required: true
                            },
                    confermaPasswordDb:
                            {
                                required: true,
                                equalTo: "#passwordDb"
                            },
                    smtp:
                            {
                                required: true,
                                domainName: true
                            },
                    emailSmtp:
                            {
                                required: true,
                                email: true
                            },
                    passwordEmail:
                            {
                                required: true
                            },
                    nome:
                            {
                                required: true,
                                maxlength: 20
                            },
                    cognome:
                            {
                                required: true,
                                maxlength: 20
                            },
                    emailAdmin:
                            {
                                required: true,
                                email: true
                            },
                    pecAdmin:
                            {
                                required: true,
                                email: true
                            },
                    telefono:
                            {
                                required: true,
                                number: true,
                                maxlength: 10,
                                minlength: 3
                            },
                    username:
                            {
                                required: true,
                                username: true,
                                minlength: 4,
                                maxlength: 15
                            },
                    password:
                            {
                                required: true,
                                passwordMethod: true
                            },
                    confermaPassword:
                            {
                                required: true,
                                equalTo: "#password"
                            }
                },
        messages:
                {
                    host:
                            {
                                required: "Inserire Host Name"
                            },
                    userDb:
                            {
                                required: "Inserire nome User Database"
                            },
                    passwordDb:
                            {
                                required: "Inserire password database"
                            },
                    confermaPasswordDb:
                            {
                                required: "Inserire nuovamente la password",
                                equalTo: "La password non coincide"
                            },
                    smtp:
                            {
                                required: "Inserire server smtp"
                            },
                    emailSmtp:
                            {
                                required: "Inserire e-mail",
                                email: "Inserire una e-mail valida"
                            },
                    passwordEmail:
                            {
                                required: "Inserire Password"
                            },
                    nome:
                            {
                                required: "Inserire nome",
                                maxlength: "La lunghezza massima è 20"
                            },
                    cognome:
                            {
                                required: "Inserire cognome",
                                maxlength: "La lunghezza massima è 20"
                            },
                    emailAdmin:
                            {
                                required: "Inserire l'email",
                                email: "Inserire un'email valida del tipo mario.rossi@gmail.com"
//                                remote: "Email già esistente"
                            },
                    pecAdmin:
                            {
                                required: "Inserire l'email",
                                email: "Inserire un'email valida del tipo mario.rossi@gmail.com"
                            },
                    telefono:
                            {
                                required: "Inserire il numero di telefono",
                                number: "Contiene solo numeri",
                                maxlength: "Massimo 10 cifre",
                                minlength: "Minimo 4 cifre"
                            },
                    username:
                            {
                                required: "Inserire username",
                                minlength: "La lunghezza minime dello username è 4",
                                maxlength: "La lunghezza massima dello username è 15"
//                                remote: "Username già esistente"
                            },
                    password:
                            {
                                required: "Inserire password"
                            },
                    confermaPassword:
                            {
                                required: "Inserire nuovamente la password",
                                equalTo: "La password non coincide"
                            }
                },
        errorPlacement: function (error, element) {
            $(element).attr('title', error.text());
        },
        unhighlight: function (element) {
            $(element).removeAttr('title').removeClass('error');
        },
        submitHandler: function ()
        {
            $('#messaggioDialogBox').empty();
            $('#messaggioDialogBox').text('Installazione...');
            $('#dialog').append("<div id='progressBar'></div>");
            $('#dialog').dialog('option', 'buttons', {}).dialog('open');
            $("#progressBar").progressbar({
                value: false
            });
            inviaDatiInstallazione();
        }
    });
}

function inviaDatiInstallazione() {
    var dati = $('#formInstallazione').serialize();
    $.ajax({
        type: 'POST',
        url: 'installa',
        data: dati,
        success: function (datiRisposta)
        {
            $('#main').html(datiRisposta);
        },
        complete: function () {
            $('#progressBar').progressbar('destroy');
            $('#dialog').dialog('close');
            if ($('#formInstallazione').length) {
                $('#messaggioDialogBox').empty();
                $('#messaggioDialogBox').text('Dati non validi, reinserire i dati!');
                // forse aggiungere un add listener
                $("#dialog").dialog('option', 'buttons', [
                    {
                        text: "OK",
                        click: function () {
                            $(this).dialog("close");
                        }
                    }
                ]);
                $("#dialog").dialog('open');
                validazioneInstallazione();
            }
        }
    });
}