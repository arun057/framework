var active_signup = '';
var redirect_href = '';

// called when an account ajax call has returned with new contents to replace the account sign_in/up box
//     set proper state for sign in and join buttons, fill in drop down with sign or join
//     remap any internal anchors to use the account_submit ajax call
function refresh_sign_in(response, account_action) {

    show_lightbox();
    if ((account_action == '/account/sign_up?ajax=1') || (account_action == '/account/connect_create')) {
        $('#signup_slidedown #sign_up_username_email').focus();
        active_signup = 'account_signup';
    }
    else {
        $('#signup_slidedown #sign_in_username_email').focus();
        active_signup = 'account_signin';
    }

    $('#sign_in_dropdown').html(response);
    $('[rel=ajax_account]').each(function() {
            $(this).attr('href', "javascript:account_submit('" + $(this).attr('account_url') + "?ajax=1', '')");
        });
    $('[rel=ajax_account_redirect]').each(function() {
            //            $(this).attr('href', "javascript:account_submit('" + $(this).attr('account_url') + "?ajax=1', '')");
            $(this).attr('href', "javascript:account_submit_redirect('" + $(this).attr('account_url') + "')");
        });

    $('#signup_slidedown').show();
}

// all submit buttons in account module add an onsubmit to call this function
//     if the call will potentially be redirecting to facebook or twitter
function account_submit_redirect(url) {

    // if clicking a button which requires sign in/up first, set continue to go to original button action
    if (redirect_href)
        location.href = url + '?continue=' + redirect_href;
    else 
        location.href = url + '?continue=' + location.href;
}


// all submit buttons in account module add an onsubmit to call this function with the form id
//     this turns the submit into an ajax call
function account_submit(url, form_id) {

    $.post(url, (form_id) ? $('#' + form_id).serialize() : '{}', function(response) {

            if (response.substr(0, 10) != '<!-- embed') {
                if (redirect_href)
                    window.location = redirect_href;

                // created via twitter, facebook, we were redirected to auth with FB or TW
                // so now have to redirect back to where we were going before going off to auth
                else if (connect_create) {
                    if (connect_create_redirect)
                        window.location.href = connect_create_redirect;
                }
                else
                    window.location.reload();
                
                return;
            }
            refresh_sign_in(response, url);
        });
}

// hook up the buttons to the account_submit ajax call
//
$(document).ready(function()
{
        $('.account_module #close').live('click', (function(e) {
                e.preventDefault();
                $('#signup_slidedown').hide();
                $('#lightbox').hide();
                active_signup = '';
                })
        );

        if (sign_in_now)
            account_submit('/account/sign_in?ajax=1', ''); 

        if (connect_create) 
            account_submit('/account/connect_create', ''); 

 });

// show a dim lightbox - just to enforce modal operation
function show_lightbox() {
   // if ($("#lightbox").width() < 1100) 
     //   $("#lightbox").width('1100px');
$("#lightbox").width($(document).width() + 'px');
    $("#lightbox").height($(document).height() + 'px');
    $("#lightbox").show();
}

