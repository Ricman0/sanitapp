function validazione(task1, controller1, task2)
{
    switch (task1)
    {
        
        case "utente":
            validazioneUtente();
            break;

        case "medico":
            validazioneMedico();
            break;

        case "clinica":
            if (controller1 === "impostazioni")
            {
                validazioneImpostazioniClinica();
            } else
            {
                validazioneClinica();
            }
            break;

        case "autenticazione":
            validazioneLogIn(controller1);
            break;

        case "aggiungi":
            switch(controller1)
            {
                case 'prenotazioni':
                    validazioneCodiceFiscale();
                    break;
                    
                case 'pazienti':
                    validazioneUtente();
                    break;
                
                default:
                    validazioneEsame();
                    break;
            }
            break;

        case 'modifica':
            switch (task2)
            {

                case 'informazioni':
                    validazioneInformazioni();
                    break;
                case 'credenziali':
                    validazioneCredenziali();
                    break;
                case 'medico':
                    validazioneCodiceFiscaleMedicoCurante();
                    break;
                default:
                    break;
            }




        default:
            break;
    }
}

function validazioneCredenziali()
{
    //

    jQuery.validator.addMethod("password", function (valore) {
        //espressione regolare per la password
        var regex = /(((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])).{6,10})/;
        return valore.match(regex);
    }, "Da 6 a 10 caratteri con un numero ed una lettera \n\
        maiuscola. ");

    $('#formModificaPassword').validate({
        rules:
                {
                    password:
                            {
                                required: true,
                                password: true
                            },
                    ripetiPassword:
                            {
                                required: true,
                                equalTo: "#nuovaPassword"
                            }
                },
        messages:
                {
                    password:
                            {
                                required: "Inserire password"
                            },
                    ripetiPassword:
                            {
                                required: "Inserire nuovamente la password",
                                equalTo: "Le password non corrispondono"
                            }
                },
        submitHandler: function ()
        {

            inviaDatiModificaImpostazioni('impostazioni', 'modifica', 'credenziali', "#contenutoAreaPersonale");
        }
    });
}

function validazioneInformazioni()
{
    $('#formModificaInformazioni').validate({
        rules:
                {
                    Via:
                            {
                                required: true,
                                maxlength: 30
                            },
                    NumCivico:
                            {
                                number: true,
                                min: 0
                            },
                    CAP:
                            {
                                required: true,
                                minlength: 5,
                                maxlength: 5
                            }
                },
        messages:
                {
                    Via:
                            {
                                required: "Inserire indirizzo",
                                maxlength: "La lunghezza massima è 30"
                            },
                    NumCivico:
                            {
                                number: "Il numero civico è un numero",
                                min: "Inserire un numero maggiore o uguale a zero"
                            },
                    CAP:
                            {
                                required: "Inserire il CAP",
                                minlength: "Il CAP è un numero lungo 5",
                                maxlength: "Il CAP è un numero lungo 5"
                            }
                },
        submitHandler: function ()
        {
            inviaDatiModificaImpostazioni('impostazioni', 'modifica', 'informazioni', "#contenutoAreaPersonale");

        }
    });
}

