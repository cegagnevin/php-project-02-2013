<ul>
<?php foreach ($locations as $loc) : ?>
	<li><?= $loc ?></li>
<?php endforeach; ?>
<form method=post action="/locations">
	<label for="name">Name:</label>
	<input type="text" name="name" id="name"/>
	<input type="hidden" name="_method" value="POST">
	<input type="submit" value="Add New"/>
</form>
</ul>
