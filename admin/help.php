<?php 
		wp_enqueue_style( 'uikitcss', plugin_dir_url( __DIR__ ) . 'css/uikit.min.css', true, '3.6.3', 'all' );
		wp_register_script( 'quikitjs', plugin_dir_url( __DIR__ ) . 'js/uikit.min.js', array(), '3.6.3', true );
		wp_enqueue_script('quikitjs');
		wp_register_script( 'uikiticons', plugin_dir_url( __DIR__ ) . 'js/uikit-icons.min.js', array(), '3.6.3', true );
		wp_enqueue_script('uikiticons');

		wp_enqueue_style( 'qanvacss', plugin_dir_url( __DIR__ ) . 'css/basic.css', array(), '1.0.0', 'all' );
		
?>
	<script type="text/javascript">
	window.addEventListener( 'load', function(){
		document.getElementById( 'wpfooter' ).remove();
		const elements = document.getElementsByClassName('fs-notice');
			while(elements.length > 0){
				elements[0].parentNode.removeChild(elements[0]);
			}
	});
	</script>
<style>
html, body{
    height:100%;
    background:rgb(241, 241, 241) !important;
}
.qanvaexample p, .qanvaeffect:not(h1):not(h2):not(h3):not(h4){
	font-size:16px;
}
#wpfooter, .fs-notice *{
	width:0;
	height:0;
	display:none;
}
#wpbody-content {
  padding-bottom:0;
}
.update-nag,.fs-notice,.fs-notice label,.fs-notice-body, .notice:not( .quickalert ){
	display:none !important;
	border:0 !important;
	padding:0 !important;
	box-shadow:none !important;
}
ul{
	list-style:initial
}
</style>
<div class="qanvatcd uk-container-center uk-margin-top uk-margin-large-bottom">
<h3><img src="<?php echo plugin_dir_url( __DIR__ ); ?>/img/qanvalogo.svg" class="logo"><?php _e("Display content controlled by time, day, week and many more.", "qanva-time-controlled-display" ); ?></h3>
  <div class="uk-grid uk-margin-remove-left uk-margin-right" data-uk-grid-margin>
   <div class="uk-width-1-2 uk-card uk-card-default uk-card-body">
				<!-- content left -->
					<h5><?php _e( "How it works", "qanva-time-controlled-display" ); ?></h5>
					<?php _e( "With Time Controlled Display every Elementor element can be hidden or displayed at the frontend in a fixed time period", "qanva-time-controlled-display" ); ?>.
					<ul>
					<li><?php _e( "Activate an element in Elementor and got to advanced", "qanva-time-controlled-display" ); ?>.	</li>
					<li><?php _e( "There use the Time Controlled Display settings panel", "qanva-time-controlled-display" ); ?>.	</li>
					<li><?php _e( "First of all: choose the timezone for the conditions", "qanva-time-controlled-display" ); ?>.	</li>
					<li><?php _e( "Now the panel with the time range options opens", "qanva-time-controlled-display" ); ?>.	</li>
					<li><?php _e( "Now choose if the setting applies to the whole year or certain months", "qanva-time-controlled-display" ); ?>.	</li>
					<li><?php _e( "You can choose on which weekdays the condition is valid", "qanva-time-controlled-display" ); ?>.	</li>
					<li><?php _e( "And narrow it down to from hour/minutes to hour/minutes", "qanva-time-controlled-display" ); ?>.	</li>
					<li><?php _e( "By standard all elements are visible, thats why it makes sense to set the condition to 'hide'", "qanva-time-controlled-display" ); ?>.	</li>
					</ul>
					<h5><?php _e( "Notice", "qanva-time-controlled-display" ); ?>:</h5><p>
					<?php _e( "Previous settings get overwritten by newer ones", "qanva-time-controlled-display" ); ?>!	</p>
		 </div>  
			<div class="uk-width-1-2 uk-card uk-card-default uk-card-body qanvaexample">
				<!-- content right -->
			</div>
		</div>  
		<div class="uk-text-right uk-text-meta uk-text-small uk-margin-right"><small>&copy; <?php echo date( "Y");?> <a href="https://qanva.tech" target="_blank" class="uk-link-text" >QANVA.TECH</a> All rights reserved.</small>
		</div>
</div>
			