$(document).ready(function(){
    $("#sidebar .block > .button").mouseenter(function(){
        $(this).find(".rightArrow").css({opacity: 1});
        $(this).find(".sprite").removeClass("sprite").addClass("sprite-white");
    }).mouseleave(function(){
        $(this).find(".rightArrow").css({opacity: 0});
        $(this).find(".sprite-white").removeClass("sprite-white").addClass("sprite");
    });
    
    $("#nav .time").tipsy({gravity: "s", delayIn: 1000});
});