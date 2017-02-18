<div id="elementiFormMainRicerca" class="affiancato">
    <div id="inputMainRicerca" class="affiancato verticalmenteAllineato">
        <h3 class="grigio">Cosa cerchi?</h3>
        <img src="./Immagini/iconaRicerca.png" id="iconaMainRicercaRicerca" class="affiancato verticalmenteAllineato">
        <form id="formMainRicerca" class="affiancato verticalmenteAllineato"> 
            <input type="hidden" name="controller" value="esami" class ='controllerFormRicercaEsami' id="controllerFormMainRicerca"/> 
            <label for="esame" class="ricerca">Esame</label>
            <input type="text" name="esame" class="ricerca" id="mainRicercaEsame" target="_blank" 
                   placeholder="Raggi"/>
            <label for="luogo" class="ricerca">Luogo</label>
            <input type="text" name="luogo" class="ricerca" id="mainRicercaLuogo" target="_blank" 
                   placeholder="Roma"/>
            <br>
            <input type="button" class="ricerca ricercaEsamiCerca" id="mainRicercaCerca" value="Cerca"> 
        </form>
    </div>

    <div id="italy-map" class="affiancato verticalmenteAllineato"> 

        <div id="region-map">
            <img src="./Immagini/transparent.gif"  title="Clicca su una regione per vedere le cliniche!" 
                 alt="Clicca su una regione per vedere le cliniche!" usemap="#ItalyMap" /> 
        </div> 
    </div>

    <map id="ItalyMap" name="ItalyMap"> 
        <area shape="poly" class="cliccabile" data-id="1" alt="Valle d'Aosta" title="Valle de Aosta"   coords="47,56,48,76,14,86,1,65" /> 
        <area shape="poly" class="cliccabile" data-id="2" alt="Piemonte" title="Piemonte"   coords="66,34,73,46,74,67,79,84,70,94,85,106,95,122,78,133,58,128,49,153,32,154,7,136,11,119,-2,103,7,96,19,96,21,83,48,75,48,57,60,42" /> 
        <area shape="poly" class="cliccabile" data-id="3" alt="Liguria" title="Liguria"   coords="131,156,105,134,108,131,90,126,69,137,74,133,65,131,56,141,49,157,47,154,40,154,31,165,35,169,48,170,75,141,89,137,95,139" /> 
        <area shape="poly" class="cliccabile" data-id="4" alt="Lombardia" title="Lombardia"   coords="101,122,88,105,75,107,72,89,84,84,73,65,78,47,92,63,105,27,113,40,132,39,137,23,157,35,148,39,152,48,142,64,147,57,149,64,162,65,151,79,159,80,158,84,153,85,160,95,183,109,153,107,154,110,130,104,130,99,117,103,113,100,102,108,105,117" /> 
        <area shape="poly" class="cliccabile" data-id="5" alt="Trentino-Alto Adigio" title="Trentino-Alto Adige"  coords="150,64,166,66,162,73,176,70,176,63,190,51,192,59,196,47,203,50,203,43,197,37,197,29,210,27,210,19,212,26,224,20,213,12,213,-3,199,5,176,6,166,17,152,12,141,17,146,14,145,25,136,24,141,30,154,34,148,40,151,45,146,59" /> 
        <area shape="poly" class="cliccabile" data-id="6" alt="Veneto" title="Veneto"   coords="218,116,210,114,209,107,197,110,190,113,177,108,155,88,157,82,160,67,177,74,182,52,203,49,205,40,199,35,225,19,233,23,232,35,219,43,223,51,223,61,229,67,242,67,247,72,220,86,218,101,228,112" /> 
        <area shape="poly" class="cliccabile" data-id="7" alt="Friuli-Venezia Giulia" title="Friuli-Venezia Giulia"   coords="277,78,272,73,246,75,242,65,227,66,223,62,221,44,238,22,272,32,265,42,271,52,270,64,279,72" /> 
        <area shape="poly" class="cliccabile" data-id="8" alt="Emilia-Romagna" title="Emilia-Romagna"   coords="236,162,231,157,214,161,210,171,189,158,196,152,177,143,178,148,165,153,125,132,109,138,99,127,103,115,108,100,131,103,144,107,148,111,153,110,215,111,215,139" /> 
        <area shape="poly" class="cliccabile" data-id="9" alt="Toscana" title="Toscana"   coords="185,236,196,224,200,212,205,198,214,193,215,169,196,167,193,152,181,147,164,156,125,132,120,140,132,153,146,191,150,208,151,213,144,216,133,217,133,221,142,223,149,220,145,216,152,213,168,225,177,238" /> 
        <area shape="poly" class="cliccabile" data-id="10" alt="Umbria" title="Umbria"   coords="228,238,253,221,256,217,242,212,235,186,228,186,220,178,210,179,212,189,206,201,203,217,205,226,212,224,225,237" /> 
        <area shape="poly" class="cliccabile" data-id="11" alt="Lazio" title="Lazio"   coords="276,298,282,277,264,270,254,260,242,256,247,249,258,250,258,248,250,246,249,231,260,229,254,221,226,240,212,226,206,228,202,217,197,220,196,232,188,240,205,260,215,267,219,274,245,293" /> 
        <area shape="poly" class="cliccabile" data-id="12" alt="Marche" title="Marche"   coords="215,169,232,186,237,189,240,210,255,216,259,227,279,213,264,174,253,175,239,158,234,167,222,157,221,155,209,166" /> 
        <area shape="poly" class="cliccabile" data-id="13" alt="Abruzzo" title="Abruzzo"   coords="312,255,279,213,258,227,261,232,250,230,252,245,259,250,254,251,246,251,245,255,263,267,284,274,289,272,289,269,296,262,301,267,301,271,305,270" /> 
        <area shape="poly" class="cliccabile" data-id="14" alt="Molise" title="Molise"  coords="328,261,315,257,305,271,302,268,297,264,290,270,291,272,283,275,284,284,284,288,285,292,290,281,303,289,321,283,318,278,326,274" /> 
        <area shape="poly" class="cliccabile" data-id="15" alt="Campania" title="Campania"  coords="342,360,349,346,331,316,341,312,342,305,331,301,331,298,320,283,301,290,290,282,286,289,274,298,285,317,295,317,303,329,316,328,321,348" /> 
        <area shape="poly" class="cliccabile" data-id="16" alt="Puglia" title="Puglia"   coords="329,261,360,255,368,266,367,272,359,280,364,289,411,310,420,319,440,325,445,331,452,338,454,346,454,359,450,370,438,363,427,342,413,344,399,331,394,341,385,334,386,322,373,321,365,311,363,309,354,306,360,308,362,306,353,297,354,299,341,305,330,296,320,278,327,277" /> 
        <area shape="poly" class="cliccabile" data-id="17" alt="Basilicata" title="Basilicata"   coords="351,361,343,356,351,346,335,317,342,313,343,306,359,304,361,310,358,312,375,321,387,324,387,336,395,339,386,351,376,350,372,363,361,363,359,359" /> 
        <area shape="poly" class="cliccabile" data-id="18" alt="Calabria" title="Calabria"  coords="363,466,345,462,345,447,353,438,356,422,367,415,361,405,363,391,352,364,355,357,372,364,378,349,383,351,378,371,404,387,404,410,387,416,381,428,385,433" /> 
        <area shape="poly" class="cliccabile" data-id="19" alt="Sardegna" title="Sardegna"   coords="92,418,96,400,110,406,121,377,117,346,124,329,109,292,91,302,75,313,62,310,58,323,68,339,66,362,72,364,61,402,78,416" /> 
        <area shape="poly" class="cliccabile" data-id="20" alt="Sicilia" title="Sicilia"   coords="322,529,299,521,286,507,271,505,237,482,228,481,219,472,226,451,238,453,249,447,269,456,296,459,309,449,323,453,340,445,344,450,329,474,325,489,334,508,332,513" /> 
    </map>
</div>
