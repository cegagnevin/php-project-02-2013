<ul>
	<li><?= $location ?></li>
</ul>
<form action="/locations/<?= $îd ?>" method="POST">
    <input type="hidden" name="_method" value="PUT">
    <input type="text" name="name" value="<?= $location ?>">
    <input type="submit" value="Update">
</form>

<form action="/locations/<?= $id ?>" method="POST">
    <input type="hidden" name="_method" value="DELETE">
    <input type="submit" value="Delete">
</form>
