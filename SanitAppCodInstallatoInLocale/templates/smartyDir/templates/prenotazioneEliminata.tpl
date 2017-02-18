{if ($prenotazioneEliminata===TRUE)}
    <p>La prenotazione è stata eliminata con successo</p>
    <br>
        {if ($mailInviata===TRUE)}            
            <p>L'utente è stato avvisato con un'email dell'avvenuta eliminazione della prenotazione </p>
            <br>
        {else}
            <p>Ci spiace, non è stato possibile inviare un'email all'utente</p>
            <br>
            <p>Contatti l'utente per avvertirlo dell'avvenuta eliminazione della prenotazione </p>
        {/if}           
{else}
    <p> C'è stato un problema, la prenotazione non è stata eliminata</p>
    <br>
{/if}
<input type="button" id="prenotazioneEliminata"  value="OK" />