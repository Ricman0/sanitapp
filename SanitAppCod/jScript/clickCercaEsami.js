/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    $("#main").on("click","#ricercaEsamiCerca", function() {
        inviaDatiForm();
    });
});

function inviaDatiForm()
{
    var controller = $("#controllerFormRicercaEsami").val();
    var nomeClinica = (($("#nomeClinicaFormRicercaEsami").val()).toLowerCase()).trim();
    nomeClinica = nomeClinica.replace(" ", "_"); 
    
    var nomeEsame = (($("#nomeEsameFormRicercaEsami").val()).toLowerCase()).trim();
    nomeEsame = nomeEsame.replace(" ", "_"); 
    var luogo = (($("#luogoClinicaFormRicercaEsami").val()).toLowerCase()).trim(); 
    luogo = luogo.replace(" ", "_"); 
    var url;
    
    url = controller;
    //nome esame !=0
    if(nomeEsame.length!==0)
    {
        //nomeClinica e luogo = 0
        if( nomeClinica.length===0)
        {
            if(luogo.length===0)
            {
                url = url + "/" + nomeEsame;
            }
            else
            {
                url = url + "/" + nomeEsame + "/all/" + luogo;
            }           
        }
        else
        {
            if(luogo.length===0)
            {
                url = url + "/" + nomeEsame + "/" + nomeClinica;
            }
            else
            {
                url = url + "/" + nomeEsame + "/" + nomeClinica + "/" + luogo;
            } 
        }    
    }
    //nome esame =0
    else
    {
        if(nomeClinica.length!==0)
        {
            if(luogo.length===0)
            {
                url = url + "/all/" + nomeClinica;
            }
            else
            {
                url = url + "/all/" + nomeClinica + "/" + luogo;
            }
        }
        else
        {
            if(luogo.length!==0)
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
        success: function(msg)
        {
            alert("Dati ricerca esame inviati per effettuare la registrazione");
            $("#main").html(msg);
        },
        error: function()
        {
            alert("Chiamata fallita, si prega di riprovare...  ");
            
        }   
    });
}
