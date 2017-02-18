<!DOCTYPE html>
<html>
    <head> 
        <link rel="stylesheet" type="text/css" href="./Css/normalize.css">
        <link rel="stylesheet" type="text/css" href="./Css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="./Css/homePage.css">
        <link rel="stylesheet" type="text/css" href="./Css/logo.css">
        <link rel="icon" href="./Immagini/favicon.ico" />

        <link rel="stylesheet" type="text/css" href="./plugins/jquery-ui/jquery-ui.min.css"/>

        <script type="text/javascript" src="./plugins/jquery-1.12.4.js"></script>
        <script type="text/javascript" src="./plugins/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="./plugins/jquery-ui/datepicker-it.js"></script>        
        <script type="text/javascript" src="./plugins/jquery.validate.js"></script>

        <script type="text/javascript" src="./jScript/funzioniGeneriche.js"></script>
        <script type="text/javascript" src="./jScript/clickHomePage.js"></script>
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
                      
                    {$contenuto}
                </div> 
                
            </div>
            <div id="dialog" title="Attenzione" >
                <p id='messaggioDialogBox' ></p>
            </div>
            <!--Footer della pagina-->
            
            <div id="footer">
                <span class="copyright">©2017 Copyright - SanitApp</span>
            </div>
        </div>
    </body>
</html>