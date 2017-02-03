$(function () {
    var $ = jQuery;
    var map = $("#italy-map");
    var region_map = $("#region-map");
    $("area[data-id]").mouseover(function () {
        var r = $(this);
        var id = r.attr("data-id");
        region_map.removeClass();
        region_map.addClass("sprite_region sprite_region_" + id);
    });

    $("area[data-id]").mouseout(function () {
        region_map.removeClass();
    });

    $("area[data-id]").click(function () {
        var r = $(this);
        var id = r.attr("data-id");
        var title = r.attr("title");
        inviaRegione(title);
    });
});

function inviaRegione(nomeRegione) {

    var  nomeClinica = '';
    var luogo = nomeRegione;
    luogo = luogo.replace("-", " ");
    var datiPOST ={nome:nomeClinica, luogo:luogo};
    $.ajax({
        type: "POST",
        url: 'cliniche',
        data: datiPOST,
        dataType: "html",
        success: function (msg)
        {
            $("#main").html(msg);
            $(".tablesorter").tablesorter({
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
            alert("Chiamata fallita, si prega di riprovare...");
        }
        
    });
}