<!DOCTYPE html>
<html>
    <head> 
        <link rel="stylesheet" type="text/css" href="./Css/normalize.css">
        <link rel="stylesheet" type="text/css" href="./Css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="./Css/homePage.css">
        <link rel="stylesheet" type="text/css" href="./Css/logo.css">
        <link rel="icon" href="./Immagini/favicon.ico" />       
        <link rel="stylesheet" type="text/css" href="./Css/log.css">
       
        <!--       <link rel="stylesheet" type="text/css" href="./Css/inserisciUtente.css">
                <link rel="stylesheet" type="text/css" href="./Css/inserisciMedico.css">-->
        <link rel="stylesheet" type="text/css" href="./Css/navigationBar.css">
        <link rel="stylesheet" type="text/css" href="./Css/mainRicerca.css">  
        <link rel="stylesheet" type="text/css" href="./Css/footer.css">
        <link rel="stylesheet" type="text/css" href="./Css/cartinaItalia.css"/>
        <link rel="stylesheet" type="text/css" href="./Css/areaPersonale.css"/>
        <link rel="stylesheet" type="text/css" href="./Css/tabelle.css"/>
        <link rel="stylesheet" type="text/css" href="./plugins/jquery-ui-timepicker/jquery-ui-timepicker-addon.css"/>
        <link rel="stylesheet" type="text/css" href="./plugins/jquery-ui/jquery-ui.min.css"/>
        <link rel='stylesheet' href='plugins/fullcalendar/fullcalendar.css' />

        <script type="text/javascript" src="./plugins/jquery-1.12.4.js"></script>
        <script type="text/javascript" src="./plugins/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="./plugins/jquery-ui/datepicker-it.js"></script>        
        <script type="text/javascript" src="./plugins/jquery.validate.js"></script>
        <script type="text/javascript" src="./plugins/jquery.tablesorter.js"></script>
        <script type="text/javascript" src="./plugins/jquery-ui-timepicker/jquery-ui-timepicker-addon.js"></script>
        
        <script type="text/javascript" src="./jScript/gestioneCartinaItalia.js"></script>
        <script type="text/javascript" src="./jScript/eventi_click.js"></script>
        <script type="text/javascript" src="./jScript/clickRegistrazione.js"></script>
        <script type="text/javascript" src="./jScript/clickLogIn.js"></script>
        <script type="text/javascript" src="./jScript/clickEsami.js"></script>
        <script type="text/javascript" src="./jScript/clickCercaCliniche.js"></script>
        <script type="text/javascript" src="./jScript/clickCercaEsami.js"></script>
        <script type="text/javascript" src="./jScript/validazioneDati.js"></script>
        <script type="text/javascript" src="./jScript/clickHome.js"></script>
        <script type="text/javascript" src="./jScript/clickClinica.js"></script>
        <script type="text/javascript" src="./jScript/clickUtente.js"></script>
        <script type="text/javascript" src="./jScript/clickMedico.js"></script>
        <script type="text/javascript" src="./jScript/clickPrenotazione.js"></script>
        <script src='plugins/moment.js'></script>
        <script src='plugins/fullcalendar/fullcalendar.js'></script>

        <!--<img src="./Immagini/cartinaItalia.gif" />-->




        <!--inserisco meta viewport per ottenere una nav bar responsive
        <meta name="viewport" content="width=device-width" initial-scale=1  maximum-scale=1>    

        <meta charset="UTF-8">
        
        <script type="text/javascript" src="./jScript/adaptive-image.js"></script>-->

    </head>

    <body>
        <!-- Classe container per l'intera pagina-->
        <div id="wrapper">

            <!-- Header della pagina-->

            <div class="header" id="header">
                <img id="logoSanitApp" src="Immagini/logoSanitApp.png" alt="logoSanitApp">
                {$logIn}
                {$navigationBar}    <!-- Navigation bar della pagina-->
            </div>
            <br>
            <!-- Main della pagina-->
            <div id="main">
                {$mainRicerca}
                {$cartina}
            </div> 

            <div id="contenutiAjax">

            </div>
            <!--Footer della pagina-->
            <div id="footer">
                <span class="copyright">©2016 Copyright - SanitApp</span>
            </div>
        </div>
    </body>
</html>