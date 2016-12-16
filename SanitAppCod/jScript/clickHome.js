$(document).ready(function(){
    $("#headerMain").on("click", ".homepage", function(){
        var History = window.history;
        History.pushState(null, 'home', 'index.php');
        $.ajax({
            type : "GET",
            url: "index.php",
            dataType: "html",
            success: function(msg)
              {
                $("#wrapper").html(msg);
                
              },
              
            error: function()
              {
                alert("Chiamata fallita, si prega di riprovare...");
              }
        });
    });
});