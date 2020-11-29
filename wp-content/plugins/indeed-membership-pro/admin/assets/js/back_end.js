function setAddVal(id, target){
	var value;
	switch(jQuery(id).val()){
	 case '1':
	 	 value = 'ihc-login-template-1';
	      break;
	case '2':
	 	 value = 'ihc-login-template-7';
	      break;
	case '3':
	 	 value = 'ihc-login-template-7';
	      break;
	case '4':
	 	 value = 'ihc-login-template-5';
	      break;
	case '5':
	 	 value = 'ihc-login-template-3';
	      break;
	case '6':
	 	 value = 'ihc-login-template-6';
	      break;
	case '7':
	 	 value = 'ihc-login-template-2';
	      break;
	case '8':
	 	 value = 'ihc-login-template-8';
	      break;
	case '9':
	 	 value = 'ihc-login-template-9';
	      break;
	case '10':
	 	 value = 'ihc-login-template-10';
	      break;
	case '11':
	 	 value = 'ihc-login-template-11';
	      break;
	case '12':
	 	 value = 'ihc-login-template-12';
	      break;
	case '13':
	 	 value = 'ihc-login-template-13';
	      break;
	default:
		  value = 'ihc-login-template-1';
	}
	jQuery(target).val(value);
}


function ihcMakeInputhString(divCheck, showValue, hiddenInputId){
    str = jQuery(hiddenInputId).val();
    if (str==-1){
				str = '';
		}
    if (str!=''){
				showArr = str.split(',');
		} else {
			  showArr = new Array();
		}
    if (jQuery(divCheck).is(':checked')){
        show_arr.push(showValue);
    } else {
        var index = show_arr.indexOf(showValue);
        show_arr.splice(index, 1);
    }
    str = show_arr.join(',');
    if (str==''){
				str = -1;
		}
    jQuery(hiddenInputId).val(str);
}

function ihcClosePopup(){
	jQuery('#popup_box').fadeOut(300, function(){
		jQuery(this).remove();
	});
}

function ihcLoginPreview(){
   	jQuery.ajax({
        type : "post",
        url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
        data : {
                   action: "ihc_login_form_preview",
                   remember: jQuery('#ihc_login_remember_me').val(),
                   register: jQuery('#ihc_login_register').val(),
                   pass_lost: jQuery('#ihc_login_pass_lost').val(),
                   css: jQuery('#ihc_login_custom_css').val(),
                   template: jQuery('#ihc_login_template').val(),
                   ihc_login_show_sm: jQuery("#ihc_login_show_sm").val(),
                   ihc_login_show_recaptcha: jQuery('#ihc_login_show_recaptcha').val(),
               },
        success: function (data) {
        	jQuery('#ihc-preview-login').fadeOut(200, function(){
        		jQuery(this).html(data);
        		jQuery(this).fadeIn(400);
        	});
        }
   });
}

function ihcWriteTagValue(id, hiddenId, viewDivId, prevDivPrefix){
    if(id.value==-1) return;
    hidden_i = jQuery(hiddenId).val();

    if(hidden_i!='') show_arr = hidden_i.split(',');
    else show_arr = new Array();

    if(show_arr.indexOf(id.value)==-1){
        show_arr.push(id.value);

	    str = show_arr.join(',');
	    jQuery(hiddenId).val(str);

		label = jQuery(id).find("option:selected").text();
		jQuery(viewDivId).append('<div id="'+prevDivPrefix+id.value+'" class="ihc-tag-item">'+label+'<div class="ihc-remove-tag" onclick="ihcremoveTag(\''+id.value+'\', \'#'+prevDivPrefix+'\', \''+hiddenId+'\');" title="Removing tag">x</div></div>');
    }

    jQuery(id).val(-1);
}

function ihcWriteTagValueForEditPost(id, hiddenId, viewDivId, prevDivPrefix){
    if(id.value==-1) return;
    hidden_i = jQuery(hiddenId).val();

    if(hidden_i!='') show_arr = hidden_i.split(',');
    else show_arr = new Array();

    if(show_arr.indexOf(id.value)==-1){
        show_arr.push(id.value);

	    str = show_arr.join(',');
	    jQuery(hiddenId).val(str);

		label = jQuery(id).find("option:selected").text();
		jQuery(viewDivId).append('<div id="'+prevDivPrefix+id.value+'" class="ihc-tag-item">'+label+'<div class="ihc-remove-tag" onclick="ihcremoveTagForEditPost(\''+id.value+'\', \'#'+prevDivPrefix+'\', \''+hiddenId+'\');" title="Removing tag">x</div></div>');

		//drip
		jQuery('#ihc_drip_content_list_targets').append('<div id="ihc_drip_target-'+id.value+'">'+label+'</div>');
		if (jQuery('#ihc_mb_type').val()=='show'){
			jQuery('#ihc_drip_content_empty_meta_box').css('display', 'none');
			jQuery('#ihc_drip_content_meta_box').css('display', 'block');
		}
    }
    jQuery(id).val(-1);
}

function ihcWriteLevelTagValue(id, hiddenId, viewDivId, prevDivPrefix){
    if (id.value==-2) return;
    hidden_i = jQuery(hiddenId).val();

    if (hidden_i!='') show_arr = hidden_i.split(',');
    else show_arr = new Array();

    if (show_arr.indexOf(id.value)==-1){
        show_arr.push(id.value);

	    str = show_arr.join(',');
	    jQuery(hiddenId).val(str);

		label = jQuery(id).find("option:selected").text();
		jQuery(viewDivId).append('<div id="'+prevDivPrefix+id.value+'" class="ihc-tag-item">'+label+'<div class="ihc-remove-tag" onclick="ihcremoveTagForEditPost(\''+id.value+'\', \'#'+prevDivPrefix+'\', \''+hiddenId+'\');" title="Removing tag">x</div></div>');

		//drip
		jQuery('#ihc_drip_content_list_targets').append('<div id="ihc_drip_target-'+id.value+'">'+label+'</div>');
		if (jQuery('#ihc_mb_type').val()=='show'){
			jQuery('#ihc_drip_content_empty_meta_box').css('display', 'none');
			jQuery('#ihc_drip_content_meta_box').css('display', 'block');
		}
    }
    jQuery(id).val(-2);
}

