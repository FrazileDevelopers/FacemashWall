<!-- <?php
include('mysql.php');
$dirname = 'GirlWalls/';

if ($handle = opendir('images/'.$dirname)) {
 /* This is the correct way to loop over the directory. */
 while (false !== ($file = readdir($handle))) {
  if($file!='.' && $file!='..') {
   $images[] = "('".$file."', '".$dirname."')";
  }
 }
 closedir($handle);
}
$query = "INSERT INTO images (filename, dirname) VALUES ".implode(',', $images)." ";
if (!mysqli_query($conn, $query)) {
 print mysqli_error($conn);
}
else {
 print "finished installing your images!";
}

// print $query;
 
?> -->
