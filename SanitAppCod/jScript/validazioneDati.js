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
            } 
            else
            {
                validazioneClinica();
            }
            break;

        case "autenticazione":
            validazioneLogIn(controller1);
            break;

        case "aggiungi":
            switch (controller1)
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

        case "recuperaPassword":
            validazioneEmail();
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
//                case 'medico':
//                    validazioneCodiceFiscaleMedicoCurante();
//                    break;
                case 'alboNum':
                    validazioneAlboNum();
                    break;
                default:
                    break;
            }
        
        case 'workingPlan':
            validaWorkingPlan();
        break;
            



        default:
            break;
    }
}

/**
 * Funzione che consente di validare il working plan della clinica
 * @return {undefined}
 */
function validaWorkingPlan(){
    $('#workingPlan').validate({
        rules:{
            LunediStart: {
                required : '#Lunedi:checked'
            },
            LunediEnd: {
                required : '#Lunedi:checked'
            },
            MartediStart: {
                required : '#Martedi:checked'
            },
            MartediEnd: {
                required : '#Martedi:checked'
            },
            MercolediStart: {
                required : '#Mercoledi:checked'
            },
            MercolediEnd: {
                required : '#Mercoledi:checked'
            },
            GiovediStart: {
                required : '#Giovedi:checked'
            },
            GiovediEnd: {
                required : '#Giovedi:checked'
            },
            VenerdiStart: {
                required : '#Venerdi:checked'
            },
            VenerdiEnd: {
                required : '#Venerdi:checked'
            },
            SabatoStart: {
                required : '#Sabato:checked'
            },
            SabatoEnd: {
                required : '#Sabato:checked'
            },
            DomenicaStart: {
                required : '#Domenica:checked'
            },
            DomenicaEnd: {
                required : '#Domenica:checked'
            }
        },
        messages:{
            LunediStart: {
                required : 'Inserire campo'
            },
            LunediEnd: {
                required : 'Inserire campo'
            },
            MartediStart: {
                required : 'Inserire campo'
            },
            MartediEnd: {
                required : 'Inserire campo'
            },
            MercolediStart: {
                required : 'Inserire campo'
            },
            MercolediEnd: {
                required : 'Inserire campo'
            },
            GiovediStart: {
                required : 'Inserire campo'
            },
            GiovediEnd: {
                required : 'Inserire campo'
            },
            VenerdiStart: {
                required : 'Inserire campo'
            },
            VenerdiEnd: {
                required : 'Inserire campo'
            },
            SabatoStart: {
                required : 'Inserire campo'
            },
            SabatoEnd: {
                required : 'Inserire campo'
            },
            DomenicaStart: {
                required : 'Inserire campo'
            },
            DomenicaEnd: {
                required : 'Inserire campo'
            }
        
        },
        errorPlacement: function (error, element) {
            $(element).attr('title', error.text());
        },
        unhighlight: function (element) {
            $(element).removeAttr('title').removeClass('error');
        },
        submitHandler: function(){
            inviaImpostazioniClinica('#workingPlan', 'impostazioni', 'clinica', 'workingPlan', "#contenutoAreaPersonale");
        }
        
    });
};
//function validaWorkingPlan()
//{  
////    var LunediBreakStart = $('#LunediBreakStart');
////    var LunediBreakEnd = $('#LunediBreakEnd');
////
////    $.timepicker.datetimeRange(
////            LunediBreakStart,
////            LunediBreakEnd,
////            {
////                    minInterval: (1000*5), // 5 minuti
//////                    dateFormat: 'dd M yy', 
////                    timeFormat: 'HH:mm',
////                    start: {}, // start picker options
////                    end: {} // end picker options					
////            }
////    );
////    
////    var LunediStart = $('#LunediStart');
////    var LunediEnd = $('#LunediEnd');
////
////    $.timepicker.datetimeRange(
////            LunediStart,
////            LunediEnd,
////            {
////                    minInterval: (1000*5), // 5 minuti
////                    dateFormat: 'dd M yy', 
////                    timeFormat: 'HH:mm',
////                    start: {}, // start picker options
////                    end: {} // end picker options					
////            }
////    );
//    //jQuery.validator.addMethod(nomeMetodo, funzione, messaggio);
//    //funzione ritorna true se un elemento è valido. First argument: Current value. Second argument: Validated element. Third argument: Parameters.
//    //funzione(valore, elemento, parametri) // valore (di tipo string) =valore corrente del ; elemento = elemento da validare; parametri
////    value/valore
////    Type: String
////    the current value of the validated element
////    element
////    Type: Element
////    the element to be validated
////    params
////    Type: Object
////    parameters specified for the method, e.g. for min: 5, the parameter is 5, for range: [1, 5] it's [1, 5]
////    jQuery.validator.addMethod("greaterThan", 
////        function(valore, elemento, params) {
////            if(valore ==='' && $(params).val() ==='')
////            {
////                $(this).removeAttr('title').removeClass('error');
////                return true;
////            }
////            if($(params).val() !=='')
////            {
////                valore = '2017-01-27 ' + valore;
////                var valore2 = '2017-01-27 ' + $(params).val();
////                if (!/Invalid|NaN/.test(new Date(valore))) {
////                    if(new Date(valore) > new Date(valore2))
////                    {
////                        $(this).removeAttr('title').removeClass('error');
////                        return true;
////                    }
////                    else
////                    {
////                        return false;
////                    }
////                }
////            }
////            else
////            {
////                if(isNaN(valore) || Number(valore))
////                {
////                    return false;
////                }
////                else
////                {
////                    $(this).removeAttr('title').removeClass('error');
////                    return true;
////                }
////            }
////            
////        },'Deve essere maggiore di {0}.');
////        
////        jQuery.validator.addMethod("lessThan", 
////        function(valore, elemento, params) {
////            if(valore ==='' && $(params).val() ==='')
////            {
////                $(this).removeAttr('title').removeClass('error');
////                return true;
////            }
////            if($(params).val() !=='')
////            {
////                valore = '2017-01-27 ' + valore;
////                var valore2 = '2017-01-27 ' + $(params).val();
////                if (!/Invalid|NaN/.test(new Date(valore))) {
////                    if(new Date(valore) < new Date(valore2))
////                    {
////                        $(this).removeAttr('title').removeClass('error');
////                        return true;
////                    }
////                    else
////                    {
////                        return false;
////                    }
////                }
////            }
////            else
////            {
////                if(isNaN(valore) || Number(valore))
////                {
////                    return false;
////                }
////                else
////                {
////                    $(this).removeAttr('title').removeClass('error');
////                    return true;
////                }
////            }
////            
////        },'Deve essere minore di {0}.');
//
//    $('#workingPlan').validate({
////        rules:
////                {
////                    LunediEnd:
////                            {
////                                greaterThan: '#LunediStart'
////                            },
////                    MartediEnd:
////                            {
////                                greaterThan: '#MartediStart'
////                            },
////                    MercolediEnd:
////                            {
////                                greaterThan: '#MercolediStart'
////                            },
////                    GiovediEnd:
////                            {
////                                greaterThan: '#GiovediStart'
////                            },
////                    VenerdiEnd:
////                            {
////                                greaterThan: '#VenerdiStart'
////                            },
////                    SabatoEnd:
////                            {
////                                greaterThan: '#SabatoStart'
////                            },
////                    DomenicaEnd:
////                            {
////                                greaterThan: '#DomenicaStart'
////                            },
//////                    LunediBreakStart:
//////                            {
//////                                greaterThan: '#LunediStart'
//////                            },
//////                    MartediBreakStart:
//////                            {
//////                                greaterThan: '#MartediStart'
//////                            },
//////                    MercolediBreakStart:
//////                            {
//////                                greaterThan: '#MercolediStart'
//////                            },
//////                    GiovediBreakStart:
//////                            {
//////                                greaterThan: '#GiovediStart'
//////                            },
//////                    VenerdiBreakStart:
//////                            {
//////                                greaterThan: '#VenerdiStart'
//////                            },
//////                    SabatoBreakStart:
//////                            {
//////                                greaterThan: '#SabatoStart'
//////                            },
//////                    DomenicaBreakStart:
//////                            {
//////                                greaterThan: '#DomenicaBreakStart'
//////                            },
//////                    LunediBreakEnd:
//////                            {
//////                                greaterThan: '#LunediBreakStart'
//////                            },
//////                    MartediBreakEnd:
//////                            {
//////                                greaterThan: '#MartediBreakStart'
//////                            },
//////                    MercolediBreakEnd:
//////                            {
//////                                greaterThan: '#MercolediBreakStart'
//////                            },
//////                    GiovediBreakEnd:
//////                            {
//////                                greaterThan: '#GiovediBreakStart'
//////                            },
//////                    VenerdiBreakEnd:
//////                            {
//////                                greaterThan: '#VenerdiBreakStart'
//////                            },
//////                    SabatoBreakEnd:
////                            {
////                                greaterThan: '#SabatoBreakStart'
////                            },
////                    DomenicaBreakEnd:
////                            {
////                                greaterThan: '#DomenicaBreakStart'
////                            }
////                },
//        
////        errorPlacement: function (error, element) {
////            $(element).attr('title', error.text());
////        },
////        unhighlight: function (element) {
////            $(element).removeAttr('title').removeClass('error');
////        },
//        submitHandler: function ()
//        {
//            inviaImpostazioniClinica('#workingPlan', 'impostazioni', 'clinica', 'workingPlan', "#contenutoAreaPersonale");
//        }
//    });
//}