function ihcremoveTagForEditPost(removeVal, prevDivPrefix, hiddenId){
	jQuery(prevDivPrefix+removeVal).fadeOut(200, function(){
		jQuery(this).remove();
	});

    hidden_i = jQuery(hiddenId).val();
    show_arr = hidden_i.split(',');

    show_arr = removeArrayElement(removeVal, show_arr);
    str = show_arr.join(',');
	jQuery(hiddenId).val(str);

	//drip
	jQuery('#ihc_drip_target-'+removeVal).remove();
	if (str==''){
		jQuery('#ihc_drip_content_meta_box').fadeOut(300, function(){
			jQuery('#ihc_drip_content_empty_meta_box').css('display', 'block');
		});
	}
}

function ihcWriteTagValueCfl(id, hiddenId, viewDivId, prevDivPrefix){
    if(id.value==-2) return;
    hidden_i = jQuery(hiddenId).val();

    if(hidden_i!='') show_arr = hidden_i.split(',');
    else show_arr = new Array();

    if(show_arr.indexOf(id.value)==-1){
        show_arr.push(id.value);

	    str = show_arr.join(',');
	    jQuery(hiddenId).val(str);

		label = jQuery(id).find("option:selected").text();
		jQuery(viewDivId).append('<div id="'+prevDivPrefix+id.value+'" class="ihc-tag-item">'+label+'<div class="ihc-remove-tag" onclick="ihcremoveTag(\''+id.value+'\', \'#'+prevDivPrefix+'\', \''+hiddenId+'\');" title="Removing tag">x</div></div>');
    }

    jQuery(id).val(-2);
}

function ihcWriteTagValueListUsers(id, hiddenId, viewDivId, prevDivPrefix){
    if(id.value==-1) return;
    hidden_i = jQuery(hiddenId).val();

    if(hidden_i!='') show_arr = hidden_i.split(',');
    else show_arr = new Array();

    if(show_arr.indexOf(id.value)==-1){
        show_arr.push(id.value);

	    str = show_arr.join(',');
	    jQuery(hiddenId).val(str);

		label = jQuery(id).find("option:selected").text();
		jQuery(viewDivId).append('<div id="'+prevDivPrefix+id.value+'" class="ihc-tag-item">'+label+'<div class="ihc-remove-tag" onclick="ihcremoveTag(\''+id.value+'\', \'#'+prevDivPrefix+'\', \''+hiddenId+'\');ihcPreviewUList();" title="Removing tag">x</div></div>');
    }

    jQuery(id).val(-1);
}

function ihcShowHideDrip(){
	if (jQuery('#ihc_mb_type').val()=='show'){
		jQuery('#ihc_drip_content_empty_meta_box').css('display', 'none');
		jQuery('#ihc_drip_content_meta_box').css('display', 'block');
	} else {
		jQuery('#ihc_drip_content_empty_meta_box').css('display', 'block');
		jQuery('#ihc_drip_content_meta_box').css('display', 'none');
	}
}

function ihcremoveTag(removeVal, prevDivPrefix, hiddenId){
	jQuery(prevDivPrefix+removeVal).fadeOut(200, function(){
		jQuery(this).remove();
	});

    hidden_i = jQuery(hiddenId).val();
    show_arr = hidden_i.split(',');

    show_arr = removeArrayElement(removeVal, show_arr);
    str = show_arr.join(',');
	jQuery(hiddenId).val(str);
}

function removeArrayElement(elem, arr){
	for (i=0;i<arr.length;i++) {
	    if(arr[i]==elem){
	    	arr.splice(i, 1);
	    }
	}
	return arr;
}

function ihcRedirectReplaceDd(v){
	var replace_id = '#ihc-meta-box-replace';
	var redirect_id = '#ihc-meta-box-redirect';
	var hidden_replace_content = '#ihc_replace_content';
	if(v=='redirect'){
		jQuery(replace_id).attr('class', 'ihc-display-none');
		jQuery(redirect_id).attr('class', 'ihc-display-block');
		//hide the replace content editor
		jQuery(hidden_replace_content).fadeOut(300);
	}else{
		jQuery(redirect_id).attr('class', 'ihc-display-none');
		jQuery(replace_id).attr('class', 'ihc-display-block');
		//hide the replace content editor
		jQuery(hidden_replace_content).fadeIn(300);
	}
}

jQuery('#ihc_locker_custom_content').on('blur', function(){
	ihcLockerPreview();
});

function ihcUpdateTextarea(){
    content = jQuery( "#ihc_locker_custom_content_ifr" ).contents().find( '#tinymce' ).html();
    jQuery('#ihc_locker_custom_content').val(content);
    ihcLockerPreview();
}

function ihcLockerPreview(){
	//preview locker based of current selections
   	jQuery.ajax({
        type : "post",
        url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
        data : {
                   action: "ihc_locker_preview_ajax",
                   ihc_locker_template: jQuery('#ihc_locker_template').val(),
				   		 		 ihc_locker_login_template: jQuery('#ihc_locker_login_template').val(),
                   ihc_locker_login_form: jQuery('#ihc_locker_login_form').val(),
                   ihc_locker_additional_links: jQuery('#ihc_locker_additional_links').val(),
                   ihc_locker_custom_content: jQuery('#ihc_locker_custom_content').val(),
                   ihc_locker_custom_css: jQuery('#ihc_locker_custom_css').val(),
                   ihc_locker_display_sm: jQuery('#ihc_locker_display_sm').val(),
               },
        success: function (response) {
        	jQuery('#locker-preview').fadeOut(200, function(){
        		jQuery(this).html(response);
        		jQuery(this).fadeIn(400);
        	});
        }
   });
}

