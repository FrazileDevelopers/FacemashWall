<?php
/*
 * Performance rating = [(Total of opponents' ratings + 400 * (Wins - Losses)) / score]
 */

include('mysql.php');
include('functions.php');
// Get random 2
$query="SELECT * FROM images ORDER BY RAND() LIMIT 0,30";
$result = @mysqli_query($conn, $query);
while($row = mysqli_fetch_object($result)) {
	$images[] = (object) $row;
}
// Get the top10
$result = mysqli_query($conn, "SELECT *, ROUND(score/(1+(losses/wins))) AS performance FROM images ORDER BY ROUND(score/(1+(losses/wins))) DESC LIMIT 0,10");
while($row = mysqli_fetch_object($result)) $top_ratings[] = (object) $row;
// Close the connection
mysqli_close($conn);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-163948473-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-163948473-1');
</script>
<title>Facemash</title>
<style type="text/css">
body, html {font-family:Arial, Helvetica, sans-serif;width:100%;margin:0;padding:0;text-align:center;}
h1 {background-color:#600;color:#fff;padding:20px 0;margin:0;}
a img {border:0;}
td {font-size:11px;}
.image {background-color:#eee;border:1px solid #ddd;border-bottom:1px solid #bbb;padding:5px;}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).keydown(function (e){ 
    if(e.keyCode == 37) // left arrow key
    {
	window.location.href='rate.php?winner=<?=$images[0]->image_id?>&loser=<?=$images[1]->image_id?>';
    }
    else if(e.keyCode == 39)    // right arrow key
    {
	window.location.href='rate.php?winner=<?=$images[1]->image_id?>&loser=<?=$images[0]->image_id?>';
    }
});
</script>
</head>
<body>
<h1>FACEMASH</h1>
<h3>Were we let images to look? On our phones & will be our phones rated on them? Yes.</h3>
<h2>Which is the best image? Click to choose.</h2>
<center>
<table>
	<tr>
		<td valign="top" class="image" id="imageA"><a href="rate.php?winner=<?=$images[0]->image_id?>&loser=<?=$images[1]->image_id?>"><img src="images/<?=$images[0]->dirname?><?=$images[0]->filename?>" width="250px" /></a></td>
<td valign="center" style="padding: 120px"></td>
		<td valign="top" class="image" id="imageB"><a href="rate.php?winner=<?=$images[1]->image_id?>&loser=<?=$images[0]->image_id?>"><img src="images/<?=$images[1]->dirname?><?=$images[1]->filename?>" width="250px" /></a></td>
	</tr>
	<tr>
		<td>Won: <?=$images[0]->wins?>, Lost: <?=$images[0]->losses?></td>
<td></td>
		<td>Won: <?=$images[1]->wins?>, Lost: <?=$images[1]->losses?></td>
	</tr>
	<tr>
		<td>Score: <?=$images[0]->score?>, Downloads: <?=$images[0]->downloads?></td>
<td></td>
		<td>Score: <?=$images[1]->score?>, Downloads: <?=$images[1]->downloads?></td>
	</tr>
	<tr>
		<td>Expected: <?=round(expected($images[1]->score, $images[0]->score), 4)?></td>
<td></td>
		<td>Expected: <?=round(expected($images[0]->score, $images[1]->score), 4)?></td>
	</tr>
</table>
</center>
<h2>Top Rated</h2>
<center>
<table>
	<tr>
		<?php foreach($top_ratings as $key => $image) : ?>
		<td valign="top"><img src="images/<?=$image->dirname?><?=$image->filename?>" width="50" /></td>
		<?php endforeach ?>
	</tr>
	<tr>
		<?php foreach($top_ratings as $key => $image) : ?>
		<td valign="top">Score: <?=$image->score?></td>
		<?php endforeach ?>
	</tr>
	<tr>
		<?php foreach($top_ratings as $key => $image) : ?>
		<td valign="top">Performance: <?=$image->performance?></td>
		<?php endforeach ?>
	</tr>
	<tr>
		<?php foreach($top_ratings as $key => $image) : ?>
		<td valign="top">Won: <?=$image->wins?></td>
		<?php endforeach ?>
	</tr>
	<tr>
		<?php foreach($top_ratings as $key => $image) : ?>
		<td valign="top">Lost: <?=$image->losses?></td>
		<?php endforeach ?>
	</tr>
</table>
</center>
</body>
</html>
