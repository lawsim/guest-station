<?php

	echo form_open('welcome/index');
?>
<input type="hidden" id="curClass" value="<?php echo $class; ?>" />

<h2>Scan your card now</h2>

<div id="info-box"></div>

<script>
var currentScanID = "";
var curClass = "<?php echo $class; ?>";
$(document).on("keypress", function(e) {
	/* ENTER PRESSED LOOKUP*/
	if (e.keyCode == 13) {
		console.log("pressed enter");
		// get stu info
		$.post( "<?php echo base_url(); ?>" + "index.php/welcome/get_student_by_card", { stucard: currentScanID, class: curClass})
			.done(function( data ) {
				$("#info-box").html(data);
			});
		currentScanID = "";
		return false;
	}
	/* any other key */
	else
	{
		currentScanID += String.fromCharCode(e.which);
		console.log(currentScanID);
		return false;
	}
});

</script>