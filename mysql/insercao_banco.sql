ALTER DATABASE g5 CHARSET = UTF8 COLLATE = utf8_general_ci;
DROP TABLE IF EXISTS paradas;
CREATE TABLE paradas (
  stop_id int(11) NOT NULL,
  stop_name varchar(100) DEFAULT NULL,
  stop_desc varchar(100) DEFAULT NULL,
  stop_lat decimal(8,6) DEFAULT NULL,
  stop_lon decimal(8,6) DEFAULT NULL,
  PRIMARY KEY (`stop_id`),
  INDEX `index_stop_id` (`stop_id`) 
);
LOAD DATA LOCAL INFILE 'C:\\Users\\ferna\\trabalho_mapa_slw\\mysql\\stops.txt' INTO TABLE paradas FIELDS TERMINATED BY ',' ENCLOSED BY '"';
SELECT * FROM paradas;
