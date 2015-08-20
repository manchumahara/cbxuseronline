<?php

/**
 * The file that defines the helper plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://wpboxr.com
 * @since      1.0.0
 *
 * @package    Cbxuseronline
 * @subpackage Cbxuseronline/includes
 */



/**
 * The helper plugin class.
 *
 * This is used to define some helper methods that can be used in frontend and backend
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Cbxuseronline
 * @subpackage Cbxuseronline/includes
 * @author     WPBoxr <info@wpboxr.com>
 */
class CBXUseronlineHelper{

	/**
	 * initialize cookie
	 */
	public static function init_cookie() {

		if(!is_admin()){
			if ( !is_user_logged_in() ) {

				$cookie_value = 'wpuseronlineguest-' . rand(CBX_USERONLINE_RAND_MIN, CBX_USERONLINE_RAND_MAX);
				if (!isset($_COOKIE[CBX_USERONLINE_COOKIE_NAME]) && empty($_COOKIE[CBX_USERONLINE_COOKIE_NAME])) {

					setcookie(CBX_USERONLINE_COOKIE_NAME, $cookie_value, CB_RATINGSYSTEM_COOKIE_EXPIRATION_30DAYS, SITECOOKIEPATH, COOKIE_DOMAIN);

					//$_COOKIE var accepts immediately the value so it will be retrieved on page first load.
					$_COOKIE[CBX_USERONLINE_COOKIE_NAME] = $cookie_value;

				} elseif(isset($_COOKIE[CBX_USERONLINE_COOKIE_NAME])) {

					//var_dump($_COOKIE[CB_POLL_COOKIE_NAME]);
					if( substr($_COOKIE[CBX_USERONLINE_COOKIE_NAME], 0, 17) != 'wpuseronlineguest' ) {
						setcookie(CBX_USERONLINE_COOKIE_NAME, $cookie_value, CB_RATINGSYSTEM_COOKIE_EXPIRATION_30DAYS, SITECOOKIEPATH, COOKIE_DOMAIN);

						//$_COOKIE var accepts immediately the value so it will be retrieved on page first load.
						$_COOKIE[CBX_USERONLINE_COOKIE_NAME] = $cookie_value;
					}
				}
			}


		}

	}

