function validazione(task1, controller1)
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
            if(controller1 == "impostazioni")
            {
                validazioneImpostazioniClinica();
            }
            else
            {
                validazioneClinica();
            }
            break; 
            
        case "autenticazione":
            validazioneLogIn();
            break;
            
        case "aggiungi":
            validazioneEsame();
            break;
            
        
            
        default: break;
    }
}



function validazioneLogIn()
{
    jQuery.validator.addMethod("password", function(valore){
        //espressione regolare per la password
        var regex = /(((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])).{6,10})/;
        return valore.match(regex);
        }, "La password consta da 6 a 10 caratteri, contiene almeno un numero, una lettera \n\
        maiuscola,una lettera minuscola. ");
    jQuery.validator.addMethod("username", function(valore){
        //espressione regolare per codice fiscale
        var regex = /[0-9a-zA-Z\_\-]{2,15}/;
        return valore.match(regex);
        }, "L'username contiene solo _ , - , numeri, lettere maiuscole o minuscole");
    $("#logInForm").validate({
        rules:
                {
                    uname:
                                {
                                    required:true,
                                    username: true
                                },
                    passwordLogIn:
                                {
                                    required:true,
                                    password: true
                                },
                },
        messages:
                {
                    uname:
                                {
                                    required: "Inserire username"
                                },
                    passwordLogIn:
                                {
                                    required: "Inserire password"
                                },
                },
        submitHandler:function(form) 
        { 
            alert('I dati log in sono stati inseriti correttamente');
            // inviaDatiRegistrazione si trova in clickRegistrazione.js
            inviaDatiLogIn('#logInForm', '#main' );
        }
    });
}

function validazioneUtente()
{
    //aggiungo un metodo di validazione per poter validare correttamente la password
    // il nome della classe, la funzione per validare e il messaggio in caso di errore
    jQuery.validator.addMethod("password", function(valore){
        //espressione regolare per la password
        var regex = /(((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])).{6,10})/;
        return valore.match(regex);
        }, "Inserire da 6 a 10 caratteri che contengano almeno un numero, una lettera \n\
        maiuscola,una lettera minuscola");
    
    jQuery.validator.addMethod("codiceFiscale", function(valore){
        //espressione regolare per codice fiscale
        var regex = /[A-Z]{6}[0-9]{2}[A-Z]{1}[0-9]{2}[A-Z]{1}[0-9]{3}[A-Z]{1}/;
        return valore.match(regex);
        }, "Il codice fiscale deve essee del tipo DMRCLD89S42G438S");
    
    jQuery.validator.addMethod("username", function(valore){
        //espressione regolare per codice fiscale
        var regex = /[0-9a-zA-Z\_\-]{2,15}/;
        return valore.match(regex);
        }, "Può contenere numeri, lettere maiuscole o minuscole");
    
    
    
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
                                codiceFiscale:true,
                                maxlength: 16, 
                                minlength: 16
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
                                number: true,
                                min:0
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
                                email: true
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
                                maxlength: 15
//                                remote:
//                                        { 
//                                           type: "GET",
//                                           url: "validazione/username/" + $("#usernameUtente").val()  
//                                        }
                            },
                    passwordUtente:
                            {
                                required: true
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
                                minlength: "Il codice fiscale è lungo 16 caratteri"
//                                remote: "Codice Fiscale già esistente"
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
                                email: "Inserire un'email valida del tipo mario.rossi@gmail.com"
//                                remote: "Email già esistente"
                            },
                    usernameUtente:
                            {
                                required: "Inserire username",
                                minlength: "La lunghezza minime dello username è 2",
                                maxlength: "La lunghezza massima dello username è 15"
//                                remote: "Username già esistente"
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
        submitHandler:function(form) 
        { 
            alert('I dati sono stati inseriti correttamente');
            // inviaDatiRegistrazione si trova in clickRegistrazione.js
            inviaDatiRegistrazione('#inserisciUtente', 'registrazione', 'utente', '#main');
        }
    });
}

