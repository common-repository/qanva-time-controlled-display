<?php
use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Element_Base;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Css_Filter;

class Qanvatimecontrolcontrols{

	public static function init(){
		add_action( 'elementor/element/common/_section_responsive/after_section_end',  [ __CLASS__, 'qanvatimecontroladdcontrol' ], 1 );
	}
	
 public static function qanvatimecontroladdcontrol( Element_Base $element ){
		
		$element->start_controls_section(
			'qanva_tc_timecontrol',
			[
				'label' => __('Time Controlled Display', 'qanva-time-controlled-display'),
				'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
			]
		);
  			 
		$regions = array(
   'Africa' => DateTimeZone::AFRICA,
   'America' => DateTimeZone::AMERICA,
   'Antarctica' => DateTimeZone::ANTARCTICA,
   'Aisa' => DateTimeZone::ASIA,
   'Atlantic' => DateTimeZone::ATLANTIC,
   'Europe' => DateTimeZone::EUROPE,
   'Indian' => DateTimeZone::INDIAN,
   'Pacific' => DateTimeZone::PACIFIC
		);		
	
		$timezones = [];
		
		foreach ($regions as $name => $mask){
			$zones = DateTimeZone::listIdentifiers($mask);
				foreach($zones as $timezone){
					$time = new DateTime(NULL, new DateTimeZone($timezone));
					$date = new DateTime();
					$timeZone = $date->getTimezone();
					$local_tz = new DateTimeZone($timeZone->getName());
					$local = new DateTime('now', $local_tz);
					$user_tz = new DateTimeZone($timezone);
					$user = new DateTime('now', $user_tz);
					$local_offset = $local->getOffset() / 3600;
					$user_offset = $user->getOffset() / 3600;
					$diff = $user_offset - $local_offset;
					if('-' != substr($diff,0,1)){
						$diff = '+' . $diff;
					}
					$timezones[$name][$timezone] = substr($timezone, strlen($name) + 1) . "\n" . '( ' . $diff . ' ' .__('Hours', 'qanva-time-controlled-display' ) .')';
				}
		}
	
		$zonelist = '<span class="elementor-control-title" style="display:inline-block;margin-top:8px">' . __( 'Timezone', 'qanva-time-controlled-display' ) . '</span><div class="elementor-control-type-select elementor-control-input-wrapper elementor-control-unit-5" style="float:right;width:75%"><select data-setting="qanva_tc_times" id="tcdzones" class="chosen-select">';
		$zonelist .= '<option value="0">' . __( 'Select Timezone', 'qanva-time-controlled-display' ) . '</option>';
    foreach($timezones as $region => $list){
     $zonelist .= '<optgroup label="' . $region . '">';
     foreach($list as $timezone => $name){
      $zonelist .= '<option value="' . $timezone . '">' . $timezone . '</option>';
     }
     $zonelist .= '</optgroup>';
    }
    
    $zonelist .= '</select></div>';


  $element->add_control(
  'qanva_tc_times',
   [
    'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => $zonelist,
			]
		);

 
  $element->add_control(
  'qanva_tc_css',
   [
    'type' => \Elementor\Controls_Manager::RAW_HTML,
    'show_label' => false,
    'raw' => '<style>
     .elementor-control-qanva_tc_button{
     display:none;
     padding-bottom:5px;
     }
     .elementor-control-qanva_tc_button button, #qtcdsave{
     width:100% !important;height:26px
     }
     #qtcdsave{
      margin-top:5px
     }
     .centerit{
      text-align:center;
      font-weight:bold
     }
     [id^=qanvatcc-]{
     border-top:1px solid #e6e9ec;padding-top:10px
     }
     .qanvatcdtable{
     width:100%;margin-bottom:10px
     }
     .qanvatcdtable th{
     padding:0 0 5px 0
     }
     .qanvatcdtable th, #qtcmon{
     text-align:center
     }
     .qanvatcdtable.qtcselect tr:nth-of-type(3) td{
     padding-top:5px;text-align:initial
     }
     .datepicker{
     width: 100px;float: right;text-align: right;
     }
     .qanvatcdtable.collapsed{
      border-collapsed:collapsed
     }
     #qtcdhidetdi{
     text-align:center;padding:5px 0 0 0;cursor:pointer;
     }
     #qtcdshowtdi{
     text-align:center;padding:5px 0 0 0;width:50%;cursor:pointer;
					}
     #qtcdhidetd{
     text-align:center;padding:5px 0 0 0;
     }
     #qtcdshowtd{
     text-align:center;padding:5px 0 0 0;
					}
     #qtcdhidetd input, #qtcdshowtd input{
      display:none
     }
					#qtcdhidetdi div, #qtcdhidetd img, #qtcdshowtdi div, #qtcdshowtd img{
						cursor:pointer;
					}
     #qtcdhidetd img, #qtcdshowtd img{
      width:40px;filter: grayscale(100%);
     }
     #qtcdhidetd input:checked + img{
      filter: grayscale(0%);
     }
     #qtcdshowtd input:checked + img{
      filter: grayscale(0%);
     }
     div[id^=qtcddel-]{
     width:17px;height:17px;float:right;border:2px solid #6d7882;text-align:center;font-size:14px;cursor:pointer
     }
     #qanvatcdnotice{
     color:red;text-align:center;width:100%;padding: 0;
     }
     #delitemsetting{
     width:100%;height:24px;margin:5px 0
     }
     .chosen-container a{
     font-weight:normal
     }
     div[id^=monatesel]{
     display:none
     }
     input[type=checkbox][id^=mon-0-], input[type=checkbox][id=onOff] {
     display:none;
     }
     .switch {
     position: relative;
     display: inline-block;
     width: 50px;
     height: 24px;
     }
     .slider {
     position: absolute;
     cursor: pointer;
     top: 0;
     left: 0;
     right: 0;
     bottom: 0;
     background-color: #1e87f0;
     -webkit-transition: .4s;
     transition: .4s;
     }

     .slider:before {
     position: absolute;
     content: "";
     height: 22px;
     width: 22px;
     left: 1px;
     bottom: 1px;
     background-color: white;
     -webkit-transition: .4s;
     transition: .4s;
     }

     input:checked + .slider {
     background-color: #1e87f0;
     }
     input[id=onOff]:checked + .slider {
     background-color: #1e87f0;
     color:white
     }

     input:focus + .slider {
     box-shadow: 0 0 1px #2196F3;
     }

     input:checked + .slider:before {
     -webkit-transform: translateX(26px);
     -ms-transform: translateX(26px);
     transform: translateX(26px);
     }
     .slider.round {
     border-radius: 20px;
     color: white;
     width: 50px;
     padding: 5px 0 5px 6px;
     letter-spacing: 18px;
     }
     .slider.round.oo {
     background-color: #c4c4c4;
     color:#6d7882
     }

     .slider.round:before {
     border-radius: 12px;
     }
     .slider.round.oo{word-spacing:3px;
     letter-spacing:0
     }
     .chosen-container-single .chosen-search input[type="text"]{
      color:black
     }
					.seperator{
						border-top:1px solid #e6e9ec;
						padding-top: 8px;
						margin-top: 5px;
						text-align:justify;
						font-size:11px
					}
					.qtccenter{
						text-align:center;
						padding-top:3px
					}
    </style>
    <input type="hidden" id="qanvatcdacpost" value="' . get_the_id() . '"><input type="hidden" id="qanvatcdactive"><div id="qanvatcdnotice" class="elementor-control" style="display:none"><button class="elementor-button elementor-button-danger" id="delitemsetting" value="">' . __( 'Delete setting', 'qanva-time-controlled-display' ) . '</button></div><div class="seperator"><div class="qtccenter elementor-panel-heading-title">' . __( 'Info', 'qanva-time-controlled-display' ) . '!</div>' . __('We offer a PRO version where you can additionally select a date range, add multiple conditions and elements in the frontend get removed, instead of only hidden.', 'qanva-time-controlled-display') . '<div class="qtccenter">' . __('Check our offer at', 'qanva-time-controlled-display') . '<p><a href="https://qanva.tech/qanva-time-controlled-display">QANVA.TECH</a></div></div>',
   ]
  );

		
		$element->end_controls_section();

 }

}

?>