function ihcLockerPreviewWi(id, popupDisplay){
	if(id==-1){
		return;
	}
	//preview locker based on id
   	jQuery.ajax({
        type : "post",
        url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
        data : {
                   action: 'ihc_locker_preview_ajax',
                   locker_id: id,
                   popup_display: popupDisplay,
               },
        success: function (response) {
        	if (popupDisplay){
        		jQuery('#locker-preview').append(response);
        	} else {
            	jQuery('#locker-preview').fadeOut(200, function(){
            		jQuery(this).html(response);
            		jQuery(this).fadeIn(400);
            	});
        	}

        }
   });
}

function ihcReq(id, n){
	if(!jQuery(id).is(':checked')){
		jQuery('#req-check-'+n).removeAttr('checked');
		jQuery('#ihc-require-'+n).val(0);
	}
}

jQuery(document).ready(function(){
	jQuery('#ihc-register-fields-table tbody').sortable({
		 update: function(e, ui) {
		        jQuery('#ihc-register-fields-table tbody tr').each(function (i, row) {
		        	id = jQuery(this).attr('id');
		        	var newindex = jQuery("#ihc-register-fields-table tbody tr").index(jQuery('#'+id));
		        	jQuery('#'+id+' .ihc-order').val(newindex);
		        });
		    }
	});

	jQuery('#ihc-levels-table tbody').sortable({
		 disabled: true,
		 update: function(e, ui) {
			 	arr = new Array();i = 0;
			 	jQuery('#ihc-levels-table tbody tr').each(function (i, row) {

			 		id = jQuery(this).attr('id');
			 		if(id){
			        	//var new_index = jQuery("#ihc-levels-table tbody tr").index(jQuery('#'+id));
			        	var level_id = jQuery('#'+id+' .ihc-hidden-level-id').val();
			        	arr.push(level_id);
			        	//arr[i]['id'] = level_id;
			        	//arr[i]['order'] = new_index;
			 		}
		        	i++;
		        });
			 	j = false;
			 	j = JSON.stringify(arr);
		        if (j){
		           	jQuery.ajax({
		                type : 'post',
		                url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
		                data : {
		                           action: 'ihc_reorder_levels',
		                           json_data: j,
		                       },
		                success: function (response) {
							console.log(response);
		                }
		           });
		        }
		    }
	});
});

function ihcSortableOnOff(i, selector){
	if (window.ihc_sortable){
		//disable
		jQuery( selector ).sortable( "disable" );
		jQuery( i ).attr('class', 'ihc-sortable-off');
		jQuery(selector).css('cursor', '');
		jQuery(selector).css('opacity', '1');
		jQuery('#ihc-reorder-msg').fadeOut(200);
		window.ihc_sortable = 0;
	} else {
		//enable
		jQuery( selector ).sortable( "enable" );
		jQuery( i ).attr('class', 'ihc-sortable-on');
		jQuery(selector).css('cursor', 'move');
		jQuery(selector).css('opacity', '0.7');
		jQuery('#ihc-reorder-msg').fadeIn(200);
		window.ihc_sortable = 1;
	}

}

function ihcSelectAllCheckboxes(check, selector){
	if(jQuery(check).is(':checked')){
		jQuery(selector).each(function(){
			jQuery(this).attr('checked', 'checked');
		});
	}else{
		jQuery(selector).each(function(){
			jQuery(this).removeAttr('checked');
		});
	}
}

function ihcDhSelector(id, display){
	if (display){
		jQuery(id).css('visibility', 'visible');
	} else {
		jQuery(id).css('visibility', 'hidden');
	}
}

function ihcDeleteUserPrompot(i){
		swal({
			title: "Are you sure that you want to delete this user?",
			text: "",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "OK",
			closeOnConfirm: true
		},
		function(){
			jQuery.ajax({
					type : 'post',
					url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
					data : {
										 action: 'ihc_delete_user_via_ajax',
										 id: i,
								 },
					success: function () {
						jQuery('#ihc_user_id_'+i).fadeOut(200);
					}
		 });
	 });

}

function ihcFirstConfirm(m){
	/*
	var c = confirm(m);
	if (c){
		return true;
	} else {
		return false;
	}
*/
	swal({
		title: m,
		text: "",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "OK",
		closeOnConfirm: true
	},
	function(){
		return true;
 });

}
function ihcFirstConfirmBeforeSubmitForm(m){
		swal({
				title: m,
				text: "",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "OK",
				closeOnConfirm: true
			},
			function(){
				jQuery("form[name='ihc-users']").submit();
				//return true;
	 	});
}

function indeedConfirmAndRedirect(url){
		swal({
			title: "Are you sure?",
			text: "",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "OK",
			closeOnConfirm: true
		},
		function(){
			 window.location.href = url;
	 });
}

function ihcRegisterLockerPreview(){
	//preview locker based of current selections
   	jQuery.ajax({
        type : 'post',
        url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
        data : {
                   action: 'ihc_register_preview_ajax',
                   template: jQuery('#ihc_register_template').val(),
                   custom_css: jQuery('#ihc_register_custom_css').val(),
               },
        success: function (response) {
        	jQuery('#register_preview').fadeOut(200, function(){
        		jQuery(this).html(response);
        		jQuery(this).fadeIn(400);
        	});
        }
   });
}

function ihcSelectShDiv(s, target, value){
	if (jQuery(s).val()==value){
		jQuery(target).fadeIn(300, function(){
			jQuery(this).css('display', 'block');
		});
	} else {
		jQuery(target).fadeOut(300, function(){
			jQuery(this).css('display', 'none');
		});
	}
}

function ihcApproveUser(id){
   	jQuery.ajax({
        type : 'post',
        url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
        data : {
                   action: 'ihc_approve_new_user',
                   uid: id,
               },
        success: function (response) {
        	jQuery('#user-'+id+'-status').fadeOut(200, function(){
        		the_span_style = 'background-color: #f1f1f1;color: #666;padding: 3px 0px;font-size: 10px;font-weight: bold;display: inline-block; min-width: 70px; border: 1px solid #ddd;border-radius: 3px;text-align: center; text-transform: capitalize;';
        		jQuery(this).html('<span style="'+the_span_style+'">'+response+'</span>');
        		jQuery(this).fadeIn(200);
        		jQuery('#approveUserLNK'+id).fadeOut(200, function(){
        			jQuery(this).html('');
        		});
        	});
        }
   });
}

