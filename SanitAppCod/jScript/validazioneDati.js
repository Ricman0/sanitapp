function validazione(task1)
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
            validazioneClinica();
            break; 
        default: break;
    }
}


function validazioneUtente()
{
    $("#inserisciUtente").validate({
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
                                maxlength: 16, 
                                minlength: 16,
//                                remote:
//                                        { 
//                                           type: "GET",
//                                           url: "validazione/codiceFiscale/" + ($("#codiceFiscale").val()) + "/", 
//                                           
//                                        }
                            },
                    indirizzo:
                            {
                                required: true,
                                maxlength: 30
                            },
                    numeroCivico:
                            {
                                number: true
                            },
                    CAP:
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
//                                remote:
//                                        { 
//                                           type: "GET",
//                                           url: "validazione/email/" + $("#email").val()  
//                                        }             
                            },
                    usernameUtente:
                            {
                                required: true,
                                minlength: 2,
                                maxlength: 15,
//                                remote:
//                                        { 
//                                           type: "GET",
//                                           url: "validazione/username/" + $("#usernameUtente").val()  
//                                        }
                            },
                    passwordUtente:
                            {
                                required: true,
                                pattern: /^(((?=.*[0-9])(?=.*[a-zA-Z])).{6,10})$/,
                                minlength: 6,
                                maxlength: 10
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
//                                remote: "Codice Fiscale già esistente"
                            },
                    indirizzo:
                            {
                                required: "Inserire indirizzo",
                                maxlength: "La lunghezza massima è 30"
                            },
                    numeroCivico:
                            {
                                number: "Il numero civico è un numero"
                            },
                    CAP:
                            {
                                required: "Inserire il CAP",
                                number: "Il CAP è un numero",
                                minlength: "Il CAP è un numero lungo 5",
                                maxlength: "Il CAP è un numero lungo 5"
                            },
                    email:
                            {
                                required: "Inserire l'email",
                                email: "Inserire un'email valida del tipo mario.rossi@gmail.com",
//                                remote: "Email già esistente"
                            },
                    usernameUtente:
                            {
                                required: "Inserire username",
                                minlength: "La lunghezza minime dello username è 2",
                                maxlength: "La lunghezza massima dello username è 15",
//                                remote: "Username già esistente"
                            },
                    passwordUtente:
                            {
                                required: "Inserire password",
                                pattern: "Inserire una password che contenga \n\
                                         almeno un numero, una lettera maiuscola,\n\
                                          una lettera minuscola",
                                minlength: "La lunghezza minima della password è 6",
                                maxlength: "La lunghezza massima della password è 10"
                            },
                    ripetiPasswordUtente:
                            {
                                required: "Inserire nuovamente la password",
                                equalTo: "La password deve essere sempre la stessa"
                            }
                },
        submitHandler:function(form) 
        { 
            alert('I dati sono stati inseriti correttamente');
            inviaDatiRegistrazione('#inserisciUtente', 'registrazione', 'utente', '#main');
        }
    });
}

