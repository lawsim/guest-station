<?php
	// print_r($student);
	// no student returned
	if($student->num_rows() <= 0)
	{
		echo "<h3>No student found for your card</h3>";
	}
	else
	{
		$stuinfo = $student->row();
		if($checkin_stu)
		{
			echo "<h3>Checked in student " . $stuinfo->first . " " . $stuinfo->last;
			echo " to class: " . $class->class_name . " - " . $class->first . " " . $class->last . "<h3>";
		}
		else
		{
			echo "<h3>Failed to checkin?</h3>";
		}
	}