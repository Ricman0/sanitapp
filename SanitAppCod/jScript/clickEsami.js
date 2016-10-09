$(document).ready(function () {

    $("#esami").click(function () {
        inviaController('ricercaEsami', '#main');
    });
    
    $('#main').on("click", ".rigaEsame", function () {
        var id = $(this).attr('id');
        var contenitore = "#" + $(this).closest("div").prop("id"); //ritorna l'elemento contenitore sul quale inserire la risposta ajax
        var controller = $("#controllerTabella").attr("value");
        alert(controller);
        if(controller == "esami")
        {
            alert("ciao");
            clickRiga(controller, 'visualizza', id, contenitore);
        }

    });
});

function inviaController($controller, ajaxdiv)
    {
       $.ajax({
            type: 'GET',
            url: $controller ,
            success: function(datiRisposta)
            {
                alert(datiRisposta);
                $(ajaxdiv).html(datiRisposta);
            },
            error:function()
            {
                alert("Sbagliato ESAMI");
            }
        });  
    }