<?php
$conn = pg_connect("host=localhost dbname=photodb user=photodb password=<password>");

$query = "INSERT INTO tags(tagtitle) VALUES ('" . $_POST['newtag'] . "')";
echo $query . "<br>";
$result = pg_query($conn, $query);

if (!$result)
{
    echo pg_result_error_field($result, PGSQL_DIAG_SQLSTATE);
}
else if (isset($_POST['photo']))
{
    $query = "SELECT (id) FROM tags WHERE tagtitle = '" . $_POST['newtag'] . "'";
    echo $query . "<br>";
    $result = pg_query($conn, $query);

    if (!$result)
    {
        echo pg_result_error_field($result, PGSQL_DIAG_SQLSTATE);
    }
    else
    {
        $row = pg_fetch_row($result);
        $query = "INSERT INTO tagged_items(photo_id, tag_id) VALUES (" . $_POST['photo'] . ", " . $row[0] . ')';
        echo $query . "<br>";
        $result = pg_query($conn, $query);

        if (!$result)
        {
            echo pg_result_error_field($result, PGSQL_DIAG_SQLSTATE);
        }
    }
}


?>
