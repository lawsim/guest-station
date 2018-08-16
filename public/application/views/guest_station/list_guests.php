<?php
	// echo form_open('guest_station/list_guests',array('data-ajax'=>"false"));
	echo form_open('guest_station/list_guests',array('method'=>'get','data-ajax'=>"false"));
	// echo form_hidden('stationid',$station_info->stationid);
	// echo form_hidden('site',$station_info->site);
	// echo form_hidden('location',$station_info->location);
	// print_r($station_info);
?>
<p>Date: <input type="text" id="date" name="date" size="30" value="<?php echo $date; ?>"></p>
<input type="submit" value="Submit" id="submit">


</form>
<table data-role="table" id="table-column-toggle" class="ui-responsive table-stroke">
	<thead>
		<tr>
			<th data-priority="3">Picture</th>
			<th style="width: 15%" data-priority="1">In Time</th>
			<th style="width: 15%" data-priority="2">Name</th>
			<th style="width: 15%" data-priority="2">Location</th>
			<th style="width: 40%" data-priority="2">Reason</th>
			<th data-priority="3">Out Picture</th>
			<th style="width: 15%" data-priority="1">Out Time</th>
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
			echo '<td><img width="240" src="' . $row->picture . '"/></td>';
			echo "<td>" . $row->intime . "</td>";
			echo "<td>" . $row->name . "</td>";
			echo "<td>" . $row->location . "</td>";
			echo "<td>" . $row->reason . "</td>";
			if(!empty($row->outpicture))
			{
				echo '<td><img width="240" src="' . $row->outpicture . '"/></td>';
				echo "<td>" . $row->outtime . "</td>";
			}
			else
			{
				echo "<td></td>";
				echo "<td>Not checked out</td>";
			}
			echo "</tr>";
		}
	?>
	</tbody>
</table>



<script>
	$( function() {
		$( "#date" ).datepicker({
			dateFormat: "yy-mm-dd"
		});
	} );
</script>