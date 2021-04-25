<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div class="w3-container w3-margin w3-theme w3-center" style="font-size: 160%">
		<?php
			filemtime("index.php");
			echo "<span class='w3-text-white'>Cette page a été modifiée le : ".date("d F Y H:i:s."."</span>");
		?>
	</div>


</body>
</html>