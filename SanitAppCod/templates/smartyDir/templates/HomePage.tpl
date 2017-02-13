<!DOCTYPE html>
<html>
    <head> 
        <link rel="stylesheet" type="text/css" href="./Css/normalize.css">
        <link rel="stylesheet" type="text/css" href="./Fonts/font-awesome/css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="./Css/homePage.css">
        <link rel="stylesheet" type="text/css" href="./Css/logo.css">
        <link rel="icon" href="./Immagini/favicon.ico" />       
        <link rel="stylesheet" type="text/css" href="./Css/log.css">

        <!--       <link rel="stylesheet" type="text/css" href="./Css/inserisciUtente.css">
                <link rel="stylesheet" type="text/css" href="./Css/inserisciMedico.css">-->
        <link rel="stylesheet" type="text/css" href="./Css/navigationBar.css">
        <link rel="stylesheet" type="text/css" href="./Css/mainRicerca.css">
        <link rel="stylesheet" type="text/css" href="./Css/cartinaItalia.css"/>
        <link rel="stylesheet" type="text/css" href="./Css/areaPersonale.css"/>
        <link rel="stylesheet" type="text/css" href="./plugins/jquery-ui-timepicker/jquery-ui-timepicker-addon.css"/>
        <link rel="stylesheet" type="text/css" href="./plugins/jquery-ui/jquery-ui.min.css"/>
        <link rel='stylesheet' href='plugins/fullcalendar/fullcalendar.css' />
        <link rel='stylesheet' href='./Css/tabelle.css' />
        <link rel='stylesheet' href='plugins/tablesorter/theme.blue.css' />

        <script type="application/javascript" src="./plugins/jquery-1.12.4.js"></script>
        <script type="application/javascript" src="./plugins/jquery-ui/jquery-ui.min.js"></script>
        <script type="application/javascript" src="./plugins/jquery-ui/datepicker-it.js"></script>        
        <script type="application/javascript" src="./plugins/jquery.validate.js"></script>
        <script type="application/javascript" src="./plugins/additional-methods.min.js"></script>
        <script type="application/javascript" src="./plugins/tablesorter/jquery.tablesorter.js"></script>
        <script type="application/javascript" src="./plugins/tablesorter/jquery.tablesorter.widgets.js"></script>
        <script type="application/javascript" src="./plugins/jquery-ui-timepicker/jquery-ui-timepicker-addon.js"></script>

        <script type="application/javascript" src="./jScript/gestioneCartinaItalia.js"></script>
        <script type="application/javascript" src="./jScript/funzioniGeneriche.js"></script>
        <script type="application/javascript" src="./jScript/clickHomePage.js"></script>
        <script type="application/javascript" src="./jScript/clickLogIn.js"></script>
        <script type="application/javascript" src="./jScript/clickEsami.js"></script>
        <script type="application/javascript" src="./jScript/clickCercaCliniche.js"></script>
        <script type="application/javascript" src="./jScript/clickCercaEsami.js"></script>
        <script type="application/javascript" src="./jScript/validazioneDati.js"></script>
        <script type="application/javascript" src="./jScript/clickClinica.js"></script>
        <script type="application/javascript" src="./jScript/clickUtente.js"></script>
        <script type="application/javascript" src="./jScript/clickMedico.js"></script>
        <script type="application/javascript" src="./jScript/clickPrenotazione.js"></script>
        <script type="application/javascript" src="./jScript/clickAmministratore.js"></script>
        <script src='plugins/moment.js'></script>
        <script src='plugins/fullcalendar/fullcalendar.js'></script>
        <script src='plugins/fullcalendar/locale/it.js'></script>

    </head>

    <body>
        <!-- Classe container per l'intera pagina-->
        <div id="wrapper">
            <div id="headerMain">
                <!-- Header della pagina-->

                <div class="header" id="header">
                    <img id="logoSanitApp" class="logoBig" src="Immagini/logoSanitApp.png" alt="logoSanitApp">
                    <div id="logNavBar">
                        {$logIn}
                        {$navigationBar}    <!-- Navigation bar della pagina-->
                    </div>
                </div>
                <br>
                <!-- Main della pagina-->

                <div id="main">
                    {$mainRicerca}
                </div> 

            </div>
            <div id="dialog" title="Attenzione" >
                <p id='messaggioDialogBox' ></p>
            </div>
            <div id="loadingModal" class='modal'>    
                <div id="loading" class="loading">
                    <!-- per l'animazione durante il caricamento di una pagina -->
                </div>
            </div>
            <!--Footer della pagina-->
            <div id="footer">
                <div class="centrato">
                    <a id="info" class="soloController" >Informazioni Validazione </a>  |  <a id="contatti" class="soloController" > Contatti</a>  |  <a id="privacyPolicy" class="soloController" > Privacy Policy</a>
                </div>
                <div class="copyright centrato">©2017 Copyright - SanitApp</div>
            </div>
        </div>
    </body>
</html>