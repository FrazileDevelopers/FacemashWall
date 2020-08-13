<?php

include('mysql.php');
include('functions.php');

header("Content-Type: application/json; charset=UTF-8");

if ($_GET['downloads']) {
    // Get the downloader
    $result = mysqli_query($conn, "SELECT * FROM images WHERE image_id = ".$_GET['downloads']." ");
    $downloader = mysqli_fetch_object($result);

    // Update the downloader score
    $downloader_expected = expected($downloader->wins, $downloader->losses);
    $downloader_new_score = download($downloader->score, $downloader_expected, $downloader->downloads+1);
    // test print "Downloader: Score = ".$downloader->score." - New Score = ".$downloader_new_score." - Downloads = ".$downloader->downloads." - Exp = ".$downloader_expected."<br>";
    if (mysqli_query($conn, "UPDATE images SET score = ".$downloader_new_score.", downloads = downloads+1 WHERE image_id = ".$_GET['downloads'])) {
        $query="SELECT * FROM images WHERE image_id = ".$_GET['downloads']." ";
        $result = @mysqli_query($conn, $query);

        $jsonData = array();
        if(mysqli_num_rows($result) > 0){
            while ($array = mysqli_fetch_assoc($result)) {
            $jsonData[] = $array;
        }

        $json = '{"Wallpaper Downloaded":';
        $json .= json_encode($jsonData);
        $json .= '}';
        echo stripslashes($json);
    }
}
} else if ($_GET['cat']) {
        $c = $_GET['cat'];
        $catquery = "SELECT COUNT(DISTINCT(dirname)) AS count FROM images WHERE dirname='".$c."'";
        $catresult = @mysqli_query($conn, $catquery);
        $row = mysqli_fetch_assoc($catresult);
        if ($row['count'] != 0) {
            $query="SELECT *, ROUND(score/(1+(losses/wins))) AS performance FROM images WHERE dirname='".$c."' ORDER BY ROUND(score/(1+(losses/wins))) DESC";
            $result = @mysqli_query($conn, $query);
            
            $jsonData = array();
            if(mysqli_num_rows($result) > 0) {
            while ($array = mysqli_fetch_assoc($result)) {
                $jsonData[] = $array;
            }
            
            
            $json = '{"'.$c.'":';
            $json .= json_encode($jsonData);
            $json .= '}';
            echo stripslashes($json);
            
            }        
        } else {
            $json = '{"Error":';
            $json .= '"No Category named found."';
            $json .= '}';
            echo stripslashes($json);
        }
}
else {
    $query="SELECT DISTINCT(dirname) AS category FROM images";
    $result = @mysqli_query($conn, $query);
    
    $jsonData = array();
    if(mysqli_num_rows($result) > 0) {
    while ($array = mysqli_fetch_assoc($result)) {
        $jsonData[] = $array;
    }
    
    
    $json = '{"Categories":';
    $json .= json_encode($jsonData);
    $json .= '}';
    echo stripslashes($json);
    
    }

}