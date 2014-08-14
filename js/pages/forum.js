$(document).ready(function(){
    //$(".f-stats").tipsy({gravity: "e", delayIn: 0});
});

$(window).load(function(){
    $(".t-donate").each(function(){
        //var w = $(this).css("width");
        var originalValue = parseInt($(this).find("span").text());
        
        //$(this).css("width", w);
        
        var mouse = false;
                
        if (!$(this).hasClass("disabled")){
            $(this).attr("title", "Cubes given for this post.<br/>Click to open.").tipsy({delayIn: 0, html: true});
        }else if ($(this).hasClass("green")){
            $(this).attr("title", "You have given cubes for this post.").tipsy({delayIn: 0, html: true});
        }else{
            $(this).attr("title", "You cannot give cubes to yourself.").tipsy({delayIn: 0, html: true});
        }
            
        $(this).click(function(e){
            if (!$(this).hasClass("disabled")){
            
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
                            if (data == "Give 5 Cubes?"){
                                span.parent().addClass("ready");
                            }
                        }
                    });
                }else{
                    // Clicked when the thing is already open
                    // Sorry, I'm just bored and lazy right now and don't want to describe stuff...

                    if ($(this).hasClass("ready")){
                        var span = $(this).find("span");
                        span.text("Sending Cubes..");

                        $.post("/api/givePostCubes.php", {id: $(this).parent().parent().find(".t-post-id").val()}, function(data){
                            if (data == "y"){
                                span.text("Thanks! :)");
                                span.parent().addClass("disabled").addClass("green");
                                span.parent().attr("title", "You have given cubes to this post.").tipsy({delayIn: 0, html: true});
                                span.parent().find(".icon").attr("src", "/images/icons/cubes-white.svg");
                                
                                // Update sidebar cubes value
                                $("#cubes-counter").text(addCommas(parseInt($("#cubes-counter").text().replace(/\D/g,''))-5));
                                // Update counter
                                originalValue += 5;
                            }else{
                                span.text("Error Occured");
                            }
                        });
                    }
                }
            }
        }).mouseleave(function(e){
            mouse = false;
            
            $(this).find("span").text(originalValue).css("float", "right");
            $(this).find(".icon").show();
            $(this).removeClass("ready");
            
        });
    });
});