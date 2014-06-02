$(document).ready(function(){
    $("#content .right .more .thumbnail").mouseenter(function(){
        $(this).find(".details").stop().animate({marginTop: 56}, 110);
    }).mouseleave(function(){
        $(this).find(".details").stop().animate({marginTop: 80}, 110);
    });
});