$(document).ready(function(){
    //$(".f-stats").tipsy({gravity: "e", delayIn: 0});
});

$(window).load(function(){
    $(".t-donate").each(function(){
        //var w = $(this).css("width");
        var originalValue = $(this).find("span").text();
        
        //$(this).css("width", w);
        
        var mouse = false;
        
        $(this).attr("title", "Cubes given to this post. Click to open.").tipsy({delayIn: 0});
        
        $(this).click(function(e){
            $('.tipsy:last').remove();
            
            if (mouse == false){
                mouse = true;

                $(this).find("span").text("Just a sec..").css("float", "none");
                $(this).find(".icon").hide();
                //$(this).removeAttr("title");

                var span = $(this).find("span");

                $.post("/api/loadPostGiver.php", {id: $(this).parent().parent().find(".t-post-id").val()}, function(data){
                    if (mouse){
                        span.text(data);
                        span.parent().css({backgroundColor: "#6FA857", color: "#fff"}, 200);
                    }
                });
            }else{
                // Clicked when the thing is already open
                // Sorry, I'm just bored and lazy right now 
            }
        }).mouseleave(function(e){
            mouse = false;
            
            $(this).find("span").text(originalValue).css("float", "right");
            $(this).find(".icon").show();
            $(this).css({backgroundColor: "#e0e0e0", color: "#000"}, 200);
        });
    });
});