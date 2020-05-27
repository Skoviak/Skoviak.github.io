<?php
function getAlbums(){
    global $search_term, $result, $conn, $genres, $arr_album_description, $arr_album_title, $arr_artist_name, $arr_album_cover;

    if($search_term != NULL)
    {
        $search_term = '%' . $search_term . '%';

        // Query the table for album data where search term is met
        $sql =
            "SELECT
            album_title, artist_name, album_cover, album_year, album_description
             FROM
                albums
                JOIN
                artists ON albums.artist_id = artists.artist_id
                JOIN
                genres ON albums.genre_id = genres.genre_id 
             WHERE
                (genre_name = ? || genre_name = ? || genre_name = ?)
                &&
                (artist_name LIKE ? || album_title LIKE ? || album_year LIKE ?)
             ORDER BY
                artist_name asc, album_year asc";

        // Store the data from the query in a variable
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $genres[0], $genres[1], $genres[2], $search_term, $search_term, $search_term);
        $stmt->execute();
        $result = $stmt->get_result(); // get the mysqli result
    }
    else
    {
        // Query the table for album data
        $sql =
            "SELECT
            album_title, artist_name, album_cover, album_year, album_description
             FROM
                albums
                JOIN
                artists ON albums.artist_id = artists.artist_id
                JOIN
                genres ON albums.genre_id = genres.genre_id 
             WHERE
                genre_name = ? || genre_name = ? || genre_name = ?
             ORDER BY
                artist_name asc, album_year asc";

        // Store the data from the query in a variable
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $genres[0], $genres[1], $genres[2]);
        $stmt->execute();
        $result = $stmt->get_result(); // get the mysqli result
    }


    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $arr_album_title[] = $row["album_title"];
            $arr_artist_name[] = $row["artist_name"];
            $arr_album_cover[] = $row["album_cover"];
            $arr_album_description[] = $row["album_description"];
        }
    } else {
        echo "0 results";
    }

    $conn->close();
}

function displayAlbums()
{
    global $album_root, $result, $arr_album_title, $arr_artist_name, $arr_album_cover;
    for ($i = 1; $i < ($result->num_rows + 1); $i++) {
        echo "<div class='albumCover' id='" . $i . "'>
                  <img id='" . $arr_album_cover[$i] . "' src='" . $album_root . $arr_album_cover[$i] . "' width='200' height='200'>
                  <p class='title'>" . $arr_artist_name[$i] . "<br>" . $arr_album_title[$i] . "</p>
                  </div>";
    }
}