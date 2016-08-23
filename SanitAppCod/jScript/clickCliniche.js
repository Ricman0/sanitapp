$(document).ready(function () {
    
    $("#cliniche").click(function () {
        inviaController('ricercaCliniche', '#main');
    });
});

function inviaController($controller, ajaxdiv)
{
    $.ajax({
        type: 'GET',
        url:$controller,
        success: function(datiRisposta)
        {
            alert(datiRisposta);
            $(ajaxdiv).html(datiRisposta);
        },
        error:function()
        {
            alert("Sbagliato click su CLINICHE");
        },
//        complete:
//            function(){
//                $.getScript("./jScript/clickCercaCliniche");
//            }
    });
}


