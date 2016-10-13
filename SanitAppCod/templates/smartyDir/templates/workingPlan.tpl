<div>
    <form id="workingPlan">
        <input type="hidden" name="controller" value="impostazioni" />
        <fieldset>
            <div class="row-fluid">
                <div class="col-md-7 working-plan-wrapper">
                    <h4>Working Plan</h4>
                    <span class="help-block">
                        Spunta i giorni lavorativi della tua attività.
                        Aggiungi gli orari di inizio e fine giornata.
                    </span>

                    <table class="working-plan table table-striped">
                        <thead>
                            <tr>
                                <th>Giorno</th>
                                <th>Ora Inizio</th>
                                <th>Ora Fine</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach from=$giorniSettimanali item=giorno}
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <input type="checkbox" id="{$giorno}" name="{$giorno}" />
                                            <label for="{$giorno}">{$giorno}</label>
                                        </div>
                                        <input type="hidden" id="{$giorno}Pausa" name="{$giorno}Pausa" value="" />
                                    </td>
                                    <td><input type="text" id="{$giorno}Start" name="{$giorno}Start" class="time" /></td>
                                    <td><input type="text" id="{$giorno}End"  name="{$giorno}End" class="time" /></td>
                                </tr>
                            {/foreach}   
                            </tbody>
                        </table>

                    <br>

                    <h4>Tempo Limite Prenotazione</h4>
                    <span class="help-block">
                        Definisci il tempo limite entro cui i clienti possono prenotare o modificare gli appuntamenti.
                    </span>
                    <div class="form-group">
                        <label for="tempoLimite">Tempo Limite</label>
                        <input type="text" id="tempoLimite" name="tempoLimite" class="time" />
                    </div>
                </div>
                <div >
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
                                        <a href="#"><i class="fa fa-edit fa-lg" aria-hidden="true"></i></a>
                                        <a href="#"><i class="fa fa-times fa-lg" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            {/foreach}
                            {/if}

                        </tbody>
                    </table>
                </div>
            </div>
        </fieldset>
        <input type="button" id="salvaImpostazioniClinica" value="Salva" />
    </form>
</div>
