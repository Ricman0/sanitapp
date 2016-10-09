<div id="workingPlan">
        <form>
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
                                    <td><input type="text" id="LunedìStart" class="orari" /></td>
                                    <td><input type="text" id="LunedìEnd" class="orari" /></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <input type="checkbox" id="Martedì" name="Martedì" />
                                            <label for="Martedì">Martedì</label>
                                        </div>
                                    </td>
                                    <td><input type="text" id="MartedìStart" class="orari" /></td>
                                    <td><input type="text" id="MartedìEnd" class="orari" /></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <input type="checkbox" id="Mercoledì" name="Mercoledì" />
                                            <label for="Mercoledì">Mercoledì</label>
                                        </div>
                                    </td>
                                    <td><input type="text" id="MercoledìStart" class="orari" /></td>
                                    <td><input type="text" id="MercoledìEnd" class="orari" /></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <input type="checkbox" id="Giovedì" name="Giovedì" />
                                            <label for="Giovedì">Giovedì</label>
                                        </div>
                                    </td>
                                    <td><input type="text" id="GiovedìStart" class="orari" /></td>
                                    <td><input type="text" id="GiovedìEnd" class="orari" /></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <input type="checkbox" id="Venerdì" name="Venerdì" />
                                            <label for="Venerdì">Venerdì</label>
                                        </div>
                                    </td>
                                    <td><input type="text" id="VenerdìStart" class="orari" /></td>
                                    <td><input type="text" id="VenerdìEnd" class="orari" /></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <input type="checkbox" id="Sabato" name="Sabato" />
                                            <label for="Sabato">Sabato</label>
                                        </div>
                                    </td>
                                    <td><input type="text" id="SabatoStart" class="orari" /></td>
                                    <td><input type="text" id="SabatoEnd" class="orari" /></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <input type="checkbox" id="Domenica" name="Domenica" />
                                            <label for="Domenica">Domenica</label>
                                        </div>
                                    </td>
                                    <td><input type="text" id="DomenicaStart" class="orari" /></td>
                                    <td><input type="text" id="DomenicaEnd" class="orari" /></td>
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
                            <input type="text" id="tempoLimite" name="tempoLimite" />
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
        </form>
</div>
