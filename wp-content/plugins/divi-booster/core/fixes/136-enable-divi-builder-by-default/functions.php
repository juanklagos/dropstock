<?php 
if (!defined('ABSPATH')) { exit(); } // No direct access

if (!class_exists('DBDBOption136_EnableBuilderByDefault')) {
	
	class DBDBOption136_EnableBuilderByDefault {
		
		function init() {
			add_action('load-post-new.php', array($this, 'enableDiviBuilderByDefault')); 
		}

		public function enableDiviBuilderByDefault() {
			$this->enableVisualBuilderByDefault();
			$this->enableClassicBuilderByDefault();
		}

		protected function enableVisualBuilderByDefault() {
			add_action('wp_insert_post', array($this, 'convertToVisualBuilderPost'), 10, 2);
		}
		
		public function convertToVisualBuilderPost($post_id, $post) {
			remove_action('wp_insert_post', array($this, 'convertToVisualBuilderPost'), 10, 2); 
			if (isset($post->post_type) && in_array($post->post_type, $this->et_builder_get_enabled_builder_post_types())) {
				$this->setPostStatusToDraft($post_id);
				$this->enableDiviBuilder($post_id);
				$this->redirectToVisualBuilder($post_id);
			}
		}
		
		protected function et_builder_get_enabled_builder_post_types() {
			if (!function_exists('et_builder_get_enabled_builder_post_types')) { 
				return array(); 
			}
			return et_builder_get_enabled_builder_post_types();
		}
		
		protected function setPostStatusToDraft($post_id) {
			wp_update_post(array('ID'=>$post_id, 'post_status'=>'draft'));
		}
		
		protected function enableDiviBuilder($post_id) {
			update_post_meta($post_id, '_et_pb_use_builder', 'on');
		}
		
		protected function redirectToVisualBuilder($post_id) {
			$builderUrl = $this->et_fb_get_builder_url(get_the_permalink($post_id), 'vb');
			if (wp_redirect($builderUrl)) {
				exit;
			}
		}

		protected function enableClassicBuilderByDefault() {
			if ($this->bfbEnabled()) { 
				return; 
			}
			add_filter('et_builder_always_enabled', '__return_true');
		}
		
		protected function et_fb_get_builder_url($url, $builder) {
			if (!function_exists('et_fb_get_builder_url')) { 
				return false; 
			}
			return et_fb_get_builder_url($url, $builder);
		}
		
		protected function bfbEnabled() {
			return (function_exists('et_builder_bfb_enabled') && et_builder_bfb_enabled());
		}
	}
	
	(new DBDBOption136_EnableBuilderByDefault)->init();
}
