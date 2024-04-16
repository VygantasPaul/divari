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
        var bottomBarHeight = jQuery('.bottom_bar').height();
        var topBarHeight = jQuery('.top_bar').height();
        jQuery(window).scroll(function () {
            var scrollThreshold = topBarHeight + bottomBarHeight + 30; // Arbatinis slenkstis, kada pritaikyti fiksuotą poziciją
            
            if (jQuery(window).scrollTop() > scrollThreshold) {
                bottomBar.addClass('sticky');
                jQuery('.bottom_bar').css('margin-top', '34px');
            } else {
                bottomBar.removeClass('sticky');
                jQuery('.bottom_bar').css('margin-top', '0');
            }

            if (window.matchMedia('(max-width: 768px)').matches)
            {
                if (jQuery(window).scrollTop() > 120) {
                    bottomBar.addClass('sticky');
                    jQuery('.bottom_bar').css('margin-top', '34px');
                } else {
                    bottomBar.removeClass('sticky');
                    jQuery('.bottom_bar').css('margin-top', '0');
                }
            }
            if (window.matchMedia('(max-width: 425px)').matches)
            {
                if (jQuery(window).scrollTop() > 200) {
                    bottomBar.addClass('sticky');
                    jQuery('.bottom_bar').css('margin-top', '0');
                } else {
                    bottomBar.removeClass('sticky');
                    jQuery('.bottom_bar').css('margin-top', '0');
                }
            }
        });
        
        
    } else {
        var bottomBar = jQuery('.bottom_bar');
        var topBarHeight = jQuery('.top_bar').height(); // Gauti .top_bar aukštį
        
        jQuery(window).scroll(function () {
            var scrollThreshold = topBarHeight; // Arbatinis slenkstis, kada pritaikyti fiksuotą poziciją
            
            if (jQuery(window).scrollTop() > scrollThreshold) {
                bottomBar.addClass('sticky');
            } else {
                bottomBar.removeClass('sticky');
            }
        });
    }
    
    jQuery('.sidebar-overlay').on('click', function (event) {
        
        jQuery('.left-sidebar').removeClass('active');
        
    });
});