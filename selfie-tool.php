<?php
/*
Plugin Name: Selfie Tool
Description: A tool that allows users to upload selfies and have them ranked by score
depending on factors.
Version: 1.0
Author: Prakhar Yadav
License: none
*/

class selfie_tool extends WP_Widget{
	function __construct(){
		$widget_ops = array(
			'classname' => 'selfie-tool',
			'description' => 'A tool that allows users to upload selfies and have them ranked by score depending on factors.'
		);
		parent::__construct('selfie-tool', $name=__('Selfie Tool'), $widget_ops);
	}
	function form($instance){
		echo '<p>No options for this widget.</p>';
	}
	function widget($args, $instance){
		echo $args['before_widget'];
?>
	<style>
		iframe#selfie-tool{
			border: 2px solid #d5d9dc;
			border-top: 5px solid #3fc6ee;
			overflow: auto;
			width: 100%;
			height: 670px;
			border-radius: 5px;
		}
	</style>
	<iframe id="selfie-tool" src="/wp-content/plugins/selfie-tool/src/source.html"></iframe>
<?php
		echo $args['after_widget'];
	}
}

add_action('widgets_init',function(){
	register_widget('selfie_tool');
});

?>