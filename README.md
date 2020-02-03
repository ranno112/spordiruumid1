# Spordiruumide broneerimissüsteem

Tere tulemast Annemarii Hunt lõputöö projekti GitHubi repositooriumile!

Tegemist on kohaliku omavalitsuste spordiga seotud allasutuste spordiruumide kalendrisüsteemi rakendusega. 

Oma serverisse laadimiseks on vaja muuta application/config kaustas kaks faili: config.php ning database.php:
```
config.php tuleb määrata URL $config['base_url']
database.php tuleb määrata 'hostname', 'username', ning 'password'.
```

Rakenduse tööle saamiseks tuleb luua SQL tabelid:
```sql
CREATE TABLE `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typeID` int(11) DEFAULT NULL,
  `public_info` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `c_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `c_phone` int(11) DEFAULT NULL,
  `c_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_bin,
  `comment_inner` text CHARACTER SET utf8 COLLATE utf8_bin,
  `organizer` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `workout` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `event_in` datetime DEFAULT NULL,
  `event_out` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (id)
);

CREATE TABLE `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `roleID` int(11) NOT NULL,
  `buildingID` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `userName` varchar(255) DEFAULT NULL,
  `userPhone` varchar(255) DEFAULT NULL,
  `pw_hash` varchar(255) NOT NULL,
  `session_id` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (userID)
);


CREATE TABLE `bookingTypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
   PRIMARY KEY (id)
);

INSERT INTO `bookingTypes` (`id`, `name`) VALUES
(1, 'trenn'),
(2, 'trenn (hooajaline)'),
(3, 'üritus'),
(4, 'suletud');

CREATE TABLE `bookingTimes` (
  `timeID` int(11) NOT NULL AUTO_INCREMENT,
  `bookingID` int(11) NOT NULL,
  `roomID` int(11) NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `takes_place` tinyint(1) NOT NULL DEFAULT '1',
  `title` varchar(255) NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
   PRIMARY KEY (timeID)
);

CREATE TABLE `buildings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `regionID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `notify_email` varchar(255) NOT NULL,
  `price_url` varchar(255) NOT NULL,
   PRIMARY KEY (id)
);


CREATE TABLE `regions` (
  `regionID` int(11) NOT NULL AUTO_INCREMENT,
  `regionName` varchar(255) NOT NULL,
   PRIMARY KEY (regionID)
    
);

INSERT INTO `regions` (`regionID`, `regionName`) VALUES
(1, 'Pärnu Kesklinn/Raeküla'),
(2, 'Pärnu Ülejõe'),
(3, 'Audru'),
(4, 'Tõstamaa'),
(5, 'Paikuse');


CREATE TABLE `rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `buildingID` int(11) NOT NULL,
  `roomName` varchar(255) NOT NULL,
  `activeRoom` int(11) NOT NULL,
  `roomActive` tinyint(1) NOT NULL DEFAULT '1',
   PRIMARY KEY (id)
);


CREATE TABLE `userRoles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) NOT NULL,
   PRIMARY KEY (id)
);
INSERT INTO `userRoles` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'Juht'),
(3, 'Haldur');
```
