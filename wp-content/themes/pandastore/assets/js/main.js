jQuery(document).ready(function () {
    jQuery('.menu-item-has-children > a').on('click', function (e) {
        e.preventDefault();
        var subMenu = jQuery(this).siblings('.sub-menu');
        subMenu.slideToggle('fast');
        jQuery(this).parent('.menu-item-has-children').toggleClass('active');
    });
    
    
    jQuery('.sidebar-toggle-mobile').on('click', function (e) {
        e.stopPropagation();
        e.preventDefault(); // Prevent default link behavior
        jQuery('.left-sidebar').addClass('active');
    });
    
    jQuery('.sidebar-close').on('click', function (e) {
        
        e.preventDefault(); // Prevent default link behavior
        jQuery('.left-sidebar').removeClass('active');
    });
    
    if (jQuery('body').hasClass('logged-in')) {
        var bottomBar = jQuery('.bottom_bar');
        var top_bar_height = jQuery('.top_bar').height();
        var bottom_bar_height = jQuery('.bottom_bar').height() ;
        jQuery(window).scroll(function () {
   
            var scrollThreshold = top_bar_height + bottom_bar_height  + 40;  // Arbatinis slenkstis, kada pritaikyti fiksuotą poziciją
            if (jQuery(window).scrollTop() > scrollThreshold) {
                bottomBar.addClass('sticky');
                jQuery('body').addClass('loaded-nav');
                jQuery('.bottom_bar').css('margin-top', '34px');
            } else {
                bottomBar.removeClass('sticky');
                jQuery('body').removeClass('loaded-nav');
                jQuery('.bottom_bar').css('margin-top', '0');
            }

            if (window.matchMedia('(max-width: 768px)').matches)
            {
                if (jQuery(window).scrollTop() > 120) {
                    jQuery('body').addClass('loaded-nav');
                    bottomBar.addClass('sticky');
                    jQuery('.bottom_bar').css('margin-top', '34px');
                } else {
                    bottomBar.removeClass('sticky');
                    jQuery('body').removeClass('loaded-nav');
                    jQuery('.bottom_bar').css('margin-top', '0');
                }
            }
            if (window.matchMedia('(max-width: 425px)').matches)
            {
                if (jQuery(window).scrollTop() > 200) {
                    jQuery('body').addClass('loaded-nav');
                    bottomBar.addClass('sticky');
                    jQuery('.bottom_bar').css('margin-top', '0');
                } else {
                    bottomBar.removeClass('sticky');
                    jQuery('body').removeClass('loaded-nav');
                    jQuery('.bottom_bar').css('margin-top', '0');
                }
            }
        });
        
        
    } else {
        var bottomBar = jQuery('.bottom_bar');
        var top_bar_height = jQuery('.top_bar').height();
        var bottom_bar_height = jQuery('.bottom_bar').height() ;
        
        jQuery(window).scroll(function () {
            var scrollThreshold = top_bar_height + bottom_bar_height  + 40; // Arbatinis slenkstis, kada pritaikyti fiksuotą poziciją
            
            if (jQuery(window).scrollTop() > scrollThreshold) {
                jQuery('body').addClass('loaded-nav');
                bottomBar.addClass('sticky');
            } else {
                jQuery('body').removeClass('loaded-nav');
                bottomBar.removeClass('sticky');
            }
        });
    }
    
    jQuery('.sidebar-overlay').on('click', function (event) {
        
        jQuery('.left-sidebar').removeClass('active');
        
    });
});