function validazioneCodiceFiscaleMedicoCurante()
{
    jQuery.validator.addMethod("codiceFiscale", function (valore) {
        //espressione regolare per codice fiscale
        var regex = /[A-Z]{6}[0-9]{2}[A-Z]{1}[0-9]{2}[A-Z]{1}[0-9]{3}[A-Z]{1}/;
        return valore.match(regex);
    }, "Il codice fiscale deve essere del tipo DMRCLD89S42G438S");
    
    $("#formModificaMedico").validate({
        /*
         * Il plugin di default invia una richiesta ajax  per la regola remote
         * ogni volta che rilasciamo un tasto (key up) causando molte richieste ajax.
         * Per cui per disattivare questà funzionalità imposto onkeyup:false. 
         * in questo modo l'input che richiama la regola remote sarà validata con una sola chiamata ajax
         * una volta che abbiamo terminato di digitare l'input.
         */
        onkeyup: false,
        rules:
                {
                    codiceFiscale:
                            {
                                required: true,
                                codiceFiscale: true,
                                maxlength: 16,
                                minlength: 16,
                                remote:
                                        {
                                            type: "POST",
                                            url: "ricerca/codice/medico",
                                            data: {inverti: $('#inverti').val()}
                                        }
                            }
                },
        messages:
                {
                    
                    codiceFiscale:
                            {
                                required: "Inserire il proprio codice fiscale",
                                maxlength: "Il codice fiscale è lungo 16 caratteri",
                                minlength: "Il codice fiscale è lungo 16 caratteri",
                                remote: "Medico non esistente in Sanitapp"
                            }
                },
        submitHandler: function ()
        {
            inviaDatiModificaImpostazioni('impostazioni', 'modifica', 'medico', "#contenutoAreaPersonale");

        }
    });
}
    
