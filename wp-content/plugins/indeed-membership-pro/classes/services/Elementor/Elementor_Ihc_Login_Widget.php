<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Elementor_Ihc_Login_Widget extends \Elementor\Widget_Base
{

  public function get_name()
  {
      return 'ump-login-page-shortcode';
  }

  public function get_title()
  {
      return __( 'UMP - Login Page', 'ihc' );
  }

  public function get_icon()
  {
      return 'fa fa-code';
  }

  protected function render()
  {
      echo '[ihc-login-form]';
  }

}
