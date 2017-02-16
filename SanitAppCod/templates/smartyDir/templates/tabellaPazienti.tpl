<h3>PAZIENTI</h3>
<hr>
{if isset($pazienti)}
            <h4>Clicca su una riga della tabella per visualizzare il paziente corrispondente.</h4>
            {if isset($tastoAggiungi)}
                <h4>Per aggiungere un nuovo paziente clicca sull'icona seguente.</h4>
                <i class="fa fa-plus-circle fa-2x tastoAggiungi" id="iconaAggiungiPaziente" aria-hidden="true" ></i>
            {/if}
            <br>
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
            {foreach from=$dati item=curr_row}
                <tr id="{$curr_row['CodFiscale']}" class="rigaPaziente cliccabile">
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
     <br>
     <h3>Non sono presenti pazienti.</h3>
        <h3>Per aggiungere un paziente, clicca sul tasto aggiungi</h3>
        <br>
            {if isset($tastoAggiungi)}
                <i class="fa fa-plus-circle fa-2x tastoAggiungi" id="iconaAggiungiPaziente" aria-hidden="true" ></i>               
            {/if}
        <br>
 {/if}