	/**
	 * Get Ip of the current visitor
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_ipaddress(){
		if (empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {

			$ip_address = $_SERVER["REMOTE_ADDR"];
		}
		else {

			$ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}

		if (strpos($ip_address, ',') !== false) {

			$ip_address = explode(',', $ip_address);
			$ip_address = $ip_address[0];
		}

		return esc_attr($ip_address);
	}

	/**
	 * Returns popular bot names as array
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_bots(){
		$bots = array(
			'Google Bot'    => 'google',
			'MSN'           => 'msnbot',
			'BingBot'       => 'bingbot',
			'Alex'          => 'ia_archiver',
			'Lycos'         => 'lycos',
			'Ask Jeeves'    => 'jeeves',
			'Altavista'     => 'scooter',
			'AllTheWeb'     => 'fast-webcrawler',
			'Inktomi'       => 'slurp@inktomi',
			'Turnitin.com'  => 'turnitinbot',
			'Technorati'    => 'technorati',
			'Yahoo'         => 'yahoo',
			'Findexa'       => 'findexa',
			'NextLinks'     => 'findlinks',
			'Gais'          => 'gaisbo',
			'WiseNut'       => 'zyborg',
			'WhoisSource'   => 'surveybot',
			'Bloglines'     => 'bloglines',
			'BlogSearch'    => 'blogsearch',
			'PubSub'        => 'pubsub',
			'Syndic8'       => 'syndic8',
			'RadioUserland' => 'userland',
			'Gigabot'       => 'gigabot',
			'Become.com'    => 'become.com',
			'Baidu'         => 'baidu',
			'Yandex'        => 'yandex',
			'Amazon'        => 'amazonaws.com',
			'Ahrefs'        => 'AhrefsBot',
			'Yandex Bot'     => 'YandexBot' //added new
		);

		return apply_filters('cbxuseronline_bots', $bots);
	}


	public static function get_referral(){
		$referral = '';
		if ( isset( $_SERVER['HTTP_REFERER'] ) )
			$referral = sanitize_text_field( $_SERVER['HTTP_REFERER'] );
		else
			$referral = '';

		return apply_filters('cbxuseronline_referral', $referral) ;
	}

	/**
	 * Get user agent
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_useragent()
	{
		$user_agent = '';
		if (isset($_SERVER['HTTP_USER_AGENT']))
			$user_agent = sanitize_text_field($_SERVER['HTTP_USER_AGENT']);
		else
			$user_agent = '';

		return apply_filters('cbxuseronline_useragents', $user_agent) ;
	}

	public static function get_tablename(){
		global $wpdb;

		return $wpdb->prefix . "cbxuseronline";
	}

	/**
	 * Detection mobile
	 *
	 * @since 1.0.0
	 *
	 * return true if mobile or false
	 */
	public static function is_mobile()
	{
		//$user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);

		$user_agent = strtolower(CBXUseronlineHelper::get_useragent());

		//var_dump($user_agent);

		$accept     = strtolower($_SERVER['HTTP_ACCEPT']);

		if (
			0
			or preg_match('/ip[ao]d/', $user_agent)
			or preg_match('/iphone/', $user_agent) //iPhone or iPod
			or preg_match('/android/', $user_agent) //Android
			or preg_match('/opera mini/', $user_agent) //Opera Mini
			or preg_match('/blackberry/', $user_agent) //Blackberry
			or preg_match('/series ?60/', $user_agent) //Symbian OS
			or preg_match('/(pre\/|palm os|palm|hiptop|avantgo|plucker|xiino|blazer|elaine)/', $user_agent) //Palm OS
			or preg_match('/(iris|3g_t|windows ce|opera mobi|iemobile)/', $user_agent) //Windows OS
			or preg_match('/(maemo|tablet|qt embedded|com2)/', $user_agent) //Nokia Tablet
		){	return true;}

		/**
		 * Now look for standard phones & mobile devices
		 */

		//Mix of standard phones
		if (preg_match('/(mini 9.5|vx1000|lge |m800|e860|u940|ux840|compal|wireless| mobi|ahong|lg380|lgku|lgu900|lg210|lg47|lg920|lg840|lg370|sam-r|mg50|s55|g83|t66|vx400|mk99|d615|d763|el370|sl900|mp500|samu3|samu4|vx10|xda_|samu5|samu6|samu7|samu9|a615|b832|m881|s920|n210|s700|c-810|_h797|mob-x|sk16d|848b|mowser|s580|r800|471x|v120|rim8|c500foma:|160x|x160|480x|x640|t503|w839|i250|sprint|w398samr810|m5252|c7100|mt126|x225|s5330|s820|htil-g1|fly v71|s302|-x113|novarra|k610i|-three|8325rc|8352rc|sanyo|vx54|c888|nx250|n120|mtk |c5588|s710|t880|c5005|i;458x|p404i|s210|c5100|teleca|s940|c500|s590|foma|samsu|vx8|vx9|a1000|_mms|myx|a700|gu1100|bc831|e300|ems100|me701|me702m-three|sd588|s800|8325rc|ac831|mw200|brew |d88|htc\/|htc_touch|355x|m50|km100|d736|p-9521|telco|sl74|ktouch|m4u\/|me702|8325rc|kddi|phone|lg |sonyericsson|samsung|240x|x320|vx10|nokia|sony cmd|motorola|up.browser|up.link|mmp|symbian|smartphone|midp|wap|vodafone|o2|pocket|kindle|mobile|psp|treo|vnd.rim|wml|nitro|nintendo|wii|xbox|archos|openweb|mini|docomo)/', $user_agent))
		{
			return true;
		}

		//Any falling through the cracks
		if (
			0
			or strpos($accept, 'text/vnd.wap.wml') > 0
			or strpos($accept, 'application/vnd.wap.xhtml+xml') > 0
			or isset($_SERVER['HTTP_X_WAP_PROFILE'])
			or isset($_SERVER['HTTP_PROFILE'])
		){	return true;	}

		//Catch all
		if (
			in_array(
				substr($user_agent, 0, 4),
				array(
					'1207', '3gso', '4thp', '501i', '502i', '503i', '504i', '505i', '506i', '6310',
					'6590', '770s', '802s', 'a wa', 'acer', 'acs-', 'airn', 'alav', 'asus', 'attw',
					'au-m', 'aur ', 'aus ', 'abac', 'acoo', 'aiko', 'alco', 'alca', 'amoi', 'anex',
					'anny', 'anyw', 'aptu', 'arch', 'argo', 'bell', 'bird', 'bw-n', 'bw-u', 'beck',
					'benq', 'bilb', 'blac', 'c55/', 'cdm-', 'chtm', 'capi', 'cond', 'craw', 'dall',
					'dbte', 'dc-s', 'dica', 'ds-d', 'ds12', 'dait', 'devi', 'dmob', 'doco', 'dopo',
					'el49', 'erk0', 'esl8', 'ez40', 'ez60', 'ez70', 'ezos', 'ezze', 'elai', 'emul',
					'eric', 'ezwa', 'fake', 'fly-', 'fly_', 'g-mo', 'g1 u', 'g560', 'gf-5', 'grun',
					'gene', 'go.w', 'good', 'grad', 'hcit', 'hd-m', 'hd-p', 'hd-t', 'hei-', 'hp i',
					'hpip', 'hs-c', 'htc ', 'htc-', 'htca', 'htcg', 'htcp', 'htcs', 'htct', 'htc_',
					'haie', 'hita', 'huaw', 'hutc', 'i-20', 'i-go', 'i-ma', 'i230', 'iac', 'iac-',
					'iac/', 'ig01', 'im1k', 'inno', 'iris', 'jata', 'java', 'kddi', 'kgt', 'kgt/',
					'kpt ', 'kwc-', 'klon', 'lexi', 'lg g', 'lg-a', 'lg-b', 'lg-c', 'lg-d', 'lg-f',
					'lg-g', 'lg-k', 'lg-l', 'lg-m', 'lg-o', 'lg-p', 'lg-s', 'lg-t', 'lg-u', 'lg-w',
					'lg/k', 'lg/l', 'lg/u', 'lg50', 'lg54', 'lge-', 'lge/', 'lynx', 'leno', 'm1-w',
					'm3ga', 'm50/', 'maui', 'mc01', 'mc21', 'mcca', 'medi', 'meri', 'mio8', 'mioa',
					'mo01', 'mo02', 'mode', 'modo', 'mot ', 'mot-', 'mt50', 'mtp1', 'mtv ', 'mate',
					'maxo', 'merc', 'mits', 'mobi', 'motv', 'mozz', 'n100', 'n101', 'n102', 'n202',
					'n203', 'n300', 'n302', 'n500', 'n502', 'n505', 'n700', 'n701', 'n710', 'nec-',
					'nem-', 'newg', 'neon', 'netf', 'noki', 'nzph', 'o2 x', 'o2-x', 'opwv', 'owg1',
					'opti', 'oran', 'p800', 'pand', 'pg-1', 'pg-2', 'pg-3', 'pg-6', 'pg-8', 'pg-c',
					'pg13', 'phil', 'pn-2', 'pt-g', 'palm', 'pana', 'pire', 'pock', 'pose', 'psio',
					'qa-a', 'qc-2', 'qc-3', 'qc-5', 'qc-7', 'qc07', 'qc12', 'qc21', 'qc32', 'qc60',
					'qci-', 'qwap', 'qtek', 'r380', 'r600', 'raks', 'rim9', 'rove', 's55/', 'sage',
					'sams', 'sc01', 'sch-', 'scp-', 'sdk/', 'se47', 'sec-', 'sec0', 'sec1', 'semc',
					'sgh-', 'shar', 'sie-', 'sk-0', 'sl45', 'slid', 'smb3', 'smt5', 'sp01', 'sph-',
					'spv ', 'spv-', 'sy01', 'samm', 'sany', 'sava', 'scoo', 'send', 'siem', 'smar',
					'smit', 'soft', 'sony', 't-mo', 't218', 't250', 't600', 't610', 't618', 'tcl-',
					'tdg-', 'telm', 'tim-', 'ts70', 'tsm-', 'tsm3', 'tsm5', 'tx-9', 'tagt', 'talk',
					'teli', 'topl', 'hiba', 'up.b', 'upg1', 'utst', 'v400', 'v750', 'veri', 'vk-v',
					'vk40', 'vk50', 'vk52', 'vk53', 'vm40', 'vx98', 'virg', 'vite', 'voda', 'vulc',
					'w3c ', 'w3c-', 'wapj', 'wapp', 'wapu', 'wapm', 'wig ', 'wapi', 'wapr', 'wapv',
					'wapy', 'wapa', 'waps', 'wapt', 'winc', 'winw', 'wonu', 'x700', 'xda2', 'xdag',
					'yas-', 'your', 'zte-', 'zeto', 'acs-', 'alav', 'alca', 'amoi', 'aste', 'audi',
					'avan', 'benq', 'bird', 'blac', 'blaz', 'brew', 'brvw', 'bumb', 'ccwa', 'cell',
					'cldc', 'cmd-', 'dang', 'doco', 'eml2', 'eric', 'fetc', 'hipt', 'http', 'ibro',
					'idea', 'ikom', 'inno', 'ipaq', 'jbro', 'jemu', 'java', 'jigs', 'kddi', 'keji',
					'kyoc', 'kyok', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-', 'libw', 'm-cr', 'maui',
					'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'mywa', 'nec-',
					'newt', 'nok6', 'noki', 'o2im', 'opwv', 'palm', 'pana', 'pant', 'pdxg', 'phil',
					'play', 'pluc', 'port', 'prox', 'qtek', 'qwap', 'rozo', 'sage', 'sama', 'sams',
					'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar', 'sie-', 'siem', 'smal',
					'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-', 'tosh', 'treo', 'tsm-',
					'upg1', 'upsi', 'vk-v', 'voda', 'vx52', 'vx53', 'vx60', 'vx61', 'vx70', 'vx80',
					'vx81', 'vx83', 'vx85', 'wap-', 'wapa', 'wapi', 'wapp', 'wapr', 'webc', 'whit',
					'winw', 'wmlb', 'xda-'
				)
			)
		)
		{
			return true;
		}

		return false;
	}// end of _check_mobile_device

