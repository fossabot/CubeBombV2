$(document).ready(function(){
    $("#content .right .more .thumbnail").mouseenter(function(){
        $(this).find(".details").stop().animate({marginTop: 56}, 110);
    }).mouseleave(function(){
        $(this).find(".details").stop().animate({marginTop: 80}, 110);
    });
    
    $("#s-gift").tipsy({delayIn: 800});
    
    $commentTemplate = $("#comment-template").clone();
    $("#comment-template").remove();
    
    $commentTemplate.removeAttr("id");
    
    id = $("#id").val();
    lowestId = 0;
    
    loadComments(id, 0);
    
    function loadComments(id, start){
        $.post("/api/loadItemComments.php", {id: id, start: start}, function(data){
            // Response
            
            $("#load-more.disabled").remove();
            
            $fillspace = $(".left .fillspace");
            
            switch($.trim(data)){
                case "[]":
                    $fillspace.find(".message").each(function(){ $(this).remove() });
                    
                    if (start == 0){
                        $fillspace.append("<div class=\"message\">There are no comments yet.</div>");
                    }else{
                        $fillspace.append("<div class=\"message\">There are no more comments.</div>");
                    }
                    break;
                default:
                    // Test if json data
                    var response = $.parseJSON(data);
                    
                    if (typeof response == "object"){
                        var more = response[0]["more"];
                        
                        var i = 1;
                        while (response[i] != null){
                            $fillspace.find(".message").each(function(){ $(this).remove() });

                            next = $commentTemplate.clone();

                            next.find(".content > span").text(response[i]["message"]);
                            next.find(".content .details > span").text(response[i]["ago"]);
                            next.find(".content .details a").text(response[i]["name"]);
                            next.find(".avatar").css({backgroundImage: "url(/data/avatars/"+(response[i]["name"].toLowerCase())+".png)"});

                            next.appendTo($fillspace).show();
                            
                            // Check if this is the last one
                            if (response[i+1] == null){
                                // It is, so set lowst id
                                lowestId = response[i]["id"];
                            }
                            
                            i++;
                        }
                        
                        if (more){
                            $fillspace.append("<div class=\"sa-button\" id=\"load-more\">More comments</div>");
                            
                            // Reload trigger
                            $("#load-more").click(function(){
                                if ($(this).hasClass("disabled"))
                                    return;

                                $(this).addClass("disabled");
                                $(this).text("Loading...");

                                loadComments(id, lowestId);
                            });
                        }
                    }else{
                        $fillspace.append("<div class=\"message\">An error occurred.</div>");
                    }
                    
                    break;
            }
        });
    }
});