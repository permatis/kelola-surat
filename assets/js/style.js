$(document).ready(function () {
    $('ul.submenu').toggle();
    $('ul.subsubmenu').toggle();
    $('a.submenu').click(function () {
        $('ul.tree').toggle(300);
        // var cs = $(this).attr("class");
        // if(cs == 'nav-toggle-icon glyphicon pull-right glyphicon-chevron-right') {
        //     $(this).removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-down');
        // }
        // if(cs == 'nav-toggle-icon glyphicon pull-right glyphicon-chevron-down') {
        //     $(this).removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-right');
        // }
    });
    // $('.img-preview img').hide();
    
    // $('ul.thumbs li a img').click(function() {
    //     $('.img-preview img').fadeOut(400).hide();

    //     var thumb = $(this).attr("id"),
    //         id = thumb.replace('thumb_',''),
    //         image = $('.img-preview img.image_'+id).fadeIn(400).show();
        
    //     $('.img-preview').addClass('image_'+id);
    //     $('.img-preview').zoom({ url: image.attr('src') });

    //     return false;
    // });

    // $('.img-preview img:first').show();
    // $('.img-preview:first').zoom();

    // $('#list').click( function(event){
    //     event.preventDefault();
    //     $('.product .item').addClass('list-group-item');
    //     $('.product .item .thumbnail .price').addClass('text-right');
    //     $('.product .item .thumbnail .btn-cart').addClass('text-right');
    //     $('#list').addClass('active');
    //     $('#grid').removeClass('active');
    // });

    // $('#grid').click(function(event){
    //     event.preventDefault();
    //     $('.product .item').removeClass('list-group-item');
    //     $('.product .item .thumbnail .price').removeClass('text-right');
    //     $('.product .item .thumbnail .btn-cart').removeClass('text-right');
    //     $('#list').removeClass('active');
    //     $('#grid').addClass('active');
    // });
});
