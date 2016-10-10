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
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <input type="checkbox" id="Lunedì" name="Lunedì" />
                                            <label for="Lunedì">Lunedì</label>
                                        </div>
                                    </td>
                                    <td><input type="text" id="LunedìStart" class="time" /></td>
                                    <td><input type="text" id="LunedìEnd" class="time" /></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <input type="checkbox" id="Martedì" name="Martedì" />
                                            <label for="Martedì">Martedì</label>
                                        </div>
                                    </td>
                                    <td><input type="text" id="MartedìStart" class="time" /></td>
                                    <td><input type="text" id="MartedìEnd" class="time" /></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <input type="checkbox" id="Mercoledì" name="Mercoledì" />
                                            <label for="Mercoledì">Mercoledì</label>
                                        </div>
                                    </td>
                                    <td><input type="text" id="MercoledìStart" class="time" /></td>
                                    <td><input type="text" id="MercoledìEnd" class="time" /></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <input type="checkbox" id="Giovedì" name="Giovedì" />
                                            <label for="Giovedì">Giovedì</label>
                                        </div>
                                    </td>
                                    <td><input type="text" id="GiovedìStart" class="time" /></td>
                                    <td><input type="text" id="GiovedìEnd" class="time" /></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <input type="checkbox" id="Venerdì" name="Venerdì" />
                                            <label for="Venerdì">Venerdì</label>
                                        </div>
                                    </td>
                                    <td><input type="text" id="VenerdìStart" class="time" /></td>
                                    <td><input type="text" id="VenerdìEnd" class="time" /></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <input type="checkbox" id="Sabato" name="Sabato" />
                                            <label for="Sabato">Sabato</label>
                                        </div>
                                    </td>
                                    <td><input type="text" id="SabatoStart" class="time" /></td>
                                    <td><input type="text" id="SabatoEnd" class="time" /></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <input type="checkbox" id="Domenica" name="Domenica" />
                                            <label for="Domenica">Domenica</label>
                                        </div>
                                    </td>
                                    <td><input type="text" id="DomenicaStart" class="time" /></td>
                                    <td><input type="text" id="DomenicaEnd" class="time" /></td>
                                </tr>
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
                    <div class="col-md-5 breaks-wrapper">
                        <h4>Pause</h4>
                        <span class="help-block">
                            Aggiungi le pause di ogni giorno lavorativo
                        </span>

                        <div>
                            <input type="button" value="Aggiungi Pausa" />                                
                        </div>

                        <br>

                        <table class="breaks table table-striped">
                            <thead>
                                <tr>
                                    <th>Giorno</th>
                                    <th>Inizio</th>
                                    <th>Fine</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                             <!-- c'è da aggiungere la modalità per inserire le pause -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </fieldset>
            <input type="button" id="salvaImpostazioniClinica" value="Salva" />
        </form>
</div>
