<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <link rel="stylesheet" type="text/css" href="../a/photos.css">
    <script language="javascript" src="utils.js"></script>
</head>
<?php
if (isset($_GET['offset']))
{
    $offset = $_GET['offset'];
}
else
{
    $offset = 0;
}

// Count Number of photos in db to be displayed
$conn = pg_connect("host=localhost dbname=photodb user=photodb password=<password>");
$query = "select count(photos.id) FROM photos inner join thumbnails on photos.filename = thumbnails.filename and photos.create_date is not null";
$result = pg_query($conn, $query);
$row = pg_fetch_row($result);
$max = $row['0'];

?>

<body onLoad="PhotoQuery(<?php echo $offset;?>);">
<?php echo $_POST['offset']; ?>
    <form name="offsetform" onSubmit="return false">
        <input type="hidden" name="offset" value="<?php echo $offset;?>" onChange="ProcessOffsetForm();">
        <input type="hidden" name="max" value="<?php echo $row[0]; ?>">
    </form>
    <div class="topTitleBox">
        <span class="topTitle">Photographs&nbsp;<?php echo $_SERVER['PHP_AUTH_USER'] ?>&nbsp;</span>
    </div>
    <div class="topControlBox">
    <table>
      <tr>
        <td>
          <span onClick="OpenTags();" class="navText">+Tags</span>
        </td>
        <td>
        <span onClick="SelectAll();" class="navText">+All</span>
        </td>
        <td>
          <span onClick="Next();" class="navtext">Next&nbsp;&gt;</span>
        </td>
      </tr>
      <tr>
      <td>
      <span onClick="DebugToggle();" class="navtext">Debug</span>
      </td>
      <td>
        <span onClick="DeSelectAll();" class="navText">-All</span>
      </td>
      <td>
      <span onClick="Prev();" class="navtext">&lt;&nbsp;Prev</span>
      </td>
      </tr>
      </table>
    </div>
    <div class="copyrightBox">
        <span class="tinytext">&copy; Dom Esplen 2015</span>
    </div>
    <div style="margin-top: 10px;"><span class="topTitle">&nbsp;</span></div>
    <div class="debug" id="output-box">Debug Output</div>
    <div class="tags" id="tag-box"><div class="taginner" id="tagContent"></div></div>
    <div id="box" class="photoOuter">
        <div id="content-box" class="photoInner">
        </div>
    </div>
</body>
</html>
