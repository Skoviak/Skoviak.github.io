<?php
// Const Variables
$album_root = "images/album_covers/";

// Global Variables
$arr_artist_name[] = " ";
$arr_album_title[] = " ";
$arr_album_cover[] = " ";
$result = " ";
$search_term = NULL;

$genres = array("Progressive (Metal)", "Progressive (Avant-Garde)", "Progressive (Rock)");

if(isset($_POST['btnSearch'])){
    $search_term = $_POST['txtSearch'];
}

include 'includes/dbconn.php';
include 'php_functions/albums.php';
getAlbums();

?>
<!DOCTYPE html>
<html>
<head>
    <title>REPRIEVE OF SOUND</title>
    <link href="genre_page_styles.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="genre_page_script.js"></script>
    <script>
        $(function(){
            $(".albumCover").click(function(){
                var albumid = $(this).attr('id');
                var searchterm = $("#search_box").val();
                $.post("php_functions/get_description_prog.php", {albumID : albumid, searchTerm : searchterm}, function(result){
                    $(".details").html(result);
                });
            })
        })
    </script>
</head>

<body>
<h1 class="sideLabel">P<br>R<br>O<br>G<br>R<br>E<br>S<br>S<br>I<br>V<br>E</h1>
<div id="prog">
    <div id="title">
        <h1><a href='index.php'>REPRIEVE OF SOUND</a></h1>
    </div>

    <div id="nav">
        <?php include 'includes/nav.php'?>
    </div>

    <div class="details"></div>

    <div id="rightContent">
        <div class="search">
            <form id="search" method="post">
                <input id="search_box" name="txtSearch" value="<?= $search_term ?>" type="text">
                <input id="search_button" name="btnSearch" value="SEARCH" type="submit">
            </form>
        </div>

        <div id="subgenres">
            <ul>
                <?php
                for($i = 0; $i < count($genres); $i++) echo "<li>".$genres[$i]."</li>";
                ?>
            </ul>
        </div>

        <div class="albums">
            <?php displayAlbums(); ?>
        </div>
    </div>

    <div id="footer">
        <?php include 'includes/footer.php' ?>
    </div>
</body>
</html>