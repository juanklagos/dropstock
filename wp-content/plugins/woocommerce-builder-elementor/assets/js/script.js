!(function($){
	"use strict";
	$.fn.dtwcbe_product_gallery_slider = function( options ){
	var defaults = {
		vertical: false,
		thumbsToShow: 4,
	}
	  var option = $.extend(defaults, options);
	  
	  $('.woocommerce-product-gallery .venobox').venobox({
	    	autoplay: true,
	    	titleattr: 'title',
	    	titleBackground: '#000000',
	    	titleBackground: '#000000',
	    	titleColor: '#fff',
	    	numerationColor: '#fff',
	    	arrowsColor: '5',
	    	titlePosition: 'bottom',
	    	numeratio: true,
	    	spinner : 'double-bounce',
	    	spinColor: '#fff',
	    	border: '5px',
	    	bgcolor: '#f2f2f2',
	    	infinigall: false,
	    	numerationPosition: 'bottom'
	    });
	   
	  $('#product-image-slider').slick({
		  slidesToShow:1,
		  slidesToScroll:1,
		  accessibility: false,
		  lazyLoad: 'progressive',
		  arrows:true,
		  fade:false,
		  infinite:true,
		  autoplay:false,
		  nextArrow:'<i class="btn-next fa fa-angle-right"></i>',
		  prevArrow:'<i class="btn-prev fa fa-angle-left"></i>',
		  asNavFor:'#product-thumbnails-carousel',
		  dots :false,
	  });
	  
	  $('#product-thumbnails-carousel').slick({
		  slidesToShow:option.thumbsToShow,
		  slidesToScroll:1,
		  accessibility: false,
		  asNavFor:'#product-image-slider',
		  dots:false,
		  infinite:true,
		  arrows:true,
		  nextArrow:'<i class="btn-next fa fa-angle-right"></i>',
		  prevArrow:'<i class="btn-prev fa fa-angle-left"></i>',
		  centerMode:false,
		  dots:false,
		  draggable: false,
		  vertical: option.vertical,
		  focusOnSelect:true,
		  responsive:[{
			  breakpoint:767,
			  settings:{
				  slidesToShow:3,
				  slidesToScroll:1,
				  vertical:false,
				  draggable:true,
				  autoplay:false,
				  isMobile:true,
				  arrows:false
				  }
		  },],});
	  
	  $('.woocommerce-product-gallery__image img').load(function() {
		    var imageObj = jQuery('.woocommerce-product-gallery__image img');
		    $('.woocommerce-product-gallery__image--thumbnail img').remove();
		    $( ".woocommerce-product-gallery__image--thumbnail" ).append( "<img src="+imageObj.attr('src')+" />" );
			
		    if (!(imageObj.width() == 1 && imageObj.height() == 1)) {
		    	$('.slider-for .woocommerce-product-gallery__image , #product-thumbnails-carousel .slick-slide .woocommerce-product-gallery__image--thumbnail').trigger('click');
		    	$('.woocommerce-product-gallery__image img').trigger('zoom.destroy');
		    }
	  });
	  
	  if( jQuery('.elementor-widget-single-product-images .elementor-widget-container > .onsale').length ){
	  	var $onsaleHTML = jQuery('.elementor-widget-single-product-images .elementor-widget-container > .onsale');
	  	jQuery('div.elementor-widget-single-product-images #product-image-slider').prepend($onsaleHTML);
	  }

  };
	  
	jQuery(document).ready(function($) {
		if( jQuery('.dtwcbe-woocommerce-checkout').find('div.dtwcbe_woocommerce_checkout_form-login').length){
			var checkout_login_toggle = jQuery(".dtwcbe-woocommerce-checkout .woocommerce-form-login-toggle");
    		var checkout_form_login = jQuery(".dtwcbe-woocommerce-checkout form.woocommerce-form-login");
    		jQuery(".dtwcbe_woocommerce_checkout_form-login").append(checkout_login_toggle),checkout_login_toggle.show(),checkout_form_login.insertAfter(checkout_login_toggle);
    	}
		if( jQuery('.dtwcbe-woocommerce-checkout').find('div.dtwcbe_woocommerce_checkout_coupon_form').length){
			var coupon_toggle = jQuery(".dtwcbe-woocommerce-checkout .woocommerce-form-coupon-toggle");
    		var coupon_form = jQuery(".dtwcbe-woocommerce-checkout form.woocommerce-form-coupon");
    		jQuery(".dtwcbe_woocommerce_checkout_coupon_form").append(coupon_toggle),coupon_toggle.show(),coupon_form.insertAfter(coupon_toggle);
		}
	});
	jQuery(window).load(function(){
		if( jQuery('body').hasClass('woocommerce-builder-elementor single-product') ){
			var data_lementor_type = jQuery('[data-elementor-type]');
			if( jQuery(data_lementor_type).length ){
				jQuery(data_lementor_type).addClass('product');
			}
		}
	});
})(jQuery);