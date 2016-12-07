{if isset($esami)}
    <input type="hidden" name="controller" id="controllerTabella" value={$controller} />
    
    <h4>Esami cercati</h4>
    <table id="tabellaEsami" class="tablesorter">
        <thead>
            <th>Nome</th>
            <th>Descrizione</th>
            <th>Prezzo</th>
            <th>Durata</th>
            <th>Medico</th>
            <th>Categoria</th>
            <th>Clinica</th>
            <th>Località</th>
        </thead>
        <tbody>
            <br>
            {if isset($tastoAggiungi)}
                <i class="fa fa-plus-circle fa-2x tastoAggiungi" id="iconaAggiungi" aria-hidden="true" ></i>
            {/if}
            <br>
            {if isset($dati)}
                {foreach from=$dati item=curr_row}
                    <tr id="{$curr_row['IDEsame']}" class="rigaEsame">
                        <td>{$curr_row['NomeEsame']}</td>
                        <td>{$curr_row['Descrizione']}</td>
                        <td>{$curr_row['Prezzo']}</td>
                        <td>{$curr_row['Durata']}</td>
                        <td>{$curr_row['MedicoEsame']}</td>
                        <td>{$curr_row['NomeCategoria']}</td>
                        <td class="rigaNomeClinica">{$curr_row['NomeClinica']}</td>
                        <td>{$curr_row['Località']}</td>
                    </tr>
                {/foreach}
            {/if}
        </tbody>
    </table>
{else}
    {if isset($errore)}
        C'è stato un errore!Non è stato possibile recuperare gli esami
        {if is_string($errore)}
            <p>{$errore}</p>
        {/if}
    {else}
        <h4>Non sono ancora presenti esami</h4>
        <br>
        <h4>Clicca sull'icona seguente per aggiungere un nuovo servizio che la clinica offrirà</h4>
        <i class="fa fa-plus-circle fa-2x tastoAggiungi" id="iconaAggiungi" aria-hidden="true" ></i>
    {/if}
{/if}