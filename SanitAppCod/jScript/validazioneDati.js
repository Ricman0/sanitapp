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
                            remote:
                                    { 
                                       type: "GET",
                                       url: "validazione/codiceFiscale/" + $("#codiceFiscale").val()  
                                    }
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
                            remote:
                                    { 
                                       type: "GET",
                                       url: "validazione/email/" + $("#email").val()  
                                    }             
                        },
                usernameUtente:
                        {
                            required: true,
                            maxlength: 15,
                            remote:
                                    { 
                                       type: "GET",
                                       url: "validazione/username/" + $("#usernameUtente").val()  
                                    }
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
                            remote: "Codice Fiscale già esistente"
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
                            remote: "Email già esistente"
                        },
                usernameUtente:
                        {
                            required: "Inserire username",
                            maxlength: "La lunghezza massima dello username è 15",
                            remote: "Username già esistente"
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
            }
});


