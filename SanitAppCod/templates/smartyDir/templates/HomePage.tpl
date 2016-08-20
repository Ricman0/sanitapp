<!DOCTYPE html>
<html>
    <head> 
        <link rel="stylesheet" type="text/css" href="./Css/normalize.css">
        <link rel="stylesheet" type="text/css" href="./Css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="./Css/homePage.css">
        <link rel="stylesheet" type="text/css" href="./Css/logo.css">
        <link rel="icon" href="./Immagini/favicon.ico" />       
        <link rel="stylesheet" type="text/css" href="./Css/logIn.css">
       

        <!--       <link rel="stylesheet" type="text/css" href="./Css/inserisciUtente.css">
                <link rel="stylesheet" type="text/css" href="./Css/inserisciMedico.css">-->
        <link rel="stylesheet" type="text/css" href="./Css/navigationBar.css">
        <link rel="stylesheet" type="text/css" href="./Css/mainRicerca.css">  
        <link rel="stylesheet" type="text/css" href="./Css/footer.css">
        <link rel="stylesheet" type="text/css" href="./Css/cartinaItalia.css"/>
        <link rel="stylesheet" type="text/css" href="./Css/areaPersonale.css"/>

        <script type="text/javascript" src="./jScript/jquery-1.12.4.min.js"></script>
        <script type="text/javascript" src="./jScript/gestioneCartinaItalia.js"></script>
        <script type="text/javascript" src="./jScript/eventi_click.js"></script>
        <!--<script type="text/javascript" src="./jScript/clickRegistrazione.js"></script>-->
        <script type="text/javascript" src="./jScript/clickLogIn.js"></script>
        <script type="text/javascript" src="./jScript/prova.js"></script>
        <script type="text/javascript" src="./jScript/clickEsami.js"></script>
        <script type="text/javascript" src="./jScript/clickCliniche.js"></script>
        <script type="text/javascript" src="./jScript/clickCercaCliniche.js"></script>

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
                {$areaPersonale }
                
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