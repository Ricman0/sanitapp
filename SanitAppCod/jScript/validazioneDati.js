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
//                                           url: "validazione/codiceFiscale/" + $("#codiceFiscale").val()  
//                                        }
                            },
                    indirizzo:
                            {
                                required: true,
                                maxlength: 20
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
                                maxlength: "La lunghezza massima è 20"
                            },
                    numeroCivico:
                            {
                                number: "Il numero civico è un numero"
                            },
                    CAP:
                            {
                                required: "Inserire il CAP",
                                number: "Il CAP è un numero",
                                minlength: "Il CAP è un numero lungo 5 caratteri",
                                maxlength: "Il CAP è un numero lungo 5 caratteri"
                            },
                    email:
                            {
                                required: "Inserire l'email",
                                email: "Inserire un'email valida",
//                                remote: "Email già esistente"
                            },
                    usernameUtente:
                            {
                                required: "Inserire username",
                                maxlength: "La lunghezza massima dello username è 15",
//                                remote: "Username già esistente"
                            },
                    passwordUtente:
                            {
                                required: "Inserire password",
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
//                                           url: "validazione/codiceFiscale/" + $("#codiceFiscale").val()  
//                                        }
                            },
                    indirizzo:
                            {
                                required: true,
                                maxlength: 20
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
                    usernameMedico:
                            {
                                required: true,
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
                                maxlength: 2
                            },
                    numeroIscrizione:
                            {
                                required: true,
                                rangelength: [2,2]
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
                                maxlength: "La lunghezza massima è 20"
                            },
                    numeroCivico:
                            {
                                number: "Il numero civico è un numero"
                            },
                    CAP:
                            {
                                required: "Inserire il CAP",
                                number: "Il CAP è un numero",
                                minlength: "Il CAP è un numero lungo 5 caratteri",
                                maxlength: "Il CAP è un numero lungo 5 caratteri"
                            },
                    email:
                            {
                                required: "Inserire l'email",
                                email: "Inserire un'email valida",
//                                remote: "Email già esistente"
                            },
                    usernameMedico:
                            {
                                required: "Inserire username",
                                maxlength: "La lunghezza massima dello username è 15",
//                                remote: "Username già esistente"
                            },
                    passwordMedico:
                            {
                                required: "Inserire password",
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
                                maxlength: 20
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
                    indirizzoClinica:
                            {
                                required: true,
                                maxlength: 20
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
                    usernameClinica:
                            {
                                required: true,
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
                                maxlength: 2
                            },
                    capitaleSociale:
                            {
                                required: true,
                                rangelength: [2,2]
                            },
                    orarioApertutaMattina:
                            {
                                
                            },
                    orarioChiusuraMattina:
                            {
                                
                            },
                    orarioApertutaPomeriggio:
                            {
                                
                            },
                    orarioChiusuraPomeriggio:
                            {
                                
                            },
                    orarioContinuato:
                            {
                                
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
                                maxlength: "La lunghezza massima è 20"
                            },
                    numeroCivico:
                            {
                                number: "Il numero civico è un numero"
                            },
                    CAP:
                            {
                                required: "Inserire il CAP",
                                number: "Il CAP è un numero",
                                minlength: "Il CAP è un numero lungo 5 caratteri",
                                maxlength: "Il CAP è un numero lungo 5 caratteri"
                            },
                    email:
                            {
                                required: "Inserire l'email",
                                email: "Inserire un'email valida",
//                                remote: "Email già esistente"
                            },
                    usernameMedico:
                            {
                                required: "Inserire username",
                                maxlength: "La lunghezza massima dello username è 15",
//                                remote: "Username già esistente"
                            },
                    passwordMedico:
                            {
                                required: "Inserire password",
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

