

$(document).ready(function() {
  $("#ricercaClinicheCerca").click(function(){
    var controller = $("#controllerFormRicercaCliniche").val();
    controller = controller.replace(" ", ""); 

    var nome = $("#nomeClinicaFormRicercaCliniche").val();
    nome= nome.replace(" ", ""); 
    
    var luogo = $("#luogoClinicaFormRicercaCliniche").val();
    luogo = luogo.replace(" ", ""); 
    
    var url;
    if (nome.length===0 || luogo.length===0 )
    {
        if(nome.length===0)
        {
            url = controller + "/"+ luogo;
        }
        else
        {
            url = controller +"/"+ nome;
        }
    }
    else{
        url = controller +"/"+ luogo + "/" + nome ;
    } 
    
    $.ajax({
      type: "POST",
      url: url,
      data: "nome=" + nome + "&luogo=" + luogo + "&controller=" + controller,
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
  });
});

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

