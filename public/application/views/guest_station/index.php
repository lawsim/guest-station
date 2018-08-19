<?php
	echo form_open('guest_station/checkin_guest');
	echo form_hidden('stationid',$station_info->stationid);
	echo form_hidden('site',$station_info->site);
	echo form_hidden('location',$station_info->location);
	// print_r($station_info);
?>


<?php

	if(SHOW_CHECKOUT)
	{
		echo '<div><a href="' . site_url('guest_station/checkout') . '" class="ui-btn" data-ajax="false">Click here to check out</a></div>';
	}

	echo '<div id="results"><?php echo $message; ?></div>';
	if(CAPTURE_PHOTO)
	{
		echo '<div id="my_camera"></div><br />';
	}

?>

<label for="text-basic">Full Name:</label>
<input type="text" name="name" id="name" />
<br />
<label for="text-basic">Reason for visit:<?php echo MAX_REASON_LEN ? "(Max " . MAX_REASON_LEN . " characters)" : false; ?></label>
<input type="text" name="reason" id="reason" <?php echo MAX_REASON_LEN ? 'maxlength="' . MAX_REASON_LEN . '"' : false; ?> />
<input type="button" value="Click here to check-in" id="submit">

</form>

<?php if(CAPTURE_PHOTO): ?>
<!-- First, include the Webcam.js JavaScript Library -->
<script src="<?php echo base_url();?>assets/webcam.min.js"></script>

<!-- Configure a few settings and attach camera -->
<script language="JavaScript">
	Webcam.set({
		width: 320,
		height: 320,
		dest_width: 480,
		dest_height: 480,
		image_format: 'jpeg',
		jpeg_quality: 90
	});
	Webcam.attach( '#my_camera' );
</script>


<!-- Code to handle taking the snapshot and displaying it locally -->
<script language="JavaScript">
     // bind event handler
     $('#submit').click($.throttle(4000,take_snapshot));

	function take_snapshot() {
		var fname = $("#name").val();
        
        if( !$("#name").val() || !$("#reason").val())
        {
            document.getElementById('results').innerHTML = "You cannot leave name or reason blank";
            return;
        }
		// take snapshot and get image data
		Webcam.snap( function(data_uri) {
			// display results in page
			
			$.post( "<?php echo base_url(); ?>" + "index.php/guest_station/checkin_guest", { 
				fullname: fname,
				stationid: $("input[name=stationid]").val(),
				site: $("input[name=site]").val(),
				location: $("input[name=location]").val(),
				reason: $("input[name=reason]").val(),
				imguri: data_uri
			})
			.done(function( data ) {
				console.log(data);
				document.getElementById('results').innerHTML = data;
                $('#name').val('');
                $('#reason').val('');
				/*document.getElementById('results').innerHTML = 
					'<h2>Here is your large image:</h2>' + 
					'<img src="'+data_uri+'"/>';*/
			});
		} );
	}
</script>

<?php else: ?>
<!-- Code to handle taking the snapshot and displaying it locally -->
<script language="JavaScript">
     // bind event handler
     $('#submit').click($.throttle(4000,submit_checkin));

	function submit_checkin() {
		var fname = $("#name").val();
        
        if( !$("#name").val() || !$("#reason").val())
        {
            document.getElementById('results').innerHTML = "You cannot leave name or reason blank";
            return;
        }
		
		$.post( "<?php echo base_url(); ?>" + "index.php/guest_station/checkin_guest", { 
			fullname: fname,
			stationid: $("input[name=stationid]").val(),
			site: $("input[name=site]").val(),
			location: $("input[name=location]").val(),
			reason: $("input[name=reason]").val(),
			imguri: ''
		})
		.done(function( data ) {
			console.log(data);
			document.getElementById('results').innerHTML = data;
			$('#name').val('');
			$('#reason').val('');
			/*document.getElementById('results').innerHTML = 
				'<h2>Here is your large image:</h2>' + 
				'<img src="'+data_uri+'"/>';*/
		});
	}
</script>

<?php endif; ?>
