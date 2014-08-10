$(document).ready(function(){
    $("#content .right .more .thumbnail").mouseenter(function(){
        $(this).find(".details").stop().animate({marginTop: 56}, 110);
    }).mouseleave(function(){
        $(this).find(".details").stop().animate({marginTop: 80}, 110);
    });
    
    $("#s-gift").tipsy({delayIn: 800});
    
    $messageTemplate = $("#message-template").clone();
    $("#message-template").remove();
    
    $messageTemplate.removeAttr("id");
    
    lowestId = 0;
    
    loadMessages(0);
    
    function loadMessages(start){
        return loadMessages(start, false);
    }
    
    function loadMessages(start, clear){

        $.post("/api/loadInbox.php", {start: start}, function(data){
            // Response
            
            $("#load-more.disabled").remove();
            
            $messagearea = $(".messagearea");
            
            switch($.trim(data)){
                case "[]":
                    $messagearea.find(".note").each(function(){ $(this).remove() });
                    
                    if (start == 0){
                        $messagearea.append("<div class=\"note\">Your inbox is empty.</div>");
                    }else{
                        $messagearea.append("<div class=\"note\">There are no more message.</div>");
                    }
                    break;
                default:
                    // Test if json data
                    var response = $.parseJSON(data);
                    
                    if (typeof response == "object"){
                        var more = response[0]["more"];
                        
                        if (clear){
                            lowestId = 0;
                            $messagearea.html("");
                        }
                        
                        var i = 1;
                        while (response[i] != null){
                            $messagearea.find(".note").each(function(){ $(this).remove() });

                            next = $messageTemplate.clone().removeAttr("id");
                            
                            if (response[i]["colored"] == true){
                                next.find(".content").addClass("colored");
                            }
                            
                            next.attr("onclick", "window.location='/pm.php?id="+parseInt(response[i]["id"])+"'");
                            next.find(".m-subject").html(response[i]["subject"]);
                            next.find(".m-time").text(response[i]["ago"]).attr("title", response[i]["timestamp"]).tipsy();
                            next.find(".m-sender a").text(response[i]["name"]).attr("href", "/profile.php?id="+parseInt(response[i]["senderId"])).tipsy();
                            next.find(".m-flags").text("");
                            
                            if (response[i]["seen"] == "0"){
                                next.find(".message").addClass("unread");
                            }
                            
                            next.appendTo($messagearea).show();
                            
                            // Check if this is the last one
                            if (response[i+1] == null){
                                // It is, so set lowst id
                                lowestId = response[i]["id"];
                            }
                            
                            i++;
                        }
                        
                        if (more){
                            $messagearea.append("<div class=\"sa-button\" id=\"load-more\">More messages</div>");
                            
                            // Reload trigger
                            $("#load-more").click(function(){
                                if ($(this).hasClass("disabled"))
                                    return;

                                $(this).addClass("disabled");
                                $(this).text("Loading...");

                                loadMessages(lowestId);
                            });
                        }
                    }else{
                        $messagearea.append("<div class=\"message\">An error occurred.</div>");
                    }
                    
                    break;
            }
        });
    }
});