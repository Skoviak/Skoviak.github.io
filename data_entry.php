<?php
$success = false;

include('includes/dbConn.php');
// Get list of artists and artist IDs
$sql = "
    SELECT DISTINCT artist_name, artist_id
    FROM artists
    ORDER BY artist_name ASC
    ";
$result = $conn->query($sql);
$artist_count = $result->num_rows; // Save count of artists for drop down loop
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $arr_artists[] = $row["artist_name"];
        $arr_artist_ids[] = $row["artist_id"];
    }
} else {
    echo "0 results";
}

// Get list of genres and genre IDs
$sql = "
        SELECT DISTINCT genre_name, genre_id
        FROM genres
        ORDER BY genre_name ASC
        ";
$result = $conn->query($sql);
$genre_count = $result->num_rows; // Save count of genres for drop down loop
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $arr_genres[] = $row["genre_name"];
        $arr_genre_ids[] = $row["genre_id"];
    }
} else {
    echo "0 results";
}
$conn->close();

if(isset($_POST['btnAddAlbum'])){

    $album_title = $_POST['AlbumTitle'];
    $album_year = $_POST['AlbumYear'];
    $album_cover = $_POST['AlbumCover'];
    $artist_id = $_POST['ArtistID'];
    $genre_id = $_POST['GenreID'];
    $album_rating = $_POST['AlbumRating'];

    include('includes/dbConn.php');

    $sql = "
        INSERT INTO music_db.albums(
        album_title,
        artist_id,
        album_year,
        genre_id,
        album_cover,
        album_rating
        ) 
        VALUES (
        '$album_title',
        '$artist_id',
        '$album_year',
        '$genre_id',
        '$album_cover',
        '$album_rating')
    ";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        $success = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    unset($album_genre, $album_cover, $album_title, $album_year, $artist_name);

}

if(isset($_POST['btnAddArtist'])){

    $artist_name =  $_POST['ArtistName'];

    include('includes/dbConn.php');

    $sql = "
        INSERT INTO music_db.artists(
        artist_name
        ) 
        VALUES (
        '$artist_name'
        )
    ";

    if ($conn->query($sql) === TRUE) {
        echo "New artist added.";
        $success = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    unset($artist_name);
}

if(isset($_POST['btnAddGenre'])){

    $genre_name =  $_POST['GenreName'];

    include('includes/dbConn.php');

    $sql = "
        INSERT INTO music_db.genres(
        genre_name
        ) 
        VALUES (
        '$genre_name'
        )
    ";

    if ($conn->query($sql) === TRUE) {
        echo "New artist added.";
        $success = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    unset($genre_name);
}

if( $success )
{
    //header( 'HTTP/1.1 303 See Other' );
    header( 'Location: data_entry.php?message=success' );
    exit();
}

if( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] == 'success' )
{
?>
    <div style="font-size: 4em;">
        <p>
            Data added.
        </p>

        <a href="data_entry.php">Return to data entry.</a>
        <br><br>
        <a href="index.php">Return to music home.</a>
    </div>
<?php
}
else
{
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add Album</title>
    <link rel="stylesheet" type="text/css" href="data_entry_styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="data_entry_script.js"></script>
</head>
<body>
<main>
    <nav><?php include('includes/nav.php'); ?></nav>
    <div class="flex-container">
        <div class="form-mini-container">
            <h1>Add Album</h1>

            <form class="form-mini" method="post">
                <table>
                    <tr>
                        <td><input name="AlbumTitle" type="text" placeholder="Album title"></td>
                    </tr>
                    <tr>
                        <td>
                            <select name="ArtistID">
                                <option>Select an artist</option>
                                <?php
                                for($i = 0; $i < $artist_count; $i++){
                                    echo "<option value='" . $arr_artist_ids[$i] . "'>" . $arr_artists[$i] . "</option>";
                                }
                                ?>
                            </select>
                    </tr>
                    <tr>
                        <td><input name="AlbumYear" type="text" placeholder="Album year"></td>
                    </tr>
                    <tr>
                        <td>
                            <select name="GenreID">
                                <option>Select a genre</option>
                                <?php
                                for($i = 0; $i < $genre_count; $i++){
                                    echo "<option value='" . $arr_genre_ids[$i] . "'>" . $arr_genres[$i] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><input name="AlbumCover" type="text" placeholder="Cover filepath"></td>
                    </tr>
                    <tr>
                        <td>
                            <select name="AlbumRating">
                                <option>Album Rating</option>
                                <option>0</option>
                                <option>0.5</option>
                                <option>1</option>
                                <option>1.5</option>
                                <option>2</option>
                                <option>2.5</option>
                                <option>3</option>
                                <option>3.5</option>
                                <option>4</option>
                                <option>4.5</option>
                                <option>5</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-last-row" colspan="2"><input type="submit" name="btnAddAlbum" value="Add Album"></td>
                    </tr>
                </table>
            </form>
        </div>

        <br><br>

        <div class="form-mini-container">
            <h1>Add Artist</h1>

            <form class="form-mini" method="post">
                <table>
                    <tr>
                        <td><input name="ArtistName" type="text" placeholder="Artist name"></td>
                    </tr>
                    <tr>
                        <td class="form-last-row" colspan="2"><input type="submit" name="btnAddArtist" value="Add Artist"></td>
                    </tr>
                </table>
            </form>
        </div>

        <br><br>

        <div class="form-mini-container">
            <h1>Add Genre</h1>

            <form class="form-mini" method="post">
                <table>
                    <tr>
                        <td><input name="GenreName" type="text" placeholder="Genre name"></td>
                    </tr>
                    <tr>
                        <td class="form-last-row" colspan="2"><input type="submit" name="btnAddGenre" value="Add Genre"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</main>
<footer></footer>
</body>
</html>

<?php
}
?>