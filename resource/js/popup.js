
function show_popup(which_popup) {
    $("#backgroundPopup").css({"opacity": "0.2"});
    $("#backgroundPopup").fadeIn("fast");
    $("#" + which_popup).slideDown("slow");
}

function disablePopup() {
    $("#backgroundPopup").fadeOut("slow");
    $(".FB_popup").slideUp("slow");
}

function centerPopup(which_popup) {
    var windowWidth = document.documentElement.clientWidth;
    var windowHeight = document.documentElement.clientHeight;
    var popupHeight = $("#" + which_popup).height();
    var popupWidth = $("#" + which_popup).width();
    $("#" + which_popup).css({"position": "absolute","top": 500-popupHeight/2,"left": windowWidth/2-popupWidth/2});
    //    $("#backgroundPopup").css({"height": windowHeight});
}

$(document).ready(function()  {

        $("#FB_popupClose").click(function() {
                alert('closing');
                disablePopup();
            });

        $(document).keypress(function(e) {
                if(e.keyCode==27) {
                    disablePopup();
                }
            });

    });
