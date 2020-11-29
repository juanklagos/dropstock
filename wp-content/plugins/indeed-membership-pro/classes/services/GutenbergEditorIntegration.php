<?php
namespace Indeed\Ihc\Services;

class GutenbergEditorIntegration
{
    public function __construct()
    {
        if ( !is_admin() ){
            return;
        }
        if ( !function_exists( 'register_block_type' ) ) {
            return;
        }
        add_filter( 'block_categories', array( $this, 'registerCategory'), 10, 2 ); //
        add_action( 'in_admin_footer', array($this, 'assets') );
    }

    public function registerCategory( $categories=[], $post=null )
    {
        $categories[] = array(
                              'slug' => 'ihc-shortcodes',
                              'title' => __( 'Ultimate Membership Pro - Shortcodes', 'ihc' ),
                              'icon'  => '',
        );
        $categories[] = array(
                              'slug' => 'ihc-locker',
                              'title' => __( 'Ultimate Membership Pro - Locker', 'ihc' ),
                              'icon'  => '',
        );
        return $categories;
    }

    public function assets()
    {
        global $current_screen;
        if (!isset($current_screen)) {
            $current_screen = get_current_screen();
        }
        if ( !method_exists($current_screen, 'is_block_editor') || !$current_screen->is_block_editor() ) {
            return;
        }
        wp_register_script( 'ihc-gutenberg-locker-integration', IHC_URL . 'assets/js/gutenberg_locker_integration.js', array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'), null );
        wp_localize_script( 'ihc-gutenberg-locker-integration', 'ihc_locker_options', $this->lockerOptions() );
        wp_enqueue_script( 'ihc-gutenberg-integration', IHC_URL . 'assets/js/gutenberg_integration.js', array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'), null );
        wp_enqueue_script( 'ihc-gutenberg-locker-integration' );
    }

    public function lockerOptions()
    {
        $targetValues = array(
              array(
                'value'     => 'all',
                'label'     => __( 'All', 'ihc' ),
              ),
              array(
                'value'     => 'reg',
                'label'     => __( 'Registered Users', 'ihc' ),
              ),
              array(
                'value'     => 'unreg',
                'label'     => __( 'Unregistered Users', 'ihc' ),
              ),
        );
        $levels = get_option('ihc_levels');
        if ( $levels ){
            foreach ( $levels as $id => $level ){
                $targetValues[] = array(
                        'value'       => $id,
                        'label'       => $level['name'],
                );
            }
        }
        $templates = array();
        $lockers = ihc_return_meta('ihc_lockers');
        if ( $lockers ){
            $templates[] = array(
                    'value'       => '',
                    'label'       => '...',
            );
            foreach ( $lockers as $k => $v ){
                $templates[] = array(
                        'value'       => $k,
                        'label'       => $v['ihc_locker_name'],
                );
            }
        }
        return json_encode([
            'templates'         => $templates,
            'lockerTarget'      => $targetValues,
            'lockerType'        => array(
                                array(
                                    'value'     => 'show',
                                    'label'     => __( 'Show', 'ihc' ),
                                ),
                                array(
                                    'value'     => 'block',
                                    'label'     => __( 'Block', 'ihc' )
                                ),
            ),
        ]);
    }

}
