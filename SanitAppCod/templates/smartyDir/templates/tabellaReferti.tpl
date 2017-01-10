{if isset($referti)}
    <h3>REFERTI</h3>
    <h4>Clicca su una riga della tabella per visualizzare il referto corrispondente.</h4>
    <table id="tabellaReferti" class="tablesorter">
        <thead>
            <th>ID Referto</th>
            <th>ID Prenotazione</th>
            <th>ID Esame</th>
            <th>Esame</th>
            {if ($tipoUser==='clinica')}
                <th>Nome </th>
                <th>Cognome</th>
                <th>Codice Fiscale</th>
            {else}
                <th>Clinica</th>
            {/if}
            <th>Data</th>

        </thead>
        <tbody>
            <br>
            {if ($tastoAggiungi===TRUE)}
                <i class="fa fa-plus-circle fa-2x tastoAggiungi" id="iconaAggiungiReferto" aria-hidden="true" ></i>           
            {/if}
            <br>

            {foreach from=$dati item=curr_row}
                <tr id="{$curr_row['IDPrenotazione']}" class="rigaReferto">
                    <td>{$curr_row['IDReferto']}</td>
                    <td>{$curr_row['IDPrenotazione']}</td>
                    <td>{$curr_row['IDEsame']}</td>
                    <td>{$curr_row['NomeEsame']}</td>
                    {if ($tipoUser==='clinica')}
                        <td>{$curr_row['Nome']}</td>
                        <td>{$curr_row['Cognome']}</td>
                        <td>{$curr_row['CodFiscaleUtenteEffettuaEsame']}</td>
                    {else}
                        <td>{$curr_row['NomeClinica']}</td>
                        {/if}
                    <td>{$curr_row['DataReferto']}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>
{else}
    <h4>Non sono presenti referti</h4>
{/if}