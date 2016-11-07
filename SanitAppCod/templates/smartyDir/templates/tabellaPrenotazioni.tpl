<table id="tabellaPrenotazioni" class="tablesorter">
    <thead>
        <th>ID Prenotazione</th>
        {if ($tipoUser==='utente')}
        <th>Nome Esame</th>
        <th>Nome Clinica</th>
        <th>Eseguita</th>
        <th>Medico Esame</th>
        {else}
            {if ($tipoUser==='medico')}
                <th>Nome Esame</th>
                <th>Nome Clinica</th>
                <th>Nome </th>
                <th>Cognome</th>
                <th>Codice Fiscale</th>
            {else}
                <th>ID Esame</th>
                <th>Esame</th>
                <th>Nome </th>
                <th>Cognome</th>                
                <th>Codice Fiscale</th>
            {/if}
        {/if}
        <th>Data e Ora</th>
    </thead>
    <tbody>
        <br>
        {if isset($tastoAggiungi)}
            <i class="fa fa-plus-circle fa-2x tastoAggiungi" id="iconaAggiungiPrenotazione{$tipoUser}" aria-hidden="true" ></i>               
        {/if}
        <br>
        
        {if ($tipoUser==='utente')}
            {foreach from=$dati item=curr_row}
                <tr id="{$curr_row['IDPrenotazione']}" class="rigaPrenotazione">
                    <td>{$curr_row['IDPrenotazione']}</td>
                    <td>{$curr_row['NomeEsame']}</td>
                    <td>{$curr_row['NomeClinica']}</td>                     
                    <td>{$curr_row['Eseguita']}</td>
                    <td>{$curr_row['MedicoEsame']}</td>
                    <td>{$curr_row['DataEOra']}</td>
                </tr>
            {/foreach}
        {else}
            {if ($tipoUser==='medico')}
                {foreach from=$dati item=curr_row}
                    <tr id="{$curr_row['IDPrenotazione']}" class="rigaPrenotazione">
                        <td>{$curr_row['IDPrenotazione']}</td>
                        <td>{$curr_row['IDEsame']}</td>
                        <td>{$curr_row['NomeEsame']}</td>
                        <td>{$curr_row['Nome']}</td>
                        <td>{$curr_row['Cognome']}</td>
                        <td>{$curr_row['CodFiscale']}</td>                        
                        <td>{$curr_row['DataEOra']}</td>
                    </tr>
                {/foreach}
            {else}
                {foreach from=$dati item=curr_row}
                    <tr id="{$curr_row['IDPrenotazione']}" class="rigaPrenotazione">
                        <td>{$curr_row['IDPrenotazione']}</td>
                        <td>{$curr_row['IDEsame']}</td>
                        <td>{$curr_row['NomeEsame']}</td>
                        <td>{$curr_row['Nome']}</td>
                        <td>{$curr_row['Cognome']}</td>
                        <td>{$curr_row['CodFiscale']}</td>                        
                        <td>{$curr_row['DataEOra']}</td>
                    </tr>
                {/foreach}
            {/if}
        {/if}
        
        
        
    </tbody>
</table>