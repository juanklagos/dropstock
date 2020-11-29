<div id="posttype-ihc-items" class="posttypediv">
  <div id="tabs-panel-ihc-items" class="tabs-panel tabs-panel-active">
    <ul id="ihc-items-checklist" class="categorychecklist form-no-clear">
      <?php
      $siteUrl = get_option( 'siteurl' );
      $items = array(
                      'login'         => __( 'Login', 'ihc' ),
                      'register'      => __( 'Register', 'ihc' )
      );
      $i = 0;
      ?>
      <?php foreach ( $items as $key => $value ) :?>
        <?php $i--;?>
        <li>
          <label class="menu-item-title">
            <input type="checkbox" class="menu-item-checkbox" name="menu-item[<?php echo $i;?>][menu-item-object-id]" value="<?php echo $i;?>" /> <?php echo $value;?>
          </label>
          <input type="hidden" class="menu-item-type" name="menu-item[<?php echo $i;?>][menu-item-type]" value="custom" />
          <input type="hidden" class="menu-item-title" name="menu-item[<?php echo $i;?>][menu-item-title]" value="<?php echo $value;?>" />
          <input type="hidden" class="menu-item-url" name="menu-item[<?php echo $i;?>][menu-item-url]" value="<?php echo $siteUrl . '?ihc-modal=' . $key; ?>" />
        </li>
      <?php endforeach;?>
    </ul>
  </div>
  <p class="button-controls">
    <span class="add-to-menu">
      <button type="submit" class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e( 'Add to menu', 'ihc' ); ?>" name="add-post-type-menu-item" id="submit-posttype-ihc-items"><?php esc_html_e( 'Add to menu', 'ihc' ); ?></button>
      <span class="spinner"></span>
    </span>
  </p>
</div>
