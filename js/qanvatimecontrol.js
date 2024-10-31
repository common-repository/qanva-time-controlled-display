 var $ = jQuery;
 
  
$(document).ready(function(){
  
		/** hour generator for time select **/
		var qtcdhoursf = '<option value="x">' + qanvatimecontroljsvals.hour + '</option>';
		var qtcdhourst = '<option value="x">' + qanvatimecontroljsvals.hour + '</option>';
		for(var i = 0;i < 24;i++){
			qtcdhoursf += '<option value="' + i + '">' + i + ' ' + qanvatimecontroljsvals.oclock + '</option>';
			qtcdhourst += '<option value="' + i + '">' + i + ' ' + qanvatimecontroljsvals.oclock + '</option>';
		}
  
		/** Inject HTML **/
  $(document).on('click','[data-event=qanva-add-condition]',function(){
   startInjection([]);
   startCheck();
  });
  
  function startInjection(saveArr){
    var qcount = $('div[id^=qanvatcc]').length;
			if('undefined' == qcount){
				qcount = 0;
			}
		/** gespeicherte Werte **/
      var checkIt = ['checked',0,0,0,0,0,0,0,0,0,0,0,0,'','',0,0,0,0,0,0,0,'x',0,'x',0,'','','',0,1];
			var fullArr = 0;
			var MonArr = [''];
			var DayArr = [];
			var toInserte = '';
			if(saveArr.length > 0){
				for(var y = 0;y < saveArr.length;y++){
					if(parseInt(saveArr[0]) == 0){
            checkIt[0] = '';
          }
    
					if('' != saveArr[13] && '' != saveArr[14]){
						checkIt[13] = saveArr[13];
						checkIt[14] = saveArr[14];
					}
					for(var q = 1;q < 13;q++){
						if('' != parseInt(saveArr[q])){
							checkIt[q] = 1;
						//	checkIt[29] = 1;
       MonArr.push('mon-' + q + '-' + qcount);
						}
					}
					for(var t = 15;t < 22;t++){
						if('' != parseInt(saveArr[t])){
							checkIt[t] = 1;
       switch(t){
        case 15: day_s = 'mo';break;
        case 16: day_s = 'di';break;
        case 17: day_s = 'we';break;
        case 18: day_s = 'th';break;
        case 19: day_s = 'fr';break;
        case 20: day_s = 'sa';break;
        case 21: day_s = 'su';break;
       }
							DayArr.push('day-' + day_s + '-' + qcount);
						}
					}
					
					if('x' != saveArr[22]){
						checkIt[22] = parseInt(saveArr[22]);
					}
					checkIt[23] = parseInt(saveArr[23]);
					if('x' != saveArr[24]){
						checkIt[24] = parseInt(saveArr[24]);
					}
					checkIt[25] = parseInt(saveArr[25]);
					
					if(parseInt(saveArr[26]) == 1){
						checkIt[26] = ' checked';
					}
					if(parseInt(saveArr[27]) == 1){
						checkIt[27] = ' checked';
					}
					if('' != saveArr[28]){
						checkIt[29] = saveArr[29];
					}
					checkIt[28] = saveArr[28];
				}
							
				/** Ein/Aus Schalter **/
					var sStatus = '';
					if(1 == checkIt[28]){sStatus = 'checked';}
						if($(document).find('.onoffswitch').length == 0){
						toInserte = '<table class="qanvatcdtable onoffswitch"><tbody><tr><td>' + qanvatimecontroljsvals.onoff + '</td><td><label for="onOff" class="switch"><input type="checkbox" id="onOff" value="1" ' + sStatus + '><span class="slider round oo">' + qanvatimecontroljsvals.on + ' ' + qanvatimecontroljsvals.off + '</span></label></td></tr></tbody></table>';
					}
				fullArr = 1;
			}
			
			
   
   /** Monate als Select **/
   var monate = '<select class="chosen-select monate" id="monatesel-' + qcount + '" multiple>';
   var allmonth = ['',qanvatimecontroljsvals.monata,qanvatimecontroljsvals.monatb,qanvatimecontroljsvals.monatc,qanvatimecontroljsvals.monatd,qanvatimecontroljsvals.monate,qanvatimecontroljsvals.monatf,qanvatimecontroljsvals.monatg,qanvatimecontroljsvals.monath,qanvatimecontroljsvals.monati,qanvatimecontroljsvals.monatj,qanvatimecontroljsvals.monatk,qanvatimecontroljsvals.monatl];
   for(var i = 1;i < allmonth.length;i++){
				var adderM = '';
				if(checkIt[i] == 1){adderM = 'checked';}
    monate += '<option id="mon-' + i + '-' + qcount + '" value="mon-' + i + '-' + qcount + '" ' + adderM + '>' + allmonth[i] + '</option>';
   }
   monate += '</select>';
   
   /** Tage als Select **/
   var tage = '<select class="chosen-select tage tage" id="tagesel-' + qcount + '" multiple >';
   var alletage = [qanvatimecontroljsvals.Mo,qanvatimecontroljsvals.Tu,qanvatimecontroljsvals.We,qanvatimecontroljsvals.Th,qanvatimecontroljsvals.Fr,qanvatimecontroljsvals.Sa,qanvatimecontroljsvals.Su];
			var tagkurz = ['mo','tu','we','th','fr','sa','su'];
   for(var i = 0;i < alletage.length;i++){
				var adderD = '';
				if(checkIt[i + 15] == 1){adderD = 'checked';}
				tage += '<option id="day-' + tagkurz[i] + '-' + qcount + '" value="day-' + tagkurz[i] + '-' + qcount + '" ' + adderD + '>' + alletage[i] + '</option>';
   }
   tage += '</select>';
			
   
   var toInserta = '<div class="elementor-control" id="qanvatcc-' + qcount +'">';
   /** all year or specific months **/
   var toInsertb = '<table class="qanvatcdtable qtcselect"><tbody><tr><th>' + qanvatimecontroljsvals.jahrmonate + '</th></tr><tr><td id="qtcmon"><label for="mon-0-' + qcount + '" class="switch"><input type="checkbox" id="mon-0-' + qcount + '" value="1" ' + checkIt[0] + '><span class="slider round">' + qanvatimecontroljsvals.Y + '' + qanvatimecontroljsvals.M + '</span></label></td></tr><tr><td>' + monate + '</td></tr></table>';

   /** weekdays **/
  	toInsertb += '<table class="qanvatcdtable"><tbody><tr><th>' + qanvatimecontroljsvals.tage +  '</th></tr><tr><td>' + tage + '</td></tr></tbody></table>';
 
   /** from time to time **/
   toInsertb += '<table class="qanvatcdtable" id="qtcdtime-' + qcount + '"><tbody><tr><th colspan="3">' + qanvatimecontroljsvals.time + '</th></tr><tr><td id="qtcd">' + qanvatimecontroljsvals.fromhour + ' / ' + qanvatimecontroljsvals.fromtominute + '</td><td id="qtcd"><select class="qtcdselect" id="qtcd-fromhour-' + qcount + '">' + qtcdhoursf + '</select></td><td id="qtcd"><select class="qtcdselect" id="qtcd-fromminute-' + qcount + '">0<option value="0">00</option><option value="15">15</option><option value="30">30</option><option value="45">45</option></select></td></tr><tr><td id="qtcd">' + qanvatimecontroljsvals.tohour + ' / ' + qanvatimecontroljsvals.fromtominute + '</td><td id="qtcd"><select class="qtcdselect" id="qtcd-tohour-' + qcount + '">' + qtcdhourst + '</select></td><td id="qtcd"><select class="qtcdselect" id="qtcd-tominute-' + qcount + '">0<option value="0">00</option><option value="15">15</option><option value="30">30</option><option value="45">45</option></select></td></tr></tbody></table>';

   toInsertb += '<table class="qanvatcdtable collapsed"><tbody><tr><th colspan="2">' + qanvatimecontroljsvals.hideshow + '</th></tr><tr><td id="qtcdhidetdi"><label for="qtcd-hide-' + qcount + '"><div>' + qanvatimecontroljsvals.hide + '</div></label></td><td id="qtcdshowtdi"><label for="qtcd-show-' + qcount + '"><div>' + qanvatimecontroljsvals.show + '</div></label></td></tr><tr><td id="qtcdhidetd"><label for="qtcd-hide-' + qcount + '"><input type="radio" name="qtcdshowhide-' + qcount + '" id="qtcd-hide-' + qcount + '" value="1" ' + checkIt[26] + ' autocomplete="off"><img src="' + qanvatimecontroljsvals.iconfolder + 'hidden.png"></label></td><td id="qtcdshowtd"><label for="qtcd-show-' + qcount + '"><input type="radio" name="qtcdshowhide-' + qcount + '" id="qtcd-show-' + qcount + '" value="1" ' + checkIt[27] + ' autocomplete="off"><img src="' + qanvatimecontroljsvals.iconfolder + 'visible.png"></label></td></tr></tbody></table>';
   
   
   /** more than 1 condition **/
   var toInsertc = '<table class="qanvatcdtable"><tbody><tr><td><div id="qtcddel-' + qcount + '" title="' + qanvatimecontroljsvals.deleteit + '">X</div></td></tr></tbody></table>';
   var toInsertd = '</div>';

			
   
   if(0 < qcount &&  0 == saveArr.length){
    $(toInserta + toInsertb + toInsertc + toInsertd).insertAfter($('#qanvatcc-' + (qcount-1)));
    $(document).find('#qtcdsave').remove();
    $(document).find('.centerit').remove();
   }
   else{
    $(toInserta + toInsertb + toInserte + toInsertd).insertAfter($(document).find('.elementor-control-qanva_tc_times'));
   }
   
			setTimeout(function(){
				if(fullArr == 1){
					$('#qtcd-fromhour-' + qcount + ' option[value=' + checkIt[22] + ']').prop('selected',true);
					$('#qtcd-fromminute-' + qcount + ' option[value=' + checkIt[23] + ']').prop('selected',true);
					$('#qtcd-tohour-' + qcount + ' option[value=' + checkIt[24] + ']').prop('selected',true);
					$('#qtcd-tominute-' + qcount + ' option[value=' + checkIt[25] + ']').prop('selected',true);
					$("#tcdzones").val(checkIt[29]).trigger("chosen:updated");
					$('#monatesel-' + qcount).val(MonArr).trigger('chosen:updated');
					if(checkIt[29] == 1){
						$(document).find('#monatesel_' + qcount + '_chosen').css({'display':'block'});
					}
					$('#tagesel-' + qcount).val(DayArr).trigger('chosen:updated');
				}
					},500);

  }

   /** remove injected html **/
   function startCheck(){
    var closeInsertHtml = setInterval(function(){
						if($(document).find('.elementor-control-qanva_tc_times').length == 0 && $(document).find('[id^=qanvatcc-]').length){
							$(document).find('#qanvatcdnotice').remove();
							$('[id^=qanvatcc-]').each(function(){
								$(this).remove();
							});
						}
						else if($(document).find('.elementor-control-qanva_tc_times').length == 0 && $(document).find('[id^=qanvatcc-]').length == 0){
							clearInterval(closeInsertHtml);
						}
					},200);
   }

  $(document).on('click','[id^=qtcddel-]',function(){
   var toDel = $(this).attr('id').split('-')[1];
   $(document).find('#qanvatcc-' + toDel).remove();
    $('<div class="elementor-control centerit">' +qanvatimecontroljsvals.oder + '<br><button id="qtcdsave" class="elementor-button elementor-button-success">' + qanvatimecontroljsvals.save + '</button>').insertAfter($('.elementor-control-qanva_tc_button'));
  })
  
  /** temporarly save time-difference **/
  var checkTCD = setInterval(function(){
   if(document.querySelector('[data-setting=qanva_tc_times]') != null){
    setTimevals();
   }
  },500);
  
  $(document).on('change','[data-setting=qanva_tc_times]',function(){
   if($(document).find('[id^=qanvatcc-]').length == 0){
    startInjection([]);
   }
   setTimevals();
			startCheck();
  });

		/** read saved IDs of items and delete or add some **/
		var pageid = qanvatimecontroljsvals.pageid;
		var contID = JSON.parse(qanvatimecontroljsvals.items);
				function settDelete(delID,qtcdStatus){
					if(0 == qtcdStatus){
						const theIndex = contID.indexOf(delID);
						if(theIndex > -1){
							contID.splice(theIndex,1);
						}
							deleteicons(delID);
					}
					if(1 == qtcdStatus){
						contID.push(delID);
					}
				}
					
  function setTimevals(){
   if(0 != $(document).find('[data-setting=qanva_tc_times]').val()){
    clearInterval(checkTCD);
    $('.elementor-control-qanva_tc_button').show();  
   }
   else{
    $('.elementor-control-qanva_tc_button').hide();
   }
  };
  
		/** Interval to save values and add events to injected elements **/
  setInterval(function(){
			/** get id of active element **/
   var activeID = $('#elementor-preview-iframe').contents().find('.elementor-element-editable').attr('data-id');
			if( 'undefined' != activeID){
				$('#qanvatcdactive').val(activeID);
			}


   $('#delitemsetting').val($(document).find('#qanvatcdacpost').val() + '/' + activeID );
   
     if($('#elementor-preview-iframe').contents().find('.elementor-element-' + activeID).length > 0 && $(document).contents().find('.elementor-control-qanva_tc_times').length > 0){
						if($('#elementor-preview-iframe').contents().find('#qtcdicon-' + activeID).length < 1 && contID.includes(activeID) !== false){
								$('#elementor-preview-iframe').contents().find('[data-id=' + activeID + '] .elementor-editor-element-settings').append('<li class="elementor-editor-element-setting elementor-editor-element-edit qtcdiconli" title="Time Controlled Display" onclick="window.parent.iconclick()" id="qtcdicon-' + activeID + '"></li>');
						}
     }  

    readpageitems(qanvatimecontroljsvals.pageitems,activeID);

  },1000);
  
  /** AJAX to check if got settting **/
  function readpageitems(values,activeID){		
			var data = {
						'action' : 'checkqtcdisplay',
						'postid' : $(document).find('#qanvatcdacpost').val(),
						'itemid' : $(document).find('#qanvatcdactive').val(),
					};
					jQuery.post(ajaxurl, data, function(response){
						if('' != response){
							var obj = JSON.parse(response);
							$('#qanvatcdnotice').css('display','block');
								if($(document).find('[id^=qanvatcc-]').length < obj.length && obj.length){
									for(var i = 0;i < obj.length;i++){
										var valarr = [];
										for (var x in obj[i]) {
											valarr.push( obj[i][x] );
										}
											startInjection(valarr);
									}
								}
						}
   		});
  }
  
  function getInjects(){
   var InjCount = $('div[id^=qanvatcc]').length - 1;
   return InjCount;
  }
		
  $(document).on('change','[id^=mon-0]',function(){
			var indID = $(this).attr('id').split('-');
			if($(this).is(':checked')){
				$(this).val(1);
				$(document).find('#monatesel_' + indID[2] + '_chosen').css({'display':'none'});
					$('#monatesel-' + getInjects()).val(0).trigger('chosen:updated');
			}
			else{
				$(document).find('#monatesel_' + indID[2] + '_chosen').css({'display':'block'});
			}
  });
  
		/** add save button **/
		$(document).on('change','[id^=qtcd-show],[id^=qtcd-hide]',function(){
   if($('#qtcdsave').length == 0){
    $('<div class="elementor-control centerit"><button id="qtcdsave" class="elementor-button elementor-button-success">' + qanvatimecontroljsvals.save + '</button>').insertAfter($('#qanvatcc-0'));
   }
		});
  
  /**  AJAX send values to save  **/
  $(document).on('click','#qtcdsave',function(){
			/* check selected values */
   var qcount = $('div[id^=qanvatcc]').length;
			var checkCombi = '';
			for(var x = 0;x < qcount;x++){
				var datf = '';
				var datt = '';
				var timehf = $(document).find('#qtcdfromhour-' + x).val();
				var timeht = $(document).find('#qtcdtohour-' + x).val();
				if('' != datf && '' == datt){checkCombi += 'qtcdrange-' + x + ';';}
				if('x' != timehf && 'x' == timeht){checkCombi += 'qtcdtime-' + x + ';';}
			}
			if('' != checkCombi){
				var checkStr = checkCombi.substring(0,checkCombi.length -1);
				for(var y = 0;y < checkStr.split(';').length;y++){
					$('#' + checkStr.split(';')[y]).css('border','1px solid red');
				}
				alert(qanvatimecontroljsvals.alert + '!');
			}
			else{
				var qtcdvalid = [];
				$('[id^=qanvatcc]').each(function(){
					qtcdvalid.push(parseInt($(this).attr('id').split('-')[1]));
				});
				var qdtaval = '';
				var isVal = '';
				var fulListe = [];
				for(var i = 0;i < qtcdvalid.length;i++){
					var valListe = {'mon-0':'0','mon-1':'0','mon-2':'0','mon-3':'0','mon-4':'0','mon-5':'0','mon-6':'0','mon-7':'0','mon-8':'0','mon-9':'0','mon-10':'0','mon-11':'0','mon-12':'0','datefrom':'','dateto':'','day-mo':'0','day-tu':'0','day-we':'0','day-th':'0','day-fr':'0','day-sa':'0','day-su':'0','qtcd-fromhour':'x','qtcd-fromminute':'0','qtcd-tohour':'x','qtcd-tominute':'0','qtcd-hide':'0','qtcd-show':'0','onoff':'1'};
					
					$('#qanvatcc-' + qtcdvalid[i] + ' :input:not(.chosen-search-input):not(.chosen-select):not(.qtcselect):not(button)').each(function(){
						var thisId = [];
						var txtID = [];
						var selID = [];
						if($(this).is(':checked') || $(this).prop('type') == 'text' || $(this).hasClass('qtcdselect')){
       if($(this).prop('type') == 'text'){
        if('' != $(this).val()){
          isVal = $(this).val();
        }
        else{
          isVal = '';
        }
								txtID = $(this).attr('id').split('-');
								valListe[txtID[0]] = isVal;
       }
       if($(this).prop('type') != 'text'){
        if($(this).val()){
         isVal = $(this).val();
        }
        else{
         isVal = 0;
        }
								selID = $(this).attr('id').split('-');
								valListe[selID[0] + '-' + selID[1]] = isVal;
       }
       
						}
						
      var isValb = $('#tagesel-' + qtcdvalid[i]).chosen().val();
      if(isValb.length > 0){
        isValb.forEach(function(item){
          var thisIdb = item.split('-');
          if(thisIdb.length == 3){
											valListe[thisIdb[0] + '-' + thisIdb[1]] = 1;
          }
        });
      }
						
      var isValc = $('#monatesel-' + qtcdvalid[i]).chosen().val();
      if(isValc.length > 0){
        isValc.forEach(function(item){
          var thisIdc = item.split('-');
          if(thisIdc.length == 3){
											valListe[thisIdc[0] + '-' + thisIdc[1]] = 1;
          }
        });
      }
						
						fulListe[qtcdvalid[i]] = valListe;
					});
      
				}
						
						for(var y = 0;y < fulListe.length;y++){
							for(let key in fulListe[y]){
								if(key == 'onoff'){
									qdtaval += key + '=' + fulListe[y][key] + '#';
								}
								else{
									qdtaval += key + '=' + fulListe[y][key] + ',';
								}
							}
						}
								qdtaval = qdtaval.substr(0,qdtaval.length -1);
					//	console.log( qdtaval );
						var data = {
							'action' : 'setqtcdisplay',
							'postid' : $(document).find('#qanvatcdacpost').val(),
							'itemid' : $(document).find('#qanvatcdactive').val(),
							'timezone' : $('#tcdzones').chosen().val(),
							'datastring' : qdtaval,
						};
						/**/
						jQuery.post(ajaxurl, data, function(response){
							if('' != response){
								$(document).find('#qtcdsave').css({'background':'white','color':'#39b54a','border':'1px solid black'});
								$(document).find('#qtcdsave').text(qanvatimecontroljsvals.qanva_done);
								setTimeout(function(){
									$(document).find('#qtcdsave').css({'background':'#39b54a','color':'white','border':'none'});
									$(document).find('#qtcdsave').text(qanvatimecontroljsvals.save);								
								},1000);
							}
							// alert(response);
						});
						
							settDelete($(document).find('#qanvatcdactive').val(),1);
			}
  });
		
		
			/**  AJAX save "Use settings"  **/
			$(document).on('change','#onOff',function(){
				var isON = 0;
				if(true === $(this).is(':checked')){
					isON = 1;
				}
						var data = {
							'action' : 'setqtcuse',
							'postid' : $(document).find('#qanvatcdacpost').val(),
							'itemid' : $(document).find('#qanvatcdactive').val(),
							'use' : isON,
						};
						jQuery.post(ajaxurl, data, function(response){
              console.log( response );
            });
			});
			
			/** Delete all values **/
			$(document).on('click','#delitemsetting',function(){
    var ActiveID = $(document).find('#qanvatcdactive').val();
				var datadel = {
							'action' : 'deleteqtcdisplay',
							'postid' : $(document).find('#qanvatcdacpost').val(),
							'itemid' : ActiveID,
						};
						jQuery.post(ajaxurl, datadel, function(response){
						//	if('' != response){
								readpageitems(response,ActiveID);
								$('#qanvatcdnotice').hide();
								$('[id^=qanvatcc-]').remove();
								$('.centerit').remove();
								$("#tcdzones").val(0).trigger("chosen:updated");
								$('.elementor-control-qanva_tc_button').hide();
						//	}
						});
							settDelete(ActiveID,0);
							startCheck();
			});
			
			var chosencheck = setInterval(function(){
				if($(document).find(".chosen-select").length > 0){
					$(document).find(".chosen-select").each(function(){
						if($(this).css('display') != 'none'){
							if($(this).hasClass('monate')){
								$(this).chosen({placeholder_text_multiple:qanvatimecontroljsvals.selectmonat});
							}
							if($(this).hasClass('tage')){
								$(this).chosen({placeholder_text_multiple:qanvatimecontroljsvals.selecttag});
							}
						}
						$('#tcdzones').chosen({placeholder_text_single:qanvatimecontroljsvals.timez});
					});
					//	clearInterval(chosencheck);
					}
			});
			
			/** insert icon for saved settings **/
			var timecontainer = setInterval(function(){
					for(var i = 0;i < contID.length;i++){
						if($('#elementor-preview-iframe').contents().find('.elementor-element-' + contID[i]).length > 0){
							if($('#elementor-preview-iframe').contents().find('#qtcdicon-' + contID[i]).length < 1){
								$('#elementor-preview-iframe').contents().find('[data-id=' + contID[i] + '] .elementor-editor-element-settings').append('<li class="elementor-editor-element-setting elementor-editor-element-edit qtcdiconli" title="Time Controlled Display" onclick="window.parent.iconclick()" id="qtcdicon-' + contID[i] + '"></li>');
							}
						}
					}			
					startCheck();
			},500);
		
			/** delete icon after deleting settings **/
			function deleteicons(deleteID){
				var routine = setInterval(function(){
					if($('#elementor-preview-iframe').contents().find('li[id=qtcdicon-' + deleteID + ']').remove()){
						clearInterval(routine);
					}
				},300);
			}

});		
	
		/** open our widget **/
		function iconclick(){
			setTimeout(function(){
				$(document).find('.elementor-tab-control-advanced').click();
				$('.elementor-control-qanva_tc_timecontrol').click();
			},200);
		}