function ihcApproveEmail(id, new_label){
   	jQuery.ajax({
        type : 'post',
        url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
        data : {
                   action: 'ihc_approve_user_email',
                   uid: id,
               },
        success: function (response) {
        	jQuery('#user_email_'+id+'_status').fadeOut(200, function(){
        		the_span_style = 'background-color: #f1f1f1;color: #666;padding: 3px 0px;font-size: 10px;font-weight: bold;display: inline-block; min-width: 70px; border: 1px solid #ddd;border-radius: 3px;text-align: center;';
        		jQuery(this).html('<span style="'+the_span_style+'">'+new_label+'</span>');
        		jQuery(this).fadeIn(200);

        		jQuery('#approve_email_'+id).fadeOut(200, function(){
        			jQuery(this).html('');
        		});
        	});
        }
   });
}

function ihcPreviewSelectLevels(){
   	jQuery.ajax({
        type : 'post',
        url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
        data : {
                   action: 'ihc_preview_select_level',
                   template: jQuery('#ihc_level_template').val(),
                   custom_css: jQuery('#ihc_select_level_custom_css').val()
               },
        success: function (response) {
        	jQuery('#ihc_preview_levels').fadeOut(200, function(){
        		jQuery(this).html(response);
        		jQuery(this).fadeIn(200);
        	});
        }
   });
}

//OPT IN
function ihcConnectAweber(t){
    jQuery.ajax({
        type : "post",
        url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
        data : {
                action: "ihc_update_aweber",
                auth_code: jQuery( t ).val()
            },
        success: function (data) {
            alert('Connected');
        }
	});
}

function ihcGetCcList( ihc_cc_user,ihc_cc_pass ){
    jQuery("#ihc_cc_list").find('option').remove();
	jQuery.ajax({
            type : "post",
			dataType: 'JSON',
            url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
            data : {
                    action: "ihc_get_cc_list",
                    ihc_cc_user: jQuery( ihc_cc_user ).val(),
                    ihc_cc_pass: jQuery( ihc_cc_pass ).val()
            },
            success: function (data) {
					jQuery.each(data, function(i, option){
						jQuery("<option/>").val(i).text(option.name).appendTo("#ihc_cc_list");
					});
			}
    });
}

function ihcAccessPaymentType(v){
	var arr = ['#limited_access_metas','#date_interval_access_metas','#regular_period_access_metas', '#set_expired_level'];
	for (i=0;i<arr.length;i++) {
	    jQuery(arr[i]).css('display', 'none');
	}
	if(v !== 'unlimited'){
		jQuery('#billind_rec_label').css('display', 'inline-block');
		jQuery('#set_expired_level').css('display', 'block');
	}

	switch (v){
		case 'limited':
			jQuery(arr[0]).css('display', 'block');
			jQuery('#billing_type_1').css('display', 'inline-block');
			jQuery('#billing_type_2').css('display', 'none');
			jQuery('#regular_period_billing').css('display', 'none');
			break;
		case 'date_interval':
			jQuery(arr[1]).css('display', 'block');
			jQuery('#billing_type_1').css('display', 'inline-block');
			jQuery('#billing_type_2').css('display', 'none');
			jQuery('#regular_period_billing').css('display', 'none');
			break;
		case 'regular_period':
			jQuery(arr[2]).css('display', 'block');
			jQuery('#billing_type_2').val('bl_ongoing');
			jQuery('#billing_type_1').css('display', 'none');
			jQuery('#billing_type_2').css('display', 'inline-block');
			jQuery('#trial_period_billing').css('display', 'inline-block');
			break;
		case 'unlimited':
			jQuery('#billing_type_1').css('display', 'none');
			jQuery('#billing_type_2').css('display', 'none');
			jQuery('#regular_period_billing').css('display', 'none');
			jQuery('#trial_period_billing').css('display', 'none');
			jQuery('#billind_rec_label').css('display', 'none');
			break;
	}
}

function ihcCheckBillingType(v){
	if (v=='bl_limited'){
		jQuery('#regular_period_billing').css('display', 'block');
	} else {
		jQuery('#regular_period_billing').css('display', 'none');
	}
}

function ihcAddZero(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}
function iumpCheckAndH(from, target){
		if ( jQuery(from).is(":checked") ){
				jQuery(target).val(1);
		} else {
			jQuery(target).val(0);
		}
}
function ihcShowHide(div){
	jQuery(div).toggle();
}

function checkAndH(id, target){
	if(jQuery(id).is(':checked')){
		jQuery(target).val(1);
	}else{
		jQuery(target).val(0);
	}
}


function ihcMakeUserCsv(){
		// console.log( jQuery( '#ihc_make_user_csv_file' ).attr( 'data-get_variables' ) )
   	jQuery.ajax({
        type : 'post',
        url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
        data : {
                   action: 'ihc_return_csv_link',
									 getAttributes : jQuery( '#ihc_make_user_csv_file' ).attr( 'data-get_variables' )
        },
        success: function (response) {
        	if (response){
        		jQuery('.ihc-hidden-download-link a').attr('href', response);
        		jQuery('.ihc-hidden-download-link').fadeIn(200);
        		window.open(response, '_blank');
        	}
        }
   });
}

function ihcChangeTrialType(v){
	if (v==1){
		jQuery('#trial_couple_cycles').fadeOut(200, function(){
			jQuery('#trial_certain_period').css('display', 'block');
		});
	} else {
		jQuery('#trial_certain_period').fadeOut(200, function(){
			jQuery('#trial_couple_cycles').css('display', 'block');
		});
	}
}

function ihcRegisterFields(v){
	jQuery('#ihc-register-field-values').fadeOut(200);
	jQuery('#ihc-register-field-plain-text').fadeOut(200);
	jQuery('#ihc-register-field-conditional-text').fadeOut(200);
	if (v=='select' || v=='checkbox' || v=='radio' || v=='multi_select'){
		jQuery('#ihc-register-field-values').fadeIn(200);
	} else if (v=='plain_text'){
		jQuery('#ihc-register-field-plain-text').fadeIn(200);
	} else if (v=='conditional_text'){
		jQuery('#ihc-register-field-conditional-text').fadeIn(200);
	}
}

