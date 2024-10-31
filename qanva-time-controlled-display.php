<?php
/**
 * Plugin Name: Qanva Time Controlled Display
 * Description: Display content controlled by time, day, week and many more.
 * Plugin URI:  https://qanva.tech/qanva-time-controlled-display
 * Version:     1.0.1
 * Author:      fab22.com - ukischkel
 * Author URI:  https://qanva.tech
 * License:		 GPL v2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: qanva-time-controlled-display
 * Domain Path: languages
 * Elementor tested up to: 3.15.3
 * Elementor Pro tested up to: 3.15.1
*/

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

 
  define('QANVATCD','1.0.0');

		
		$qanvatimecontroldescription = __( "Display content controlled by time, day, week and many more.", "qanva-time-controlled-display" );

  	if (!get_option( 'qanva_qtcd_times' )) {
				add_option( 'qanva_qtcd_times', [] );
	  }
 
	class Qanvatimecontrol{			
		const MINIMUM_ELEMENTOR_VERSION = '3.5.0' ;
  		const MINIMUM_PHP_VERSION = '7.0' ;

		public function __construct(){
			add_action( 'plugins_loaded', [ $this, 'qanvatimecontrolinit' ] );
			add_action( 'plugins_loaded', [$this, 'ladesprachdateifuerqanvatimecontrol'] );
		}
  
		public function ladesprachdateifuerqanvatimecontrol(){
			load_plugin_textdomain( 'qanva-time-controlled-display', false, dirname( plugin_basename(__FILE__) ) . '/languages' ); 
		} 		
				
		/** plugin setting & help page **/
		public function qanvatimecontrolmenue($links){
			$url = get_admin_url() . 'options-general.php?page=qanvatimecontrol';
			$qanvalinks = '<a href="' . $url . '" style="color:#39b54a;font-weight:bold">' . __( "Help", "qanva-time-controlled-display" ) . '</a> | ';
			$links['qanva-qanvatimecontrol-link'] = $qanvalinks;
				return $links;
		}

				
  	public function addextraqtcdhelp(){
		add_submenu_page(
			'',
			'',
			'',
			'manage_options',
			'qanvatimecontrol',
			[ $this, 'qanvatimecontrolhelppage' ]
		);
  	}
    	
	public function qanvatimecontrolhelppage(){
		include_once 'admin/help.php';
	}	

  	public function qanvatimecontrolinit(){
		if ( $this->is_compatible() ){
			add_action( 'elementor/init', [ $this, 'init' ] );
		}
 	}

   /** Check required min versions **/
   public function is_compatible(){     
    	if ( !did_action( 'elementor/loaded' ) ){
    		 add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
    		 return false;
    	}
   	if ( !version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ){
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return false;
   	}
    	if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ){
		  add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
		  return false;
    	}        
    	return true;
   }
   
   public function admin_notice_missing_main_plugin(){
      if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
      $message = sprintf(
        esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'qanva-time-controlled-display' ),
        '<strong>' . esc_html__( 'Qanva Time Controlled Display', 'qanva-time-controlled-display' ) . '</strong>',
        '<strong>' . esc_html__( 'Elementor', 'qanva-time-controlled-display' ) . '</strong>'
      );
       printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
   }
    
   public function admin_notice_minimum_elementor_version(){
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
				esc_html__( '"%1$s" requires min version "%2$s" of Elementor to be installed.', 'qanva-time-controlled-display' ),
				'<strong>' . esc_html__( 'Qanva Time Controlled Display', 'qanva-time-controlled-display' ) . '</strong>',
				'<strong>' . MINIMUM_ELEMENTOR_VERSION . '</strong>'
		);
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
   }
    
   public function admin_notice_minimum_php_version(){
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
				esc_html__( '"%1$s" requires min PHP version "%2$s" running.', 'qanva-time-controlled-display' ),
				'<strong>' . esc_html__( 'Qanva Time Controlled Display', 'qanva-time-controlled-display' ) . '</strong>',
				'<strong>' . MINIMUM_PHP_VERSION . '</strong>'
		);
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
   }

	/** go **/
	public function init(){
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ) , [ $this, 'qanvatimecontrolmenue' ],10,1 );
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'qanvatimecontrolscripts' ] );
		add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'qanvatimecontrol_styles_admin' ] );
		add_action( 'wp_ajax_setqtcdisplay', [ $this, 'setqtcdisplay' ] );
		add_action( 'wp_ajax_checkqtcdisplay', [ $this, 'checkqtcdisplay' ] );
		add_action( 'wp_ajax_deleteqtcdisplay', [ $this, 'deleteqtcdisplay' ] );
		add_action( 'wp_ajax_setqtcuse', [ $this, 'setqtcuse' ] );
		add_action( 'admin_menu', [ $this, 'addextraqtcdhelp' ] );
		add_action( 'wp_footer', [ $this, 'addextraqtcdstyle' ] );
		add_action( 'wp_footer', [ $this, 'addicontopreview' ] );
	}
		
	public function qanvatimecontrolscripts(){
		$pageitemarr = [];
		$contArr = [];
		$saves = get_option('qanva_qtcd_times');
		foreach($saves AS $key => $arrb){
			$pageitemarr[] = explode('post-',$key)[1];
			$contArr[] = explode('-',$key)[2];
		}
			wp_enqueue_script('chosen', plugins_url( 'js/chosen.jquery.min.js', __FILE__ ), ['jquery','jquery-ui-core'], QANVATCD);
			wp_localize_script('chosen','chosenvals',[
				'single' => __( 'Select an Option', 'qanva-time-controlled-display' ),
				'multi' => __( 'Select Some Options', 'qanva-time-controlled-display' ),
			]);
     
			wp_enqueue_script('qanvatimecontroljs', plugins_url( 'js/qanvatimecontrol.js', __FILE__ ), ['jquery'], QANVATCD);
			wp_localize_script('qanvatimecontroljs','qanvatimecontroljsvals',[
				'ganzjahr' => __( 'Whole Year', 'qanva-time-controlled-display' ),
				'timez' => __( 'Select Timezone', 'qanva-time-controlled-display' ),
				'jahrmonate' => __( 'Whole Year or Months', 'qanva-time-controlled-display' ),
				'selectmonat' => __( 'Select Months', 'qanva-time-controlled-display' ),
				'selecttag' => __( 'Select Days', 'qanva-time-controlled-display' ),
				'Y' => __( 'Y', 'qanva-time-controlled-display' ),
				'M' => __( 'M', 'qanva-time-controlled-display' ),
				'on' => __( 'on', 'qanva-time-controlled-display' ),
				'off' => __( 'off', 'qanva-time-controlled-display' ),
				'onoff' => __( 'Use settings', 'qanva-time-controlled-display' ),
				'monate' => __( 'Months', 'qanva-time-controlled-display' ),
				'monata' => __( 'January', 'qanva-time-controlled-display' ),
				'monatb' => __( 'February', 'qanva-time-controlled-display' ),
				'monatc' => __( 'March', 'qanva-time-controlled-display' ),
				'monatd' => __( 'April', 'qanva-time-controlled-display' ),
				'monate' => __( 'May', 'qanva-time-controlled-display' ),
				'monatf' => __( 'June', 'qanva-time-controlled-display' ),
				'monatg' => __( 'July', 'qanva-time-controlled-display' ),
				'monath' => __( 'August', 'qanva-time-controlled-display' ),
				'monati' => __( 'September', 'qanva-time-controlled-display' ),
				'monatj' => __( 'October', 'qanva-time-controlled-display' ),
				'monatk' => __( 'November', 'qanva-time-controlled-display' ),
				'monatl' => __( 'December', 'qanva-time-controlled-display' ),
				'tage' => __( 'Days', 'qanva-time-controlled-display' ),
				'Mo' => __( 'Monday', 'qanva-time-controlled-display' ),
				'Tu' => __( 'Tuesday', 'qanva-time-controlled-display' ),
				'We' => __( 'Wednesday', 'qanva-time-controlled-display' ),
				'Th' => __( 'Thursday', 'qanva-time-controlled-display' ),
				'Fr' => __( 'Friday', 'qanva-time-controlled-display' ),
				'Sa' => __( 'Saturday', 'qanva-time-controlled-display' ),
				'Su' => __( 'Sunday', 'qanva-time-controlled-display' ),
				'Mok' => __( 'Mo', 'qanva-time-controlled-display' ),
				'Tuk' => __( 'Tu', 'qanva-time-controlled-display' ),
				'Wek' => __( 'We', 'qanva-time-controlled-display' ),
				'Thk' => __( 'Th', 'qanva-time-controlled-display' ),
				'Frk' => __( 'Fr', 'qanva-time-controlled-display' ),
				'Sak' => __( 'Sa', 'qanva-time-controlled-display' ),
				'Suk' => __( 'Su', 'qanva-time-controlled-display' ),
				'daterange' => __( 'or Date range', 'qanva-time-controlled-display' ),
				'from' => __( 'from date', 'qanva-time-controlled-display' ),
				'to' => __( 'to date', 'qanva-time-controlled-display' ),
				'fromhour' => __( 'from time hours', 'qanva-time-controlled-display' ),
				'tohour' => __( 'to time hours', 'qanva-time-controlled-display' ),
				'fromtominute' => __( 'minutes', 'qanva-time-controlled-display' ),
				'hideshow' => __( 'Hide or show on condition', 'qanva-time-controlled-display' ),
				'hide' => __( 'Hide', 'qanva-time-controlled-display' ),
				'show' => __( 'Show', 'qanva-time-controlled-display' ),
				'time' => __( 'Time', 'qanva-time-controlled-display' ),
				'oclock' => __( 'O\'clock', 'qanva-time-controlled-display' ),
				'select' => __( 'Please select', 'qanva-time-controlled-display' ),
				'hour' => __( 'Hour', 'qanva-time-controlled-display' ),
				'minute' => __( 'M', 'qanva-time-controlled-display' ),
				'alert' => __( 'Please check the marked settings', 'qanva-time-controlled-display' ),
				'oder' => __( 'or', 'qanva-time-controlled-display' ),
				'save' => __( 'Save', 'qanva-time-controlled-display' ),
				'deleteit' => __( 'Remove this segment', 'qanva-time-controlled-display' ),
				'qanva_done' => __( 'Done', 'qanva-time-controlled-display' ),
				'daynamevar' => [
				 __( "Sunday", "qanva-time-controlled-display" ),
				 __( "Monday", "qanva-time-controlled-display" ),
				 __( "Tuesday", "qanva-time-controlled-display" ),
				 __( "Wednesday", "qanva-time-controlled-display" ),
				 __( "Thursday", "qanva-time-controlled-display" ),
				 __( "Friday", "qanva-time-controlled-display" ),
				 __( "Saturday", "qanva-time-controlled-display" ),
			],
				'pageitems' => json_encode($pageitemarr),
				'pageid' => get_the_id(),
				'items' => json_encode($contArr),
				'iconfolder' => plugins_url('/img/',__FILE__),
		  ]);
			  wp_enqueue_style('qanva_tcd_chosen',plugins_url( 'css/chosen.min.css', __FILE__ ),true,QANVATCD,'all' );
			  wp_enqueue_style('qanva_tcd_ui',plugins_url( 'css/jquery-ui.min.css', __FILE__ ),true,QANVATCD,'all' );
			  wp_enqueue_style('qanva_tcd_uis',plugins_url( 'css/jquery-ui.structure.min.css', __FILE__ ),true,QANVATCD,'all' );
			  wp_enqueue_style('qanva_tcd_uit',plugins_url( 'css/jquery-ui.theme.min.css', __FILE__ ),true,QANVATCD,'all' );
	}
				
	public function init_controls(){
		require_once( __DIR__ . '/controls/qanvatimecontrol-control.php' );
		Qanvatimecontrolcontrols::init();
	}

	public function qanvatimecontrol_styles_admin() {
		wp_enqueue_style( 'qanvatimecontrolcss', plugins_url( 'css/qanvatimecontrol_admin.css', __FILE__ ), [ 'elementor-editor' ], QANVATCD);
   }
	    
    /** AJAX to save values **/
    public function setqtcdisplay(){
		$saves = [];
		if(!empty(get_option('qanva_qtcd_times'))){
			$saves = get_option('qanva_qtcd_times');
		}
		$postid = sanitize_text_field($_POST['postid']);
		$itemid = sanitize_text_field($_POST['itemid']);
		$timezone = sanitize_text_field($_POST['timezone']);
		$pos = '';
		$part = [];
					$key = '';
					$val = '';
     $partdata = [];
					if(strpos(sanitize_text_field($_POST['datastring']),'#') !== false){
						$dataparts = explode('#',sanitize_text_field($_POST['datastring']));
					}
					else{
						$dataparts[] = sanitize_text_field($_POST['datastring']);
					}

      for($i = 0;$i < count($dataparts);$i++){
       $partdata = explode(',',$dataparts[$i]);
							$partdataa['post-' . $postid . '-' . $itemid][$i] = [];
								for($y = 0;$y < count($partdata);$y++){
									$key = explode('=',$partdata[$y])[0];
									$val = explode('=',$partdata[$y])[1];
									$partdataa['post-' . $postid . '-' . $itemid][$i][$key] = $val;
								} 
      				$partdataa['post-' . $postid . '-' . $itemid][$i]['timezone'] = $timezone;
						}
      $newval = array_merge($saves, $partdataa);
      if(update_option('qanva_qtcd_times',$newval)){
       echo "OK";
      }
						wp_die();
    } 
    
    /** AJAX to check for setting **/
    public function checkqtcdisplay(){
     $saves = get_option('qanva_qtcd_times');
      if(isset($_POST['postid']) && isset($_POST['itemid']) && array_key_exists('post-' . sanitize_text_field($_POST['postid']) . '-' . sanitize_text_field($_POST['itemid']),$saves)){
       echo json_encode($saves['post-' . sanitize_text_field($_POST['postid']) . '-' . sanitize_text_field($_POST['itemid'])]);
      }
      else{
       echo "";
      }
						wp_die();
    }
    
    
    /** AJAX to delete values **/
    public function deleteqtcdisplay(){
     $saves = get_option('qanva_qtcd_times');
     $pageitemarrb = [];
     unset($saves['post-' . sanitize_text_field($_POST['postid']) . '-' . sanitize_text_field($_POST['itemid'])]);
      if(update_option('qanva_qtcd_times',$saves)){
     		$savesb = get_option('qanva_qtcd_times');
       foreach($savesb AS $key => $arrb){
        $pageitemarrb[] = explode('post-',$key)[1];
       }
       echo json_encode($pageitemarrb);
      }
						wp_die();
    }
    
    /** AJAX to "Use on/off" **/
    public function setqtcuse(){
     if(isset($_POST['use'])){
      $saves = get_option('qanva_qtcd_times');
      $allArr = $saves['post-' . sanitize_text_field($_POST['postid']) . '-' . sanitize_text_field($_POST['itemid'])];
      for($i = 0;$i < count($allArr);$i++){
       $allArr[$i]['onoff'] = sanitize_text_field($_POST['use']);print_r($allArr[$i]);
       $saves['post-' . sanitize_text_field($_POST['postid']) . '-' . sanitize_text_field($_POST['itemid'])][$i] = $allArr[$i];
      }
       update_option('qanva_qtcd_times',$saves);
        wp_die();
     }
    }
     
     
    public function addextraqtcdstyle(){
		include_once 'makecss.php';
		$pgid = 0;
		if(in_array(get_the_id(),$pageid)){
			$pgid = get_the_id();
		}
		if(!empty(get_option('qanva_qtcd_times')) && !isset($_GET['preview'])){
				echo '<style id="qtcd-' . $pgid . '">';
				echo esc_html($returncss);
				echo '</style>';
		}
		if(!empty(get_option('qanva_qtcd_times')) && isset($_GET['preview'])){
				echo '<style id="qtcd-' . time() . '">';
				echo $infocss;
				echo '</style>';
		}
    }
    
    public function addicontopreview(){
     $elementor_preview_active = \Elementor\Plugin::$instance->preview->is_preview_mode();
					if($elementor_preview_active){
						echo '<style id="qtcds-' . get_the_id() . '">';
						?>
							li[id^="qtcdicon-"]{
								cursor:pointer;
								height: 26px !important;
								width: 26px !important;
								background-color: #61d2f6 !important;
								background-image: url(<?php echo plugins_url('/img/clock.svg',__FILE__);?>) !important;
								background-position: center !important;
								background-size: 20px 20px !important;
								background-repeat: no-repeat !important;
							}
							.qtcdiconli{
								width:25px !important;
							}
						<?php
						echo '</style>';
     }
    }
 }
	
	 
		new Qanvatimecontrol();
