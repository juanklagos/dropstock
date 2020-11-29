<?php
add_action('wp_enqueue_scripts', 'dbdb_icons_socicon_register_css');
add_filter('dbdb_icons_socicon_data', 'dbdb_icons_socicon_correct_slugs');
add_filter('dbdb_icons_socicon_data', 'dbdb_icons_socicon_correct_names');
add_filter('dbdb_icons_socicon_data', 'dbdb_icons_socicon_remove_defunct_networks');
add_filter('dbdb_icons_socicon_data', 'dbdb_icons_socicon_sort_networks_by_name');

if (!function_exists('dbdb_icons_socicon_inline_css')) {
	function dbdb_icons_socicon_inline_css() {
		$font_dir = plugin_dir_url(__FILE__).'socicon/fonts/';
		?>
<link rel="preload" href="<?php esc_attr_e($font_dir); ?>Socicon.woff2?87visu" as="font" crossorigin>
<style>
@font-face {
  font-family: 'Socicon';
  src:  url('<?php esc_attr_e($font_dir); ?>Socicon.eot?87visu');
  src:  url('<?php esc_attr_e($font_dir); ?>Socicon.eot?87visu#iefix') format('embedded-opentype'),
	url('<?php esc_attr_e($font_dir); ?>Socicon.woff2?87visu') format('woff2'),
	url('<?php esc_attr_e($font_dir); ?>Socicon.ttf?87visu') format('truetype'),
	url('<?php esc_attr_e($font_dir); ?>Socicon.woff?87visu') format('woff'),
	url('<?php esc_attr_e($font_dir); ?>Socicon.svg?87visu#Socicon') format('svg');
  font-weight: normal;
  font-style: normal;
  font-display: block;
}
</style>
		<?php
	}
}

if (!function_exists('dbdb_icons_socicon_register_css')) {
	function dbdb_icons_socicon_register_css() { 
		wp_register_style('dbdb-icons-socicon', plugin_dir_url(__FILE__).'socicon/style.css', array(), BOOSTER_VERSION);
	}
}

if (!function_exists('dbdb_icons_socicon_network_names')) {
	function dbdb_icons_socicon_network_names() {
		$networks = dbdb_icons_socicon_data();
		return is_array($networks)?wp_list_pluck($networks, 'name'):array();
	}
}

if (!function_exists('dbdb_icons_socicon_data')) {
	function dbdb_icons_socicon_data() {
		$networks = include(dirname(__FILE__).'/socicon-data.php');
		$networks = is_array($networks)?$networks:array();
		return apply_filters('dbdb_icons_socicon_data', $networks);
	}
}

if (!function_exists('dbdb_icons_socicon_correct_slugs')) {
	function dbdb_icons_socicon_correct_slugs($networks) {
		$replacements = array(
			'hitbox' => 'smashcast'  // Rebranded
		);
		foreach($replacements as $old_id=>$new_id) {
			$networks[$new_id] = $networks[$old_id];
			unset($networks[$old_id]);
		}
		return $networks;
	}
}

if (!function_exists('dbdb_icons_socicon_correct_names')) {
	function dbdb_icons_socicon_correct_names($networks) {
		$replacements = array(
			'amplement' => 'Amplement',
			'appstore' => 'App Store',
			'augment' => 'Augment',
			'baidu' => 'Baidu',
			'bandcamp' => 'Bandcamp',
			'battlenet' => 'Battle.net',
			'beatport' => 'Beatport',
			'bebo' => 'Bebo',
			'bloglovin' => "Bloglovin'",
			'coderwall' => 'Coderwall',
			'crunchbase' => 'Crunchbase',
			'debian' => 'Debian',
			'deezer' => 'Deezer',
			'deviantart' => 'DeviantArt',
			'disqus' => 'Disqus',
			'douban' => 'Douban',
			'draugiem' => 'Draugiem.lv',
			'dribbble' => 'Dribbble',
			'ebay' => 'eBay',
			'elementaryos' => 'Elementary OS',
			'endomondo' => 'Endomondo',
			'filmweb' => 'Filmweb',
			'flickr' => 'Flickr',
			'formulr' => 'Formulr',
			'foursquare' => 'Foursquare',
			'fyuse' => 'Fyuse',
			'ghost' => 'Ghost',
			'gitter' => 'Gitter',
			'goodreads' => 'Goodreads',
			'hackerone' => 'HackerOne',
			'heroes' => 'Heroes of the Storm',
			'smashcast' => 'Smashcast',
			'icq' => 'ICQ',
			'indiedb' => 'Indie DB',
			'instructables' => 'Instructables',
			'issuu' => 'Issuu',
			'jamendo' => 'Jamendo',
			'lastfm' => 'Last.fm',
			'livemaster' => 'Livemaster',
			'loomly' => 'Loomly',
			'lyft' => 'Lyft',
			'mix' => 'Mix',
			'mobcrush' => 'Mobcrush',
			'mumble' => 'Mumble',
			'napster' => 'Napster',
			'naver' => 'Naver',
			'niconico' => 'Niconico',
			'pixiv' => 'Pixiv',
			'redbubble' => 'Redbubble',
			'reddit' => 'Reddit',
			'remote' => 'Remote',
			'renren' => 'Renren',
			'reverbnation' => 'ReverbNation',
			'skype' => 'Skype',
			'society6' => 'Society6',
			'songkick' => 'Songkick',
			'soundcloud' => 'SoundCloud',
			'spreadshirt' => 'Spreadshirt',
			'stackoverflow' => 'Stack Overflow',
			'stackexchange' => 'Stack Exchange',
			'stage32' => 'Stage 32',
			'steam' => 'Steam',
			'strava' => 'Strava',
			'tripadvisor' => 'TripAdvisor',
			'tumblr' => 'Tumblr',
			'tunein' => 'TuneIn',
			'uber' => 'Uber',
			'udemy' => 'Udemy',
			'viewbug' => 'ViewBug',
			'vimeo' => 'Vimeo',
			'wykop' => 'Wykop',
			'xbox' => 'Xbox',
			'yelp' => 'Yelp',
			'zomato' => 'Zomato',
			'zynga' => 'Zynga'
		);
		foreach($replacements as $id=>$name) {
			$networks[$id]['name'] = $name;
		}
		return $networks;
	}
}

if (!function_exists('dbdb_icons_socicon_remove_defunct_networks')) {
	function dbdb_icons_socicon_remove_defunct_networks($networks) {
		unset($networks['appnet']);
		unset($networks['grooveshark']);
		unset($networks['stumbleupon']); // Now part of Mix.com
		return $networks;
	}
}

if (!function_exists('dbdb_icons_socicon_sort_networks_by_name')) {
	function dbdb_icons_socicon_sort_networks_by_name($networks) {
		uasort($networks, 'dbdb_icons_socicon_compare_names'); 
		return $networks;
	}
}

if (!function_exists('dbdb_icons_socicon_compare_names')) {
	function dbdb_icons_socicon_compare_names($a, $b) {
		// Sort any non-network items (e.g. "Select a network") first.
		if (!isset($a['name'])) { return -1; } 
		if (!isset($b['name'])) { return 1; }
		// Sort alphabetically
		return strcasecmp($a['name'], $b['name']);
	}
}