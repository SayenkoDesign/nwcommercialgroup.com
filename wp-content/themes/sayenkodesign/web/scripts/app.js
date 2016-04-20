jQuery(document).ready(function(){
    jQuery(document).foundation();
    jQuery('.slick').slick({
        autoplay: true,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear',
        arrows: false,
        pauseOnHover: false
    });

    jQuery(document).ready(function() {
        jQuery(".fancybox").attr('rel', 'gallery').fancybox({
            maxWidth: "60%",
            maxHeight: "90%",
            autoCenter  : true
        });
    });

    jQuery('.member-overview .member > a.hide-for-small-only').on("click", function(e){
        var elem = jQuery('#' + jQuery(this).attr('data-toggle'));

        if(elem.is(':visible')) {
            elem.slideToggle();
            e.preventDefault();
            e.defaultPrevented;
            return false;
        }

        var visible = jQuery('.member-details .member:visible');
        if(visible.length) {
            visible.slideToggle(function () {
                elem.slideToggle();
            });
            e.preventDefault();
            e.defaultPrevented;
            return false;
        }

        elem.slideToggle();
        e.preventDefault();
        e.defaultPrevented;
        return false;
    });

    jQuery('.member-details .member a.close').on("click", function(e){
        jQuery(this).parent('.member').slideToggle();
        e.preventDefault();
        e.defaultPrevented;
        return false;
    })
});