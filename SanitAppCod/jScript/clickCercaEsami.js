/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    $('#headerMain').on("click", ".ricercaEsamiCerca", function () {
        var id = $(this).attr('id');// id= ricercaEsamiCerca 
        alert (id);
        //this si riferisce al button ricercaEsamiCerca. Io cerco il div più vicino che abbia come id contenutoAreaPersonale 
        // e poi prendo id che ovviamente è contenutoAreaPersonale.
        var ajaxDiv = "#" + $(this).closest('div').prop('id');
        alert (ajaxDiv);
        if(ajaxDiv!=='#contenutoAreaPersonale') // nel caso in cui non esista div con id contenutoAreaPersonale
        {
           ajaxDiv = '#main';
        }
        inviaDatiForm(ajaxDiv);
    });
});

function inviaDatiForm(ajaxDiv)
{
    
    var controller = $(".controllerFormRicercaEsami").val();
    var nomeClinica = '';
    if($("input[name=clinica]").length){
        nomeClinica = (($("input[name=clinica]").val()).toLowerCase()).trim();
        nomeClinica = nomeClinica.replace(" ", "_");
    }
    var nomeEsame = (($("input[name=esame]").val()).toLowerCase()).trim();
    nomeEsame = nomeEsame.replace(" ", "_");
    var luogo = (($("input[name=luogo]").val()).toLowerCase()).trim();
    luogo = luogo.replace(" ", "_");
    var url;

    url = controller;
    //nome esame !=0
    if (nomeEsame.length !== 0)
    {
        //nomeClinica e luogo = 0
        if (nomeClinica.length === 0)
        {
            if (luogo.length === 0)
            {
                url = url + "/" + nomeEsame;
            } else
            {
                url = url + "/" + nomeEsame + "/all/" + luogo;
            }
        } else
        {
            if (luogo.length === 0)
            {
                url = url + "/" + nomeEsame + "/" + nomeClinica;
            } else
            {
                url = url + "/" + nomeEsame + "/" + nomeClinica + "/" + luogo;
            }
        }
    }
    //nome esame =0
    else
    {
        if (nomeClinica.length !== 0)
        {
            if (luogo.length === 0)
            {
                url = url + "/all/" + nomeClinica;
            } else
            {
                url = url + "/all/" + nomeClinica + "/" + luogo;
            }
        } else
        {
            if (luogo.length !== 0)
            {
                url = url + "/all/all/" + luogo;
            }

        }
    }
    $.ajax({
        //url della risorsa alla quale viene inviata la richiesta
        // url:  "index.php",
        url: url,
        //il tipo di richiesta HTTP da effettuare, di default è GET
        type: 'GET',
        dataType: "html",
        success: function (msg)
        {
            alert("Dati ricerca esame inviati per effettuare la registrazione");
            $(ajaxDiv).html(msg);
            $("#tabellaEsami").tablesorter({
                theme: 'blue',
                widgets: ["filter"],
                widgetOptions: {
                    // filter_anyMatch replaced! Instead use the filter_external option
                    // Set to use a jQuery selector (or jQuery object) pointing to the
                    // external filter (column specific or any match)
                    filter_external: '.search',
                    // add a default type search to the first name column
                    filter_defaultFilter: {1: '~{query}'},
                    // include column filters
                    filter_columnFilters: true,
                    filter_placeholder: {search: 'Search...'},
                    filter_saveFilters: true,
                    filter_reset: '.reset'
                }

            });
        },
        error: function ()
        {
            alert("Chiamata fallita, si prega di riprovare...  ");

        }
    });
}
