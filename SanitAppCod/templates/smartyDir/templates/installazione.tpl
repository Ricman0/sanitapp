<!DOCTYPE html>
<html>
    <head> 
        <link rel="stylesheet" type="text/css" href="./Css/normalize.css">
        <link rel="stylesheet" type="text/css" href="./Css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="./Css/homePage.css">
        <link rel="stylesheet" type="text/css" href="./Css/logo.css">
        <link rel="icon" href="./Immagini/favicon.ico" />

        <link rel="stylesheet" type="text/css" href="./Css/footer.css">
        <link rel="stylesheet" type="text/css" href="./plugins/jquery-ui/jquery-ui.min.css"/>

        <script type="text/javascript" src="./plugins/jquery-1.12.4.js"></script>
        <script type="text/javascript" src="./plugins/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="./plugins/jquery-ui/datepicker-it.js"></script>        
        <script type="text/javascript" src="./plugins/jquery.validate.js"></script>

        <script type="text/javascript" src="./jScript/eventi_click.js"></script>
        <script type="text/javascript" src="./jScript/validazioneSetup.js"></script>

    </head>

    <body>
        <!-- Classe container per l'intera pagina-->
        <div id="wrapper">
            <div id="headerMain">
                <!-- Header della pagina-->
                  <div class="headerSottile" id="header">
                    <img id="logoSanitApp" class="centrato logoSmallFisso" src="Immagini/logoSanitApp.png" alt="logoSanitApp">
                </div>
                <br>
                <hr>
                <!-- Main della pagina-->

                <div id="main">
                     <noscript>
            <div class="noscript">
                Il tuo browser non supporta JavaScript, o lo hai disattivato!<br>
                Riattivalo accedendo alle impostazioni del browser se vuoi usufruire dei nostri servizi
            </div>
            </noscript> 
            
            <form id="formInstallazione">
                <div id="databaseEmailConfig" class="affiancato verticalmenteAllineato">
                    <h3>Configurazione</h3>
                    <br>
                    Database
                    <br>
                    <br>
                    <label for="host" class="elementiForm">Host</label>
                    <input type="text" name="host" id="host" class="elementiForm" value="{if isset($dati_registrazione.host)}{$dati_registrazione.host}{/if}" required/>
                    <br>

                    <label for="user_db" class="elementiForm">User db</label>
                    <input type="text" name="user_db" id="user_db" class="elementiForm" value="{if isset($dati_registrazione.user_db)}{$dati_registrazione.user_db}{/if}" required/>
                    <br>

                    <label for="password_db" class="elementiForm">Password</label>
                    <input type="password" name="password" id="password_db" class="elementiForm" value="{if isset($dati_registrazione.password_db)}{$dati_registrazione.password_db}{/if}" required/>
                    <br>

                    <label for="confermapassword_db" class="elementiForm">Conferma password</label>
                    <input type="password" name="confermaPassword" id="confermapassword_db" class="elementiForm" value="{if isset($dati_registrazione.password_db)}{$dati_registrazione.password_db}{/if}" required/>
                    <br>
                    <br>
                    Server SMTP
                    <br>
                    <br>
                    <label for="smtp" class="elementiForm">Server SMTP</label>
                    <input type="text" name="smtp" id="smtp" class="elementiForm" value="{if isset($dati_registrazione.smtp)}{$dati_registrazione.smtp}{/if}" required/>
                    <br>
                    <label for="email_admin" class="elementiForm">E-mail</label>
                    <input type="email" name="email_admin" id="email_admin" class="elementiForm" value="{if isset($dati_registrazione.email_admin)}{$dati_registrazione.email_admin}{/if}" required/>
                    <br>
                    <label for="password_mail" class="elementiForm">Password</label>
                    <input type="password" name="password_mail" id="password_mail" class="elementiForm" value="{if isset($dati_registrazione.password_mail)}{$dati_registrazione.password_mail}{/if}" required/>
                    <br>
                    <br>
                </div>
                    <div id="adminConfig" class="affiancato verticalmenteAllineato">


                    <h3>Amministratore</h3>
                    <br>
                    <br>  <br>  

                    <label for="nome" class="elementiForm">Nome</label>
                    <input type="text" name="nome" id="nome" class="elementiForm" value="{if isset($dati_registrazione.nome)}{$dati_registrazione.nome}{/if}" required/>
                    <br>

                    <label for="cognome" class="elementiForm">Cognome</label>
                    <input type="text" name="cognome" id="cognome" class="elementiForm" value="{if isset($dati_registrazione.cognome)}{$dati_registrazione.cognome}{/if}" required/>
                    <br>

                    <label for="username" class="elementiForm">Username</label>
                    <input type="text" name="username" id="username" class="elementiForm" value="{if isset($dati_registrazione.username)}{$dati_registrazione.username}{/if}" required/> 
                    <br>

                    <label for="password" class="elementiForm">Password</label>
                    <input type="password" name="password" id="password" class="elementiForm" value="{if isset($dati_registrazione.password)}{$dati_registrazione.password}{/if}" required/>
                    <br>

                    <label for="confermaPassword" class="elementiForm">Conferma password</label>
                    <input type="password" name="confermaPassword" id="confermaPassword" class="elementiForm" value="{if isset($dati_registrazione.password)}{$dati_registrazione.password}{/if}" required/>
                    <br>

                    <label for="email" class="elementiForm">E-mail</label>
                    <input type="email" name="email" id="email" class="elementiForm" value="{if isset($dati_registrazione.email)}{$dati_registrazione.email}{/if}" required/>
                    <br>

                </div>
                    <input type="submit" class="centrato nuovaRiga" id="registrazione" name="submit" value="Installa" />
                <br>
              <!--  <div id="loading">
                    <i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>
                </div>
              -->

            </form>
                </div> 
                
            </div>
            <div id="dialog" title="Attenzione" >
                <p id='messaggioDialogBox' ></p>
            </div>
            <!--Footer della pagina-->
            <div id="footer">
                <span class="copyright">©2016 Copyright - SanitApp</span>
            </div>
        </div>
    </body>
</html>