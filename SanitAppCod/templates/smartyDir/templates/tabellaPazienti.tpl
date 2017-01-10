{if isset($pazienti)}
    <table id="tabellaPazienti" class="tablesorter">
        <thead>
            <th>Nome</th>
            <th>Cognome</th>
            <th>Via</th>
            <!--<th>Numero Civico</th>-->
            <th>CAP</th>
            <th>Email</th>
            <th>Codice Fiscale</th>
        </thead>
        <tbody>
            <br>

            <h3>PAZIENTI</h3>
            {if isset($tastoAggiungi)}
                <h4>Per aggiungere un nuovo paziente clicca sull'icona seguente</h4>
                <i class="fa fa-plus-circle fa-2x tastoAggiungi" id="iconaAggiungiPaziente" aria-hidden="true" ></i>
            {/if}
            <br>

            {foreach from=$dati item=curr_row}
                <tr id="{$curr_row['CodFiscale']}" class="rigaPaziente">
                    <td>{$curr_row['Nome']}</td>
                    <td>{$curr_row['Cognome']}</td>
                    <td>{$curr_row['Via']}, {$curr_row['NumCivico']}</td>
                    <td>{$curr_row['CAP']}</td>
                    <td>{$curr_row['Email']}</td>
                    <td>{$curr_row['CodFiscale']}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>
 {else}
     <h4>Non sono presenti pazienti</h4>
        <p>Per aggiungere un paziente, clicca sul tasto aggiungi</p>
        <br>
            {if isset($tastoAggiungi)}
                <i class="fa fa-plus-circle fa-2x tastoAggiungi" id="iconaAggiungiPaziente" aria-hidden="true" ></i>               
            {/if}
        <br>
 {/if}