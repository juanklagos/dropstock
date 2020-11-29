(function($){

	"use strict";

	function u(e) {
		return typeof e == 'undefined' ? false : e;
	}

	$(document).on( 'svx-wc_settings_wfsm_vendor_groups-load', function(e,f) {

		var r = [];

		var c=0;
		$.each( f.val, function(i,b) {

			r[typeof b.order!=='undefined'?b.order:c] = {
				name:u(b.name),
				users:u(b.users),
				permissions:u(b.permissions)
			};
			c++;

		});

		f.val = r;

	} );

	$(document).on( 'svx-wc_settings_wfsm_vendor_groups-save', function(e,f) {

		var r = {};

		var c=0;
		$.each( f.val, function(i,b) {

			b.name = u(b.name)?b.name:'Not set';

			r[sanitize_title(b.name)] = {
				name:b.name,
				users:u(b.users),
				permissions:u(b.permissions),
				order:c
			};
			c++;

		});

		f.save_val = r;

	} );

	$(document).on( 'svx-wc_settings_wfsm_custom_settings-load', function(e,f) {

		var r = [];

		$.each( f.val, function(i,b) {

			r[i] = {
				name:u(b.name),
				options:[]
			};

			$.each( b.type, function(n,m) {
				r[i].options[n] = {
					name:u(b['setting-name'][n]),
					type:u(b.type[n]),
					default:u(b.default[n]),
					key:u(b.key[n])
				};
				if ( u(b.options)&&u(b.options[n]) ) {
					r[i].options[n].options = b.options[n];
				}
			} );

		});

		f.val = r;

	});

	$(document).on( 'svx-wc_settings_wfsm_custom_settings-save', function(e,f) {

		var r = {};

		$.each( f.val, function(i,b) {

			r[i] = {
				name:u(b.name)?b.name:'Not set',
				type: [],
				'setting-name': [],
				default: [],
				key: [],
				options:[]
			}

			$.each( b.options, function(n,m) {

				$.each( m, function(q,s) {
					if ( q=='name' ) {
						r[i]['setting-name'][n] = s;
					}
					else {
						r[i][q][n] = s;
					}
				} );
			} );

		});

		f.save_val = r;

	});

	function sanitize_title(s) {
		if ( u(s) ) {
			s = s.toString().replace(/^\s+|\s+$/g, '');
			s = s.toLowerCase();

			var from = "ąàáäâèéëêęìíïîłòóöôùúüûñńçěšśčřžźżýúůďťňćđ·/_,:;#";
			var to   = "aaaaaeeeeeiiiiloooouuuunncesscrzzzyuudtncd-------";

			for (var i=0, l=from.length ; i<l ; i++)
			{
				s = s.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
			}

			s = s.replace('.', '-')
				.replace(/[^a-z0-9 -]/g, '')
				.replace(/\s+/g, '-')
				.replace(/-+/g, '-');
		}
		else {
			s = '';
		}

		return s;
	}

})(jQuery);