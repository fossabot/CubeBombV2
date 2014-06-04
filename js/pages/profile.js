var isAdminVisible = false;

$(document).ready(function(){
    $("#content .right .friends .thumbnail").tipsy({gravity: "s"});
    
    $("#content .right .actions a").mouseenter(function(){
        $(this).find(".sprite-rightPointer").removeClass("sprite").addClass("sprite-white");
    }).mouseleave(function(){
        $(this).find(".sprite-rightPointer").removeClass("sprite-white").addClass("sprite");
    });
    
    $("#content .right .friends .thumbnail").mouseenter(function(){
        $(this).find(".details").stop().animate({marginTop: 56}, 110);
    }).mouseleave(function(){
        $(this).find(".details").stop().animate({marginTop: 80}, 110);
    });

    $("#content .left .inventory .item").mouseenter(function(){
        $(this).find(".details").stop().animate({marginTop: 73}, 110);
    }).mouseleave(function(){
        $(this).find(".details").stop().animate({marginTop: 97}, 110);
    });
    
    $("#adminDropdownButton").click(function(){                    
        if ($(this).find(".text").text() == "Administration [Expand]"){
            $("#adminDropdown").stop().slideDown();
            $(this).find(".text").text("Administration [Close]");
        }else{
            $("#adminDropdown").stop().slideUp();
            $(this).find(".text").text("Administration [Expand]");
        }
    });
    
    $commentTemplate = $("#comment-template").clone();
    $("#comment-template").remove();
    
    $commentTemplate.removeAttr("id");
    
    id = $("#id").val();
    lowestId = 0;
    
    loadComments(id, 0);
    
    function loadComments(id, start){
        return loadComments(id, start, false);
    }
    
    function loadComments(id, start, clear){

        $.post("/api/loadShoutboxComments.php", {id: id, start: start}, function(data){
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
                        
                        if (clear){
                            lowestId = 0;
                            $fillspace.html("");
                        }
                        
                        var i = 1;
                        while (response[i] != null){
                            $fillspace.find(".message").each(function(){ $(this).remove() });

                            next = $commentTemplate.clone();
                            
                            if (response[i]["colored"] == true){
                                next.find(".content").addClass("colored");
                            }

                            next.find(".content > span").html(response[i]["message"]);
                            next.find(".content .details > span").text(response[i]["ago"]).attr("title", response[i]["timestamp"]).tipsy();
                            next.find(".content .details a").text(response[i]["name"]);
                            next.find(".avatar").css({backgroundImage: "url(/data/avatars/"+(response[i]["name"].toLowerCase())+".png)"}).tipsy();
                            
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
    
    $("#s-comment").keyup(function(){
        if ($.trim($(this).val()) == "" || $.trim($(this).val()) == $(this).attr("label")){
            $("#s-submit").stop().slideUp(100);
        }else{
            $("#s-submit").stop().slideDown(100);
        }
    });
    
    var form = $("#id").parent();
    
    $("#s-submit").click(function(e){
        // Prevent the click from triggering any other events.
        // Don't allow form to be submitted prematurely
        e.preventDefault();

        if ($(this).hasClass("disabled")){
            return;
        }
        
        $(this).text("Submitting...");

        // Check required fields
        errorOccurred = false;
        flagFields(form);

        if (!errorOccurred){
            // No errors caused by empty fields.

            // Disable button and attach disabled class
            $(this).addClass("disabled");
            $(this).attr("disabled");

            form.find(".error").hide();

            // Convert the inputs into postable data
            formData = form.serialize();
            
            button = $(this);

            // Post data to handler given in form action  field.
            // Response body sent to "response" field of function when request finishes
            $.post(form.attr("action"), formData, function(response){
                switch(response){
                    case "x":
                        error("Unknown error.", form);

                        button.removeClass("disabled");
                        button.removeAttr("disabled");
                        button.text("Submit");
                        
                        break;
                    case "y":
                        $("#s-comment").val($("#s-comment").attr("label"));
                        $("#s-submit").stop().slideUp(100);
                        
                        loadComments(id, 0, true);

                        button.removeClass("disabled");
                        button.removeAttr("disabled");
                        button.text("Submit");

                        break;
                    default:
                        // Got text as response. Assume it is an error.
                        error(response, form);

                        button.removeClass("disabled");
                        button.removeAttr("disabled");
                        button.text("Submit");
                        
                        break;
                }
            });
        }
    });
});