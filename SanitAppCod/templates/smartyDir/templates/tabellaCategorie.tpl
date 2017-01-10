<h3>CATEGORIE DELL'APPLICAZIONE</h3>
<h4>Clicca su una riga per eliminare la categoria corrispondente.</h4>
<h4>Clicca sull'icona seguente per aggiungere una categoria.</h4>
<table id="tabellaCategorie" class="tablesorter">
    <thead>
        <th>Nome</th> 
    </thead>
    <tbody>  
        <br>
        <i class="fa fa-plus-circle fa-2x tastoAggiungi" id="iconaAggiungiCategoria" aria-hidden="true" ></i>
        <br>
        {foreach from=$dati item=curr_row}
            <tr id="{$curr_row['Nome']}" class="rigaCategoria">
                <td>{$curr_row['Nome']}</td>
            </tr>
        {/foreach}
    </tbody>
</table>