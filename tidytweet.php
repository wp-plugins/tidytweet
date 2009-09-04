<?php
/*
Plugin Name: TidyTweet
Plugin URI: http://tidytweet.com/widgets/wordpress
Description: Display your customized and moderated Twitter feed from TidyTweet.
Version: 1.0
Author: TidyTweet
Author URI: http://tidytweet.com

Copyright 2009 TidyTweet.com  (email : tidytweet@rockfishinteractive.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_action( 'widgets_init', 'tidyTweet_load_widgets' );

function tidyTweet_load_widgets() {
	register_widget( 'TidyTweet' );
}

class TidyTweet extends WP_Widget {

	function TidyTweet() {
		$widget_ops = array( 'classname' => 'tidytweet', 'description' => __('Display your customized and moderated Twitter feed from TidyTweet.', 'example') );
		$control_ops = array( 'id_base' => 'tidytweet' );
		$this->WP_Widget( 'tidytweet', __('TidyTweet', 'example'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		$count = $instance['count'];
		$rssFeed = $instance['rssFeed'];
		$widgetURL = str_replace('.atom', '.widget', $rssFeed);

		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;
		?>
		
		<div id="twitter_div">
		<ul id="twitter_update_list"></ul>
		<a id="tidytweet-link" href="http://tidytweet.com" title="Twitter feed provided by TidyTweet.com"><img src="http://tidytweet.com/_resources/Images/Icons/PoweredBy.png" alt="Powered by TidyTweet.com" /></a></div>
		<script type="text/javascript" src="<?php echo $widgetURL; ?>?count=<?php echo $count; ?>"></script>

		<?php

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count'] = strip_tags( $new_instance['count'] );
		$instance['rssFeed'] = strip_tags( $new_instance['rssFeed'] );

		return $instance;
	}

	function form( $instance ) {
		$defaults = array( 'title' => __('Twitter Updates', 'example'), 'count' => __(5, 'example') );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Tweet Count:', 'example'); ?></label>
			<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'rssFeed' ); ?>"><?php _e('Locate the "RSS Feed" link on the "Manage" page of your TidyTweet account.  Copy and paste that link location into the box below:', 'example'); ?></label>
			<input id="<?php echo $this->get_field_id( 'rssFeed' ); ?>" name="<?php echo $this->get_field_name( 'rssFeed' ); ?>" value="<?php echo $instance['rssFeed']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}

?>