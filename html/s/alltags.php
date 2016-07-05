<table>
<?php

$photo = $_POST['photo'];
$conn = pg_connect("host=localhost dbname=photodb user=photodb password=<password>");

$query = "SELECT * FROM tags";
$results = pg_query($conn, $query);

while ($row = pg_fetch_row($results))
{
    echo '<tr><td><input type="checkbox" class="alltagtick" name="check-' . $row[0] . '"></td><td>' . $row[1] . '</td></tr>';
}
echo '<tr><td colspan="2"><input style="width: 160px;" placeholder="Add New Tag" type="text" name="alltags-new" onKeyDown="Pressed(event, false, 0)"></td><tr>';
?>
<tr><td colspan="2">&nbsp;</td</tr>
<tr><td colspan="2" align="right">
<a href="#" onClick="HideTagAll()" class="photobutton">Cancel</a>
<a href="#" onClick="TagSelected()" class="photobutton">Set</a>
</td></tr>
</table>
