$(document).ready(function(){
    $("#wrapper").on("click", "#homeNavBar", function(){
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


