{script src="js/lib/owlcarousel/owl.carousel.min.js"}
<script type="text/javascript">
//<![CDATA[
(function(_, $) {
    $.ceEvent('on', 'ce.commoninit', function(context) {
        var elm = context.find('#scroll_list_company_images');

        var item = 6,
            // default setting of carousel
            itemsDesktop = 6,
            itemsDesktopSmall = 5;
            itemsTablet = 4;

        if (elm.length) {
            elm.owlCarousel({
                items: item,
                itemsDesktop: [1199, itemsDesktop],
                itemsDesktopSmall: [979, itemsDesktopSmall],
                itemsTablet: [768, itemsTablet],
                itemsMobile: [479, 1],
                scrollPerPage: true,
                autoPlay: false,
                slideSpeed: '400',
                stopOnHover: true,
                navigation: true,
                navigationText: ['&nbsp;', '&nbsp;'],
                pagination: false
            });
        }
    });
}(Tygh, Tygh.$));
//]]>
</script>