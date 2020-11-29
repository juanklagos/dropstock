class WidgetHandlerClass extends elementorModules.frontend.handlers.Base {
    getDefaultSettings() {
        return {
            selectors: {
                wooProductGallery: '.woocommerce-product-gallery',
                vertical		 : false,
            },
        };
    }

    getDefaultElements() {
        const selectors = this.getSettings( 'selectors' );
        return {
            $wooProductGallery: this.$element.find( selectors.wooProductGallery ),
            $vertical: this.$element.find( selectors.vertical ),
        };
    }
    
    getSliderOptions(){
    	var _this = this;
    	
    	var elementSettings = this.getElementSettings(),
	    settings = this.getSettings();
    	
    	var SliderOptions = {
    			vertical : elementSettings.gallery_slider_style === 'vertical',
    	};
    	
    	return SliderOptions;
    }
    
    initSlider(){
    	
    	var options = this.getSliderOptions();
    	
    	jQuery().dtwcbe_product_gallery_slider(options);
		jQuery('.woocommerce-product-gallery').css('opacity','1');
    }
    
    onInit(){
    	this.initSlider();
    }
    
    
}

jQuery( window ).on( 'elementor/frontend/init', () => {
   const addHandler = ( $element ) => {
       elementorFrontend.elementsHandler.addHandler( WidgetHandlerClass, {
           $element,
       } );
   };

   elementorFrontend.hooks.addAction( 'frontend/element_ready/single-product-images.default', addHandler );
} );