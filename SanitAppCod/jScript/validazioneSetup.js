/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    
    
   
       $(function() {
            $(document).tooltip({
                items: 'input.error'
//                content: function(){
//                    return $(this).next('label.error').text();
//                }
            });
         });


    
    //aggiungo un metodo di validazione per poter validare correttamente la password
    // il nome della classe, la funzione per validare e il messaggio in caso di errore
    jQuery.validator.addMethod("password", function (valore) {
        //espressione regolare per la password
        var regex = /(((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])).{6,10})/;
        return valore.match(regex);
    }, "Inserire da 6 a 10 caratteri che contengano almeno un numero, una lettera \n\
        maiuscola,una lettera minuscola");
    
    jQuery.validator.addMethod("username", function (valore) {
        //espressione regolare per codice fiscale
        var regex = /[0-9a-zA-Z\_\-]{2,15}/;
        return valore.match(regex);
    }, "Può contenere numeri, lettere maiuscole o minuscole");

    $("#formInstallazione").validate({
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
                    password:
                            {
                                required: true,
                                password: true
                            },
                    confermaPassword:
                            {
                                required: true,
                                equalTo: "#password"
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
                    password:
                            {
                                required: "Inserire password"
                            },
                    confermaPassword:
                            {
                                required: "Inserire nuovamente la password",
                                equalTo: "La password deve essere sempre la stessa"
                            }
                },
                errorPlacement: function(error, element){
                    $(element).attr('title', error.text());
                },
                unhighlight: function(element) {
                    $(element).removeAttr('title').removeClass('error');
                  },



        submitHandler: function ()
        {
            alert('I dati sono stati inseriti correttamente');
            var ajaxDiv = "#main";
            alert(ajaxDiv);
            inviaDatiInstallazione('#inserisciUtente', 'registrazione', 'utente', ajaxDiv);
        }
    });
});

function inviaDatiInstallazione(){
    
}

