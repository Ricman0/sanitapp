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
        alert("clicked id:" + id + " " + title);
        inviaRegione(title);
    });
});

function inviaRegione(nomeRegione) {

    var controller = "cliniche";
    var luogo = nomeRegione;
    luogo = luogo.replace("-", "_");
    luogo = luogo.replace(" ", "_");
    var url = controller + "/all/" + luogo;
    $.ajax({
        
        type: "GET",
        url: url,
        dataType: "html",
        success: function (msg)
        {
            $("#main").html(msg);
            $(".tablesorter").tablesorter();
        },
        error: function ()
        {
            alert("Chiamata fallita, si prega di riprovare...");
        }
        
    });
}