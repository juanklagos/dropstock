( function ( $ ) {

	'use strict';

	if ( $( '.woocommerce div.product' ).hasClass( 'product-type-grouped' ) ) {
		return false;
	}

	$.fn.serializeArrayAll = function () {

		var rCRLF = /\r?\n/g;

		return this.map(function () {
			return this.elements ? jQuery.makeArray(this.elements) : this;
		}).map(function (i, elem) {
			var val = jQuery(this).val();

			if (val == null) {
				return val == null

			} else if (this.type == "checkbox" && this.checked == false) {
				return {name: this.name, value: this.checked ? this.value : ''}

			} else if (this.type == "radio" && this.checked == false) {
				return {name: this.name, value: this.checked ? this.value : ''}

			} else {
				return jQuery.isArray(val) ?
					jQuery.map(val, function (val, i) {
						return {name: elem.name, value: val.replace(rCRLF, "\r\n")};
					}) :
					{name: elem.name, value: val.replace(rCRLF, "\r\n")};
			}
		}).get();
	};

	var AjaxSingleAddToCart = {

		init: function() {

			var self = this;

			$( document ).on( 'click', '.single_add_to_cart_button', self.ajaxAddToCart );

		},

		ajaxAddToCart: function( event ) {

			event.preventDefault();

			var $this    = $(this),
				$form    = $this.closest('form.cart'),
				data     = $form.serializeArrayAll(),
				is_valid = false;

			$.each( data, function ( i, item ) {
				if ( item.name === 'add-to-cart' ) {
					is_valid = true;
					return false;
				}
			} );

			if ( is_valid ) {
				event.preventDefault();
			}
			else {
				return;
			}

			$( document.body ).trigger( 'adding_to_cart', [$this, data] );

			$.ajax( {
				type: 'POST',
				url: wc_add_to_cart_params.wc_ajax_url,
				data: data,
				beforeSend: function ( response ) {
					$this.removeClass( 'added' ).addClass( 'loading' );
				},
				complete: function ( response ) {
					$this.addClass( 'added' ).removeClass( 'loading' );
				},
				success: function ( response ) {
					if ( response.error & response.product_url ) {

						window.location = response.product_url;
						return;

					}

					$( document.body ).trigger( 'added_to_cart', [response.fragments, response.cart_hash, $this] );
					$( document.body ).trigger( 'wc_fragment_refresh' );

				},
			} );

			return false;

		}
		
	};

	AjaxSingleAddToCart.init();

} )( jQuery );