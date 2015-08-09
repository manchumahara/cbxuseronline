<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://wpboxr.com
 * @since      1.0.0
 *
 * @package    Cbxuseronline
 * @subpackage Cbxuseronline/admin/partials
 */
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap columns-2">
	<h2><?php echo esc_html( get_admin_page_title() ); ?> </h2>
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="post-body-content" style="position: relative;">
				<?php
				$this->setting->show_navigation();
				$this->setting->show_forms();
				?>
			</div>
			<div id="postbox-container-1" class="postbox-container-1">
				<?php require_once( plugin_dir_path( __FILE__ ). '/sidebar.php' ); ?>
			</div>
		</div>
	</div>
</div>
