
<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js"></script>-->

<script type="text/javascript" charset="utf-8">

	$(document).ready(function() {

	    // page is now ready, initialize the calendar...

	   	var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		$('#calendar').fullCalendar({
			header: {
							left: 'prev,next today',
							center: 'title',
							right: 'month,agendaWeek,agendaDay'
						},
			eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {	
		
			var dt = new Date(event.start);   
			var yr = dt.getFullYear();
			var dy = dt.getDate()+1;
			var grabdate = dt.getDate();
			var mth = dt.getMonth()+1;
			if (mth < 10){
				var new_mth = "0"+mth;
			}else{
				var new_mth = mth;
			}
			if (grabdate < 10){
				var new_dy = "0"+grabdate;
			}else{
				var new_dy = grabdate;
			}
			var hrs = dt.getHours();
			var mns = dt.getMinutes();
			var grab_date = new_mth+' '+new_dy+' '+yr+' '+hrs+':'+mns+':'+'00'; 
			
			//var grab_date = "06 05 2011 10:300:00";
			
			
			var newdate = Date.parse(grab_date);
			var newdatetime = newdate.getTime();
			
			var newdatetime2 = newdatetime /1000;
	$.post(EE.BASE+"&C=addons_modules&M=show_module_cp&module=editorial&method=update&month="+new_mth+"&day="+new_dy+"&year="+yr+"&entry_date="+newdatetime2+"&entry_id="+event.id);
			
			},
			editable: false,
			events: [
				
				
				<?
				
				$count = count($events); 
				$i = 0;
				foreach($events as $event)
				{
					$i++;
					$var_dat = $event['day'];
					$var_year = $event['year'];
					//$var_month = $event['month'];
					$var_month = (string)$event['month'];
					$var_id = $event['id'];
					$var_channel = $event['channel'];
					$var_status = $event['status'];
					//make valid date
					$var_date = (string) $var_dat;
					$new_date = $var_date-1;
					//make url
					$url = BASE.AMP."D=cp&C=content_publish".AMP."M=entry_form".AMP."channel_id=$var_channel".AMP."entry_id=$var_id" ;
					$new_url = str_replace("&amp;","&",$url);
					//get time from time stamp
					$time = $event['time'];
					

					if($i == $count){
						$var_title = $event['title'];
						$new_title = str_replace('\'', '', $var_title);
						echo"{";
						echo "title: '$new_title',";
						echo "url: '$new_url',";
						echo "id: '$var_id',";
						echo "start  : '$var_year-$var_month-$var_dat ".date('h:i:s', $time)."',";
						//echo "start: new Date($var_year,$var_month,$var_dat,".date('H,i', $time)." ), ";
						echo "allDay: false,";
						echo "backgroundColor: 'red',";
						if($status_select == ''){
							
						}else{
							if($var_status == $status_select){
								echo "editable: true,";
								echo "className: \"draft\"";
							}else{
							echo "editable: false";
							}
						}
						echo "}";
					}else{
						$var_title = $event['title'];
						$new_title = str_replace('\'', '', $var_title);
						echo"{";
						echo "title: '$new_title',";
						echo "url: '$new_url',";
						echo "id: '$var_id',";
						echo "start  : '$var_year-$var_month-$var_dat ".date('h:i:s', $time)."',";
						//echo "start: new Date($var_year,$var_month,$var_dat,".date('h,i', $time)." ), ";
						echo "allDay: false,";
						echo "backgroundColor: 'red',";
						if($status_select == ''){
							
						}else{
							if($var_status == $status_select){
								echo "editable: true,";
								echo "className: \"draft\"";
							}else{
							echo "editable: false";
							}
						}
						echo "},";
					}
						
				    }
				?>
				
				
			
				
				
			],
			dayClick: function( date, allDay, jsEvent, views) {
				if (allDay) {
				            $('#calendar')
							     		     	.fullCalendar('changeView', 'agendaDay')
							     		     	.fullCalendar('gotoDate', date);
				        }else{
					
				            mth = date.getMonth()+1;
							if (mth < 10){
								var new_mth = "0"+mth;
							}else{
								var new_mth = mth;
							}

							var new_date = date.getFullYear()+"-"+new_mth+"-"+date.getDate()
							var hours = date.getHours();
							var mins = date.getMinutes();
							if(hours < 10){
								var new_hours = "0"+hours;
							}else{
								new_hours = hours;
							}
							if(mins < 29){
								var mins = "00";
							}

							var id = "<?echo $id?>";
									window.location = EE.BASE+"&D=cp&C=content_publish&M=entry_form&channel_id="+id+"&date="+new_date+"&time="+new_hours+"-"+mins;

									   return false;
				        }
				
				
					
				


			    }
		});
	

	});
</script>


<div id="calendar"></div>
<div style="clear:both"></div>

