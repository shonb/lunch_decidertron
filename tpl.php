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
	}
	else {
		sel.firstChild.data += '.';
	}
	i++;
}

var interval = setInterval("show()", 500);

</script>
