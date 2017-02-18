<div>
    <form id="workingPlan">
        <input type="hidden" name="controller" value="impostazioni" />
        <fieldset class="noBordo">
            <div class="row-fluid">
                <div class="col-md-7 working-plan-wrapper">
                    <h3>WORKING PLAN</h3>
                    <hr>
                    <br>
                    <p class="help-block">
                        Spunta i giorni lavorativi della tua attività.
                        Aggiungi gli orari di inizio e fine giornata.
                    </p>
                    <br>
                    <table class="working-plan table table-striped">
                        <thead>
                            <tr>
                                <th>Giorno</th>
                                <th>Ora Inizio</th>
                                <th>Ora Fine</th>
                                <th>Inizio Pausa</th>
                                <th>Fine Pausa</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach from=$giorniSettimanali item=giorno}
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <input type="checkbox" id="{$giorno}" name="{$giorno}" {if isset($workingPlan.$giorno)} checked {/if} />
                                            <label for="{$giorno}">{$giorno}</label>
                                        </div>
                                        <input type="hidden" id="{$giorno}Pausa" name="{$giorno}Pausa" value="" />
                                    </td>
                                    <td><input type="text" id="{$giorno}Start" name="{$giorno}Start" class="time timeStart " title="" {if isset($workingPlan.$giorno->Start)}value="{$workingPlan.$giorno->Start}"{/if}/></td>
                                    <td><input type="text" id="{$giorno}End"  name="{$giorno}End" class="time timeEnd" title="" {if isset($workingPlan.$giorno->End)}value="{$workingPlan.$giorno->End}"{/if} /></td>
                                    <td><input type="text" id="{$giorno}BreakStart" name="{$giorno}BreakStart" class="time timeStart breakStart" {if isset($workingPlan.$giorno->BreakStart)}value="{$workingPlan.$giorno->BreakStart}"{/if}/></td>
                                    <td><input type="text" id="{$giorno}BreakEnd"  name="{$giorno}BreakEnd" class="time timeEnd" {if isset($workingPlan.$giorno->BreakEnd)}value="{$workingPlan.$giorno->BreakEnd}"{/if}/></td>
                                </tr>
                            {/foreach}   
                        </tbody>
                    </table>

              <!--      <br>

                    <h4>Tempo Limite Prenotazione</h4>
                    <p class="help-block">
                        Definisci il tempo limite entro cui i clienti possono prenotare o modificare gli appuntamenti.
                    </p>
                    <br>
                    <div class="form-group">
                        <label for="tempoLimite">Tempo Limite</label>
                        <input type="text" id="tempoLimite" name="tempoLimite" class="time" {if isset($workingPlan.tempoLimite)}value="{$workingPlan.tempoLimite}"{/if}/>
                    </div>
              -->
                </div>
            </div>
        </fieldset>
        <input type="submit" id="salvaImpostazioniClinica" value="Salva" />
        <input type="button" id="annullaImpostazioniClinica" value="Annulla" />
        <br>
    </form>
</div>
<!--   <div >
       <h4>Pause</h4>
       <span class="help-block">
           Aggiungi le pause di ogni giorno lavorativo
       </span>

       <div>
           <input type="button" id="aggiungiPausaButton" value="Aggiungi Pausa" />                                
       </div>

       <br>

       <table id="tabellaPause" class="tabellaPause">
           <thead>
               <tr>
                   <th>Giorno</th>
                   <th>Inizio</th>
                   <th>Fine</th>
                   <th>Azioni</th>
               </tr>
           </thead>
           <tbody class="bodyTabellaPause">
{if isset($pause)}
    {foreach from=$pause item=curr_row}
        <tr>
            <td>{$curr_row['Giorno']}</td>
            <td>{$curr_row['OraInizio']}</td>
            <td>{$curr_row['OraFine']}</td>
            <td>
                <a ><i class="fa fa-edit fa-lg" aria-hidden="true"></i></a>
                <a ><i class="fa fa-times fa-lg" aria-hidden="true"></i></a>
            </td>
        </tr>
    {/foreach}
{/if}

</tbody>
</table>
</div>
-->