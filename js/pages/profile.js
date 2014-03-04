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
});