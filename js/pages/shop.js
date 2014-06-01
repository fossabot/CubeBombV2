$(document).ready(function(){
    $(".item").mouseenter(function(){
        $(this).find(".cubes").attr("src", "/images/icons/cubes-white.svg");
        $(this).addClass("hover");
    }).mouseleave(function(){
        $(this).find(".cubes").attr("src", "/images/icons/cubes.svg");
        $(this).removeClass("hover");
    });
});