function validazioneMedico()
{
    $("#inserisciMedico").validate({
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
                    codiceFiscaleMedico:
                            {
                                required: true,
                                maxlength: 16, 
                                minlength: 16,
//                                remote:
//                                        { 
//                                           type: "GET",
//                                           url: "validazione/codiceFiscale/" + $("#codiceFiscale").val()  
//                                        }
                            },
                    indirizzoMedico:
                            {
                                required: true,
                                maxlength: 20
                            },
                    numeroCivicoMedico:
                            {
                                number: true
                            },
                    CAPMedico:
                            {
                                required: true,
                                number: true,
                                minlength: 5,
                                maxlength: 5
                            },
                    emailMedico:
                            {
                                required: true,
                                email: true,
//                                remote:
//                                        { 
//                                           type: "GET",
//                                           url: "validazione/email/" + $("#email").val()  
//                                        }             
                            },
                    usernameMedico:
                            {
                                required: true,
                                minlength: 2,
                                maxlength: 15,
//                                remote:
//                                        { 
//                                           type: "GET",
//                                           url: "validazione/username/" + $("#usernameUtente").val()  
//                                        }
                            },
                    passwordMedico:
                            {
                                required: true,
                                pattern: /^(((?=.*[0-9])(?=.*[a-zA-Z])).{6,10})$/,
                                minlength: 6,
                                maxlength: 10
                            },
                    ripetiPasswordMedico:
                            {
                                required: true,
                                equalTo: "#passwordMedico"
                            },
                    PECMedico:
                            {
                                required:true,
                                email: true
                            },
                    provinciaAlbo:
                            {
                                required: true,
                                rangelength: [2,2]
                            },
                    numeroIscrizione:
                            {
                                required: true,
                                rangelength: [6,6]
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
                    codiceFiscaleMedico:
                            {
                                required: "Inserire il proprio codice fiscale",
                                maxlength: "Il codice fiscale è lungo 16 caratteri",
                                minlength: "Il codice fiscale è lungo 16 caratteri",
//                                remote: "Codice Fiscale già esistente"
                            },
                    indirizzoMedico:
                            {
                                required: "Inserire indirizzo",
                                maxlength: "La lunghezza massima è 20"
                            },
                    numeroCivicoMedico:
                            {
                                number: "Il numero civico è un numero"
                            },
                    CAPMedico:
                            {
                                required: "Inserire il CAP",
                                number: "Il CAP è un numero",
                                minlength: "Il CAP è un numero lungo 5 caratteri",
                                maxlength: "Il CAP è un numero lungo 5 caratteri"
                            },
                    emailMedico:
                            {
                                required: "Inserire l'email",
                                email: "Inserire un'email valida",
//                                remote: "Email già esistente"
                            },
                    usernameMedico:
                            {
                                required: "Inserire username",
                                minlength: "La lunghezza minima dello username è 2",
                                maxlength: "La lunghezza massima dello username è 15",
//                                remote: "Username già esistente"
                            },
                    passwordMedico:
                            {
                                required: "Inserire password",
                                pattern: "Inserire una password che contenga \n\
                                         almeno un numero, una lettera maiuscola,\n\
                                          una lettera minuscola",
                                minlength: "La lunghezza minima della password è 6",
                                maxlength: "La lunghezza massima della password è 10"
                            },
                    ripetiPasswordMedico:
                            {
                                required: "Inserire nuovamente la password",
                                equalTo: "La password deve essere sempre la stessa"
                            },
                    PECMedico:
                            {
                                required: "Inserire la PEC",
                                email: "Inserire un'email valida"
                            },
                    provinciaAlbo:
                            {
                                required: "Inserire la provincia dell'albo a cui si è iscritti",
                                maxlength: "Inserire la sigla della provincia"
                            },
                    numeroIscrizione:
                            {
                                required: "Inserire il numero di iscrizione",
                                rangelength: "Deve avere 6 numeri",
                            }
                },
        submitHandler:function(form) 
        { 
            alert('I dati sono stati inseriti correttamente');
            inviaDatiRegistrazione('#inserisciMedico', 'registrazione', 'medico', '#main');
        }
    });
}

