$(document).ready(function () {

    $("#esami").click(function () {
        inviaController('ricercaEsami', '#main');
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