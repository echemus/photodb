<?php
$conn = pg_connect("host=localhost dbname=photodb user=photodb password=<password>");

$query  = "select photos.filename,'thumb' || lpad(to_hex(thumbnails.thumbid), 16, '0') || '.jpg', ";
$query .= "photos.create_date, photos.id ";
$query .= "FROM photos inner join thumbnails on photos.filename = thumbnails.filename and ";
$query .= "photos.create_date is not null ";
$query .= "order by photos.create_date desc limit 60 offset " . $_POST['offset'];
$result = pg_query($conn, $query);

while ($row = pg_fetch_row($result))
{
   echo '<div id="' . $row[3] . '" class="photocard"';
   echo ' OnMouseEnter="ExpandPhotoCard(' . $row[3] . ')"';
//   echo ' OnMouseLeave="CollapsePhotoCard(' . $row[3] . ')"';
   echo '>';
   echo '<div class="photo"';
   echo ' style="background: url(thumbs360/' . $row[1] . ') 50% 50% no-repeat;"';
   echo '>';
   echo '<div class="options" id="' . $row[3] . '-options">';
   echo '</div></div>';
   echo '<input type="checkbox" name="' . $row[3]. '-check" class="totalcheck"><span class="caption">';
   echo basename($row[0]);
   echo '</span><br>';
   echo '<span class="detail">' . $row[3] . ' - ' . $row[2] . '</span>';
   echo "</div>\n";
}

?>
