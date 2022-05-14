$(function() {

    $("a").click(function() {

        $(".dialog").slideDown("slow");
        return false;
    });

    $(".jsc-back").click(function() {

        $(".dialog").fadeOut("fast");
        return false;
    });

});