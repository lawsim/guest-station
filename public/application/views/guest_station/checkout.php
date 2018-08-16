<?php
	echo form_open('guest_station/checkin_guest');
	echo form_hidden('stationid',$station_info->stationid);
	echo form_hidden('site',$station_info->site);
	echo form_hidden('location',$station_info->location);
	// print_r($station_info);
?>
<div><a href="<?php echo site_url('guest_station'); ?>" class="ui-btn" data-ajax="false">Click here to check in</a></div>
<h2>Click your picture to checkout</h2>
<div id="my_camera"></div>

<table data-role="table" id="table-column-toggle" class="ui-responsive table-stroke">
	<thead>
		<tr>
			<th data-priority="3">Picture</th>
			<th style="width: 10%" data-priority="1">Time</th>
			<th style="width: 20%" data-priority="2">Name</th>
			<th style="width: 20%" data-priority="2">Location</th>
			<th style="width: 70%" data-priority="2">Reason</th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach($guests->result() as $row)
		{
			// print_r($row);
			// echo "<br />";
			echo "<tr>";
			// echo '<td><img src="data:image/jpeg;base64,' . $row->picture . '"/></td>';
			// echo '<td><a href="' . site_url('guest_station/checkout_guest?guestid=' . $row->guestid) . '"><img width="240" src="' . $row->picture . '"/></a></td>';
			echo '<td><img width="240" src="' . $row->picture . '" class="submit" id="' . $row->guestid . '"/></td>';
			echo "<td>" . $row->intime . "</td>";
			echo "<td>" . $row->name . "</td>";
			echo "<td>" . $row->location . "</td>";
			echo "<td>" . $row->reason . "</td>";
			echo "</tr>";
		}
	?>
	</tbody>
</table>
</form>


<!-- First, include the Webcam.js JavaScript Library -->
<script src="<?php echo base_url();?>assets/webcam.min.js"></script>

<!-- Configure a few settings and attach camera -->
<script language="JavaScript">
	Webcam.set({
		width: 1,
		height: 1,
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
     $('.submit').click(function(event) {
		 $.throttle(4000,take_snapshot(event.target.id));
	 });

	function take_snapshot(guestid) {
		// take snapshot and get image data
		Webcam.snap( function(data_uri) {
			// display results in page
			
			$.post( "<?php echo base_url(); ?>" + "index.php/guest_station/checkout_guest", {
				stationid: $("input[name=stationid]").val(),
				guestid: guestid,
				imguri: data_uri
			})
			.done(function( data ) {
				console.log(data);
				// document.getElementById('results').innerHTML = data;
                // $('#name').val('');
                // $('#reason').val('');
				/*document.getElementById('results').innerHTML = 
					'<h2>Here is your large image:</h2>' + 
					'<img src="'+data_uri+'"/>';*/
				window.location.href = "<?php echo base_url(); ?>" + "index.php/guest_station?message=" + data
			});
		} );
	}
</script>
