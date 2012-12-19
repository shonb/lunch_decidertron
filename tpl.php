<img src="resources/logo.png" alt="Logo" />

<h1>Lunch Decidertron</h1>

<h3>Options</h3>
<table border=1>
	<tr>
		<th>Place</th>
		<th>Weight</th>
	</tr>
	<?php foreach ($options as $place => $weight): ?>
	<tr>
		<td><?php echo $place; ?></td>
		<td><?php echo $weight; ?></td>
	</tr>
	<?php endforeach; ?>
</table>

<h3>We are going to <span id="selection"> </span></h3>

<script type="text/javascript">
var i = 0;
var max = 3;

function show() {
	var sel = document.getElementById('selection');
	if (i == max) {
		sel.firstChild.data = "<?php echo $selected; ?>";
		clearInterval(interval);

		document.getElementById('overwriteForm').style.display = "block";
	}
	else {
		sel.firstChild.data += '.';
	}
	i++;
}

function confirm_overwrite() {
	return confirm("Are you sure? Misuse of this feature carries a penalty of paying for everyone's lunch for 1 week!");
}

var interval = setInterval("show()", 500);

</script>


<div id="overwriteForm" style="display:none;">
<form method="post" onsubmit="return confirm_overwrite();">
<input type="hidden" name="overwrite" value="1" />
<input type="submit" value="Choose Again" />
</form>

<p>Last time someone shamelessly clicked this button: <?php echo $last_overwrite; ?></p>
</div>
