<?php

	// echo "<pre>";
	// print_r($checkins);
	// print_r($class);
	// echo "</pre>";
	
	echo "<h2>" . $class->class_name . " - " . $class->first . " " . $class->last . "</h2>";
?>
<table data-role="table" id="table-column-toggle" data-mode="columntoggle" class="ui-responsive table-stroke">
	<thead>
		<tr>
			<th>Student</th>
			<th data-priority="1">Time</th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach($checkins->result() as $row)
		{
			// print_r($row);
			// echo "<br />";
			echo "<tr>";
			echo "<td>" . $row->first . " " . $row->last . "</td>";
			echo "<td>" . $row->time . "</td>";
			echo "</tr>";
		}
	?>
	</tbody>
</table>