	public static function user_online($page = ''){

		global $wpdb;
		$cbxuseronline_tablename = CBXUseronlineHelper::get_tablename();

		//var_dump($page);

		$where = '';
		if($page != ''){

			$where = $wpdb->prepare( ' WHERE page_url = %s ', $page );
		}

		//var_dump("SELECT * FROM $cbxuseronline_tablename ".$where." ORDER BY timestamp DESC");

		$userdata = $wpdb->get_results( "SELECT * FROM $cbxuseronline_tablename ".$where." ORDER BY timestamp DESC" );

		$userdata_group = array();

		foreach($userdata as $user){
			$userdata_group[$user->user_type][] = $user;
		}

		return array('users_bygroup' => $userdata_group, 'count' => sizeof($userdata));

	}

	public static function cbxuseronline_display($atts, $scope="shortcode"){

		/*echo '<pre>';
		print_r($atts);
		echo '</pre>';*/

		//todo: find a way to translate 0, 1 and more than 1  with proper plural strings

		extract( $atts, EXTR_SKIP );

		$plugin_slug = 'cbxuseronline';

		//var_dump($page);

		$userdata = CBXUseronlineHelper::user_online($page);


		//$cbxuseronline_basics = get_option('cbxuseronline_basics');

		//$linkusername = isset($atts['linkusername']) ? intval($atts['linkusername']) : 1;

		//$output = '';
		$output_memebers = '';
		$output_online_count = '';
		$output_online_count_parts = '';

		//usercount
		if($count){
			$user_count = isset($userdata['count']) ? intval($userdata['count']): 0;

			//$output_online_count .= ''.sprintf( _n( 'Total <strong>%d</strong> user', 'Total <strong>%d</strong> users', $user_count, $plugin_slug ), $user_count ).'';
			$output_online_count .= CBXUseronlineHelper::get_correct_plugral_text($user_count, __( 'Total <strong>%</strong> users', $plugin_slug ), __( 'Total <strong>%</strong> user', $plugin_slug ));
		}


		if($member_count && $count_individual){
			$members = isset($userdata['users_bygroup']['user']) ? $userdata['users_bygroup']['user']: array();
			$members_count = sizeof($members);

			if($output_online_count_parts != '' && $member_count == 1) {
				//var_dump($output_online_count_parts);
				$output_online_count_parts .= ',';
				//var_dump($output_online_count_parts);
			}


			//$output_online_count_parts .= ($members_count) ? sprintf( _n( ' <strong>%d</strong> member', ' <strong>%d</strong> members', $members_count, $plugin_slug ), $members_count ): '';
			$output_online_count_parts .= CBXUseronlineHelper::get_correct_plugral_text($members_count, __(' <strong>%</strong> members', $plugin_slug), __(' <strong>%</strong> member', $plugin_slug));


		}

		//var_dump($count_individual);
		//var_dump($guest_count);

		if($guest_count && $count_individual){
			$guest = isset($userdata['users_bygroup']['guest']) ? $userdata['users_bygroup']['guest']: array();
			$guests_count = sizeof($guest);
			if($output_online_count_parts != '' && $guest_count) {
				//var_dump($output_online_count_parts);
				$output_online_count_parts .= ',';
				//var_dump($output_online_count_parts);
			}

			//$output_online_count_parts .= ($guest_count) ? sprintf( _n( ' <strong>%d</strong> guest', ' <strong>%d</strong> guests', $guest_count, $plugin_slug ), $guest_count ): '';
			$output_online_count_parts .= CBXUseronlineHelper::get_correct_plugral_text($guests_count, __(' <strong>%</strong> guests',$plugin_slug), __(' <strong>%</strong> guest', $plugin_slug));
		}


		if($bot_count && $count_individual){
			$bot = isset($userdata['users_bygroup']['bot']) ? $userdata['users_bygroup']['bot']: array();
			$bots_count = sizeof($bot);


			if($output_online_count_parts != '' && ($bot_count)) $output_online_count_parts .= ',';
			//$output_online_count_parts .= ($bot_count) ? sprintf( _n( ' <strong>%d</strong> bot', ' <strong>%d</strong> bots', $bot_count, $plugin_slug ), $bot_count ): '';
			$output_online_count_parts .= CBXUseronlineHelper::get_correct_plugral_text( $bots_count, __(' <strong>%</strong> bots', $plugin_slug), __(' <strong>%</strong> bot', $plugin_slug));
		}

		if($output_online_count_parts != '' && $count_individual) {
			$output_online_count .= __(' including',$plugin_slug);
			$output_online_count .= $output_online_count_parts;
		}

		$output_online_count .= __(' online', $plugin_slug);
		if($page != ''){
			$output_online_count .= __(' on this page',$plugin_slug);
		}
		$output_online_count = '<p>'.$output_online_count.'</p>';



		$mostuseronline_html = '';
		if($mostuseronline){
			$mostuser = get_option('cbxuseronline_mostonline');
			//var_dump($mostuser);
			/*, array(
				'count' => $cbxuseronline_mostonline_now,
				'date' => current_time( 'timestamp' )
			));*/

			$mostuser_count = isset($mostuser['count'])? intval($mostuser['count']) : 0;
			$mostuser_date  = isset($mostuser['date'])? intval($mostuser['date']) : 0;

			$mysql_date = false;

			if ( $mysql_date ){
				$mostuser_date = mysql2date( sprintf( __( '%s @ %s', $plugin_slug ), get_option( 'date_format' ), get_option( 'time_format' ) ), $mostuser_date, true );
			}
			else{
				$mostuser_date = date_i18n( sprintf( __( '%s @ %s', $plugin_slug), get_option( 'date_format' ), get_option( 'time_format' ) ), $mostuser_date );
			}

			$mostuseronline_html = '<p>'.sprintf(__('Most users ever online were <strong>%d</strong>, on %s', $plugin_slug), $mostuser_count, $mostuser_date ).'</p>';
		}

		if($memberlist && isset($userdata['users_bygroup']['user'])){

			$output_memebers .= '<ul class="cbxuseronline_memberlist cbxuseronline_memberlist_'.$scope.'">';

			foreach($userdata['users_bygroup']['user'] as $member){

				/*echo '<pre>';
				print_r($member);
				echo '</pre>';*/

				$mobile_label = '';
				$mobile_label_class= '';

				if($mobile){
					$mobile_label = '<span class="cbxuseronline_'.(($member->mobile) ? 'mobile': 'desktop').' '.apply_filters('mobile_label_class', $mobile_label_class, $atts).'"></span>';
				}

				$memberlist_css_class = 'cbxuseronline_memberlist_item';
				$memberlist_css_class = apply_filters('memberlist_css_class', $memberlist_css_class, $atts );

				$member_name = apply_filters('cbxuseronline_memberitemname',$member->user_name, $atts);

				//var_dump($linkusername);

				if($linkusername){
					$output_memebers .= '<li class="'.$memberlist_css_class.'"><a title="'.$member->user_name.'" href="'.get_author_posts_url($member->userid).'">';
						$item_label =  $member_name.$mobile_label;
						$output_memebers .= apply_filters('cbxuseronline_memberitemhtml',$item_label, $member->userid, $atts);


					$output_memebers .= '</a>';

					if(isset($atts['details']) && $atts['details'] ){
						$member_lastlogin_time = '';
						if ( $mysql_date ){
							$member_lastlogin_time = mysql2date( sprintf( __( '%s @ %s', $plugin_slug ), get_option( 'date_format' ), get_option( 'time_format' ) ), $member->timestamp, true );
						}
						else{
							$member_lastlogin_time = date_i18n( sprintf( __( '%s @ %s', $plugin_slug), get_option( 'date_format' ), get_option( 'time_format' ) ), $member->timestamp );
						}

						$output_memebers .= '<p>'.__('User ID: ',$plugin_slug).$member->userid.'</p>';
						$output_memebers .= '<p>'.__('IP Address: ',$plugin_slug).$member->user_ip.'</p>';
						$output_memebers .= '<p>'.__('User Agent: ',$plugin_slug).$member->user_agent.'</p>';
						$output_memebers .= '<p><a target="_blank" href="'.$member->page_url.'">'.__('URL',$plugin_slug).'</a> <a target="_blank" href="'.$member->referral.'">'.__('Referral',$plugin_slug).'</a></p>';

					}

					$output_memebers .= '</li>';
				}
				else{
					$output_memebers .= '<li class="'.$memberlist_css_class.'">';
						$item_label =  $member_name;
						$output_memebers .= apply_filters('cbxuseronline_memberitemhtml', $item_label, $member->userid, $atts);
						//var_dump($atts['details']);

						if(isset($atts['details']) && $atts['details'] ){
							$member_lastlogin_time = '';
							if ( $mysql_date ){
								$member_lastlogin_time = mysql2date( sprintf( __( '%s @ %s', $plugin_slug ), get_option( 'date_format' ), get_option( 'time_format' ) ), $member->timestamp, true );
							}
							else{
								$member_lastlogin_time = date_i18n( sprintf( __( '%s @ %s', $plugin_slug), get_option( 'date_format' ), get_option( 'time_format' ) ), $member->timestamp );
							}

							$output_memebers .= '<p>'.__('User ID: ',$plugin_slug).$member->userid.'</p>';
							$output_memebers .= '<p>'.__('IP Address: ',$plugin_slug).$member->user_ip.'</p>';
							$output_memebers .= '<p>'.__('User Agent: ',$plugin_slug).$member->user_agent.'</p>';
							$output_memebers .= '<p><a target="_blank" href="'.$member->page_url.'">'.__('URL',$plugin_slug).'</a> <a target="_blank" href="'.$member->referral.'">'.__('Referral',$plugin_slug).'</a></p>';

						}

					$output_memebers .= '</li>';
				}

			}
			$output_memebers .= '</ul>';
		}



		return 	'<div class="cbxuseronline cbxuseronline_'.$scope.'">'.$output_online_count.$mostuseronline_html.$output_memebers.'</div>';
	}

	public  static function cbxuseronline_number( $nooped_plural, $count, $text_domain ) {

		return printf( translate_nooped_plural( $nooped_plural, $count, $text_domain ), $count );
	}


	/**
	 * Displays the plural strings if value is more than 1, unless singular
	 *
	 * @param $number interger
	 * @param $plural  string
	 * @param $singular string
	 *
	 * @return string
	 */
	function get_correct_plugral_text( $number, $plural, $singular ) {


		if ( $number > 1 ) {
			$output = str_replace( '%', number_format_i18n( $number ), $plural );
		}
		else {
			//less than 1
			$output = str_replace( '%', number_format_i18n( $number ), $singular );
		}

		return $output;
	}


}