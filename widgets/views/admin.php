<!-- This file is used to markup the administration form of the widget. -->

<!-- Custom  Title Field -->
<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>">
		<?php _e( 'Title:',"cbxuseronline"); ?>
	</label>

	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
</p>
<p>
	<input class="checkbox" type="checkbox" <?php checked($memberlist, true) ?> id="<?php echo $this->get_field_id('memberlist'); ?>" name="<?php echo $this->get_field_name('memberlist'); ?>" />
	<label for="<?php echo $this->get_field_id('memberlist'); ?>"><?php _e('Show Memberlist', $this->get_widget_slug()); ?></label><br />
	<input class="checkbox" type="checkbox" <?php checked($linkusername, true) ?> id="<?php echo $this->get_field_id('linkusername'); ?>" name="<?php echo $this->get_field_name('linkusername'); ?>" />
	<label for="<?php echo $this->get_field_id('linkusername'); ?>"><?php _e('Link user to author page', $this->get_widget_slug()); ?></label><br />

	<input class="checkbox" type="checkbox" <?php checked($count, true) ?> id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" />
	<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Show online count', $this->get_widget_slug()); ?></label><br />
	<input class="checkbox" type="checkbox" <?php checked($count_individual, true) ?> id="<?php echo $this->get_field_id('count_individual'); ?>" name="<?php echo $this->get_field_name('count_individual'); ?>" />
	<label for="<?php echo $this->get_field_id('count_individual'); ?>"><?php _e('Show individual count', $this->get_widget_slug()); ?></label><br />
	<input class="checkbox" type="checkbox" <?php checked($member_count, true) ?> id="<?php echo $this->get_field_id('member_count'); ?>" name="<?php echo $this->get_field_name('member_count'); ?>" />
	<label for="<?php echo $this->get_field_id('member_count'); ?>"><?php _e('Show member count', $this->get_widget_slug()); ?></label><br />
	<input class="checkbox" type="checkbox" <?php checked($guest_count, true) ?> id="<?php echo $this->get_field_id('guest_count'); ?>" name="<?php echo $this->get_field_name('guest_count'); ?>" />
	<label for="<?php echo $this->get_field_id('guest_count'); ?>"><?php _e('Show guest count', $this->get_widget_slug()); ?></label><br />
	<input class="checkbox" type="checkbox" <?php checked($bot_count, true) ?> id="<?php echo $this->get_field_id('bot_count'); ?>" name="<?php echo $this->get_field_name('bot_count'); ?>" />
	<label for="<?php echo $this->get_field_id('bot_count'); ?>"><?php _e('Show bot count', $this->get_widget_slug()); ?></label><br />
	<input class="checkbox" type="checkbox" <?php checked($page, true) ?> id="<?php echo $this->get_field_id('page'); ?>" name="<?php echo $this->get_field_name('page'); ?>" />
	<label for="<?php echo $this->get_field_id('page'); ?>"><?php _e('Show for current page', $this->get_widget_slug()); ?></label><br />
	<input class="checkbox" type="checkbox" <?php checked($mostuseronline, true) ?> id="<?php echo $this->get_field_id('mostuseronline'); ?>" name="<?php echo $this->get_field_name('mostuseronline'); ?>" />
	<label for="<?php echo $this->get_field_id('mostuseronline'); ?>"><?php _e('Show most user online', $this->get_widget_slug()); ?></label><br />
	<input class="checkbox" type="checkbox" <?php checked($mobile, true) ?> id="<?php echo $this->get_field_id('mobile'); ?>" name="<?php echo $this->get_field_name('mobile'); ?>" />
	<label for="<?php echo $this->get_field_id('mobile'); ?>"><?php _e('Show mobile or desktop logged in status', $this->get_widget_slug()); ?></label><br />
</p>
<?php
do_action('cbxuseronline_widget_form_admin', $instance, $this)
?>