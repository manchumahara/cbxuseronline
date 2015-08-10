<?php
/**
 * @package   Codeboxr_Flexible_CountDown
 * @author    Codeboxr <info@codeboxr.com>
 * @license   GPL-2.0+
 * @link      http://codeboxr.com/
 * @copyright 2014 Codeboxr
 */
?>

<div id="side-info-column">
    <div class="postbox">
        <h3>Plugin Info</h3>
        <div class="inside">
            <p>Plugin Name : <?php echo $plugin_data['Title'] ?> <?php echo $plugin_data['Version'] ?></p>
            <p>Author : <?php echo $plugin_data['Author'] ?></p>
            <p>Website : <a href="http://wpboxr.com" target="_blank">wpboxr.com</a></p>
            <p>Email : <a href="mailto:info@wpboxr.com" target="_blank">info@wpboxr.com</a></p>
            <p>Twitter : @<a href="http://twitter.com/wpboxr" target="_blank">WPBpboxr</a></p>
            <p>Facebook : <a href="http://facebook.com/wpboxr" target="_blank">http://facebook.com/wpboxr</a></p>
            <p>Linkedin : <a href="www.linkedin.com/company/codeboxr" target="_blank">codeboxr</a></p>
            <p>Gplus : <a href="https://plus.google.com/+wpboxr" target="_blank">Google Plus</a></p>
        </div>
    </div>
    <div class="postbox">
        <h3>Help & Supports</h3>
        <div class="inside">
            <p>Support: <a href="http://wpboxr.com/contact-us" target="_blank">Contact Us</a></p>
            <p><i class="icon-envelope"></i> <a href="mailto:info@wpboxr.com">info@wpboxr.com</a></p>
            <p><i class="icon-phone"></i> <a href="tel:008801717308615">+8801717308615</a> (CEO, Sabuj Kundu)<br></p>

        </div>
    </div>
    <!--div class="postbox">
        <h3>Video demo</h3>
        <div class="inside">
            <iframe src="http://www.screenr.com/embed/2Ow7" width="260" height="158" frameborder="0"></iframe>
        </div>
    </div-->
	<div class="postbox">
		<h3><?php _e('WPBoxr Other Plugins','cbxuseronline'); ?></h3>
		<div class="inside">
			<?php

			include_once(ABSPATH . WPINC . '/feed.php');
			if (function_exists('fetch_feed')) {
				$feed = fetch_feed('http://wpboxr.com/feed?post_type=product');
				// $feed = fetch_feed('http://feeds.feedburner.com/wpboxr'); // this is the external website's RSS feed URL
				if (!is_wp_error($feed)) : $feed->init();
					$feed->set_output_encoding('UTF-8'); // this is the encoding parameter, and can be left unchanged in almost every case
					$feed->handle_content_type(); // this double-checks the encoding type
					$feed->set_cache_duration(21600); // 21,600 seconds is six hours
					$limit = $feed->get_item_quantity(6); // fetches the 18 most recent RSS feed stories
					$items = $feed->get_items(0, $limit); // this sets the limit and array for parsing the feed

					$blocks = array_slice($items, 0, 6); // Items zero through six will be displayed here
					echo '<ul>';
					foreach ($blocks as $block) {
						$url    = $block->get_permalink();
						/* $id     = $block->get_id();
							$id     = str_replace('amp;','', $id);
							//var_dump($id);
							$id     = parse_url($id);
							$id     = $id['query'];
						   // var_dump($id);
							parse_str($id, $ids);
							$id = $ids['p'];*/
						//var_dump($id);
						echo '<li style="clear:both;  margin-bottom:5px;"><a target="_blank" href="' . $url . '">';
						//echo '<img style="float: left; display: inline; width:70px; height:70px; margin-right:10px;" src="http://wpboxr.com/wp-content/uploads/productshots/'.$id.'-profile.png" alt="wpboxrplugins" />';
						echo '<strong>' . $block->get_title() . '</strong></a></li>';
					}//end foreach
					echo '</ul>';


				endif;
			}
			?>
		</div>
	</div>

    <div class="postbox">
        <h3>WPBoxr.com Updates</h3>
        <div class="inside">
            <?php

            include_once(ABSPATH . WPINC . '/feed.php');
            if (function_exists('fetch_feed')) {
                $feed = fetch_feed('http://wpboxr.com/feed');
                // $feed = fetch_feed('http://feeds.feedburner.com/codeboxr'); // this is the external website's RSS feed URL
                if (!is_wp_error($feed)) : $feed->init();
                    $feed->set_output_encoding('UTF-8'); // this is the encoding parameter, and can be left unchanged in almost every case
                    $feed->handle_content_type(); // this double-checks the encoding type
                    $feed->set_cache_duration(21600); // 21,600 seconds is six hours
                    $limit = $feed->get_item_quantity(6); // fetches the 18 most recent RSS feed stories
                    $items = $feed->get_items(0, $limit); // this sets the limit and array for parsing the feed

                    $blocks = array_slice($items, 0, 6); // Items zero through six will be displayed here
                    echo '<ul>';
                    foreach ($blocks as $block) {
                        $url = $block->get_permalink();
                        echo '<li><a target="_blank" href="' . $url . '">';
                        echo '<strong>' . $block->get_title() . '</strong></a></li>';
                        //var_dump($block->get_description());
                        //echo $block->get_description();
                        //echo substr($block->get_description(),0, strpos($block->get_description(), "<br />")+4);
                    }//end foreach
                    echo '</ul>';


                endif;
            }
            ?>
        </div>
    </div>
	<div class="postbox">
		<div class="inside">
			<h3><?php _e('Codeboxr Networks','cbxuseronline') ?></h3>
			<p><?php _e('Html, Wordpress & Joomla Themes','cbxuseronline') ?></p>
			<a target="_blank" href="http://themeboxr.com"><img src="http://themeboxr.com/wp-content/themes/themeboxr/images/themeboxr-logo-rect.png" style="max-width: 100%;" alt="themeboxr" title="Themeboxr - useful themes"  /></a>
			<br/>
			<p><?php _e('Wordpress Plugins','cbxuseronline') ?></p>
			<a target="_blank" href="http://wpboxr.com"><img src="http://wpboxr.com/wp-content/themes/themeboxr/images/wpboxr-logo-rect.png" style="max-width: 100%;" alt="wpboxr" title="WPBoxr - Wordpress Extracts"  /></a>
			<br/><br/>
			<p>Joomla Extensions</p>
			<a target="_blank" href="http://joomboxr.com"><img src="http://joomboxr.com/wp-content/themes/themeboxr/images/joomboxr-logo-rect.png" style="max-width: 100%;" alt="joomboxr" title="Joomboxr - Joomla Extracts"  /></a>

		</div>
	</div>

    <div class="postbox">
        <h3>WPBoxr on facebook</h3>
        <div class="inside">
            <iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fwpboxr&amp;width=260&amp;height=258&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;border_color&amp;header=false&amp;appId=558248797526834" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:260px; height:258px;" allowTransparency="true"></iframe>
        </div>
    </div>
</div>