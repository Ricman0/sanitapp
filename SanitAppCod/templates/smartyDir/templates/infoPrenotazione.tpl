<div id="infoPrenotazione">
            <span>
                Esame: {$nomeEsame}
            </span>
            <br>
            <span>
                Data e Ora: {$prenotazione->getDataEOra()}
            </span>
            <br>
            <span>
               Medico: {$medicoEsame}
            </span>
            <br>
            {if ($tipoUser==='utente')}
                <span>
                    Clinica: {$eClinica->getNomeClinica()}
                </span>
           
                <div>
                   Indirizzo Clinica: {$eClinica->getViaClinica()} , {$eClinica->getLocalitaClinica()} ({$eClinica->getProvinciaClinica()})
                </div>
                <div> 
                        Telefono: {$eClinica->getTelefonoClinica()} , Email: {$eClinica->getEmail()}
                </div>
                <div>
                    Prenotazione effettuata da : 
                </div>
                <div>
                    {if isset($idReferto)}
                        Codice Referto : {$idReferto}
                    {/if}
                </div>    
           
                <div id="divConfermaPrenotazioneUtente">
                    Prenotazione: 
                    {if ($prenotazione->getConfermataPrenotazione()==TRUE)} 
           
                        Confermata 
                    {else} 
                        
                        Non Confermata  
                        <input type="button" id="confermaPrenotazioneUtente" value="Conferma Prenotazione" data-idPrenotazione="{$prenotazione->getIdPrenotazione()}" />
                    {/if}
                </div>
          
                <span>
                    Prenotazione: 
                    {if ($prenotazione->getEseguitaPrenotazione()== TRUE)}
                        Eseguita 
                    {else} 
                        Non Eseguita 
                    {/if}
                </span>
                <br>
                <span>
                    Prenotazione effettua da: {$nome} {$cognome}
                </span>
                <br>
            {/if}
                
            {if ($tipoUser==='clinica')}
                {if isset($nomeUtente)}
                <span>
                    Nome: {$nomeUtente}
                </span>
                <br>
                {/if}
                {if isset($cognomeUtente)}
                <span>
                    Cognome: {$cognomeUtente}
                </span>
                <br>
                {/if}
                <input type="button" id="aggiungiRefertoButton" value="Aggiungi Referto" data-idPrenotazione="{$prenotazione->getIdPrenotazione()}" />
            {/if}
            <input type="button" id="cancellaPrenotazione" value="Cancella Prenotazione" data-idPrenotazione="{$prenotazione->getIdPrenotazione()}" />
            <input type="button" id="modificaPrenotazione" value="Modifica Prenotazione" data-idPrenotazione="{$prenotazione->getIdPrenotazione()}" />
</div>