function ihcAddNewRegisterFieldValue(){
	var s = '<div style="display: block; margin-bottom: 5px;" class="ihc-custom-field-item-wrapp" >';
	s += '<input type="text" name="values[]" value=""/> ';
	s += '<i class="fa-ihc ihc-icon-remove-e" style="cursor: pointer;" onclick="jQuery(this).parent().remove();"></i>';
	s += '<i class="fa-ihc fa-arrows-ihc"></i>';
	s += '</div>';
	jQuery('.ihc-register-the-values').append(s);
}

function ihcMakeInputhString(divCheck, showValue, hidden_input_id){
    str = jQuery(hidden_input_id).val();
    if (str!=''){
    	show_arr = str.split(',');
    } else{
    	show_arr = new Array();
    }
    if (jQuery(divCheck).is(':checked')){
        show_arr.push(showValue);
    } else {
        var index = show_arr.indexOf(showValue);
        show_arr.splice(index, 1);
    }
    str = show_arr.join(',');
    jQuery(hidden_input_id).val(str);
}

function ihcGenerateCode(target, length){
	var str = "";
    var characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i=0;i<length;i++){
    	str += characters.charAt(Math.floor(Math.random() * characters.length));
	}
	jQuery(target).val(str);
}

function ihcDiscountType(v){
	if (v=='percentage'){
		jQuery("#discount_currency").fadeOut(300, function(){
			jQuery("#discount_percentage").css("display", "inline");
		});
	} else {
		jQuery("#discount_percentage").fadeOut(300, function(){
			jQuery("#discount_currency").css("display", "inline");
		});
	}
}

function ihcDeleteCoupon(i, d){
	var c = confirm("Are You sure You wish to delete this coupon?");
	if (c){
		//delete here
	   	jQuery.ajax({
	        type : 'post',
	        url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
	        data : {
	                   action: 'ihc_delete_coupon_ajax',
	                   id: i
	               },
	        success: function (r) {
	        	if (r){
	        		jQuery(d).fadeOut(300);
	        	}
	        }
	   });
    }
}

function ihcChangeNotificationTemplate(){
   	jQuery.ajax({
	        type : 'post',
	        url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
	        data : {
	                   action: 'ihc_notification_templates_ajax',
	                   type: jQuery('#notification_type').val()
	               },
	        success: function (r) {
	        	var o = jQuery.parseJSON(r);
	        	console.log(o);
	        	jQuery('#notification_subject').val(o.subject);
	        	jQuery('#ihc_message').val(o.content);
	        	jQuery( "#ihc_message_ifr" ).contents().find( '#tinymce' ).html(o.content);
	        }
   });
}

function ihcRemoveCurrency(c){
   	jQuery.ajax({
        type : 'post',
        url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
        data : {
                   action: 'ihc_delete_currency_code_ajax',
                   code: c
               },
        success: function (r) {
        	if (r){
        		jQuery("#ihc_div_"+c).fadeOut(300);
        	}
        }
   });
}

function ihcCheckboxDivRelation(c, t){
	/*
	 * c = checkbox id to check
	 * t = target div
	 */
	var o = 0.5;
	if (jQuery(c).is(":checked")){
		o = 1;
	}
	jQuery(t).css("opacity", o);
}

function ihcChangeColorScheme(id, value, where ){
    jQuery('#colors_ul li').each(function(){
        jQuery(this).attr('class', 'color-scheme-item');
    });
    jQuery(id).attr('class', 'color-scheme-item-selected');
    jQuery(where).val(value);
}

function ihcChangeColorSchemeWd(id, value, where ){
	var non_selected = 'color-scheme-item';
	var selected = 'color-scheme-item-selected';
	var c = jQuery(id).attr('class');
    jQuery('#colors_ul li').each(function(){
        jQuery(this).attr('class', non_selected);
    });
    jQuery(where).val('');
    if (c==non_selected){
	    jQuery(id).attr('class', selected);
	    jQuery(where).val(value);
    }
}

function ihcPreviewUList(){
	jQuery('#preview').html('');
	jQuery("#preview").html('<div style="background:#fff;width: 100%;text-align:center;"><img src="'+window.ihc_url+'admin/assets/images/loading.gif" class=""/></div>');
	var meta = [];
	meta.num_of_entries = jQuery('#num_of_entries').val();
	meta.entries_per_page = jQuery('#entries_per_page').val();
	meta.order_by = jQuery('#order_by').val();
	meta.order_type = jQuery('#order_type').val();
	if (jQuery('#filter_by_level').is(":checked")){
		meta.filter_by_level = 1;
		meta.levels_in = jQuery('#levels_in').val();
	}
	meta.user_fields = jQuery('#user_fields').val();

	//console.log(meta.user_fields);

	if (jQuery('#include_fields_label').is(':checked')){
		meta.include_fields_label = 1;
	}
	meta.theme = jQuery('#theme').val();
	meta.color_scheme = jQuery('#color_scheme').val();
	meta.columns = jQuery('#columns').val();
	if (jQuery('#align_center').is(":checked")){
		meta.align_center = 1;
	}
	if (jQuery('#inside_page').is(":checked")){
		meta.inside_page = 1;
	}
	if (jQuery('#slider_set').is(":checked")){
		meta.slider_set = 1;
		meta.items_per_slide = jQuery('#items_per_slide').val();
		meta.speed = jQuery("#speed").val();
		meta.pagination_speed = jQuery('#pagination_speed').val();
		meta.pagination_theme = jQuery('#pagination_theme').val();
		meta.animation_in = jQuery('#animation_in').val();
		meta.animation_out = jQuery('#animation_out').val();
		var slider_special_metas = ['bullets', 'nav_button', 'autoplay', 'stop_hover', 'responsive', 'autoheight', 'lazy_load', 'loop'];
		for (var i=0; i<slider_special_metas.length; i++){
			if (jQuery('#'+slider_special_metas[i]).is(":checked")){
				meta[slider_special_metas[i]] = 1;
			}
		}
	}

	if (jQuery('#show_search').is(':checked')){
		meta.show_search = 1;
		meta.search_by = jQuery('#search_by').val();
	}
	if (jQuery('#show_search_filter').is(':checked') && jQuery('#search_filter').val()!=''){
		meta.show_search_filter = 1;
		meta.search_filter_items = jQuery('#search_filter').val();
	}

	meta.general_pagination_theme = jQuery('#general_pagination_theme').val();
	meta.pagination_pos = jQuery('#pagination_pos').val();

	if (jQuery('#exclude_pending').is(':checked')){
		meta.exclude_pending = 1;
	}

	///SHORTCODE
	var str = "[ihc-list-users ";
	for (var key in meta) {
		str += key + " ='" + meta[key] +"' ";
	}
	str += ']';
    jQuery('.the-shortcode').html(str);
    jQuery(".php-code").html('&lt;?php echo do_shortcode("'+str+'");?&gt;');

    //AJAX CALL
   	jQuery.ajax({
        type : 'post',
        url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
        data : {
                   action: 'ihc_preview_user_listing',
                   shortcode: str
               },
        success: function (r) {
        	jQuery('#preview').html(r);
        }
   	});
}

