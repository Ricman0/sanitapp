

$(function(){
  var $ = jQuery;
  var map = $("#italy-map")
  var region_map = $("#region-map")
  $("area[data-id]").mouseover(function(){
    var r = $(this)
    var id = r.attr("data-id")
    region_map.removeClass()
    region_map.addClass("sprite_region sprite_region_"+id)
  })
  
  $("area[data-id]").mouseout(function(){
    region_map.removeClass()
  })
  
  $("area[data-id]").click(function(){
    var r = $(this)
    var id = r.attr("data-id")
    var title = r.attr("title")
    alert("clicked id:"+id+" "+title)
  })
})


