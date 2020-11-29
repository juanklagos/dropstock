<div class="iump-form-line">
<h4> <?php  _e('WordPress Role', 'ihc'); ?> </h4>
<p><?php  _e('If is necessary choose a specific wp role for current member', 'ihc'); ?> </p>
    <?php
          echo indeed_create_form_element(
                        array(
                            'type' => 'select',
                            'name' => 'role',
                            'value' => $role,
                            'multiple_values' => ihc_get_wp_roles_list(),
                            'class' => 'ihc-form-element ihc-form-element-select ihc-form-select '
                        )
          );
    ?>
</div>