function ihcAdminDeleteUserLevelRelationship(l_id, u_id){
   	jQuery.ajax({
        type : 'post',
        url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
        data : {
                   action: 'ihc_delete_user_level_relationship',
                   uid: u_id,
                   lid: l_id
               },
        success: function (r){
        	jQuery('#tr_level_user_' + l_id + '_' + u_id).remove();
        }
   	});
}

function ihcFirstConfirmThenRedirect(u){
	swal({
			title: "Are You sure You want to delete this Level?",
			text: "",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "OK",
			closeOnConfirm: true
	},
	function(){
		 window.location.href = u;
	});

}

function ihcChangeUapAffiliate(i){
	var c = jQuery('#uap_checkbox_' + i);
	if (c.is(':checked')){
		/// make affiliate
		var the_action = 1;
	} else {
		///remove from affiliate
		var t = confirm('Are You sure You want to remove this User From Affiliate list?');
		if (t){
			/// do remove
			var the_action = 0;
		} else {
			c.attr('checked', 'checked');
			return false;
		}
	}

	if (typeof the_action!='undefined'){
	   	jQuery.ajax({
	        type : 'post',
	        url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
	        data : {
	                   action: 'ihc_make_user_affiliate',
	                   uid: i,
					   act: the_action
	               },
	        success: function (r){
	        	//console.log(r);
	        }
	   	});
	}
}

function ihcNotificationLevelOnlyFor(){
	var v = jQuery('#notification_type').val();
	switch (v){
		case 'admin_user_register':
		case 'register':
		case 'review_request':
		case 'before_expire':
		case 'expire':
		case 'payment':
		case 'bank_transfer':
		case 'admin_user_expire_level':
		case 'admin_before_user_expire_level':
		case 'admin_user_payment':
			/// show only for level id
			jQuery('[name=level_id]').removeAttr('disabled');
			break;
		case 'email_check':
		case 'email_check_success':
		case 'reset_password_process':
		case 'reset_password':
		case 'change_password':
		case 'approve_account':
		case 'delete_account':
			/// hide
			jQuery('[name=level_id]').val(-1);
			jQuery('[name=level_id]').attr('disabled', 'disabled');
			break;
	}
}

function ihcCheckEmailServer(){
	jQuery.ajax({
			type : 'post',
	        url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
	        data : {
	                   action: 'ihc_check_mail_server',
	               },
	        success: function (r){
	        	alert(window.ihc_messages.email_server_check);
	        }
	});
}

function ihcUpdateLevelSlugSpan(){
	var s = jQuery('#level_slug_id').val();
	jQuery('.plan-slug-name').html(s);
}


function ihcApMakeVisible(t, m){
	jQuery('.ihc-ap-tabs-list-item').removeClass('ihc-ap-tabs-selected-item');
	jQuery(m).addClass('ihc-ap-tabs-selected-item');
	jQuery('.ihc-ap-tabs-settings-item').fadeOut(200, function(){
		jQuery('#ihc_tab_item_' + t).css('display', 'block');
	});
}

function openMediaUp(target, img_target){
    //If the uploader object has already been created, reopen the dialog
  var custom_uploader;
  if (custom_uploader) {
      custom_uploader.open();
      return;
  }
  //Extend the wp.media object
  custom_uploader = wp.media.frames.file_frame = wp.media({
      title: 'Choose Image',
      button: {
          text: 'Choose Image'
      },
      multiple: false
  });
  //When a file is selected, grab the URL and set it as the text field's value
  custom_uploader.on('select', function() {
      attachment = custom_uploader.state().get('selection').first().toJSON();
      jQuery(target).val(attachment.url);
      if (img_target!=''){
      	jQuery(img_target).attr('src', attachment.url);
      	jQuery(img_target).css('display', 'block');
      }
  });
  //Open the uploader dialog
  custom_uploader.open();
}

function ihcDoBuiltInvidualPages(){
	jQuery('#ihc_loading').css('visibility', 'visible');
	jQuery.ajax({
		type : 'post',
	    url : decodeURI(window.ihc_site_url) + '/wp-admin/admin-ajax.php',
	    data : {
	            action: 'ihc_do_generate_individual_pages',
	    },
	    success: function (r){
	    	jQuery('#ihc_loading').css('visibility', 'hidden');
	    }
	});
}

function ihcAddToHiddenWhenUncheck(c, v, t){
    var i = jQuery(t).val();
    if (i!=''){
    	var a = i.split(',');
    } else {
    	var a = new Array();
    }
	if (jQuery(c).is(':checked')){
		var k = a.indexOf(v);
		if (k!=-1){
			a.splice(k, 1);
		}
	} else {
        a.push(v);
	}
	if (a.length){
		var s = a.join(',');
	} else {
		var s = '';
	}
	jQuery(t).val(s);
}

