
var Shares = {
 links : {
    set_counts : function() {
            $('.share').each(
                function() {
                    if ($(this).attr('share_count'))
                        Shares.links.get_counts($(this), $(this).attr('share_url'), $(this).attr('share_type'));
                });
        },
    get_counts : function(link, url, share_type) {
            $.ajax({
                url : "/cms/share_counts/get_counts",
                        type : 'POST',
                        data : { url : url, share_type : share_type },
                        success : function(msg) {
                        link.attr('share_count', msg);
                        link.html(msg);
                    },
                        failure : function(msg) {
                        // alert(msg);
                    }
                });
        },
		
    inc_counts: function( url, share_type ) {
            $.ajax({
                url : "/cms/share_counts/inc_counts",
                        type : 'POST',
                        data : { url : url, share_type : share_type }
                });
        }
 },
 click : {
    share_facebook : function(e) {
            var share_url = $(e).attr('share_url');
            Shares.links.inc_counts(share_url, 'facebook');
            var url = "http://www.facebook.com/sharer.php?u="
            + encodeURIComponent(share_url);
            url += "&amp;t=" + $(e).attr('share_msg');
            window.open(url, "facebook", "toolbar=no, width=550, height=550");
        },
    share_twitter : function(e) {
            var share_url = $(e).attr('share_url');
            Shares.links.inc_counts(share_url, 'twitter');
            var url = "http://twitter.com/intent/tweet?text="
            + encodeURIComponent($(e).attr('share_msg'));
            url += "&url=" + encodeURIComponent(share_url);
            window.open(url, 'twitter', "toolbar=no, width=550, height=550");
        },
    share_email : function(e) {
            var share_url = $(e).attr('share_url');
            Shares.links.inc_counts(share_url, 'email');
            var url = "mailto:?subject=" + encodeURIComponent( $(e).attr('share_msg')) + '&body=' + encodeURIComponent(share_url);
            window.open(url, 'email', "toolbar=no, width=550, height=550");
        },
    share_print : function(e) {
            var share_url = $(e).attr('share_url');
            Shares.links.inc_counts(share_url, 'print');
            window.print();
        }
 }
};

$(document).ready(function(){

        Shares.links.set_counts();

        $('.facebook_share').click( function() {
                Shares.click.share_facebook($(this)); 
            });

        $('.twitter_share').click( function() {
                Shares.click.share_twitter($(this));
            });

        $('.email_share').click( function() {
                Shares.click.share_email($(this));
            });

    });

