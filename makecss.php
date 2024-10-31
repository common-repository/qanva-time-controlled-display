<?php 

	$returncss = '';
	$infocss = '';
		$saves = get_option('qanva_qtcd_times');
     		foreach($saves AS $key => $arrb){
								$part = $saves[$key];
								$items[$key] = [];
								$mon = [];
								$timezone = [];
								$subarr = 0;
								$days2 = ['mo','tu','we','th','fr','sa','su'];
								$days3 = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
									foreach($part AS $keyb){
										$monproof = 0;
										for( $i = 0; $i < 12; $i++ ){
											$monproof = $monproof + $keyb['mon-' . $i ];
    						}
										if(0 != $monproof){
												/* months	*/
												for( $i = 0; $i < 13; $i++ ){
    									if(0 == $i && 1 == $keyb['mon-0']){$mon[$subarr] = range(1,12);}
    									if($i > 0 && 1 == $keyb['mon-' . $i]){$mon[$subarr] = [$i];}
												}
										}
										else{
											for( $i = 0; $i < 13; $i++ ){
												$mon[$subarr][$i] = 0;
											}
										}
										/* date range	*/
										$trange[$subarr] = [];
										if('' != $keyb['datefrom']){$trange[$subarr] = array_merge($trange[$subarr],[$keyb['datefrom']]);}
											else{$trange[$subarr] = array_merge($trange[$subarr],[0]);}
										if('' != $keyb['dateto']){$trange[$subarr] = array_merge($trange[$subarr],[$keyb['dateto']]);}
											else{$trange[$subarr] = array_merge($trange[$subarr],[0]);}
										/*	days */
										$days[$subarr] = [];
										for( $i = 0; $i < count($days2); $i++ ){
											if(1 == $keyb['day-' . $days2[$i]]){$days[$subarr] = array_merge($days[$subarr],[$days3[$i]]);}
											else{$days[$subarr] = array_merge($days[$subarr],['x']);}
   						 }	
										/* hours / minutes	*/
										$hours[$subarr] = [];
										$minutes[$subarr] = [];
										if(0 != $keyb['qtcd-fromhour']){$hours[$subarr][0] = $keyb['qtcd-fromhour'];}
										else{$hours[$subarr][0] = 0;}
										if(0 != $keyb['qtcd-tohour']){$hours[$subarr][1] = $keyb['qtcd-tohour'];}
										else{$hours[$subarr][1] = 0;}
										if(0 != $keyb['qtcd-fromminute']){$minutes[$subarr][0] = $keyb['qtcd-fromminute'];}
										else{$minutes[$subarr][0] = 0;}
										if(0 != $keyb['qtcd-tominute']){$minutes[$subarr][1] = $keyb['qtcd-tominute'];}
										else{$minutes[$subarr][1] = 0;}
										/* show or hide	*/
										$showhide[$subarr] = [];
										if(1 == $keyb['qtcd-hide']){$showhide[$subarr] = 'none';}
										if(1 == $keyb['qtcd-show']){$showhide[$subarr] = 'block';}
										
										if( isset( $keyb['timezone'] ) ) {
											$timezone[] = $keyb['timezone'];
										}
												$pageid[$subarr] = explode('-',$key)[1];
												$itemid[$subarr] = explode('-',$key)[2];
													$subarr++;
													
										$ison = 1;			
										if(0 == $keyb['onoff']){
											$ison = 0;
										}
									}
				#		}
						###########################################
								date_default_timezone_set($timezone[0]);
								for( $i = 0; $i < $subarr; $i++ ){
         $proofm = 0;
         $proofdr = 0;
         $proofdd = 0;
         $proofhms = 0;
         $proofhme = 0;
         $proofclock = 0;
         /** month numeric **/
									if(in_array(date('n'),$mon[$i]) || 1 == $mon[0]){$proofm = 1;}
         /** day 3 letter **/
				 				if(in_array(date('D'),$days[$i])){$proofdd = 1;}
         $alldays = 0;
         for($yx = 0;$yx < 7;$yx++){
          if('x' == $days[0][$yx]){$alldays++;}
         }
         if(7 == $alldays){$proofdd = 1;}
         /** hours 24 / minutes **/
         if('x' != $hours[$i][0] && 'x' != $hours[$i][1]){
          $proofclock = 1;
										############# Anfang erreicht == 1 ##############
										/** Anfang Std kleiner End Std **/
										if($hours[$i][0] < $hours[$i][1]){
											if(date('G') . intval(date('i')) >= intval($hours[$i][1] . $minutes[$i][1])){$proofhms = 1;}
										}
										/** Anfang Std größer End Std **/
										if($hours[$i][0] > $hours[$i][1]){
											if(0 == $minutes[$i][1]){
												if(date('G') < $hours[$i][1]){$proofhms = 1;}
											}
           else{
												if(date('Gi') < $hours[$i][1] . $minutes[$i][1]){$proofhms = 1;}
											}
										}
										/** Anfang Std gleich End Std **/
										if($hours[$i][0] == $hours[$i][1]){
											if(date('G') == $hours[$i][0] && intval(date('i')) >= $minutes[$i][0]){$proofhms = 1;}
										}
										
										############# Ende nicht erreicht == 1 ##############
										/** Anfang Std kleiner End Std **/
										if($hours[$i][0] < $hours[$i][1]){
											$add = '';
											if($minutes[$i][1] == 0){$add = '0';}
											if(date('G') . intval(date('i')) >= intval($hours[$i][1] . $minutes[$i][1] . $add)){$proofhme = 1;}
										}
										/** Anfang Std größer End Std **/
										if($hours[$i][0] > $hours[$i][1]){
											if(0 == $minutes[$i][0]){
												if(date('G') < $hours[$i][1] ){$proofhme = 1;}
											}
										}
										/** Anfang Std gleich End Std **/
										if($hours[$i][0] == $hours[$i][1]){
											if(intval(date('i')) > $minutes[$i][1]){$proofhme = 1;}
										}
         }
									
         if('' != strtotime($trange[$i][0] . date("Y")) && '' != strtotime($trange[$i][1] . date("Y"))){
          if(strtotime($trange[$i][0] . date('Y')) <= time() && strtotime($trange[$i][1] . date('Y')) >= time()){$proofdr = 1;}
         }
									
									/** Anfang Std kleiner Startstd **/
									if($hours[$i][0] > intval(date('H'))){
										$proofhms = 0;
										$proofdr = 0;
									}
										        
         $trueval = 0;

								if(1 == $ison){
									if(1 == $proofm && 1 == $proofdd && 0 == $proofhms && 0 == $proofhme && 0 == $proofdr && 0 == $proofclock){
										$trueval = 1;
									}
								
									if(1 == $proofm && 1 == $proofdd && 1 == $proofhms && 0 == $proofhme && 0 == $proofdr){
										$trueval = 1;
									}
								
									if(0 == $proofm && 1 == $proofdd && 0 == $proofhms && 0 == $proofhme && 1 == $proofdr){
										$trueval = 1;
									}
								
									if(0 == $proofm && 1 == $proofdd && 1 == $proofhms && 1 == $proofhme && 1 == $proofdr){
										$trueval = 1;
									}
								
									if(0 == $proofm && 1 == $proofdd && 1 == $proofhms && 1 == $proofhme && 0 == $proofdr){
										$trueval = 1;
									}
									
									if(1 == $proofdr && 1 == $proofdd && 1 == $proofhms && 0 == $proofhme){
										$trueval = 1;
									}

										if(1 == $trueval){
											$returncss .= '.elementor-element-' . $itemid[$i] . '{display:' . $showhide[$i] . '}';
										}
										$infocss = '.elementor-element-' . $itemid[$i] . '::after{content:"Timed Display";position:relative;left:calc(50% - 50px);top:-35%;background:yellow;z-index:-1}';
								} 
    				
								}
						}

?>