function iumpAdminPreviewInvoice(){
	var metas = jQuery('#invoice_form').serializeArray();
	jQuery.ajax({
		type : 'post',
	    url : decodeURI(window.ihc_site_url) + '/wp-admin/admin-ajax.php',
	    data : {
	            action: 'ihc_preview_invoice_via_ajax',
	            m: metas
	    },
	    success: function (r){
	    	jQuery('#preview_container').html(r);
	    }
	});
}

function ihcInsidePageChangeContentType(){
	//var v = jQuery('[name=ihc_listing_users_inside_page_type]').val();

	if (jQuery('#iump-switch_left').is(':checked')){
		jQuery('#ihc_listing_users_content_basic').css('display', 'block');
		jQuery('#ihc_listing_users_content_extra_custom').css('display', 'none');
	} else {
		jQuery('#ihc_listing_users_content_basic').css('display', 'none');
		jQuery('#ihc_listing_users_content_extra_custom').css('display', 'block');
	}
}

function ihcDoCleanUpLogs(u){
	var o = jQuery('#older_then_select').val();
	window.location.href = u + '&do_cleanup_logs=1&older_then=' + o;
}

function ihcCheckFieldLimit(limit, d){
	var val = jQuery(d).val().length;
	if (val>limit){
		jQuery(d).val('');
		alert(limit + ' is the maximum number of characters for this field!');
	}
}


jQuery(document).ready(function(){
	jQuery('#ihc_reorder_menu_items tbody').sortable({
		 update: function(e, ui) {
		        jQuery('#ihc_reorder_menu_items tbody tr').each(function (i, row) {
		        	var id = jQuery(this).attr('id');
		        	jQuery('#'+id+' .ihc_account_page_menu_order').val(i);
		        });
		 }
	});
});


function ihcDoUpdateHashField(){
	var string = jQuery('#ihc_api_hash').val();
	jQuery('.ihc-base-api-link-hash').html(string);
}


///// SHINY SELECT

function indeedShinySelect(params){
	/*
	 * params selector, item_selector, option_name_code, option_name_icon, default_icon, default_code
	 */
	this.selector = params.selector; ///got # in front of it
	this.popup_id = 'indeed_select_' + params.option_name_code;
	this.popup_visible = false;
	this.option_name_code = params.option_name_code;
	this.option_name_icon = params.option_name_icon;
	this.item_selector = params.item_selector; /// got . in front of it
	this.init_default = params.init_default;
	this.second_selector = params.second_selector;
	var current_object = this;

	jQuery(current_object.selector).after('<input type="hidden" name="' + current_object.option_name_code + '" value="' + params.default_code + '" />');
	jQuery(current_object.selector).after('<input type="hidden" name="' + current_object.option_name_icon + '" value="' + params.default_icon + '" />');
	jQuery(current_object.selector).after('<div class="indeed_select_popup" style="display: none;" id="' + current_object.popup_id + '"></div>');

	///run init
	if (this.init_default){
		jQuery(current_object.selector).html('<i class="fa-ihc-preview fa-ihc ' + params.default_icon + '"></i>');
	}


	function loadDataViaAjax(){
		var img = "<img src='" + decodeURI(window.ihc_site_url)+'/wp-content/plugins/indeed-membership-pro/admin/assets/images/loading.gif' + "' style='width: 200px'/>";
		jQuery('#'+current_object.popup_id).html(img);
		jQuery('#'+current_object.popup_id).css('display', 'block');
		jQuery.ajax({
		    type : 'post',
		    dataType: "text",
		    url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
		    data : {
		             action: 'ihc_get_font_awesome_popup'
		    },
		    success: function (r){
		       	jQuery('#'+current_object.popup_id).html(r);
		       	jQuery(current_object.item_selector).on('click', function(){
					var code = jQuery(this).attr('data-code');
					var i_class = jQuery(this).attr('data-class');
					var the_html = jQuery(this).html();

					jQuery('[name=' + current_object.option_name_code + ']').val(code);
					jQuery('[name=' + current_object.option_name_icon + ']').val(i_class);
					jQuery(current_object.selector).html(the_html);
					removePopup();
		       	});
			}
		});
	}

	jQuery(current_object.selector).on('click', function(){
		if (!current_object.popup_visible){
			current_object.popup_visible = true;
			loadDataViaAjax();
		} else {
			removePopup();
		}
	});

	jQuery(current_object.second_selector).on('click', function(){
		if (!current_object.popup_visible){
			current_object.popup_visible = true;
			loadDataViaAjax();
		} else {
			removePopup();
		}
	});

	function removePopup(){
		jQuery('#'+current_object.popup_id).empty();
		jQuery('#'+current_object.popup_id).css('display', 'none');
		current_object.popup_visible = false;
	}

}

function ihcMakeExportFile(){
	var u = jQuery('#import_users').val();
	var s = jQuery('#import_settings').val();
	var pm = jQuery('#import_postmeta').val();
	jQuery('#ihc_loading_gif .spinner').css('visibility', 'visible');
	   	jQuery.ajax({
	        type : 'post',
	        url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
	        data : {
	                   action: 'ihc_make_export_file',
	                   import_users: u,
	                   import_settings: s,
	                   import_postmeta: pm
	               },
	        success: function (response) {
	        	if (response!=0){
	        		jQuery('.ihc-hidden-download-link a').attr('href', response);
	        		jQuery('.ihc-hidden-download-link').fadeIn(200);
							jQuery('#ihc_loading_gif .spinner').css('visibility', 'hidden');
	        	}
	        }
	   });
}

function ihcAutocompleteWriteTag(value_id, hiddenId, viewDivId, prevDivPrefix, label){
	/*
	 * viewDivId - parent
	 * prevDivPrefix - prefix of tag
	 * hiddenId - where values are
	 */
	id = prevDivPrefix + value_id;
	jQuery(viewDivId).append('<div id="'+id+'" class="ihc-tag-item">'+label+'<div class="ihc-remove-tag" onclick="ihcRemoveTag(\''+value_id+'\', \'#'+id+'\', \''+hiddenId+'\');" title="Removing tag">x</div></div>');
}