function validazioneClinica()
{
    $("#inserisciClinica").validate({
        rules:
                {
                    nomeClinica:
                            {
                                required: true,
                                maxlength: 20
                            },
                    titolare:
                            {
                                required: true,
                                maxlength: 50
                            },
                    partitaIVA:
                            {
                                required: true,
                                maxlength: 11, 
                                minlength: 11,
//                                remote:
//                                        { 
//                                           type: "GET",
//                                           url: "validazione/codiceFiscale/" + $("#").val()  
//                                        }
                            },
                    indirizzoClinica:
                            {
                                required: true,
                                maxlength: 30
                            },
                    numeroCivicoClinica:
                            {
                                number: true
                            },
                    CAPClinica:
                            {
                                required: true,
                                number: true,
                                minlength: 5,
                                maxlength: 5
                            },
                    localitàClinica:
                            {
                                required: true,
                                maxlength: 20
                            },
                    provinciaClinica:
                            {
                                required: true,
                                maxlength: 20
                            },
                    emailClinica:
                            {
                                required: true,
                                email: true,
//                                remote:
//                                        { 
//                                           type: "GET",
//                                           url: "validazione/email/" + $("#email").val()  
//                                        }             
                            },
                    PECClinica:
                            {
                                required: true,
                                email: true,
//                                remote:
//                                        { 
//                                           type: "GET",
//                                           url: "validazione/email/" + $("#email").val()  
//                                        }             
                            },
                    
                    usernameClinica:
                            {
                                required: true,
                                minlength: 2,
                                maxlength: 15,
//                                remote:
//                                        { 
//                                           type: "GET",
//                                           url: "validazione/username/" + $("#usernameUtente").val()  
//                                        }
                            },
                    passwordClinica:
                            {
                                required: true,
                                pattern: /^(((?=.*[0-9])(?=.*[a-zA-Z])).{6,10})$/,
                                minlength: 6,
                                maxlength: 10
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
                            },
                    orarioApertutaMattina:
                            {
                                pattern: /^(([0-1]?[0-9]{1})|([2]{1}[0-3]{1})):([0-5]?[0-9]{1})(:([0-5]?[0-9]))?$/
                            },
                    orarioChiusuraMattina:
                            {
                                pattern: /^(([0-1]?[0-9]{1})|([2]{1}[0-3]{1})):([0-5]?[0-9]{1})(:([0-5]?[0-9]))?$/
                            },
                    orarioApertutaPomeriggio:
                            {
                                pattern: /^(([0-1]?[0-9]{1})|([2]{1}[0-3]{1})):([0-5]?[0-9]{1})(:([0-5]?[0-9]))?$/
                            },
                    orarioChiusuraPomeriggio:
                            {
                                pattern: /^(([0-1]?[0-9]{1})|([2]{1}[0-3]{1})):([0-5]?[0-9]{1})(:([0-5]?[0-9]))?$/
                            },
                    orarioContinuato:
                            {
                                boolean: true
                            }
                },
        messages:
                {
                    nomeClinica:
                            {
                                required: "Inserire il nome della clinica",
                                maxlength: "La sequenza di caratteri deve essere massimo 20"
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
//                                remote:                                      
                            },
                    indirizzoClinica:
                            {
                                required: "Inserire l'indirizzo della clinica",
                                maxlength: "La sequenza massima di numeri è 30"
                            },
                    numeroCivicoClinica:
                            {
                                number: "Deve essere un numero",
                            },
                    CAPClinica:
                            {
                                required: "Inserire il CAP della clinica",
                                number: "Deve essere un numero",
                                minlength: "La sequenza minima di numeri è 5",
                                maxlength: "La sequenza massima di numeri è 5"
                            },
                    localitàClinica:
                            {
                                required: "Inserire la località della clinica",
                                maxlength: "La sequenza massima di caratteri è 20"
                            },
                    provinciaClinica:
                            {
                                required: "Inserire la provincia della clinica",
                                maxlength: "La sequenza massima di caratteri è 20"
                            },
                    emailClinica:
                            {
                                required: "Inserire l'email della clinica",
                                email: "Deve essere un'email"
//                                remote:
//                                                    
                            },
                    PECClinica:
                            {
                                required: "Inserire l'indirizzo PEC della clinica",
                                email: "Deve essere un'email"
//                                remote:
//                                                     
                            },
                    
                    usernameClinica:
                            {
                                required: "Inserire username",
                                minlength: "La sequenza alfanumerica minima  è 2",
                                maxlength: "La sequenza alfanumerica massima è 15"
//                                remote:
                            },
                    passwordClinica:
                            {
                                required: "Inserire password",
                                pattern: "Inserire una password che contenga \n\
                                         almeno un numero, una lettera maiuscola,\n\
                                          una lettera minuscola",
                                minlength: "La sequenza alfanumerica minima  è 6",
                                maxlength: "La sequenza alfanumerica massima è 10"
                            },
                    ripetiPasswordClinica:
                            {
                                required: "Ripetere password",
                                equalTo: "La password ripetuta deve essere identica alla password appena inserita"
                            },
                    telefonoClinica:
                            {
                                required: "Inserire il telefono",
                                maxlength:"La sequenza massima di numeri è 10"
                            },
                    capitaleSociale:
                            {
                                required: "Inserire il capitale sociale della clinica",
                                maxlength: "La sequenza massima di numeri è 11"
                            },
                    orarioApertutaMattina:
                            {
                                pattern: "Inserire un orario del tipo:  08:30 oppure 08:30:00"
                            },
                    orarioChiusuraMattina:
                            {
                                pattern: "Inserire un orario del tipo:  12:30 oppure 12:30:00"
                            },
                    orarioApertutaPomeriggio:
                            {
                                pattern: "Inserire un orario del tipo:  15:30 oppure 15:30:00"
                            },
                    orarioChiusuraPomeriggio:
                            {
                                pattern: "Inserire un orario del tipo:  19:30 oppure 19:30:00"
                            },
                    orarioContinuato:
                            {
                                boolean: "Deve essere un booleano"
                            }
                },
        submitHandler:function(form) 
        { 
            alert('I dati sono stati inseriti correttamente');
            inviaDatiRegistrazione('#inserisciMedico', 'registrazione', 'medico', '#main');
        }
    });
}

