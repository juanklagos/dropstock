<form action="<?php echo admin_url('admin.php?page=ihc_manage&tab=orders');?>" method="post">

	<input type="hidden" name="ihc_admin_add_new_order_nonce" value="<?php echo wp_create_nonce( 'ihc_admin_add_new_order_nonce' );?>" />

	<div class="ihc-stuffbox">
		<h3><?php _e('Add New Order', 'ihc');?></h3>
		<div class="inside">

      <div class="row" style="margin-left:0px;">
      		<div class="col-xs-5">
      		    <div class="input-group" style="margin:30px 0 5px 0;">
          				<span class="input-group-addon ihc-special-input-label" id="basic-addon1" style="min-width:170px; text-align:right;"><?php _e('Username:', 'ihc');?></span>
                  <input type="text" name="username"/>
      				</div>
      		</div>
      </div>

      <div class="row" style="margin-left:0px;">
      		<div class="col-xs-5">
      		    <div class="input-group" style="margin:30px 0 5px 0;">
          				<span class="input-group-addon ihc-special-input-label" id="basic-addon1" style="min-width:170px; text-align:right;"><?php _e('Level:', 'ihc');?></span>
                  <select name="lid">
                    <?php
                      $levels = get_option('ihc_levels');
                      foreach ($levels as $k=>$v){
                        ?>
                        <option value="<?php echo $k?>" >
                          <?php echo $v['label'];?>
                        </option>
                        <?php
                      }
                    ?>
                  </select>
      				</div>
      		</div>
      </div>

            <div class="row" style="margin-left:0px;">
            		<div class="col-xs-5">
            		    <div class="input-group" style="margin:30px 0 5px 0;">
                				<span class="input-group-addon ihc-special-input-label" id="basic-addon1" style="min-width:170px; text-align:right;"><?php _e('Amount:', 'ihc');?></span>
                        <input type="number" min=0 name="amount_value" step="0.01" />
            				</div>
            		</div>
            </div>

            <div class="row" style="margin-left:0px;">
      				<div class="col-xs-5">
      					<div class="input-group" style="margin:30px 0 5px 0;">
          					<span class="input-group-addon ihc-special-input-label" id="basic-addon1" style="min-width:170px; text-align:right;"><?php _e('Currency:', 'ihc');?></span>
                    <select name="amount_type">
                      <?php
        								$currency_arr = ihc_get_currencies_list('all');
        								$custom_currencies = ihc_get_currencies_list('custom');
                        $ihc_currency = get_option('ihc_currency');
        								foreach ($currency_arr as $k=>$v){
        									?>
        									<option value="<?php echo $k?>" <?php if ($k==$ihc_currency) echo 'selected';?> >
        										<?php echo $v;?>
        										<?php if (is_array($custom_currencies) && in_array($v, $custom_currencies))  _e(" (Custom Currency)");?>
        									</option>
        									<?php
        								}
        							?>
                    </select>
      					</div>
      				</div>
      			</div>

            <div class="row" style="margin-left:0px;">
      				<div class="col-xs-5">
      					<div class="input-group" style="margin:30px 0 5px 0;">
          					<span class="input-group-addon ihc-special-input-label" id="basic-addon1" style="min-width:170px; text-align:right;"><?php _e('Created Date:', 'ihc');?></span>
                    <input type="text" id="created_date_ihc" name="create_date" />
      					</div>
      				</div>
      			</div>

			<div class="row" style="margin-left:0px;">
				<div class="col-xs-5">
					<div class="input-group" style="margin:30px 0 5px 0;">
					<span class="input-group-addon ihc-special-input-label" id="basic-addon1" style="min-width:170px; text-align:right;"><?php _e('Payment Service:', 'ihc');?></span>
          <select name="ihc_payment_type">
            <?php
  						$payments = ihc_get_active_payment_services();
  						if ($payments):
  							foreach ($payments as $k=>$v):
  								$selected = ($k=='bank_transfer') ? 'selected' : '';
  								?>
  								<option value="<?php echo $k;?>" <?php echo $selected;?> ><?php echo $v;?></option>
  								<?php
  							endforeach;
  						endif;
  					?>
          </select>
					</div>
				</div>
			</div>

			<div style="margin-top: 15px;" class="ihc-wrapp-submit-bttn">
				<input type="submit" value="<?php _e('Add Order', 'ihc');?>" name="save_order" class="button button-primary button-large" />
			</div>
		</div>

	</div>
</form>
<script>
  jQuery(document).ready(function() {
      jQuery('#created_date_ihc').datepicker({
          dateFormat : 'yy-mm-dd',
          onSelect: function(datetext){
              var d = new Date();
              datetext = datetext+" "+d.getHours()+":"+ihcAddZero(d.getMinutes())+":"+ihcAddZero(d.getSeconds());
              jQuery(this).val(datetext);
          }
      });
  });
</script>
