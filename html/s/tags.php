Tags<br>
<table>
<?php

$photo = $_POST['photo'];
$conn = pg_connect("host=localhost dbname=photodb user=photodb password=<password>");

$query = "select * from tags";
$tagRes = pg_query($conn, $query);

$count = 0;
while ($row = pg_fetch_row($tagRes))
{
    $tags[$count]   = $row[1];
    $tagIds[$count] = $row[0];
    $count++;
}

   $query = "select * from tagged_items where photo_id = " . $photo;
   $tagged = pg_query($conn, $query);

   while ($tagRow = pg_fetch_row($tagged))
   {
       $usedTags[$tagRow[1]] = true;
   }

   for ($index = 0; $index < $count; $index++)
   {
       echo '<tr><td>';
       $tagName = $photo . '-' . $tagIds[$index];
       echo '<input type="checkbox" name="' . $tagName . '" onChange="ToggleTag(\'' . $tagName . '\')" ';

       if (   isset($usedTags[$tagIds[$index]])
           && $usedTags[$tagIds[$index]])
       {
           echo 'checked';
       }
       echo '></td><td>' . $tags[$index] . '</td></tr>';
   }
   echo '<tr><td colspan="2"><form onSubmit="return false">';
   echo '<input placeholder="Add New Tag" type="text" name="';
   echo $photo . '-new"';
   echo ' onKeyDown="Pressed(event, true, \'' . $photo . '\')"';


   // onChange="AddTag(\'' . $photo . '-new\');">
   echo '></form></td></tr>';
?>
</table>
