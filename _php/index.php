<!DOCTYPE html>
<html>
<head>
    <title>REPRIEVE OF SOUND</title>
    <link href="styles/genre_page_styles.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="scripts/genre_page_script.js"></script>
<script>
    <?php
    // Const Variable
    $album_root = "images/album_covers/";


    function getTopAlbums()
    {
        global $conn;
        global $result, $genre_selection, $arr_album_cover, $arr_album_title, $arr_artist_name;

        include 'includes/dbconn.php';
        // Query the table for album data
        $sql =
            "SELECT
            album_title, artist_name, album_cover, album_year
            FROM
            albums
            JOIN
            artists ON albums.artist_id = artists.artist_id
            JOIN
            genres ON albums.genre_id = genres.genre_id
            WHERE
            albums.genre_id = ? && album_rating = 5
            ORDER BY
            artist_name asc, album_year asc";

        // Store the data from the query in a variable
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $genre_selection);
        $stmt->execute();
        $result = $stmt->get_result(); // get the mysqli result



        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $arr_album_title[] = $row["album_title"];
                $arr_artist_name[] = $row["artist_name"];
                $arr_album_cover[] = $row["album_cover"];
            }
        } else {
            echo "0 results";
        }

        $conn->close();
    }

    function displayAlbums()
    {
        global $result, $album_root, $arr_album_cover, $arr_album_title, $arr_artist_name;
        for($i = 0; $i < ($result->num_rows); $i++)
        {
            echo "<tr id='".$arr_album_cover[$i]."'>
              <td>".($i + 1)."</td>
              <td><img src='".$album_root . $arr_album_cover[$i]."' width='100' height='100'></td>
              <td>".$arr_artist_name[$i]."</td><td>".$arr_album_title[$i]."</td>
              </tr>";
        }
    }
    ?>
</script>
</head>
<body>
    <h1 class="sideLabel">H<br>O<br>M<br>E</h1>

    <h1>REPRIEVE OF SOUND</h1>
    <?php include 'includes/nav.php'?>
    <nav><a href="japanese_rankings.php">Japanese Bands: Album Rankings</a></nav>


    <div class="flex-container">
        <div class="top-list">
            <h2>Top Symphonic Metal Albums</h2>
            <table>
                <tr><td></td><td></td><td>Artist</td><td>Album</td></tr>
                <?php
                unset($arr_album_cover, $arr_album_title ,$arr_artist_name);
                $genre_selection = 1;
                getTopAlbums();
                displayAlbums();
                ?>
            </table>
        </div>

        <div class="top-list">
            <h2>Top Metal Albums</h2>
            <table>
                <tr><td></td><td></td><td>Artist</td><td>Album</td></tr>
                <?php
                unset($arr_album_cover, $arr_album_title ,$arr_artist_name);
                $genre_selection = 5;
                getTopAlbums();
                displayAlbums();
                ?>
            </table>
        </div>
    </div>

</body>
</html>