/**
 * Funzione che consente di validare le credenziali e effettua la chiamata AJAX per salvare le nuove credenziali.
 * Tale chiamata verrà effettuata solo se la validazione lato client risulta valida.
 * 
 * @return {undefined} 
 */
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
                                password: true,
                                maxlength: 10
                            },
                    ripetiPassword:
                            {
                                required: true,
                                maxlength: 10,
                                equalTo: "#nuovaPassword"
                            }
                },
        messages:
                {
                    password:
                            {
                                required: "Inserire password",
                                maxlength: "Massimo 10 caratteri"
                            },
                    ripetiPassword:
                            {
                                required: "Inserire nuovamente la password",
                                maxlength: "Massimo 10 caratteri",
                                equalTo: "Le password non corrispondono"
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
            inviaDatiModificaImpostazioni('impostazioni', 'modifica', 'credenziali', "#contenutoAreaPersonale");
        }
    });
}

function validazioneInformazioni()
{
    if ($('#formModificaInformazioni').length) // esiste formModificaInformazioni
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
            errorPlacement: function (error, element) {
                $(element).attr('title', error.text());
            },
            unhighlight: function (element) {
                $(element).removeAttr('title').removeClass('error');
            },
            submitHandler: function ()
            {
                inviaDatiModificaImpostazioni('impostazioni', 'modifica', 'informazioni', "#contenutoAreaPersonale");

            }
        });
    }
    else
    {
        $('#formModificaInformazioniClinica').validate({
            rules:
                    {
                        titolare:
                                {
                                    required: true,
                                    maxlength: 50
                                },
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
                                },
                        localitaClinica:
                                {
                                    required: true,
                                    maxlength: 40
                                },
                        provinciaClinica:
                                {
                                    required: true,
                                    maxlength: 22
                                },
                        telefono:
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
                        titolare:
                                {
                                    required: "Inserire il nome e cognome del titolare",
                                    maxlength: "La sequenza di caratteri deve essere massimo 50"
                                },
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
                                },
                        localitaClinica:
                                {
                                    required: "Inserire la localita della clinica",
                                    maxlength: "La sequenza massima di caratteri è 40"
                                },
                        provinciaClinica:
                                {
                                    required: "Inserire la provincia della clinica",
                                    maxlength: "La sequenza massima di caratteri è 22"
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
            errorPlacement: function (error, element) {
                $(element).attr('title', error.text());
            },
            unhighlight: function (element) {
                $(element).removeAttr('title').removeClass('error');
            },
            submitHandler: function ()
            {
                inviaDatiModificaImpostazioni('impostazioni', 'modifica', 'informazioni', "#contenutoAreaPersonale");

            }
        });
    }
}

