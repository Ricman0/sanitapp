//

$(document).ready(function() {
    $("#main").on("click","#bottoneRicercaCliniche", function(){
//  $("#ricercaClinicheCerca").click(function(){
    inviaDati();
  });
});


function inviaDati(){
    
    var controller = $("#controllerFormRicercaCliniche").val();
//    controller = controller.replace(" ", ""); 

    var nome = ($("#nomeClinicaFormRicercaCliniche").val()).toLowerCase(); ;
    nome= nome.replace(" ", "_"); 
    
    var luogo = ($("#luogoClinicaFormRicercaCliniche").val()).toLowerCase(); ;
    luogo = luogo.replace(" ", "_"); 
    
    var url;
//    if (nome.length===0 || luogo.length===0 )
//    {
//        if(nome.length===0)
//        {
//            url = controller + "/all/"+ luogo;
//        }
//        else
//        {
//            if(luogo.length===0)
//            {
//                url = controller + "/" + nome + "/all";
//            }
//            else
//            {
//                url = controller;
//            }
//        } 
//    }
//    else
//    {
//        url = controller +"/"+ nome + "/" +luogo  ;
//    } 

    if (nome.length===0 && luogo.length===0)
    {
        url = controller;
    }
    else
    {
         if(nome.length===0 || luogo.length===0)
        {
            if(luogo.length===0)
            {
                url = controller + "/" + nome + "/all";
            }
            else
            {
                url = controller + "/all/"+ luogo;
            }
            
        }
        else
        {
            url = controller +"/"+ nome + "/" +luogo  ;
        }
    }
    $.ajax({
      //type: "POST",
      type: "GET",
      url: url,
      //data: "nome=" + nome + "&luogo=" + luogo + "&controller=" + controller,
      dataType: "html",
      success: function(msg)
      {
        $("#main").html(msg);
      },
      error: function()
      {
        alert("Chiamata fallita, si prega di riprovare...");
      }
    });
}
/*
function inviaController($controller, ajaxdiv, id)
{
    var dati = $(id).serialize();
    $.ajax({
        type: 'POST',
//        url:$controller,
        url: "cliniche", 
        data: dati,
        success: function(datiRisposta)
        {
            alert(datiRisposta);
            $(ajaxdiv).html(datiRisposta);
        },
        error:function()
        {
            alert("Sbagliato click su CERCA CLINICHE");
        }
        
    });
}
*/ 

