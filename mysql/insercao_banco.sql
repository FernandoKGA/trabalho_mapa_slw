CREATE DATABASE slw;
ALTER DATABASE slw CHARSET = UTF8 COLLATE = utf8_general_ci;
DELETE FROM paradas;
LOAD DATA LOCAL INFILE 'C:\\Users\\ferna\\trabalho_mapa_slw\\stops.txt' INTO TABLE paradas FIELDS TERMINATED BY ',' ENCLOSED BY '"';
SELECT * FROM paradas;