function validazioneAlboNum()
{
    $("#formModificaAlboNum").validate({
        rules:
                {
                    provinciaAlbo:
                            {
                                required: true,
                                maxlength: 22
                            },
                    numeroIscrizione:
                            {
                                required: true,
                                rangelength: [6, 6]
                            }
                },
        messages:
                {
                    provinciaAlbo:
                            {
                                required: 'richiesto',
                                maxlength: 'massimo 22 caratteri'
                            },
                    numeroIscrizione:
                            {
                                required: 'richiesto',
                                rangelength: '6 cifre'
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
            inviaDatiModificaImpostazioni('impostazioni', 'modifica', 'alboNum', "#contenutoAreaPersonale");
        }
    });



}

//function validazioneCodiceFiscaleMedicoCurante()
//{
//    jQuery.validator.addMethod("codiceFiscale", function (valore) {
//        //espressione regolare per codice fiscale
//        var regex = /[a-zA-Z]{6}[0-9]{2}[a-zA-Z]{1}[0-9]{2}[a-zA-Z]{1}[0-9]{3}[a-zA-Z]{1}/;
//        return valore.match(regex);
//    }, "Il codice fiscale deve essere del tipo DMRCLD89S42G438S");
//
//    $("#formModificaMedico").validate({
//        /*
//         * Il plugin di default invia una richiesta ajax  per la regola remote
//         * ogni volta che rilasciamo un tasto (key up) causando molte richieste ajax.
//         * Per cui per disattivare questà funzionalità imposto onkeyup:false. 
//         * in questo modo l'input che richiama la regola remote sarà validata con una sola chiamata ajax
//         * una volta che abbiamo terminato di digitare l'input.
//         */
//        onkeyup: false,
//        rules:
//                {
//                    codiceFiscale:
//                            {
//                                required: true,
//                                codiceFiscale: true,
//                                maxlength: 16,
//                                minlength: 16,
//                                remote:
//                                        {
//                                            type: "POST",
//                                            url: "ricerca/codice/medico",
//                                            data: {inverti: $('#inverti').val()}
//                                        }
//                            }
//                },
//        messages:
//                {
//                    codiceFiscale:
//                            {
//                                required: "Inserire il proprio codice fiscale",
//                                maxlength: "Il codice fiscale è lungo 16 caratteri",
//                                minlength: "Il codice fiscale è lungo 16 caratteri",
//                                remote: "Medico non esistente in Sanitapp"
//                            }
//                },
//        errorPlacement: function (error, element) {
//            $(element).attr('title', error.text());
//        },
//        unhighlight: function (element) {
//            $(element).removeAttr('title').removeClass('error');
//        },
//        submitHandler: function ()
//        {
//            inviaDatiModificaImpostazioni('impostazioni', 'modifica', 'medico', "#contenutoAreaPersonale");
//
//        }
//    });
//}

function validazioneCodiceFiscale()
{
    jQuery.validator.addMethod("codiceFiscale", function (valore) {
        //espressione regolare per codice fiscale
        var regex = /[a-zA-Z]{6}[0-9]{2}[a-zA-Z]{1}[0-9]{2}[a-zA-Z]{1}[0-9]{3}[a-zA-Z]{1}/;
        return valore.match(regex);
    }, "Il codice fiscale deve essere del tipo DMRCLD89S42G438S");
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
                                remote: "Utente non esistente o non confermato, inserire un codice fiscale di un utente già registrato o già confermato."
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
            } 
            else
            {
                $('#nextPrenotazioneEsame').attr('data-codiceFiscale', codiceFiscale); //aggiungo il codice fiscale al button nex in prenotazione/esame/idEsame
                $("p").show();
                $('h3').show();
                $('hr').show();
                $('span').show();
                $('#codiceFiscaleRicercaUtente').prop('readonly', true);
                $('#submitRicercaUtente').hide();
                
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
                         $("#nextPrenotazioneEsame").hide();
                        var data = dateText; //the first parameter of this function
                        $('#nextPrenotazioneEsame').attr('data-data', data);
                        var dataObject = $(this).datepicker('getDate'); //the getDate method
                        var nomeGiorno = $.datepicker.formatDate('DD', dataObject);
                        nomeGiorno = nomeGiorno.replace('ì', 'i');                        
                        var idEsame = $("#idEsame").val();
                        orariDisponibili(partitaIVAClinica, idEsame, nomeGiorno, data);
                    }});
                $('.daEliminare').remove();
            }
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
        var regex = /[0-9a-zA-Z\_\-]{4,15}/;
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
                                maxlength: 10,
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
                                required: "Inserire password",
                                maxlength: "Massimo 10 caratteri"
                            }
                },
        errorPlacement: function (error, element) {
            $(element).attr('title', error.text());
        },
        unhighlight: function (element) {
            $(element).removeAttr('title').removeClass('error');
        },
