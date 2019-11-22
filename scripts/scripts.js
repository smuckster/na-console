$(document).ready(function(){
    // Toggle the user menu
    $('#nav-profile-button').click(function(){
        $('#nav-profile-menu').slideToggle(200);
    });

    // Toggle the client list in the left nav bar
    $('.left-nav-heading').click(function(){
        $(this).children('i').toggleClass('rotate');
        $(this).siblings('.toggle-menu').slideToggle(200);
    });



    // Load modules for client when their menu item is clicked
    $('.client-menu-item').click(function() {
        var currClient = $(this).html();
        var clientName = $(this).data("name");
        var clientId = $(this).data("id");

        $('.client-menu-item').removeClass('client-menu-item-active');
        $(this).toggleClass('client-menu-item-active');

        $(".main-frame").css('opacity', '0');
        setTimeout(function() {
            $(".main-frame").css('opacity', '1');
        }, 500);

        /*$('.module').each(function(index) {
           $(this).load('mod/'+$(this).attr('id')+'.php?client='+encodeURI(currClient), function () {
                $(".loading-frame").css('opacity', '0');
           });
        });*/
        load_page("pages", "client", clientId, function() {
            $('.module').each(function() {

                // This is all a bunch of nonsense to make the loading animations smoother
                // We keep the width and height auto, and animate between a low and high max-width and max-height
                $(this).css({
                    'max-width':'100px',
                    'max-height':'100px'
                })
                var elem = $(this);
                $(this).html('<i class="fa fa-spinner" aria-hidden="true"></i>');

                load_page("mod", $(this).attr('id'), clientName, function () {

                    // Make all the children invisible,
                    elem.children().css('opacity', '0');
                    elem.css({
                        'max-width':'300px',
                        'max-height':'300px'
                    })
                    // and wait for the animation to finish before fading them in
                    setTimeout(function() {
                        elem.children().css('transition', 'opacity 0.4s ease');
                        elem.children().css('opacity', '1');
                    }, 1000);
                });
            });
        });
    });
});

// Load in a new part of the page over AJAX
function load_page(type, page, clientname, callback) {
    if(type == "pages") {
        $.post(type + "/" + page + ".php",
                { client: clientname },
                function(data) {
                    $('.main-frame').html(data);
                    if (callback) {
                        callback();
                    }
                    add_client_edit_click();
                    add_client_edit_submission();
                }
        );
    } else if(type == "mod") {
        $.post(type + "/" + page + ".php",
                { client: clientname },
                function(data) {
                    // Fade out the loading spinner (and wait for this fade) before loading content
                    $('#' + page).children().css('transition', 'opacity 0.4s ease');
                    $('#' + page).children().css('opacity', '0');

                    setTimeout(function() {
                        $('#' + page).html(data);
                        if (callback) {
                            callback();
                        }
                    }, 400);
                }
        );
    }

}

// Attach click event to client editing button
function add_client_edit_click() {
    // Display the editing form when the client info edit button is clicked
    $('.edit-button').click(function(){
        $('.client-edit-container').show();
        $('.client-info-container').hide();
    });
}

// Attach submission event to client editing form
function add_client_edit_submission() {
    // Process form data and reload the page when client info editing form is submitted
    $('#client-edit-form').submit(function() {
        var form = $('#client-edit-form')[0];
        var fd = new FormData(form);
        $.post('../editclient.php',
                { data: fd },
                function(data) {
                    $('.client-info-container').append(data);
                    $('.client-edit-container').hide();
                    $('.client-info-container').show();
                }
              );
        return false;
    });
}
