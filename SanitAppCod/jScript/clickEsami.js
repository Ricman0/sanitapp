$(document).ready(function () {

    $("#esami").click(function () {
        inviaController('esami', '#main');
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