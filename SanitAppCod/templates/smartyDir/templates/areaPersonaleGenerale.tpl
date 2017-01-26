<div class="sideNavBar affiancato verticalmenteAllineato" id="divSideNavBar">
    <ul  id="sideNavBarList">
        {foreach from=$tastiLaterali key=id item=tasto}
            
                {if $tasto=="Impostazioni" && count($tastiLaterali)==6}
                    <li class="nav" id='impostazioniClinica'>
                        <a id="{$id}" class="nav" >{$tasto}</a>
                      <!--  <button onclick="myFunction()" class="dropbtn">Dropdown</button> -->
                        <div class="dropdown-content">
                          <a id='impostazioniGeneraliClinica' >Impostazioni Generali </a>
                          <a id='impostazioniWorkingPlan'>Working Plan</a>
                        </div>  
                {else}
                    <li><a id="{$id}" >{$tasto}</a>
                {/if}
            </li>
        {/foreach}         
    </ul>   
</div>    

<div class="contenutoAreaPersonale affiancato verticalmenteAllineato " id="contenutoAreaPersonale">
    {if isset($contenutoAreaPersonale)}
        {$contenutoAreaPersonale}
    {else}
        {if count($tastiLaterali)==3}
            <br>
            <h1>Ciao UTENTE </h1>
            <p>Benvenuto nella tua area personale, da qui potrai gestire le tue prenotazioni 
                e consultare i referti o,<br> se vuoi, condividerli con il tuo medico curante</p>
            
        {elseif count($tastiLaterali)==6}
            <br>
            <h1>Ciao CLINICA </h1>
            <p>Benvenuto nella tua area personale, da qui potrai gestire i servizi, le prenotazioni, 
                i pazienti, i referti e le tue impostazioni.</p>
        {else}
            {if isset($tastiLaterali['prenotazioniAreaPersonaleMedico'])}
            <br>
                <h1>Ciao DOTTORE </h1>
                <p>Benvenuto nella tua area personale, da qui potrai gestire le prenotazioni, 
                i pazienti e i referti.</p>
            {else}
            <br>
                <h1>Ciao AMMINISTRATORE </h1>
                <p>Benvenuto nella tua area personale, da qui potrai gestire gli user dell'applicazione</p>
            {/if}
        {/if}        
    {/if}    
</div>
