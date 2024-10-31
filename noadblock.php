<?php
/*
Plugin Name: No Adblock
Plugin URI: http://www.noadblock.com
Description: This plugin will disable your visitors who using Adblock plugins.
Version: 0.1.2
Author: Verblick Dev
Author URI: http://www.verblick.com
License: GPL2
*/

function confirm_block_script(){

	$title=get_option('noadblock-title');
	$description=get_option('noadblock-description');
	
	$status=get_option('noadblock-status');
	$agree=get_option('noadblock-agree');
	$disagree=get_option('noadblock-disagree');
	$url=get_option('noadblock-url');
?>
	<script type="text/javascript" language="javascript">
		jQuery(function(){
	
	if(jQuery.adblock){
		jQuery.confirm({
			'title'		: '<?php echo $title; ?>',
			'message'	: '<?php echo $description; ?>',
			'buttons'	: {<?php if($status == "checked") { ?>
				'<?php echo $agree; ?>'	: {
					'class'	: 'blue',
					'action': function(){
						// Do nothing
						return;
					}
				},
				'<?php echo $disagree; ?>'	: {
					'class'	: 'gray',
					'action': function(){
						// Redirect to some page
						window.location = '<?php echo $url ?>';
					}
				}<?php } ?>
			}

		});
	}
	
	
});

	</script>
<?php
}
add_action('wp_footer', 'confirm_block_script');

function load_block_adblock_js() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-confirm', plugins_url( '/assets/jquery.confirm/jquery.confirm.js' , __FILE__ ));
	wp_enqueue_script('advertisment', plugins_url( '/assets/blockBlock/advertisement.js' , __FILE__ ));
	wp_enqueue_script('block-block', plugins_url( '/assets/blockBlock/blockBlock.jquery.js' , __FILE__ ));
	//wp_enqueue_script('script-script', plugins_url( '/assets/js/script.js' , __FILE__ ));	
	wp_enqueue_style('jquery-confirm-css', plugins_url( '/assets/jquery.confirm/jquery.confirm.css',__FILE__));
}
add_action('wp_enqueue_scripts', 'load_block_adblock_js');

// create custom plugin settings menu
add_action('admin_menu', 'noadblock_menu');

function noadblock_menu() {
	add_menu_page('No Adblock Settings Page', 'No Adblock', 'administrator', __FILE__, 'noadblock_settings_page', plugins_url('/assets/img/mini.png' , __FILE__ ));
	add_action( 'admin_init', 'register_noadblock_settings' );
}


function register_noadblock_settings() {
	register_setting( 'noadblock-option', 'noadblock-title' );
	register_setting( 'noadblock-option', 'noadblock-description' );
	register_setting( 'noadblock-option', 'noadblock-status' );
	register_setting( 'noadblock-option', 'noadblock-agree' );
	register_setting( 'noadblock-option', 'noadblock-disagree' );
	register_setting( 'noadblock-option', 'noadblock-url' );
}

function noadblock_settings_page() {
	wp_enqueue_style('jquery-confirm-css', plugins_url( '/assets/css/styles.css',__FILE__));
?>
<div class="wrap">
<div id="logo">
	<img src="<?php echo plugins_url('/assets/img/logo.png' , __FILE__ ); ?>" />
	<a href="http://www.noadblock.com" title="No Adblock">Plugin's Homepage</a> | <a href="http://www.noadblock.com" title="No Adblock">Changelogs</a>
</div>

<form method="post" action="options.php">
    <?php settings_fields( 'noadblock-option' ); ?>
    <?php do_settings_fields( 'noadblock-option', '' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Title</th>
        <td><input type="text" name="noadblock-title" placeholder="Adblock is Activated" value="<?php echo get_option('noadblock-title'); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Description</th>
       <!-- <td><input type="text" name="noadblock-description" value="<?php echo get_option('noadblock-description'); ?>" /></td> -->
		<td><textarea name="noadblock-description" placeholder="This website is living on advertisement. You need to disabled Adblock in order to view this page." cols="40" rows="5"><?php echo get_option('noadblock-description'); ?></textarea></td>
        </tr>
        
        <tr><td colspan="2"><hr/></td></tr>

		<tr valign="top">
		<th scope="row">Choices</th>
		<td><input type="checkbox" name="noadblock-status" value="checked" <?php echo get_option('noadblock-status'); ?> /></td>
		</tr>
        
        <tr valign="top">
        <th scope="row">Agree Text</th>
        <td><input type="text" placeholder="I will" name="noadblock-agree" value="<?php echo get_option('noadblock-agree'); ?>" /></td>
        </tr>
		
		<tr valign="top">
        <th scope="row">Disagree Text</th>
        <td><input type="text" placeholder="Forget it" name="noadblock-disagree" value="<?php echo get_option('noadblock-disagree'); ?>" /></td>
        </tr>
        
		<tr valign="top">
		<th scope="row">Redirect to</th>
		<td><input type="text" placeholder="http://www.noadblock.com" name="noadblock-url" value="<?php echo get_option('noadblock-url'); ?>" /></td>
		</tr>        
		
    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e("I'm Done") ?>" />
    </p>

</form>
</div>
<?php } ?>