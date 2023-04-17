$(document).ready(function () {

    $(".date-picker").flatpickr({ static : true });

    $("input[type='text']").bind('focus', function() {
        $(this).css('background-color', 'white');
    });


    //move dropDown Menu
    /*let dropDown = $(".d-toggle");
    dropDown.click(function() {
        let menu = $(this).parent(".card-menu").find(".dropdown-menu");
        setTimeout(() => {
            menu.css("background", "red");
            menu.css("top", "-5px !important");
            menu.css("left", "-4px !important");
        }, 300)

    });*/

});
