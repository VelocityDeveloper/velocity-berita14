jQuery(function($) {
    $('.related-post-carousel .module-vdposts,.part-carousel-home .module-vdposts').flickity({
        cellAlign: 'left',
        groupCells: true,
        autoPlay: true,
        autoPlay: 3500,
        wrapAround: true,
        lazyLoad: true,
        pageDots: false
    });
});