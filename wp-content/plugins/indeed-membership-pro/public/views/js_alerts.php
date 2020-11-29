<?php
wp_enqueue_style( 'indeed_sweetalert_css', IHC_URL . 'assets/css/sweetalert.css' );
wp_enqueue_script( 'indeed_sweetalert_js', IHC_URL . 'assets/js/sweetalert.js' );
?>
<script>
jQuery( document ).ready( function(){

  <?php if ( !empty( $error ) ):?>
    document.cookie = 'ihc_error=; path=/; Max-Age=-999;';
    swal({
      title: "<?php _e('Error', 'ihc');?>",
      text: "<?php echo $error;?>",
      type: "error",
      showCancelButton: false,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "OK",
      closeOnConfirm: true
    });
  <?php endif;?>

  <?php if ( !empty( $warning ) ):?>
    document.cookie = 'ihc_warning=; path=/; Max-Age=-999;';
    swal({
      title: "<?php _e('Warning', 'ihc');?>",
      text: "<?php echo $warning;?>",
      type: "warning",
      showCancelButton: false,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "OK",
      closeOnConfirm: true
    });
  <?php endif;?>

  <?php if ( !empty( $info ) ):?>
    document.cookie = 'ihc_info=; path=/; Max-Age=-999;';
    swal({
      title: "<?php _e('Info', 'ihc');?>",
      text: "<?php echo $info;?>",
      type: "info",
      showCancelButton: false,
      confirmButtonClass: "btn-info",
      confirmButtonText: "OK",
      closeOnConfirm: true
    });
  <?php endif;?>

});

</script>
