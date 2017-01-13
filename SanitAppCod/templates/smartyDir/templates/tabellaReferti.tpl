<h3>REFERTI</h3>
<h4>Clicca su una riga della tabella per visualizzare il referto corrispondente.</h4>
<table id="tabellaReferti" class="tablesorter">
    <thead>
        <th>ID Referto</th>
        {if ($tipoUser==='clinica')}
            <th>ID Prenotazione</th>
            <th>ID Esame</th>
            <th>Esame</th>
            <th>Nome </th>
            <th>Cognome</th>
            <th>Codice Fiscale</th>
        {elseif ($tipoUser==='medico')}
            <th>Esame</th>
            <th>Nome </th>
            <th>Cognome</th>
            <th>Codice Fiscale</th>
            <th>Clinica</th>
        {else}
            <th>ID Prenotazione</th>
            <th>Esame</th>
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
                {if ($tipoUser==='clinica')}
                    <td>{$curr_row['IDPrenotazione']}</td>
                    <td>{$curr_row['IDEsame']}</td>
                    <td>{$curr_row['NomeEsame']}</td>
                    <td>{$curr_row['Nome']}</td>
                    <td>{$curr_row['Cognome']}</td>
                    <td>{$curr_row['CodFiscaleUtenteEffettuaEsame']}</td>
                {elseif ($tipoUser==='medico')}
                    <td>{$curr_row['NomeEsame']}</td>
                    <td>{$curr_row['Nome']}</td>
                    <td>{$curr_row['Cognome']}</td>
                    <td>{$curr_row['CodFiscaleUtenteEffettuaEsame']}</td>
                    <td>{$curr_row['NomeClinica']}</td>
                {else}
                    <td>{$curr_row['IDPrenotazione']}</td>
                    <td>{$curr_row['NomeEsame']}</td>
                    <td>{$curr_row['NomeClinica']}</td>
                {/if}
                <td>{$curr_row['DataReferto']}</td>
            </tr>
        {/foreach}
    </tbody>
</table>
