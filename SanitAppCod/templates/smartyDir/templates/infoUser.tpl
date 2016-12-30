<h3>INFORMAZIONI</h3>

<span class="grassetto">USERNAME:</span><span>  {$user.Username}</span>
<br>
<span class="grassetto">EMAIL:</span><span>  {$user.Email}</span>
<br>
<span class="grassetto">CONFERMATO:</span><span>  {$user.Confermato}</span>
<br>
<span class="grassetto">CODICE CONFERMA:</span><span>  {$user.CodiceConferma}</span>
<br>
<span class="grassetto">BLOCCATO:</span><span>  {$user.Bloccato}</span>
<br>

{if ($tipoUser=='utente' || $tipoUser=='medico')}
    <span class="grassetto">CODICE FISCALE:</span><span>  {$user.CodFiscale}</span>
    <br>
    <span class="grassetto">NOME:</span><span>  {$user.Nome} {$user.Cognome}</span>
    <br>
    <span class="grassetto">INDIRIZZO:</span><span>  {$user.Via}, {$user.NumCivico}, {$user.CAP} </span>
    <br>
{/if}

{if ($tipoUser=='clinica')}
    <span class="grassetto">PARTITA IVA:</span><span>  {$user.PartitaIVA}</span>
    <br>
    <span class="grassetto">NOME CLINICA:</span><span>  {$user.NomeClinica}</span>
    <br>
    <span class="grassetto">TITOLARE CLINICA:</span><span>  {$user.Titolare}</span>
    <br>
    <span class="grassetto">INDIRIZZO:</span><span>  {$user.Via}, {$user.NumCivico}, {$user.CAP} {$user.Localita} {$user.Provincia}</span>
    <br>
    <span class="grassetto">TELEFONO:</span><span>  {$user.Telefono}</span>
    <br>
    
{/if}

{if ($tipoUser=='medico')}
    <span class="grassetto">PROVINCIA ALBO:</span><span>  {$user.ProvinciaAlbo}</span>
    <br>
    <span class="grassetto">NUMERO ISCRIZIONE ALBO:</span><span>  {$user.NumIscrizione}</span>
    <br>
{/if}

{if ($tipoUser=='clinica' || $tipoUser=='medico')}    
    <span class="grassetto">PEC:</span><span>  {$user.PEC}</span>
    <br>
    <span class="grassetto">VALIDATO:</span><span>  {$user.Validato}</span>
    <br>
{/if}

<div id='tastiInfoUser'>
    
    {if ($user.Bloccato==='SI')}
        <input type="button" id="sbloccaUser" value="Sblocca User" />     
    {else}
        <input type="button" id="bloccaUser" value="Blocca User" />      
    {/if}

    {if ($user.Validato==='NO')}
        <input type="button" id="validaUser" value="Valida User" />        
    {/if}

    {if ($user.Confermato==='NO')}
        <input type="button" id="confermaUser" value="Conferma User" />          
    {/if}
    
</div>