//        errorPlacement: function (error, element) {
//            return true;
//        },
        submitHandler: function ()
        {
            // inviaDatiRegistrazione si trova in clickRegistrazione.js
            inviaDatiGenerico(form, 'autenticazione', '#headerMain');

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
        var regex = /[a-zA-Z]{6}[0-9]{2}[a-zA-Z]{1}[0-9]{2}[a-zA-Z]{1}[0-9]{3}[a-zA-Z]{1}/;
        return valore.match(regex);
    }, "Il codice fiscale deve essee del tipo DMRCLD89S42G438S");

    jQuery.validator.addMethod("username", function (valore) {
        //espressione regolare per codice fiscale
        var regex = /[0-9a-zA-Z\_\-]{4,15}/;
        return valore.match(regex);
    }, "Deve contenere almeno 4 caratteri al massimo 15. Può contenere numeri, lettere maiuscole o minuscole");



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
                                minlength: 4,
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
                                maxlength: 10,
                                password: true
                            },
                    ripetiPasswordUtente:
                            {
                                required: true,
                                maxlength: 10,
                                equalTo: "#passwordUtente"
                            },
                    terminiServizio:
                            {
                                required:true
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
                                minlength: "La lunghezza minime dello username è 4",
                                maxlength: "La lunghezza massima dello username è 15",
                                remote: "Username già esistente"
                            },
                    passwordUtente:
                            {
                                required: "Inserire password",
                                maxlength: "Massimo 10 caratteri"
                            },
                    ripetiPasswordUtente:
                            {
                                required: "Inserire nuovamente la password",
                                maxlength: "Massimo 10 caratteri",
                                equalTo: "La password deve essere sempre la stessa"
                            },
                    terminiServizio:
                            {
                                required:'Necessario leggere e accettare i termini del servizio'
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
            // inviaDatiRegistrazione si trova in clickRegistrazione.js
            var ajaxDiv = "#main";
            if ($('#contenutoAreaPersonale').length)// se nel DOM esiste il div contenutoAreaPersonale
            {
                ajaxDiv = '#contenutoAreaPersonale';
            }
            inviaDatiRegistrazione('#inserisciUtente', 'registrazione', 'utente', ajaxDiv);
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
        var regex = /[a-zA-Z]{6}[0-9]{2}[a-zA-Z]{1}[0-9]{2}[a-zA-Z]{1}[0-9]{3}[a-zA-Z]{1}/;
        return valore.match(regex);
    }, "Il codice fiscale deve essere del tipo DMRCLD89S42G438S");

    jQuery.validator.addMethod("username", function (valore) {
        //espressione regolare per codice fiscale
        var regex = /[0-9a-zA-Z\_\-]{4,15}/;
        return valore.match(regex);
    }, "Deve contenere almeno 4 caratteri al massimo 15. Può contenere numeri, lettere maiuscole o minuscole");

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
                                number: true,
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
                                minlength: 4,
                                maxlength: 15,
                                remote:
                                        {
                                            type: "POST",
                                            url: "ricerca/username"
                                        }
                            },
                    passwordMedico:
                            {
                                required: true,
                                maxlength: 10
                            },
                    ripetiPasswordMedico:
                            {
                                required: true,
                                maxlength: 10,
                                equalTo: "#passwordMedico"
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
                    provinciaAlbo:
                            {
                                required: true,
                                maxlength: 22
                            },
                    numeroIscrizione:
                            {
                                required: true,
                                number: true,
                                rangelength: [6, 6]
                            },
                    terminiServizio:
                            {
                                required:true
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
                                number: "Inserire un numero",
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
                                minlength: "La lunghezza minima dello username è 4",
                                maxlength: "La lunghezza massima dello username è 15",
                                remote: "Username già esistente"
                            },
                    passwordMedico:
                            {
                                required: "Inserire password",
                                maxlength: "Massimo 10 caratteri"
                            },
                    ripetiPasswordMedico:
                            {
                                required: "Inserire nuovamente la password",
                                maxlength: "Massimo 10 caratteri",
                                equalTo: "La password deve essere sempre la stessa"
                            },
                    PEC:
                            {
                                required: "Inserire la PEC",
                                email: "Inserire un'email valida",
                                remote: "PEC già esistente"
                            },
                    provinciaAlbo:
                            {
                                required: "Inserire la provincia dell'albo a cui si è iscritti",
                                maxlength: "La sequenza massima di caratteri è 22"

                            },
                    numeroIscrizione:
                            {
                                required: "Inserire il numero di iscrizione",
                                number: "Inserire un numero",
                                rangelength: "Deve avere 6 numeri"
                            },
                    terminiServizio:
                            {
                                required:'Necessario leggere e accettare i termini del servizio'
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
            $("#loadingModal").show();
            var ajaxDiv = "#main";
            if ($('#contenutoAreaPersonale').length)// se nel DOM esiste il div contenutoAreaPersonale
            {
                ajaxDiv = '#contenutoAreaPersonale';
            }
            inviaDatiRegistrazione('#inserisciMedico', 'registrazione', 'medico', ajaxDiv);
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

    jQuery.validator.addMethod("partitaIVA", function (valore) {
        //espressione regolare per la partita IVA 
        var regex = /[0-9]{11}/;
        return valore.match(regex);
    }, "La partita IVA deve essere una sequenza di 11 numeri");

    jQuery.validator.addMethod("username", function (valore) {
        //espressione regolare per codice fiscale
        var regex = /[0-9a-zA-Z\_\-]{4,15}/;
        return valore.match(regex);
    }, "Deve contenere almeno 4 caratteri al massimo 15. Può contenere numeri, lettere maiuscole o minuscole");

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
                    localitaClinica:
                            {
                                required: true,
                                maxlength: 40
                            },
                    provinciaClinica:
                            {
                                required: true,
                                maxlength: 22
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
                                minlength: 4,
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
                                maxlength: 10,
                                password: true
                            },
                    ripetiPasswordClinica:
                            {
                                required: true,
                            maxlength: 10,
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
                            },
                    terminiServizio:
                            {
                                required:true
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
                    localitaClinica:
                            {
                                required: "Inserire la localita della clinica",
                                maxlength: "La sequenza massima di caratteri è 40"
                            },
                    provinciaClinica:
                            {
                                required: "Inserire la provincia della clinica",
                                maxlength: "La sequenza massima di caratteri è 22"
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
                                minlength: "La sequenza alfanumerica minima  è 4",
                                maxlength: "La sequenza alfanumerica massima è 15",
                                remote: "Username già esistente"
                            },
                    passwordClinica:
                            {
                                required: "Inserire password",
                                maxlength: "Massimo 10 caratteri"
                            },
                    ripetiPasswordClinica:
                            {
                                required: "Ripetere password",
                                maxlength: "Massimo 10 caratteri",
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
                            },
                    terminiServizio:
                            {
                                required:'Necessario leggere e accettare i termini del servizio'
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
            $("#loadingModal").show();
            var ajaxDiv = "#main";
            if ($('#contenutoAreaPersonale').length)// se nel DOM esiste il div contenutoAreaPersonale
            {
                ajaxDiv = '#contenutoAreaPersonale';
            }
            inviaDatiRegistrazione('#inserisciClinica', 'registrazione', 'clinica', ajaxDiv);
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
//
//    $("workingPlan").validate({
////        messages:
////                {
////                    LunedìStart:
////                            {
////                                required: true,
////                                time: true
////                            },
////                    MartedìStart:
////                            {
////                                required: true,
////                                time: true
////                            },
////                    MercoledìStart:
////                            {
////                                required: true,
////                                time: true
////                            },
////                    GiovedìStart:
////                            {
////                                required: true,
////                                time: true
////                            },
////                    VenerdìStart:
////                            {
////                                required: true,
////                                time: true
////                            },
////                    SabatoStart:
////                            {
////                                required: true,
////                                time: true
////                            },
////                    DomenicaStart:
////                            {
////                                required: true,
////                                time: true
////                            },
////                    LunedìEnd:
////                            {
////                                required: true,
////                                time: true
////                            },
////                    MartedìEnd:
////                            {
////                                required: true,
////                                time: true
////                            },
////                    MercoledìEnd:
////                            {
////                                required: true,
////                                time: true
////                            },
////                    GiovedìEnd:
////                            {
////                                required: true,
////                                time: true
////                            },
////                    VenerdìEnd:
////                            {
////                                required: true
////                            },
////                    SabatoEnd:
////                            {
////                                required: true
////                            },
////                    DomenicaEnd:
////                            {
////                                required: true
////                            } 
////                },
//        errorPlacement: function (error, element) {
//            $(element).attr('title', error.text());
//        },
//        unhighlight: function (element) {
//            $(element).removeAttr('title').removeClass('error');
//        },
//        submitHandler: function ()
//        {
//            // inviaDatiEsame si trova in clickGestisciServizi.js
//            inviaImpostazioniClinica('#aggiungiEsame', 'servizi', 'aggiungi', '#main');
//        }
//    });
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
//                                maxlenght: 600
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
//                                maxlenght:"Max 600 caratteri"
//                        
//                            }
                },
        errorPlacement: function (error, element) {
            $(element).attr('title', error.text());
        },
        unhighlight: function (element) {
            $(element).removeAttr('title').removeClass('error');
        },
        submitHandler: function ()
        {
            // inviaDatiEsame si trova in clickGestisciServizi.js
            inviaDatiEsame('#aggiungiEsame', 'servizi', 'aggiungi', '#contenutoAreaPersonale');
        }
    });
}

