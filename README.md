# Spordiruumide broneerimissüsteem

Tere tulemast minu õputöö projekti GitHubi repositooriumile!

Olen Annemarii Hunt ning olen Tallinna Ülikooli Haapsalu Kolledži rakendusinformaatika III kursuse tudeng. Kirjutasin lõputööd teemal "spordiasutuste saalide veebikalendri prototüübi edasiarendus pärnu linnavalitsuse näitel" ning samal ajal ehitasin rakendust.

Rakenduse näol on tegemist kohaliku omavalitsuste spordiga seotud allasutuste spordiruumide kalendrisüsteemi rakendusega. Rakendus on edasi arendatud valikpraktika projektist https://github.com/Viiskorda/maag.

Demo keskkonnaga saad tutvuda lingil https://www.spordiruumid.ee/.

Oma serverisse laadimiseks on vaja muuta application/config kaustas kaks faili: config.php ning database.php:
```
config.php //tuleb määrata URL $config['base_url']
database.php //tuleb määrata 'hostname', 'username', ning 'password'.
```
Lisaks tuleb minna kontrollerisse nimega Login.php ning järgmistesse ridadesse panema oma Google poolt genereeritud OAuth 2.0 genereeritud id ja salajane võti.

```
$google_client->setClientId(''); //Kirjuta oma ClientID	 
$google_client->setClientSecret(''); //Kirjuta oma Client Secret Key
$google_client->setRedirectUri('http://localhost/spordiruumid/login/login'); //Vajadusel muuda suunamise universaalset ressursiidentifikaatorit (Redirect Uri)
```

Rakenduse tööle saamiseks tuleb luua SQL tabelid:
```sql
CREATE TABLE `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typeID` int(11) DEFAULT NULL,
  `public_info` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `c_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `c_phone` varchar(12) DEFAULT NULL,
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
  `login_oauth_uid` varchar(100) CHARACTER SET utf8 NOT NULL,
  `roleID` int(11) NOT NULL DEFAULT '4',
  `buildingID` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `userName` varchar(255) DEFAULT NULL,
  `userPhone` varchar(255) DEFAULT NULL,
  `pw_hash` varchar(255) NOT NULL,
  `session_id` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `requestFromBuilding` tinyint default '0',
   PRIMARY KEY (userID)
);

INSERT INTO `users` (`userID`, `login_oauth_uid`, `roleID`, `buildingID`, `email`, `status`, `userName`, `userPhone`, `pw_hash`, `session_id`, `created_at`, `updated_at`) VALUES
(1, '', 1, 0, 'admin@admin.ee', 1, 'Admin', '12345', 'admin', '', '2020-03-02 09:00:46', '0000-00-00 00:00:00');

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
  `bookingTimeColor` char(50) DEFAULT '#ffffff',
  `hasChanged` tinyint(1) NOT NULL DEFAULT 0,
   PRIMARY KEY (timeID)
);

CREATE TABLE `bookingTimeVersions` (
  `versionID` int(11) NOT NULL,
  `timeID` int(11) NOT NULL,
  `startTime` timestamp NULL DEFAULT NULL,
  `endTime` timestamp NULL DEFAULT NULL,
  `nameWhoChanged` varchar(30) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `whenChanged` timestamp NOT NULL DEFAULT current_timestamp(), 
   PRIMARY KEY (versionID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `roomActive` tinyint(1) NOT NULL DEFAULT '1',
  `roomColor` char(50) DEFAULT '#ffffff',
   PRIMARY KEY (id)
);

CREATE TABLE `userRoles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) NOT NULL,
   PRIMARY KEY (id)
);

INSERT INTO `userRoles` (`id`, `role`) VALUES
(1, 'Linnavalitsuse administraator'),
(2, 'Peaadministraator'),
(3, 'Administraator'),
(4, 'Tavakasutaja');
```
