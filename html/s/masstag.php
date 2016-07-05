<?php
$conn = pg_connect("host=localhost dbname=photodb user=photodb password=<password>");

$query  = "begin;\n";
$query .= "create temporary table newvals(photo_id integer, tag_id integer);\n";

$query .= "INSERT INTO newvals (photo_id, tag_id) VALUES ";
$photos = explode(";", $_POST['NewTags']);

$comma = FALSE;

for ($photo = 0; $photo < sizeof($photos) - 1; $photo++)
{
    $photoDetail = explode(":", $photos[$photo]);
    $tags = explode("-", $photoDetail[1]);
    for ($tag = 0; $tag < sizeof($tags); $tag++)
    {
        if ($comma)
        {
            $query .= ",";
        }
        $comma = TRUE;
        $query .= '(' . $photoDetail[0] . ", " . $tags[$tag] . ')';
    }
}
$query .= ";\n";
$query .= "insert into tagged_items select * from newvals";
$query .= " where not exists(select * from tagged_items";
$query .= " where photo_id = newvals.photo_id and tag_id = newvals.tag_id);\n";


$query .= "commit;";

$result = pg_query($conn, $query);
?>
