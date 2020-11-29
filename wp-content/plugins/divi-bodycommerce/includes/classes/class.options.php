<?php
if ( ! defined( 'ABSPATH' ) ) exit;

    class DE_DB_WOO_options_interface
        {

            var $licence;

            function __construct()
                {

                    $this->licence          =   new DE_DB_WOO_licence();

                    if (isset($_GET['page']) && ($_GET['page'] == 'woo-ms-options'  ||  $_GET['page'] == 'divi-bodyshop-woo-settings'))
                        {
                          $this->options_update();
                          $this->admin_notices();
                        }

                    if(!$this->licence->licence_key_verify())
                        {
                            add_action('admin_notices', array($this, 'admin_no_key_notices'));
                            add_action('network_admin_notices', array($this, 'admin_no_key_notices'));
                        }
                }

            function __destruct()
                {

                }

            function network_admin_menu()
                {
                    if(!$this->licence->licence_key_verify()) {
                        return $this->licence_form_bodycommerce();
                    } else {
                        return $this->licence_deactivate_form();
                    }
                    add_action('load-' . $hookID , array($this, 'load_dependencies'));
                    add_action('load-' . $hookID , array($this, 'admin_notices'));

                    add_action('admin_print_styles-' . $hookID , array($this, 'admin_print_styles'));
                    add_action('admin_print_scripts-' . $hookID , array($this, 'admin_print_scripts'));
                }

            function admin_menu() {
        if (!$this->licence->licence_key_verify()) {
            return $this->licence_form_bodycommerce();
        } else {
            return $this->licence_deactivate_form();
        }
        add_action('admin_print_styles-' . $hookID, array($this, 'admin_print_styles'));
        add_action('admin_print_scripts-' . $hookID, array($this, 'admin_print_scripts'));
    }


            function options_interface()
                {

                    if(!$this->licence->licence_key_verify() && !is_multisite())
                        {
                            $this->licence_form_bodycommerce();
                            return;
                        }

                    if(!$this->licence->licence_key_verify() && is_multisite())
                        {
                            $this->licence_multisite_require_nottice();
                            return;
                        }
                }

            function options_update()
                {

                    if (isset($_POST['slt_licence_form_submit']))
                        {
                            $this->licence_form_submit();
                            return;
                        }

                }

            function load_dependencies()
                {




                }

            function admin_notices()
                {
                    global $slt_form_submit_messages;

                    if($slt_form_submit_messages == '')
                        return;

                    $messages = $slt_form_submit_messages;


                    if(count($messages) > 0)
                        {
                            echo "<div id='notice' class='updated error'><p>". implode("</p><p>", $messages )  ."</p></div>";
                        }

                }

            function admin_print_styles()
                {

                }

            function admin_print_scripts()
                {

                }


            function admin_no_key_notices()
                {
                    if ( !current_user_can('manage_options'))
                        return;

                    $screen = get_current_screen();

                    if( ! is_network_admin()   )
                        {
                            if(isset($screen->id) && $screen->id == 'divi-bodyshop-woo-settings')
                                return;

                            ?><div class="updated error"><p><?php _e( "Divi BodyCommerce is inactive, please enter your", 'divi-bodyshop-woocommerce' ) ?> <a href="admin.php?page=divi-bodyshop-woo-settings&<?php _e( "tab=license", 'divi-bodyshop-woocommerce' ) ?>"><?php _e( "License Key", 'divi-bodyshop-woocommerce' ) ?></a> to get updates</p></div><?php
                        }

                }

            function licence_form_submit()
                {
                    global $slt_form_submit_messages;

                    //check for de-activation
                    if (isset($_POST['slt_licence_form_submit']) && isset($_POST['slt_licence_deactivate']) && wp_verify_nonce($_POST['divi_bodycommerce_license_nonce'],'divi_bodycommerce_license'))
                        {
                            global $slt_form_submit_messages;

                            $license_data = DE_DB_WOO_LICENCE::get_licence_data();
                            $license_key = $license_data['key'];

                            //build the request query
                            $args = array(
                                                'woo_sl_action'         => 'deactivate',
                                                'licence_key'           => $license_key,
                                                'product_unique_id'     => DE_DB_WOO_PRODUCT_ID,
                                                'domain'                => DE_DB_WOO_INSTANCE
                                            );
                            $request_uri    = DE_DB_WOO_APP_API_URL . '?' . http_build_query( $args , '', '&');
                            $data           = wp_remote_get( $request_uri );

                            //log if debug
                            If (defined('WP_DEBUG') &&  WP_DEBUG    === TRUE)
                                {
                                    DE_DB_WOO::log_data("------\nArguments:");
                                    DE_DB_WOO::log_data($args);

                                    DE_DB_WOO::log_data("\nResponse Body:");
                                    DE_DB_WOO::log_data($data['body']);
                                    DE_DB_WOO::log_data("\nResponse Server Response:");
                                    DE_DB_WOO::log_data($data['response']);
                                }

                            if(is_wp_error( $data ) || $data['response']['code'] != 200)
                                {
                                    $slt_form_submit_messages[] .= __('There was a problem connecting to ', 'divi-bodyshop-woocommerce') . DE_DB_WOO_APP_API_URL;
                                    return;
                                }

                            $response_block = json_decode($data['body']);
                            //retrieve the last message within the $response_block
                            $response_block = $response_block[count($response_block) - 1];
                            $response = $response_block->message;

                            if(isset($response_block->status))
                                {
                                    if($response_block->status == 'success' && $response_block->status_code == 's201')
                                        {
                                            //the license is active and the software is active
                                            $slt_form_submit_messages[] = $response_block->message;

                                            $license_data = DE_DB_WOO_LICENCE::get_licence_data();

                                            //save the license
                                            $license_data['key']          = '';
                                            $license_data['last_check']   = time();

                                            DE_DB_WOO_LICENCE::update_licence_data ( $license_data );
                                        }

                                    else //if message code is e104  force de-activation
                                            if ($response_block->status_code == 'e002' || $response_block->status_code == 'e104')
                                                {
                                                    $license_data = DE_DB_WOO_LICENCE::get_licence_data();

                                                    //save the license
                                                    $license_data['key']          = '';
                                                    $license_data['last_check']   = time();

                                                    DE_DB_WOO_LICENCE::update_licence_data ( $license_data );
                                                }
                                        else
                                        {
                                            $slt_form_submit_messages[] = __('There was a problem deactivating the licence: ', 'divi-bodyshop-woocommerce') . $response_block->message;

                                            return;
                                        }
                                }
                                else
                                {
                                    $slt_form_submit_messages[] = __('There was a problem with the data block received from ' . DE_DB_WOO_APP_API_URL, 'divi-bodyshop-woocommerce');
                                    return;
                                }

                            //redirect
                            $current_url    =   'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                            wp_redirect($current_url);
                            die();

                        }



                    if (isset($_POST['slt_licence_form_submit']) && wp_verify_nonce($_POST['divi_bodycommerce_license_nonce'],'divi_bodycommerce_license'))
                        {

                            $license_key = isset($_POST['license_key'])? sanitize_key(trim($_POST['license_key'])) : '';

                            if($license_key == '')
                                {
                                    $slt_form_submit_messages[] = __("License Key can't be empty", 'divi-bodyshop-woocommerce');
                                    return;
                                }

                            //build the request query
                            $args = array(
                                                'woo_sl_action'         => 'activate',
                                                'licence_key'       => $license_key,
                                                'product_unique_id'        => DE_DB_WOO_PRODUCT_ID,
                                                'domain'          => DE_DB_WOO_INSTANCE
                                            );
                            $request_uri    = DE_DB_WOO_APP_API_URL . '?' . http_build_query( $args , '', '&');
                            $data           = wp_remote_get( $request_uri );

                            //log if debug
                            If (defined('WP_DEBUG') &&  WP_DEBUG    === TRUE)
                                {
                                    DE_DB_WOO::log_data("------\nArguments:");
                                    DE_DB_WOO::log_data($args);

                                    DE_DB_WOO::log_data("\nResponse Body:");
                                    DE_DB_WOO::log_data($data['body']);
                                    DE_DB_WOO::log_data("\nResponse Server Response:");
                                    DE_DB_WOO::log_data($data['response']);
                                }

                            if(is_wp_error( $data ) || $data['response']['code'] != 200)
                                {
                                    $slt_form_submit_messages[] .= __('There was a problem connecting to ', 'divi-bodyshop-woocommerce') . DE_DB_WOO_APP_API_URL;
                                    return;
                                }

                            $response_block = json_decode($data['body']);
                            //retrieve the last message within the $response_block
                            $response_block = $response_block[count($response_block) - 1];
                            $response = $response_block->message;

                            if(isset($response_block->status))
                                {
                                    if($response_block->status == 'success' && $response_block->status_code == 's100')
                                        {
                                            //the license is active and the software is active
                                            $slt_form_submit_messages[] = $response_block->message;

                                            $license_data = DE_DB_WOO_LICENCE::get_licence_data();

                                            //save the license
                                            $license_data['key']          = $license_key;
                                            $license_data['last_check']   = time();

                                            DE_DB_WOO_LICENCE::update_licence_data ( $license_data );

                                        }
                                        else
                                        {
                                            $slt_form_submit_messages[] = __('There was a problem activating the licence: ', 'divi-bodyshop-woocommerce') . $response_block->message;
                                            return;
                                        }
                                }
                                else
                                {
                                    $slt_form_submit_messages[] = __('There was a problem with the data block received from ' . DE_DB_WOO_APP_API_URL, 'divi-bodyshop-woocommerce');
                                    return;
                                }

                            //redirect
                            $current_url    =   'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                            wp_redirect($current_url);
                            die();
                        }

                }

            function licence_form_bodycommerce()
                {
                ob_start();
                ?>
                  <div class="wrap">
                          <form id="form_data" name="form" method="post">
                                <div class="postbox"><?php wp_nonce_field('divi_bodycommerce_license', 'divi_bodycommerce_license_nonce') ?>
                                        <input type="hidden" name="slt_licence_form_submit" value="true" />

                                         <div class="section section-text ">
                                            <h4 class="heading"><?php  echo esc_html__("License Key", 'divi-bodyshop-woocommerce' ) ?></h4>
                                            <div class="option">
                                                <div class="controls">
                                                    <input type="text" value="" name="license_key" class="text-input">
                                                </div>
                                                <div class="explain"><?php echo esc_html__("Enter the License Key you got when bought this product. If you lost the key, you can always retrieve it from ", 'divi-bodyshop-woocommerce'  ) ?> '<a href="https://diviengine.com/my-account/" target="_blank"><?php echo esc_html__("My Account", 'divi-bodyshop-woocommerce'  ) ?> </a><br />
                                              <?php echo esc_html__("More keys can be generate from ", 'divi-bodyshop-woocommerce' ) ?> <a href="https://diviengine.com/my-account/" target="_blank"><?php echo esc_html__("My Account", 'divi-bodyshop-woocommerce'  ) ?></a>
                                                </div>
                                            </div>
                                        </div>


                                </div>

                                <p class="submit">
                                    <input type="submit" name="Submit" class="button button-primary" value="<?php echo esc_html__('Save', 'divi-bodyshop-woocommerce'  ) ?>">
                                </p>
                            </form>
                        </div>
                        <?php
                        return ob_get_clean();

                }

            function licence_deactivate_form()
                {
                    $license_data = DE_DB_WOO_LICENCE::get_licence_data();

                        ob_start();
                    if(is_multisite())
                        {
                          ?>
                            <div class="wrap">
                            <div id="icon-settings" class="icon32"></div>
                            <h2><?php echo esc_html__("General Settings", 'divi-bodyshop-woocommerce') ?></h2>
                            <?php
                        }
                          ?>
                            <div id="form_data">
                                    <h2 class="subtitle"><?php echo esc_html__("Divi BodyCommerce Software License", 'divi-bodyshop-woocommerce')?></h2>
                                    <div class="postbox">
                                        <form id="form_data" name="form" method="post"><?php wp_nonce_field('divi_bodycommerce_license', 'divi_bodycommerce_license_nonce') ?>
                                            <input type="hidden" name="slt_licence_form_submit" value="true" />
                                            <input type="hidden" name="slt_licence_deactivate" value="true" />

                                            <div class="section section-text ">
                                                <h4 class="heading"><?php echo esc_html__("License Key", 'divi-bodyshop-woocommerce')?></h4>
                                                <div class="option">
                                                    <div class="controls">
                                                      <?php
                                                        if ($this->licence->is_local_instance()) {
                                                          ?>
                                                            <p>Local instance, no key applied.</p>
                                                            <?php
                                                        } else {
                                                          ?>
                                                             <p><b><?php echo substr($license_data['key'], 0, 20)?>-xxxxxxxx-xxxxxxxx</b> &nbsp;&nbsp;&nbsp;<a class="button-secondary" title="Deactivate" href="javascript: void(0)" onclick="jQuery(this).closest('form').submit();">Deactivate</a></p>
                                                             <?php
                                                        }
                                                        ?>
                                                     </div>
                                                    <div class="explain"><?php echo esc_html__("You can generate more keys from ", 'divi-bodyshop-woocommerce') ?><a href="https://diviengine.com/my-account/" target="_blank">My Account</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <?php


                    if(is_multisite())
                        {
                          ?>
            </div>
            <?php
                        }

                        return ob_get_clean();
                }

            function licence_multisite_require_nottice()
                {
                    ?>
                        <div class="wrap">
                            <div id="icon-settings" class="icon32"></div>
                            <h2><?php _e( "General Settings", 'divi-bodyshop-woocommerce' ) ?></h2>

                            <h2 class="subtitle"><?php _e( "Divi BodyCommerce Software License", 'divi-bodyshop-woocommerce' ) ?></h2>
                            <div id="form_data">
                                <div class="postbox">
                                    <div class="section section-text ">
                                        <h4 class="heading"><?php _e( "License Key Required", 'divi-bodyshop-woocommerce' ) ?>!</h4>
                                        <div class="option">
                                            <div class="explain"><?php _e( "Enter the License Key you got when bought this product. If you lost the key, you can always retrieve it from", 'divi-bodyshop-woocommerce' ) ?> <a href="http://diviengine.com/my-account/" target="_blank"><?php _e( "My Account", 'divi-bodyshop-woocommerce' ) ?></a><br />
                                            <?php _e( "More keys can be generate from", 'divi-bodyshop-woocommerce' ) ?> <a href="http://diviengine.com/my-account/" target="_blank"><?php _e( "My Account", 'divi-bodyshop-woocommerce' ) ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php

                }


        }



?>
