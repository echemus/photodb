<?php

echo 'Processing...<br>';
echo 'Set: ' . $_POST['set'] . '<br>';
echo 'photo: ' . $_POST['photo'] . '<br>';
echo 'tag: ' . $_POST['tag'] . '<br>';

$conn = pg_connect("host=localhost dbname=photodb user=photodb password=<password>");

if ($_POST['set'] == 'false')
{
    $query = "delete from tagged_items WHERE photo_id = ". $_POST['photo'] ." AND tag_id = ". $_POST['tag'];

}
else
{
    $query = "INSERT INTO tagged_items(photo_id, tag_id) VALUES (" . $_POST['photo'] . ", " . $_POST['tag'] . ')';
}

echo $query . '<br>';

$result = pg_query($conn, $query);

if (!$result)
{
    echo pg_result_error_field($result, PGSQL_DIAG_SQLSTATE);
}

?>
