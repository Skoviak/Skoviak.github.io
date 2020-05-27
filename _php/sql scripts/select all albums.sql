SELECT 
	artist_name, 
    album_title, 
    album_year, 
    genre_name
FROM
	albums
    JOIN
    artists 
    ON albums.artist_id = artists.artist_id
    JOIN
    genres
    ON albums.genre_id = genres.genre_id
ORDER BY
	artist_name asc, album_year asc;