{if isset($esami)}
    <input type="hidden" name="controller" id="controllerTabella" value={$controller} />
    {if ($controller)==="servizi"}
        <h3>SERVIZI OFFERTI</h3>
        <h4>Per visualizzare informazioni su un servizio, clicca sulla riga relativa al servizio.</h4>
        <h4>Clicca sull'icona seguente per aggiungere un servizio.</h4>
    {else}
        <h3>ESAMI</h3>
        <h4>Per visualizzare informazioni su un esame, clicca sulla riga relativa all'esame.</h4>
    {/if}
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
            {if isset($tastoAggiungi)}
                <br>
                <i class="fa fa-plus-circle fa-2x tastoAggiungi" id="iconaAggiungi{$controller}" aria-hidden="true" ></i>
            {/if}
            <br>
            {if isset($dati)}
                {foreach from=$dati item=curr_row}
                    <tr id="{$curr_row['IDEsame']}" class="rigaEsame cliccabile">
                        <td>{$curr_row['NomeEsame']}</td>
                        <td>{$curr_row['Descrizione']}</td>
                        <td>{$curr_row['Prezzo']}</td>
                        <td>{$curr_row['Durata']}</td>
                        <td>{$curr_row['MedicoEsame']}</td>
                        <td>{$curr_row['NomeCategoria']}</td>
                        <td class="rigaNomeClinica">{$curr_row['NomeClinica']}</td>
                        <td>{$curr_row['Localita']}</td>
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