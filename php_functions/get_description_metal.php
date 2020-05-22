<?php
// Const Variables
$album_root = "images/album_covers/";

// Global Variables
$arr_artist_name[] = " ";
$arr_album_title[] = " ";
$arr_album_cover[] = " ";
$arr_album_description[] = " ";
$result = " ";
$search_term = NULL;
if(isset($_POST["searchTerm"]))
{
        $search_term = $_POST["searchTerm"];
}


        // Metal Genres
        $genres = array("Metal", "Metal (Symphonic & Folk)", "Progressive (Metal)");


        //QUERY TO GET ALBUM DESCRIPTION
        include '../includes/dbconn.php';
        include 'albums.php';
        getAlbums();

if(isset($_POST["albumID"]))
{
    echo $arr_album_description[$_POST["albumID"]];
}
?>

