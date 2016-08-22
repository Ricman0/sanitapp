$("#inserisciUtente").validate({
    rules:
            {
                nome:
                        {
                            required: true
                        },
                cognome:
                        {
                            required: true
                        },
                codiceFiscale:
                        {
                            required: true,
                            maxlength: 16, 
                            minlength: 16
                            
                            
                        },
                indirizzo:
                        {
                            required: true
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
                                       url: "validazione/utente/" + $("#email").val()  
                                    } 
                                    
                                    
                        },
                usernameUtente:
                        {
                            required: true,
                        },
                passwordUtente:
                        {
                            required: true,
                            minlength: 6

                        },
                ripetiPasswordUtente:
                        {
                            required: true,
                            equalTo: "#passwordUtente",
                        }
            },
    messages:
            {
                nome:
                        {
                            required: "Inserire nome"
                        },
                cognome:
                        {
                            required: "Inserire cognome"
                        },
                codiceFiscale:
                        {
                            required: "Inserire il proprio codice fiscale",
                            maxlength: "Il codice fiscale è lungo 16 caratteri",
                            minlength: "Il codice fiscale è lungo 16 caratteri"
                        },
                indirizzo:
                        {
                            required: "Inserire indirizzo"
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
                        },
                passwordUtente:
                        {
                            required: "Inserire password",
                            minlength: "La lunghezza minima della password è 6"

                        },
                ripetiPasswordUtente:
                        {
                            required: "Inserire nuovamente la password",
                            equalTo: "La password deve essere sempre la stessa",
                        }
            },
});