function ihcRemoveTag(removeVal, removeDiv, hiddenId){
	jQuery(removeDiv).fadeOut(200, function(){
		jQuery(this).remove();
	});

    hidden_i = jQuery(hiddenId).val();
    show_arr = hidden_i.split(',');

    show_arr = removeArrayElement(removeVal, show_arr);
    str = show_arr.join(',');
	jQuery(hiddenId).val(str);
}

function removeArrayElement(elem, arr){
	for (i=0;i<arr.length;i++) {
	    if(arr[i]==elem){
	    	arr.splice(i, 1);
	    }
	}
	return arr;
}

function ihcDoDeleteWooIhcRelation(i, u){
	jQuery.ajax({
		type : 'post',
	    url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
	    data : {
	            action: 'ihc_do_delete_woo_ihc_relation',
	            id: i,
	    },
	    success: function (response) {
	    	window.location.href = u;
	    }
	});
}

function ihcChangeSearchWooType(){
	var v = jQuery('#search_woo_type').val();
	switch (v){
		case '-1':
			ihcResetAutocomplete('#product_search_input', '#ihc_reference_search_tags');
			jQuery('#woo_the_search_box').css('display', 'none');
			jQuery('#ihc_woo_all_products').css('display', 'none');
			break;
		case 'all':
			/// al prod
			if (jQuery('#product_search_input').val(-1)!=-1){
				jQuery('#product_search_input').val(-1);
				jQuery('#ihc_woo_all_products').css('display', 'block');
				jQuery('#woo_the_search_box').css('display', 'none');
			}
			break;
		case 'category':
			jQuery('#ihc_woo_all_products').css('display', 'none');
			ihcResetAutocomplete('#product_search_input', '#ihc_reference_search_tags');
			jQuery('#woo_the_search_box').css('display', 'block');
			jQuery('#the_search_label').html(window.search_cats_label);
			break;
		case 'product':
			jQuery('#ihc_woo_all_products').css('display', 'none');
			ihcResetAutocomplete('#product_search_input', '#ihc_reference_search_tags');
			jQuery('#woo_the_search_box').css('display', 'block');
			jQuery('#the_search_label').html(window.search_prod_label);
			break;
	}
}

function ihcResetAutocomplete(hidden, wrapper){
	jQuery(hidden).val('');
	jQuery(wrapper).html('');
}

function ihcRunAjaxProcess(t){
	jQuery('#ihc_ajax_run_process_spinner').css('visibility', 'visible');
	jQuery.ajax({
		type : 'post',
	    url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
	    data : {
	            action: 'ihc_run_custom_process',
	            type: t
	    },
	    success: function (response) {
			jQuery('#ihc_ajax_run_process_spinner').css('visibility', 'hidden');
	    }
	});
}

jQuery(document).ready(function(){
		jQuery('#direct_link_generate_link').on('click', function(event){
				event.preventDefault()
				jQuery.ajax({
					type : 'post',
						url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
						data : {
										action: 'ihc_generate_direct_link',
										username: jQuery('#direct_login_usernmae').val(),
										expire_time: jQuery('#direct_login_timeout').val()
						},
						success: function (response) {
								jQuery('#direct_link_value').html(response);
						}
				})
		})

		jQuery('.ihc-admin-direct-login-generator').on('click', function(event){
				jQuery.ajax({
					type : 'post',
						url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
						data : {
										action: 'ihc_generate_direct_link_by_uid',
										uid: jQuery(event.target).attr('data-uid'),
						},
						success: function (response) {
								swal({
									title: "Success",
									text: response,
									type: "success",
									showCancelButton: false,
									confirmButtonText: "OK",
									closeOnConfirm: true
								})
						}
				})
		})

		jQuery('.ihc-direct-login-remove-item').on('click', function(event){
				swal({
					title: "Are you sure that you want to delete this link?",
					text: "",
					type: "warning",
					showCancelButton: true,
					confirmButtonClass: "btn-danger",
					confirmButtonText: "OK",
					closeOnConfirm: true
				},
				function(){
					jQuery.ajax({
							type : 'post',
							url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
							data : {
												 action: 'ihc_direct_login_delete_item',
												 uid: jQuery(event.target).attr('data-uid'),
										 },
							success: function (response) {
									location.reload();
							}
				 });
			 });
		});
});

jQuery( document ).ready(function(){
		jQuery( '.deactivate' ).on( 'click', function(evt){
				if ( jQuery( evt.target ).attr('href').indexOf( 'indeed-membership-pro' ) > -1 ){
						if ( window.ihcKeepData == 1 ){
								var theMessage = 'Plugin data will be kept in database after you delete the plugin.';
						} else {
								var theMessage = 'Plugin data will be lost after you delete the plugin.';
						}
						var target = jQuery( evt.target ).attr('href');
						swal({
							title: theMessage,
							text: "Go to WP Admin dashboard, select Membership Pro Ultimate WP, click on General Options followed by Admin Workflow in the submenu. Toggle the Keep data after delete plugin: to 'On'.",
							type: "warning",
							showCancelButton: true,
							confirmButtonClass: "btn-danger",
							confirmButtonText: "OK",
							closeOnConfirm: true
						},	function(){
								window.location.href = target;
						});
						return false;
				}
		});

		jQuery( '.ihc-js-close-admin-dashboard-notice' ).on( 'click', function(){
				var parent = jQuery(this).parent();
				parent.fadeOut( 1000 );
				jQuery.ajax({
						type : 'post',
						url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
						data : {
											 action: 'ihc_close_admin_notice'
									 },
						success: function (response) {
								parent.remove();
						}
			 });
		});

});


jQuery(document).ready(function(){
	jQuery('.ihc-admin-mobile-bttn').on('click', function(){
		jQuery('.ihc-dashboard-menu-items').toggle();
	});
});

jQuery(document).ready( function() {
    var nonce = jQuery('meta[name="ump-admin-token"]').attr('content');
    jQuery.ajaxSetup( { headers: {'X-CSRF-UMP-ADMIN-TOKEN': nonce }});
});
