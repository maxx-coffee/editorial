<?


echo "<form id=\"form\" >";
echo "<p>Select the channel you would like to display on EEditorial Calendar</p><br>";
echo "<select id=\"channels\"    >";

	foreach($channels as $channel)
	{
		if($event_id == $channel['channel']){
			echo "<option class=\"channels\" name=\"channels\" selected value=\"$channel[channel]\">$channel[name]</option>";
		}else{
			echo "<option class=\"channels\" name=\"channels\" value=\"$channel[channel]\">$channel[name]</option>";
		}
		
	}

echo "</select><br>";
echo "<p>Select the status that will be editable</p>";
echo "<select class=\"result\">";
if ($status_names !=''){
	foreach ($status_names->result() as $row)
	{
	    if($event_status == $row->status){
		echo "<option selected value=\"".$row->status."\">".$row->status."</option>";
		}else{
			echo "<option value=\"".$row->status."\">".$row->status."</option>";
		}
	}
}

echo "</select>";
echo "</form>"; 
?>

<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
		$("#channels").change(function(){
			event.preventDefault()
			var channels = $('#channels ').val();
			$.post(EE.BASE+"&C=addons_modules&M=show_module_cp&module=editorial&method=settings_submit&channels="+channels, function(data) {
			  	$.get(EE.BASE+"&C=addons_modules&M=show_module_cp&module=editorial&method=find_status&channels="+channels, function(data) {
				  $('.result').html(data);
				});
			});
		});
		});
		
		$(".result").change(function(){
			var editorial_status = $('.result').val();
			$.get(EE.BASE+"&C=addons_modules&M=show_module_cp&module=editorial&method=status_update&editorial_status="+editorial_status, function(data) {
				alert(data);
			});
		});
		
		 
</script>