function validazioneMedico()
{
    jQuery.validator.addMethod("password", function(valore){
        //espressione regolare per la password
        var regex = /(((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])).{6,10})/;
        return valore.match(regex);
        }, "Inserire una password che contenga almeno un numero, una lettera \n\
        maiuscola,una lettera minuscola");
    
    jQuery.validator.addMethod("codiceFiscale", function(valore){
        //espressione regolare per codice fiscale
        var regex = /[A-Z]{6}[0-9]{2}[A-Z]{1}[0-9]{2}[A-Z]{1}[0-9]{3}[A-Z]{1}/;
        return valore.match(regex);
        }, "Il codice fiscale deve essee del tipo DMRCLD89S42G438S");
        
    jQuery.validator.addMethod("username", function(valore){
        //espressione regolare per codice fiscale
        var regex = /[0-9a-zA-Z\_\-]{2,15}/;
        return valore.match(regex);
        }, "Può contenere numeri, lettere maiuscole o minuscole");
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
                                minlength: 16
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
                                number: true,
                                min:0
                            },
                    CAPMedico:
                            {
                                required: true,
                                minlength: 5,
                                maxlength: 5
                            },
                    emailMedico:
                            {
                                required: true,
                                email: true
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
                                maxlength: 15
//                                remote:
//                                        { 
//                                           type: "GET",
//                                           url: "validazione/username/" + $("#usernameUtente").val()  
//                                        }
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
                                minlength: "Il codice fiscale è lungo 16 caratteri"
//                                remote: "Codice Fiscale già esistente"
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
                    emailMedico:
                            {
                                required: "Inserire l'email",
                                email: "Inserire un'email valida"
//                                remote: "Email già esistente"
                            },
                    usernameMedico:
                            {
                                required: "Inserire username",
                                minlength: "La lunghezza minima dello username è 2",
                                maxlength: "La lunghezza massima dello username è 15"
//                                remote: "Username già esistente"
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
                                rangelength: "Deve avere 6 numeri"
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
    jQuery.validator.addMethod("password", function(valore){
        //espressione regolare per la password
        var regex = /(((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])).{6,10})/;
        return valore.match(regex);
        }, "Inserire una password che contenga almeno un numero, una lettera \n\
        maiuscola,una lettera minuscola");
    

    jQuery.validator.addMethod("orario", function(valore){
            //espressione regolare per l'orario
            var regex = /(([0-1]?[0-9]{1})|([2]{1}[0-3]{1})):([0-5]{1}[0-9]{1})(:([0-5]{1}[0-9]{1}))?/;
            return  valore.match(regex);        
        }, "Inserire un orario del tipo: 08:30 oppure 08:30:00");    
    
    jQuery.validator.addMethod("username", function(valore){
        //espressione regolare per codice fiscale
        var regex = /[0-9a-zA-Z\_\-]{2,15}/;
        return valore.match(regex);
        }, "Può contenere numeri, lettere maiuscole o minuscole");
    
    $("#inserisciClinica").validate({
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
                                maxlength: 11, 
                                minlength: 11
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
                                number: true,
                                min:0
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
                    emailClinica:
                            {
                                required: true,
                                email: true
//                                remote:
//                                        { 
//                                           type: "GET",
//                                           url: "validazione/email/" + $("#email").val()  
//                                        }             
                            },
                    PECClinica:
                            {
                                required: true,
                                email: true
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
                                maxlength: 15
//                                remote:
//                                        { 
//                                           type: "GET",
//                                           url: "validazione/username/" + $("#usernameUtente").val()  
//                                        }
                            },
                    passwordClinica:
                            {
                                required: true
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
                    orarioAperturaAM: 
                            {
                                required: true,
                                orario:true
                            },
                    orarioChiusuraAM: 
                            {
                                required: true,
                                orario:true
                            },
                    orarioAperturaPM: 
                            {
                                required: true,
                                orario:true
                            },
                    orarioChiusuraPM: 
                            {
                                required: true,
                                orario:true
                            }        
//                    orarioContinuato:
//                            {
//                                boolean: true
//                            }
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
                                minlength: "La sequenza minima di numeri è 11"
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
                                maxlength:"La sequenza massima di numeri è 10"
                            },
                    capitaleSociale:
                            {
                                required: "Inserire il capitale sociale della clinica",
                                maxlength: "La sequenza massima di numeri è 11"
                            },
                    orarioAperturaAM: 
                            {
                                required:"Non è necessario"
                            },
                    orarioChiusuraAM: 
                            {
                                required:"Non è necessario"
                            },
                    orarioAperturaPM: 
                            {
                                required:"Non è necessario"
                            },
                    orarioChiusuraPM: 
                            {
                                required:"Non è necessario"
                            }
//                    orarioContinuato:
//                            {
//                                boolean: "Deve essere un booleano"
//                            }
                },
        submitHandler:function(form) 
        { 
            alert('I dati sono stati inseriti correttamente');
            inviaDatiRegistrazione('#inserisciClinica', 'registrazione', 'clinica', '#main');
        }
    });
}


function validazioneImpostazioniClinica()
{    
    jQuery.validator.addMethod("time", function(valore){
        //espressione regolare per la durata
        var regex = /([0-2][0-3]):([0-5]\d):([0-5]\d)/;
        return valore.match(regex);
        }, "La durata è nel formato hh:mm:ss");
    $.validator.addClassRules({
        time:
                {
                    required: true,
                    time: true, 
                    messages:{required:"Inserire orario"}
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
        submitHandler:function(form) 
        { 
            alert('Impostazioni inserite correttamente');
            // inviaDatiEsame si trova in clickGestisciServizi.js
            inviaImpostazioniClinica('#aggiungiEsame', 'servizi', 'aggiungi', '#main');
        }
    });  
}
function validazioneEsame()
{    
    jQuery.validator.addMethod("time", function(valore){
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
                                time:true
                            },
                    numPrestazioniSimultanee:
                            {
                                required: true,
                                number: true,
                                max: 20,
                                min: 1
                            },
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
                            },
//                    descrizioneEsame:
//                            {
//                                required: "Inserisci una breve descrizione",
//                                maxlenght:"Max 200 caratteri"
//                        
//                            }
                },
        submitHandler:function() 
        { 
            alert('I dati sono stati inseriti correttamente');
            // inviaDatiEsame si trova in clickGestisciServizi.js
            inviaDatiEsame('#aggiungiEsame', 'servizi', 'aggiungi', '#main');
        }
    });
}