function validazioneReferto() {

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
        },
        errorPlacement: function (error, element) {
            $(element).attr('title', error.text());
        },
        unhighlight: function (element) {
            $(element).removeAttr('title').removeClass('error');
        }
        ,
        submitHandler: function () {
            uploadReferto(); //si trova in click clinica
        }

    });
}

function validazioneCategoria() {
    $("#aggiungiCategoria").validate({
        rules:
                {
                    nomeCategoria:
                            {
                                required: true,
                                maxlength: 30
                            }
                },
        messages:
                {
                    nomeCategoria:
                            {
                                required: "Inserire nome",
                                maxlength: "La lunghezza massima è 30"
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
            // inviaDatiEsame si trova in clickGestisciServizi.js
            var nomeCategoria = $("#nomeCategoria").val();
            var datiPOST = {nomeCategoria: nomeCategoria};
            inviaControllerTaskPOST('categorie', 'aggiungi', datiPOST, '#contenutoAreaPersonale');
        }
    });

}

function inviaDatiCategoria()
{
    //recupera tutti i valori del form automaticamente
    var dati = $(id).serialize();
    $.ajax({
        //il tipo di richiesta HTTP da effettuare, di default è GET
        type: 'POST',
        //url della risorsa alla quale viene inviata la richiesta
        //url:  "index.php",
        url: "categorie/aggiungi",
        //che può essere un oggetto del tipo {chiave : valore, chiave2 : valore}, 
        //oppure una stringa del tipo "chiave=valore&chiave2=valore2"
        // contenente dei dati da inviare al server
        //data: {datiDaInviare:  dati, controller:controller1, task:task1}, 
        data: dati,
        dataType: "html",
        //success(data, textStatus, XMLHTTPRequest) : funzione che verrà 
        //eseguita al successo della chiamata. I tre parametri sono, 
        //rispettivamente, l’oggetto della richiesta, lo stato e la 
        //descrizione testuale dell’errore rilevato
        success: function (msg)
        {
            $(ajaxdiv).html(msg);
        },
        error: function (xhr, status, error)
        {
            alert("Chiamata fallita, si prega di riprovare...");
        }


    });
}





function validazioneModificaUtente() {
    
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
        var regex = /[a-zA-Z]{6}[0-9]{2}[a-zA-Z]{1}[0-9]{2}[a-zA-Z]{1}[0-9]{3}[a-zA-Z]{1}/;
        return valore.match(regex);
    }, "Il codice fiscale deve essee del tipo DMRCLD89S42G438S");

    jQuery.validator.addMethod("alfanumerico", function (valore) {
        var regex = /[a-zA-Z0-9]+/;
        return valore.match(regex);
    });

    jQuery.validator.addMethod("username", function (valore) {
        //espressione regolare per codice fiscale
        var regex = /[0-9a-zA-Z\_\-]{4,15}/;
        return valore.match(regex);
    }, "Deve contenere almeno 4 caratteri al massimo 15. Può contenere numeri, lettere maiuscole o minuscole");


    $("#modificaUserUtente").validate({
        /*
         * Il plugin di default invia una richiesta ajax  per la regola remote
         * ogni volta che rilasciamo un tasto (key up) causando molte richieste ajax.
         * Per cui per disattivare questà funzionalità imposto onkeyup:false. 
         * in questo modo limput che richiama la regola remote sarà validata con una sola chiamata ajax
         * una volta che abbiamo terminato di digitare l'input.
         */
        onkeyup: false, //turn off auto validate whilst typing
//        focusCleanup: true,
//        onclick: true, // Valida checkboxes e radio buttons on click. 
        rules:
                {
                    username:
                            {
                                required: true,
                                username: true,
                                minlength: 4,
                                maxlength: 15
                            },
                    email:
                            {
                                required: true,
                                email: true
                            },
                    codiceConferma:
                            {
                                required: true,
                                alfanumerico: true,
                                minlength: 16,
                                maxlength: 64
                            },
                    codiceFiscale:
                            {
                                required: true,
                                codiceFiscale: true,
                                maxlength: 16,
                                minlength: 16
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
                    via:
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
                    passwordUtente:
                            {
                                password: true,
                                maxlength: 10
                            }

                },
        messages:
                {
                    username:
                            {
                                required: "Inserire username",
                                minlength: "La lunghezza minime dello username è 4",
                                maxlength: "La lunghezza massima dello username è 15"
                            },
                    email:
                            {
                                required: "Inserire l'email",
                                email: "Inserire un'email valida del tipo mario.rossi@gmail.com"
                            },
                    codiceConferma:
                            {
                                required: 'Inserire codice conferma ',
                                alfanumerico: 'Il codice deve essere alfanumerico',
                                minlength: 'Minima lunghezza 16',
                                maxlength: 'Massima lunghezza 64'

                            },
                    codiceFiscale:
                            {
                                required: "Inserire il proprio codice fiscale",
                                maxlength: "Il codice fiscale è lungo 16 caratteri",
                                minlength: "Il codice fiscale è lungo 16 caratteri"
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
                    via:
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
                    passwordUtente:
                            {
                                maxlength: "Massimo 10 caratteri"
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
            $("#loadingModal").show();
            // inviaDatiRegistrazione si trova in clickRegistrazione.js
            var datiPOST = $('form').serialize() + "&tipoUser=Utente";
            $("#modificaUserUtente input[type='checkbox']").each(function (index) {
                if ($(this).val() !== true)
                {
                    var valore = $(this).attr("name");
                    datiPOST = datiPOST + "&" + valore + "=" + $(this).val();
                }



            });


            inviaControllerTaskPOST('users', 'modifica', datiPOST, '#contenutoAreaPersonale');

        }
    });
}

function validazioneModificaMedico() {
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
        var regex = /[a-zA-Z]{6}[0-9]{2}[a-zA-Z]{1}[0-9]{2}[a-zA-Z]{1}[0-9]{3}[a-zA-Z]{1}/;
        return valore.match(regex);
    }, "Il codice fiscale deve essee del tipo DMRCLD89S42G438S");

    jQuery.validator.addMethod("alfanumerico", function (valore) {
        var regex = /[a-zA-Z0-9]+/;
        return valore.match(regex);
    });

    jQuery.validator.addMethod("username", function (valore) {
        //espressione regolare per codice fiscale
        var regex = /[0-9a-zA-Z\_\-]{4,15}/;
        return valore.match(regex);
    }, "Deve contenere almeno 4 caratteri al massimo 15. Può contenere numeri, lettere maiuscole o minuscole");


    $("#modificaUserMedico").validate({
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
                    username:
                            {
                                required: true,
                                username: true,
                                minlength: 4,
                                maxlength: 15
                            },
                    email:
                            {
                                required: true,
                                email: true
                            },
                    codiceConferma:
                            {
                                required: true,
                                alfanumerico: true,
                                minlength: 16,
                                maxlength: 64

                            },
                    codiceFiscale:
                            {
                                required: true,
                                codiceFiscale: true,
                                maxlength: 16,
                                minlength: 16
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
                    via:
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
                    provinciaAlbo:
                            {
                                required: true,
                                maxlength: 22
                            },
                    numeroIscrizioneAlbo:
                            {
                                required: true,
                                rangelength: [6, 6]
                            },
                    PEC:
                            {
                                required: true,
                                email: true

                            },
                    passwordMedico:
                            {
                                password: true,
                                maxlength: 10
                            
                            }
                },
        messages:
                {
                    username:
                            {
                                required: "Inserire username",
                                minlength: "La lunghezza minime dello username è 4",
                                maxlength: "La lunghezza massima dello username è 15"
                            },
                    email:
                            {
                                required: "Inserire l'email",
                                email: "Inserire un'email valida del tipo mario.rossi@gmail.com"
                            },
                    codiceConferma:
                            {
                                required: 'Inserire codice conferma ',
                                alfanumerico: 'Il codice deve essere alfanumerico',
                                minlength: 'Minima lunghezza 16',
                                maxlength: 'Massima lunghezza 64'

                            },
                    codiceFiscale:
                            {
                                required: "Inserire il proprio codice fiscale",
                                maxlength: "Il codice fiscale è lungo 16 caratteri",
                                minlength: "Il codice fiscale è lungo 16 caratteri"
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
                    via:
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
                    PEC:
                            {
                                required: "Inserire la PEC",
                                email: "Inserire un'email valida"
                            },
                    provinciaAlbo:
                            {
                                required: "Inserire la provincia dell'albo a cui si è iscritti",
                                maxlength: "La sequenza massima di caratteri è 22"

                            },
                    numeroIscrizioneAlbo:
                            {
                                required: "Inserire il numero di iscrizione",
                                rangelength: "Deve avere 6 numeri"
                            },
                    passwordMedico:
                            {
                                maxlength: "Massimo 10 caratteri"
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
            $("#loadingModal").show();
            // inviaDatiRegistrazione si trova in clickRegistrazione.js
            var datiPOST = $('form').serialize() + "&tipoUser=Medico";
            $("#modificaUserMedico input[type='checkbox']").each(function (index) {

                if ($(this).val() !== true)
                {
                    var valore = $(this).attr("name");
                    datiPOST = datiPOST + "&" + valore + "=" + $(this).val();
                }
            });
            inviaControllerTaskPOST('users', 'modifica', datiPOST, '#contenutoAreaPersonale');
        }
    });
}

function validazioneModificaClinica() {
    //aggiungo un metodo di validazione per poter validare correttamente la password
    // il nome della classe, la funzione per validare e il messaggio in caso di errore
    jQuery.validator.addMethod("password", function (valore) {
        //espressione regolare per la password
        var regex = /(((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])).{6,10})/;
        return valore.match(regex);
    }, "Inserire da 6 a 10 caratteri che contengano almeno un numero, una lettera \n\
        maiuscola,una lettera minuscola");
    
    jQuery.validator.addMethod("partitaIVA", function (valore) {
        //espressione regolare per la partita IVA 
        var regex = /[0-9]{11}/;
        return valore.match(regex);
    }, "La partita IVA deve essere una sequenza di 11 numeri");

    jQuery.validator.addMethod("codiceFiscale", function (valore) {
        //espressione regolare per codice fiscale
        var regex = /[a-zA-Z]{6}[0-9]{2}[a-zA-Z]{1}[0-9]{2}[a-zA-Z]{1}[0-9]{3}[a-zA-Z]{1}/;
        return valore.match(regex);
    }, "Il codice fiscale deve essee del tipo DMRCLD89S42G438S");

    jQuery.validator.addMethod("alfanumerico", function (valore) {
        var regex = /[a-zA-Z0-9]+/;
        return valore.match(regex);
    });

    jQuery.validator.addMethod("username", function (valore) {
        //espressione regolare per codice fiscale
        var regex = /[0-9a-zA-Z\_\-]{4,15}/;
        return valore.match(regex);
    }, "Deve contenere almeno 4 caratteri al massimo 15. Può contenere numeri, lettere maiuscole o minuscole");

    $("#modificaUserClinica").validate({
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
                    username:
                            {
                                required: true,
                                username: true,
                                minlength: 4,
                                maxlength: 15
                            },
                    email:
                            {
                                required: true,
                                email: true
                            },
                    codiceConferma:
                            {
                                required: true,
                                alfanumerico: true,
                                minlength: 16,
                                maxlength: 64

                            },
                    nomeClinica:
                            {
                                required: true,
                                maxlength: 30
                            },
                    titolareClinica:
                            {
                                required: true,
                                maxlength: 50
                            },
                    partitaIva:
                            {
                                required: true,
                                partitaIVA: true,
                                maxlength: 11,
                                minlength: 11
                            },
                    via:
                            {
                                required: true,
                                maxlength: 30
                            },
                    numeroCivico:
                            {
                                number: true,
                                min: 0
                            },
                    localita:
                            {
                                required: true,
                                maxlength: 40
                            },
                    provincia:
                            {
                                required: true,
                                maxlength: 22
                            },
                    CAP:
                            {
                                required: true,
                                minlength: 5,
                                maxlength: 5
                            },
                    pec:
                            {
                                required: true,
                                email: true

                            },
                    telefono:
                            {
                                required: true,
                                maxlength: 10
                            },
                    passwordClinica:
                            {
                                password: true,
                                maxlength: 10
                            }
                },
        messages:
                {
                    username:
                            {
                                required: "Inserire username",
                                minlength: "La lunghezza minime dello username è 4",
                                maxlength: "La lunghezza massima dello username è 15"
                            },
                    email:
                            {
                                required: "Inserire l'email",
                                email: "Inserire un'email valida del tipo mario.rossi@gmail.com"
                            },
                    codiceConferma:
                            {
                                required: 'Inserire codice conferma ',
                                alfanumerico: 'Il codice deve essere alfanumerico',
                                minlength: 'Minima lunghezza 16',
                                maxlength: 'Massima lunghezza 64'

                            },
                    nomeClinica:
                            {
                                required: "Inserire il nome della clinica",
                                maxlength: "La sequenza di caratteri deve essere massimo 30"
                            },
                    titolareClinica:
                            {
                                required: "Inserire il nome e cognome del titolare",
                                maxlength: "La sequenza di caratteri deve essere massimo 50"
                            },
                    partitaIva:
                            {
                                required: "Inserire la partita IVA",
                                maxlength: "La sequenza massima di numeri è 11",
                                minlength: "La sequenza minima di numeri è 11"
                            },
                    via:
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
                    localita:
                            {
                                required: "Inserire la localita della clinica",
                                maxlength: "La sequenza massima di caratteri è 40"
                            },
                    provincia:
                            {
                                required: "Inserire la provincia della clinica",
                                maxlength: "La sequenza massima di caratteri è 22"
                            },
                    pec:
                            {
                                required: "Inserire la PEC",
                                email: "Inserire un'email valida"
                            },
                    telefono:
                            {
                                required: "Inserire il telefono",
                                maxlength: "La sequenza massima di numeri è 10"
                            },
                    passwordClinica:
                            {
                                maxlength: "Massimo 10 caratteri"
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
            $("#loadingModal").show();
            // inviaDatiRegistrazione si trova in clickRegistrazione.js
            var datiPOST = $('form').serialize() + "&tipoUser=Clinica";
            $("#modificaUserClinica input[type='checkbox']").each(function (index) {

                if ($(this).val() !== true)
                {
                    var valore = $(this).attr("name");
                    datiPOST = datiPOST + "&" + valore + "=" + $(this).val();
                }
            });
            inviaControllerTaskPOST('users', 'modifica', datiPOST, '#contenutoAreaPersonale');
        }
    });

}

function validazioneEmail() {
    $('#formRecuperoPassword').validate({
        rules: {
            email:
                    {
                        required: true,
                        email: true
                    }
        },
        messages: {
            email:
                    {
                        required: "Inserire l'email",
                        email: "Inserire un'email valida del tipo mario.rossi@gmail.com"
                    }
        },
        errorPlacement: function (error, element) {
            $(element).attr('title', error.text());
        },
        unhighlight: function (element) {
            $(element).removeAttr('title').removeClass('error');
        },
        submitHandler: function(){
            inviaDatiGenerico('#formRecuperoPassword', 'recuperaPassword', '#main');
        }
    });
}

function validazioneModificaEsame() {
    var idClinica = $('#submitModificaEsame').attr('data-idClinica');
    var idEsame = $('#submitModificaEsame').attr('data-idEsame');

    jQuery.validator.addMethod("time", function (valore) {
        //espressione regolare per la durata
        var regex = /([0-2][0-3]):([0-5]\d)/;
        return valore.match(regex);
    }, "La durata è nel formato hh:mm");

    $("#modificaEsameForm").validate({
        rules:
                {
                    nome:
                            {
                                required: true,
                                maxlength: 50
                            },
                    medicoResponsabile:
                            {
                                required: true,
                                maxlength: 40
                            },
                    categoria:
                            {
                                required: true,
                                maxlength: 30
                            },
                    prezzo:
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
                            }
//                    descrizione:
//                            {
//                                required: true,
//                                maxlenght: 200
//                            }

                },
        messages:
                {
                    nome:
                            {
                                required: "Inserire nome",
                                maxlength: "La lunghezza massima è 50"
                            },
                    medicoResponsabile:
                            {
                                required: "Inserire medico",
                                maxlength: "La lunghezza massima è 40"
                            },
                    categoria:
                            {
                                required: "Inserire la categoria",
                                maxlength: "La lunghezza massima è 30"
                            },
                    prezzo:
                            {
                                number: "Inserire un numero",
                                required: "Inserire il prezzo",
                                max: "Massimo 10000€",
                                min: "Minimo 1"
                            },
                    durataEsame:
                            {
                                required: "Selezionare la durata"
                            }
//                    descrizione:
//                            {
//                                required: "Inserisci una breve descrizione",
//                                maxlenght:"Max 200 caratteri"
//                        
//                            }
                },
        errorPlacement: function (error, element) {
            $(element).attr('title', error.text());
        },
        unhighlight: function (element) {
            $(element).removeAttr('title').removeClass('error');
        },
        submitHandler: function ()
        {
            var datiPOST = $('form').serialize() + "&idClinica=" + idClinica + "&idEsame=" + idEsame;
            inviaControllerTaskPOST('servizi', 'modifica', datiPOST, '#contenutoAreaPersonale');
        }
    });
}