function validazioneCodiceFiscale()
{
    jQuery.validator.addMethod("codiceFiscale", function (valore) {
        //espressione regolare per codice fiscale
        var regex = /[A-Z]{6}[0-9]{2}[A-Z]{1}[0-9]{2}[A-Z]{1}[0-9]{3}[A-Z]{1}/;
        return valore.match(regex);
    }, "Il codice fiscale deve essee del tipo DMRCLD89S42G438S");
    $("#ricercaUtente").validate({
        rules:
                {
                    codiceFiscaleRicercaUtente:
                            {
                                required: true,
                                codiceFiscale: true,
                                maxlength: 16,
                                minlength: 16,
                                remote:
                                        {
                                            type: "POST",
                                            url: "ricerca/utente"
                                        }
                            }

                },
        messages:
                {
                    codiceFiscaleRicercaUtente:
                            {
                                required: "Inserire il codice fiscale",
                                maxlength: "Il codice fiscale è lungo 16 caratteri",
                                minlength: "Il codice fiscale è lungo 16 caratteri",
                                remote: "Utente non esistente, inserire un codice fiscale di un utente già registrato"
                            }
                },
        submitHandler: function ()
        {

            var codiceFiscale = $("form input[type='text']").val();
            var nomeClinica = $("form input[type='submit']").attr('data-nomeClinica');
            if (typeof (nomeClinica) !== 'undefined')
            {
                $.ajax({
                    type: 'GET',
                    url: 'esami/all/' + nomeClinica,
                    success: function (datiRisposta)
                    {
                        $("#contenutoAreaPersonale").html(datiRisposta);
//                        //aggiungo il campo nascosto codice fiscale 
                        $('<input>').attr({
                            type: 'hidden',
                            id: 'codiceFiscaleUtentePrenotaEsame',
                            name: 'codiceFiscaleUtentePrenotaEsame',
                            value: codiceFiscale
                        }).appendTo('table');
//                        
                        $('.tablesorter').tablesorter({
                            theme: 'blue',
                            widgets: ["filter"],
                            widgetOptions: {
                                // filter_anyMatch replaced! Instead use the filter_external option
                                // Set to use a jQuery selector (or jQuery object) pointing to the
                                // external filter (column specific or any match)
                                filter_external: '.search',
                                // add a default type search to the first name column
                                filter_defaultFilter: {1: '~{query}'},
                                // include column filters
                                filter_columnFilters: true,
                                filter_placeholder: {search: 'Search...'},
                                filter_saveFilters: true,
                                filter_reset: '.reset'
                            }
                        });

                    }
                });
            } else
            {
                $('#nextPrenotazioneEsame').attr('data-codiceFiscale', codiceFiscale); //aggiungo il codice fiscale al button nex in prenotazione/esame/idEsame
                $("p").show();
                var partitaIVAClinica = $("#partitaIVAClinicaPrenotazioneEsame").val();
                var giorniNonLavorativi = getGiorniNonLavorativiClinica(partitaIVAClinica);
                $("#calendarioPrenotazioneEsame").datepicker({
                    firstDay: 1,
                    dateFormat: "dd-mm-yy",
                    regional: "it",
                    minDate: 1,
                    beforeShowDay: function (date) {
                        return [disabilitaGiorniNonLavorativi(date, giorniNonLavorativi)];
                    },
                    onSelect: function (dateText, inst) {
                        var data = dateText; //the first parameter of this function
                        $('#nextPrenotazioneEsame').attr('data-data', data);
                        alert(data);

                        var dataObject = $(this).datepicker('getDate'); //the getDate method
                        alert(dataObject);

                        var nomeGiorno = $.datepicker.formatDate('DD', dataObject);
                        nomeGiorno = nomeGiorno.replace('ì','i');
                        alert(nomeGiorno);
//                    var partitaIVAClinica = $("#partitaIVAClinicaPrenotazioneEsame").val();
//                    alert("PartitaIVA: " + partitaIVAClinica);
                        var idEsame = $("#idEsame").val();
                        orariDisponibili(partitaIVAClinica, idEsame, nomeGiorno, data);
                    }});
                $("#nextPrenotazioneEsame").show();
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

function validazioneLogIn(form)
{
    jQuery.validator.addMethod("password", function (valore) {
        //espressione regolare per la password
        var regex = /(((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])).{6,10})/;
        return valore.match(regex);
    }, "La password consta da 6 a 10 caratteri, contiene almeno un numero, una lettera \n\
        maiuscola,una lettera minuscola. ");
    jQuery.validator.addMethod("username", function (valore) {
        //espressione regolare per codice fiscale
        var regex = /[0-9a-zA-Z\_\-]{2,15}/;
        return valore.match(regex);
    }, "L'username contiene solo _ , - , numeri, lettere maiuscole o minuscole");
    $(form).validate({
        rules:
                {
                    usernameLogIn:
                            {
                                required: true,
                                username: true
                            },
                    passwordLogIn:
                            {
                                required: true,
                                password: true
                            }
                },
        messages:
                {
                    usernameLogIn:
                            {
                                required: "Inserire username"
                            },
                    passwordLogIn:
                            {
                                required: "Inserire password"
                            }
                },
        errorPlacement: function (error, element) {
            return true;
        },
        submitHandler: function ()
        {
            alert('I dati log in sono stati inseriti correttamente');
            // inviaDatiRegistrazione si trova in clickRegistrazione.js
            inviaDatiLogIn(form, '#headerMain');

        }
    });
}

/**
 * Metodo che consente la validazione dei dati inseriti da un utente
 * 
 * @public
 */
function validazioneUtente()
{


    //aggiungo un metodo di validazione per poter validare correttamente la password
    // il nome della classe, la funzione per validare e il messaggio in caso di errore
    jQuery.validator.addMethod("password", function (valore) {
        //espressione regolare per la password
        var regex = /(((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])).{6,10})/;
        return valore.match(regex);
    }, "Inserire da 6 a 10 caratteri che contengano almeno un numero, una lettera \n\
        maiuscola,una lettera minuscola");

    jQuery.validator.addMethod("codiceFiscale", function (valore) {
        //espressione regolare per codice fiscale
        var regex = /[A-Z]{6}[0-9]{2}[A-Z]{1}[0-9]{2}[A-Z]{1}[0-9]{3}[A-Z]{1}/;
        return valore.match(regex);
    }, "Il codice fiscale deve essee del tipo DMRCLD89S42G438S");

    jQuery.validator.addMethod("username", function (valore) {
        //espressione regolare per codice fiscale
        var regex = /[0-9a-zA-Z\_\-]{2,15}/;
        return valore.match(regex);
    }, "Può contenere numeri, lettere maiuscole o minuscole");



    $("#inserisciUtente").validate({
        /*
         * Il plugin di default invia una richiesta ajax  per la regola remote
         * ogni volta che rilasciamo un tasto (key up) causando molte richieste ajax.
         * Per cui per disattivare questà funzionalità imposto onkeyup:false. 
         * in questo modo limput che richiama la regola remote sarà validata con una sola chiamata ajax
         * una volta che abbiamo terminato di digitare l'input.
         */
        onkeyup: false, //turn off auto validate whilst typing
//        focusCleanup: true,
        rules:
                {
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
                    codiceFiscale:
                            {
                                required: true,
                                codiceFiscale: true,
                                maxlength: 16,
                                minlength: 16,
                                remote:
                                        {
                                            type: "POST",
                                            url: "ricerca/codice/utente"

                                        }

                            },
                    indirizzo:
                            {
                                required: true,
                                maxlength: 30
                            },
                    numeroCivico:
                            {
                                number: true,
                                min: 0
                            },
                    CAP:
                            {
                                required: true,
                                minlength: 5,
                                maxlength: 5
                            },
                    email:
                            {
                                required: true,
                                email: true,
                                remote:
                                        {
                                            type: 'POST',
                                            url: "ricerca/email"
                                        }
                            },
                    username:
                            {
                                required: true,
                                username: true,
                                minlength: 2,
                                maxlength: 15,
                                remote:
                                        {
                                            type: "POST",
                                            url: "ricerca/username"
                                        }
                            },
                    passwordUtente:
                            {
                                required: true,
                                password: true
                            },
                    ripetiPasswordUtente:
                            {
                                required: true,
                                equalTo: "#passwordUtente"
                            }
                },
        messages:
                {
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
                    codiceFiscale:
                            {
                                required: "Inserire il proprio codice fiscale",
                                maxlength: "Il codice fiscale è lungo 16 caratteri",
                                minlength: "Il codice fiscale è lungo 16 caratteri",
                                remote: "Utente già esistente"
                            },
                    indirizzo:
                            {
                                required: "Inserire indirizzo",
                                maxlength: "La lunghezza massima è 30"
                            },
                    numeroCivico:
                            {
                                number: "Il numero civico è un numero",
                                min: "Inserire un numero maggiore o uguale a zero"
                            },
                    CAP:
                            {
                                required: "Inserire il CAP",
                                minlength: "Il CAP è un numero lungo 5",
                                maxlength: "Il CAP è un numero lungo 5"
                            },
                    email:
                            {
                                required: "Inserire l'email",
                                email: "Inserire un'email valida del tipo mario.rossi@gmail.com",
                                remote: "Email già esistente"
                            },
                    username:
                            {
                                required: "Inserire username",
                                minlength: "La lunghezza minime dello username è 2",
                                maxlength: "La lunghezza massima dello username è 15",
                                remote: "Username già esistente"
                            },
                    passwordUtente:
                            {
                                required: "Inserire password"
                            },
                    ripetiPasswordUtente:
                            {
                                required: "Inserire nuovamente la password",
                                equalTo: "La password deve essere sempre la stessa"
                            }
                },
        submitHandler: function (form)
        {
            alert('I dati sono stati inseriti correttamente');
            // inviaDatiRegistrazione si trova in clickRegistrazione.js
            inviaDatiRegistrazione('#inserisciUtente', 'registrazione', 'utente', '#main');
        }
    });
}

function validazioneMedico()
{
    jQuery.validator.addMethod("password", function (valore) {
        //espressione regolare per la password
        var regex = /(((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])).{6,10})/;
        return valore.match(regex);
    }, "Inserire una password che contenga almeno un numero, una lettera \n\
        maiuscola,una lettera minuscola");

    jQuery.validator.addMethod("codiceFiscale", function (valore) {
        //espressione regolare per codice fiscale
        var regex = /[A-Z]{6}[0-9]{2}[A-Z]{1}[0-9]{2}[A-Z]{1}[0-9]{3}[A-Z]{1}/;
        return valore.match(regex);
    }, "Il codice fiscale deve essee del tipo DMRCLD89S42G438S");

    jQuery.validator.addMethod("username", function (valore) {
        //espressione regolare per codice fiscale
        var regex = /[0-9a-zA-Z\_\-]{2,15}/;
        return valore.match(regex);
    }, "Può contenere numeri, lettere maiuscole o minuscole");

    $("#inserisciMedico").validate({
        /*
         * Il plugin di default invia una richiesta ajax  per la regola remote
         * ogni volta che rilasciamo un tasto (key up) causando molte richieste ajax.
         * Per cui per disattivare questà funzionalità imposto onkeyup:false. 
         * in questo modo limput che richiama la regola remote sarà validata con una sola chiamata ajax
         * una volta che abbiamo terminato di digitare l'input.
         */
        onkeyup: false,
        rules:
                {
                    nomeMedico:
                            {
                                required: true,
                                maxlength: 20

                            },
                    cognomeMedico:
                            {
                                required: true,
                                maxlength: 20
                            },
                    codiceFiscale:
                            {
                                required: true,
                                codiceFiscale: true,
                                maxlength: 16,
                                minlength: 16,
                                remote:
                                        {
                                            type: "POST",
                                            url: "ricerca/codice/medico"
                                        }
                            },
                    indirizzoMedico:
                            {
                                required: true,
                                maxlength: 20
                            },
                    numeroCivicoMedico:
                            {
                                number: true,
                                min: 0
                            },
                    CAPMedico:
                            {
                                required: true,
                                minlength: 5,
                                maxlength: 5
                            },
                    email:
                            {
                                required: true,
                                email: true,
                                remote:
                                        {
                                            type: "POST",
                                            url: "ricerca/email"
                                        }
                            },
                    username:
                            {
                                required: true,
                                username: true,
                                minlength: 2,
                                maxlength: 15,
                                remote:
                                        {
                                            type: "POST",
                                            url: "ricerca/username"
                                        }
                            },
                    passwordMedico:
                            {
                                required: true
                            },
                    ripetiPasswordMedico:
                            {
                                required: true,
                                equalTo: "#passwordMedico"
                            },
                    PECMedico:
                            {
                                required: true,
                                email: true,
                                remote:
                                        {
                                            type: "POST",
                                            url: "ricerca/PEC"
                                        }
                            },
                    provinciaAlbo:
                            {
                                required: true,
                                rangelength: [2, 2]
                            },
                    numeroIscrizione:
                            {
                                required: true,
                                rangelength: [6, 6]
                            }
                },
        messages:
                {
                    nomeMedico:
                            {
                                required: "Inserire nome",
                                maxlength: "La lunghezza massima è 20"
                            },
                    cognomeMedico:
                            {
                                required: "Inserire cognome",
                                maxlength: "La lunghezza massima è 20"
                            },
                    codiceFiscale:
                            {
                                required: "Inserire il proprio codice fiscale",
                                maxlength: "Il codice fiscale è lungo 16 caratteri",
                                minlength: "Il codice fiscale è lungo 16 caratteri",
                                remote: "Medico già esistente"
                            },
                    indirizzoMedico:
                            {
                                required: "Inserire indirizzo",
                                maxlength: "La lunghezza massima è 20"
                            },
                    numeroCivicoMedico:
                            {
                                number: "Il numero civico è un numero",
                                min: "Inserire un numero maggiore o uguale a zero"
                            },
                    CAPMedico:
                            {
                                required: "Inserire il CAP",
                                minlength: "Il CAP è un numero lungo 5 caratteri",
                                maxlength: "Il CAP è un numero lungo 5 caratteri"
                            },
                    email:
                            {
                                required: "Inserire l'email",
                                email: "Inserire un'email valida",
                                remote: "Email già esistente"
                            },
                    username:
                            {
                                required: "Inserire username",
                                minlength: "La lunghezza minima dello username è 2",
                                maxlength: "La lunghezza massima dello username è 15",
                                remote: "Username già esistente"
                            },
                    passwordMedico:
                            {
                                required: "Inserire password"
                            },
                    ripetiPasswordMedico:
                            {
                                required: "Inserire nuovamente la password",
                                equalTo: "La password deve essere sempre la stessa"
                            },
                    PECMedico:
                            {
                                required: "Inserire la PEC",
                                email: "Inserire un'email valida",
                                remote: "PEC già esistente"
                            },
                    provinciaAlbo:
                            {
                                required: "Inserire la provincia dell'albo a cui si è iscritti",
                                maxlength: "Inserire la sigla della provincia"
                            },
                    numeroIscrizione:
                            {
                                required: "Inserire il numero di iscrizione",
                                rangelength: "Deve avere 6 numeri"
                            }
                },
        submitHandler: function (form)
        {
            alert('I dati sono stati inseriti correttamente');
            inviaDatiRegistrazione('#inserisciMedico', 'registrazione', 'medico', '#main');
        }
    });
}

function validazioneClinica()
{
    jQuery.validator.addMethod("password", function (valore) {
        //espressione regolare per la password
        var regex = /(((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])).{6,10})/;
        return valore.match(regex);
    }, "Inserire una password che contenga almeno un numero, una lettera \n\
        maiuscola,una lettera minuscola");

//
//    jQuery.validator.addMethod("orario", function (valore) {
//        //espressione regolare per l'orario
//        var regex = /(([0-1]?[0-9]{1})|([2]{1}[0-3]{1})):([0-5]{1}[0-9]{1})(:([0-5]{1}[0-9]{1}))?/;
//        return  valore.match(regex);
//    }, "Inserire un orario del tipo: 08:30 oppure 08:30:00");

    jQuery.validator.addMethod("patitaIVA", function (valore) {
        //espressione regolare per la partita IVA 
        var regex = /[0-9]{11}/;
        return valore.match(regex);
    }, "La partita IVA deve essere una sequenza di 11 numeri");

    jQuery.validator.addMethod("username", function (valore) {
        //espressione regolare per codice fiscale
        var regex = /[0-9a-zA-Z\_\-]{2,15}/;
        return valore.match(regex);
    }, "Può contenere numeri, lettere maiuscole o minuscole");

    $("#inserisciClinica").validate({
        /*
         * Il plugin di default invia una richiesta ajax  per la regola remote
         * ogni volta che rilasciamo un tasto (key up) causando molte richieste ajax.
         * Per cui per disattivare questà funzionalità imposto onkeyup:false. 
         * in questo modo limput che richiama la regola remote sarà validata con una sola chiamata ajax
         * una volta che abbiamo terminato di digitare l'input.
         */
        onkeyup: false,
        rules:
                {
                    nomeClinica:
                            {
                                required: true,
                                maxlength: 30
                            },
                    titolare:
                            {
                                required: true,
                                maxlength: 50
                            },
                    partitaIVA:
                            {
                                required: true,
                                partitaIVA: true,
                                maxlength: 11,
                                minlength: 11,
                                remote:
                                        {
                                            type: "POST",
                                            url: "ricerca/partitaIVA"
                                        }
                            },
                    indirizzoClinica:
                            {
                                required: true,
                                maxlength: 30
                            },
                    numeroCivicoClinica:
                            {
                                number: true,
                                min: 0
                            },
                    CAPClinica:
                            {
                                required: true,
                                minlength: 5,
                                maxlength: 5
                            },
                    localitàClinica:
                            {
                                required: true,
                                maxlength: 40
                            },
                    provinciaClinica:
                            {
                                required: true,
                                maxlength: 20
                            },
                    email:
                            {
                                required: true,
                                email: true,
                                remote:
                                        {
                                            type: 'POST',
                                            url: 'ricerca/email'
                                        }
                            },
                    PEC:
                            {
                                required: true,
                                email: true,
                                remote:
                                        {
                                            type: "POST",
                                            url: "ricerca/PEC"
                                        }
                            },
                    username:
                            {
                                required: true,
                                username: true,
                                minlength: 2,
                                maxlength: 15,
                                remote:
                                        {
                                            type: "POST",
                                            url: "ricerca/username"
                                        }
                            },
                    passwordClinica:
                            {
                                required: true,
                                password: true
                            },
                    ripetiPasswordClinica:
                            {
                                required: true,
                                equalTo: "#passwordClinica"
                            },
                    telefonoClinica:
                            {
                                required: true,
                                maxlength: 10
                            },
                    capitaleSociale:
                            {
                                required: true,
                                maxlength: 11
                            }
                },
        messages:
                {
                    nomeClinica:
                            {
                                required: "Inserire il nome della clinica",
                                maxlength: "La sequenza di caratteri deve essere massimo 30"
                            },
                    titolare:
                            {
                                required: "Inserire il nome e cognome del titolare",
                                maxlength: "La sequenza di caratteri deve essere massimo 50"
                            },
                    partitaIVA:
                            {
                                required: "Inserire la partita IVA",
                                maxlength: "La sequenza massima di numeri è 11",
                                minlength: "La sequenza minima di numeri è 11",
                                remote: "Partita IVA già esistente"
                            },
                    indirizzoClinica:
                            {
                                required: "Inserire l'indirizzo della clinica",
                                maxlength: "La sequenza massima di numeri è 30"
                            },
                    numeroCivicoClinica:
                            {
                                number: "Deve essere un numero",
                                min: "Inserire un numero maggiore o uguale a zero"
                            },
                    CAPClinica:
                            {
                                required: "Inserire il CAP della clinica",
                                minlength: "La sequenza minima di numeri è 5",
                                maxlength: "La sequenza massima di numeri è 5"
                            },
                    localitàClinica:
                            {
                                required: "Inserire la località della clinica",
                                maxlength: "La sequenza massima di caratteri è 40"
                            },
                    provinciaClinica:
                            {
                                required: "Inserire la provincia della clinica",
                                maxlength: "La sequenza massima di caratteri è 20"
                            },
                    email:
                            {
                                required: "Inserire l'email della clinica",
                                email: "Deve essere un'email",
                                remote: "Email già esistente"
//                                                    
                            },
                    PEC:
                            {
                                required: "Inserire l'indirizzo PEC della clinica",
                                email: "Deve essere un'email",
                                remote: "PEC già esistente"
//                                                     
                            },
                    username:
                            {
                                required: "Inserire username",
                                minlength: "La sequenza alfanumerica minima  è 2",
                                maxlength: "La sequenza alfanumerica massima è 15",
                                remote: "Username già esistente"
                            },
                    passwordClinica:
                            {
                                required: "Inserire password"
                            },
                    ripetiPasswordClinica:
                            {
                                required: "Ripetere password",
                                equalTo: "La password ripetuta deve essere identica alla password appena inserita"
                            },
                    telefonoClinica:
                            {
                                required: "Inserire il telefono",
                                maxlength: "La sequenza massima di numeri è 10"
                            },
                    capitaleSociale:
                            {
                                required: "Inserire il capitale sociale della clinica",
                                maxlength: "La sequenza massima di numeri è 11"
                            }
                },
        submitHandler: function (form)
        {
            alert('I dati sono stati inseriti correttamente');
            inviaDatiRegistrazione('#inserisciClinica', 'registrazione', 'clinica', '#main');
        }
    });
}


function validazioneImpostazioniClinica()
{
    jQuery.validator.addMethod("time", function (valore) {
        //espressione regolare per la durata
        var regex = /([0-2][0-3]):([0-5]\d):([0-5]\d)/;
        return valore.match(regex);
    }, "La durata è nel formato hh:mm:ss");
    $.validator.addClassRules({
        time:
                {
                    required: true,
                    time: true,
                    messages: {required: "Inserire orario"}
                }
    });

    $("workingPlan").validate({
//        messages:
//                {
//                    LunedìStart:
//                            {
//                                required: true,
//                                time: true
//                            },
//                    MartedìStart:
//                            {
//                                required: true,
//                                time: true
//                            },
//                    MercoledìStart:
//                            {
//                                required: true,
//                                time: true
//                            },
//                    GiovedìStart:
//                            {
//                                required: true,
//                                time: true
//                            },
//                    VenerdìStart:
//                            {
//                                required: true,
//                                time: true
//                            },
//                    SabatoStart:
//                            {
//                                required: true,
//                                time: true
//                            },
//                    DomenicaStart:
//                            {
//                                required: true,
//                                time: true
//                            },
//                    LunedìEnd:
//                            {
//                                required: true,
//                                time: true
//                            },
//                    MartedìEnd:
//                            {
//                                required: true,
//                                time: true
//                            },
//                    MercoledìEnd:
//                            {
//                                required: true,
//                                time: true
//                            },
//                    GiovedìEnd:
//                            {
//                                required: true,
//                                time: true
//                            },
//                    VenerdìEnd:
//                            {
//                                required: true
//                            },
//                    SabatoEnd:
//                            {
//                                required: true
//                            },
//                    DomenicaEnd:
//                            {
//                                required: true
//                            } 
//                },
        submitHandler: function (form)
        {
            alert('Impostazioni inserite correttamente');
            // inviaDatiEsame si trova in clickGestisciServizi.js
            inviaImpostazioniClinica('#aggiungiEsame', 'servizi', 'aggiungi', '#main');
        }
    });
}
function validazioneEsame()
{
    jQuery.validator.addMethod("time", function (valore) {
        //espressione regolare per la durata
        var regex = /([0-2][0-3]):([0-5]\d)/;
        return valore.match(regex);
    }, "La durata è nel formato hh:mm");

    $("#aggiungiEsame").validate({
        rules:
                {
                    nomeEsame:
                            {
                                required: true,
                                maxlength: 50
                            },
                    medicoEsame:
                            {
                                required: true,
                                maxlength: 40
                            },
                    categoriaEsame:
                            {
                                required: true,
                                maxlength: 30
                            },
                    prezzoEsame:
                            {
                                number: true,
                                required: true,
                                max: 10000,
                                min: 1

                            },
                    durataEsame:
                            {
                                required: true,
                                time: true
                            },
                    numPrestazioniSimultanee:
                            {
                                required: true,
                                number: true,
                                max: 20,
                                min: 1
                            }
//                    descrizioneEsame:
//                            {
//                                required: true,
//                                maxlenght: 200
//                            }

                },
        messages:
                {
                    nomeEsame:
                            {
                                required: "Inserire nome",
                                maxlength: "La lunghezza massima è 50"
                            },
                    medicoEsame:
                            {
                                required: "Inserire medico",
                                maxlength: "La lunghezza massima è 40"
                            },
                    categoriaEsame:
                            {
                                required: "Inserire la categoria",
                                maxlength: "La lunghezza massima è 30"
                            },
                    prezzoEsame:
                            {
                                number: "Inserire un numero",
                                required: "Inserire il prezzo",
                                max: "Massimo 10000€",
                                min: "Minimo 1"
                            },
                    durataEsame:
                            {
                                required: "Selezionare la durata"
                            },
                    numPrestazioniSimultanee:
                            {
                                required: "Selezionare un numero",
                                number: "Deve essere un numero",
                                min: "Minimo 1",
                                max: "Massimo 20"
                            }
//                    descrizioneEsame:
//                            {
//                                required: "Inserisci una breve descrizione",
//                                maxlenght:"Max 200 caratteri"
//                        
//                            }
                },
        submitHandler: function ()
        {
            alert('I dati sono stati inseriti correttamente');
            // inviaDatiEsame si trova in clickGestisciServizi.js
            inviaDatiEsame('#aggiungiEsame', 'servizi', 'aggiungi', '#main');
        }
    });
}

function validazioneReferto() {

alert('ciao d');

    $("#formUploadReferto").validate({
        rules: {
            referto: {
                required: true,
                accept: "application/pdf"
            }
        },
        messages: {
            referto: {
                required: "selezionare un file",
                accept: "selezionare un file pdf"
            }
        }
//        ,
//        submitHandler: function () {
//            alert('ciao');
//            uploadReferto(); //si trova in click clinica
//        }

    });
}