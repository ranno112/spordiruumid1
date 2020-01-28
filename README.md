Tere tulemast Annemarii Hunt lõputöö projekti GitHubi repositooriumile!

Tegemist on kohaliku omavalitsuste spordiga seotud allasutuste spordiruumide kalendrisüsteemi rakendusega. 

SQL tabelite loomiseks:
CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `roleID` int(11) NOT NULL,
  `buildingID` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `userName` varchar(255) DEFAULT NULL,
  `userPhone` varchar(255) DEFAULT NULL,
  `pw_hash` varchar(255) NOT NULL,
  `session_id` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO `users` (`userID`, `roleID`, `buildingID`, `email`, `status`, `userName`, `userPhone`, `pw_hash`, `session_id`, `created_at`) VALUES
(2, 2, 2, 'heli@spordibaasid.ee', 0, 'Heli Kopter', '5123416 ', 'admin', '', '2019-11-30 08:34:47'),
(3, 3, 3, 'tanja@sindi.ee', 1, 'Tatjana Smirnova', '56784512', 'admin', '', '2019-11-30 08:34:47'),
(5, 2, 2, 'juht@juht.ee', 1, 'Juht', '12345', 'admin', '', '2019-12-11 09:02:44'),
(6, 3, 3, 'haldur@haldur.ee', 1, 'Haldur', '555551', 'admin', '', '2019-12-11 09:03:09'),
(17, 1, 0, 'admin@admin.ee', 1, 'Admin', '', 'admin', '', '2019-12-14 18:41:21'),
(20, 3, 0, 'maaja@haldur.ee', 1, 'Mesilane', '65656565656', 'muffin', '', '2019-12-19 19:57:33'),
(21, 2, 0, 'mumm@haldur.ee', 1, 'dasds', 'Mumm', 'mumm', '', '2019-12-19 19:58:57'),
(24, 0, 0, 'gerli@gerli.ee', 1, 'asda', 'ttt', 'kala', '', '2019-12-27 09:24:25'),
(25, 0, 0, 'kasutaja@kasutaja.ee', 1, 'Bloop Noop', '00000', 'admin', '', '2019-12-27 09:30:03'),
(26, 0, 0, 'anna@frozen.ee', 0, 'Anna', '12121212', 'admin', '', '2020-01-03 21:48:36'),
(27, 1, 0, 'liisu@admin.ee', 0, 'Liisu', '55555', 'admin', '', '2020-01-03 22:39:03');

CREATE TABLE `bookingTypes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
);

INSERT INTO `bookingTypes` (`id`, `name`) VALUES
(1, 'trenn'),
(2, 'trenn (hooajaline)'),
(3, 'üritus'),
(4, 'suletud');

CREATE TABLE `bookingTimes` (
  `timeID` int(11) NOT NULL,
  `bookingID` int(11) NOT NULL,
  `roomID` int(11) NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `takes_place` tinyint(1) NOT NULL DEFAULT '1',
  `title` varchar(255) NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL
);

CREATE TABLE `buildings` (
  `id` int(11) NOT NULL,
  `regionID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `notify_email` varchar(255) NOT NULL,
  `price_url` varchar(255) NOT NULL
);

INSERT INTO `buildings` (`id`, `regionID`, `name`, `phone`, `contact_email`, `notify_email`, `price_url`) VALUES
(1, 1, 'Pärnu Kesklinna Kool', '115555', 'matti@estpak.eee', 'matti@estpak.eee', 'sadasdase'),
(2, 1, 'Tõstamaa rahvamaja', '4423000', 'parnu@myfitness.ee', 'parnu@myfitness.ee', 'VAATA HINDA'),
(3, 5, 'Paikuse Spordi-ja Tervisekeskus', '58371724', 'roland.simanis@paikuse.ee', 'roland.simanis@paikuse.ee', 'VAATA HINDA SIIT'),
(4, 3, 'Audru kool', '4464036', 'test@test.ee', 'test@test.ee', ''),
(5, 4, 'Tõstamaa rahvamaja', '5061930', 'sport@tostamaa.ee', 'sport@tostamaa.ee', ''),
(6, 1, 'Pärnu Koidula Gümnaasiumi võimla', '56565656', 'merilin.sellik@gmail.com', 'merilin.sellik@gmail.com', ''),
(7, 1, 'Pärnu Mai Kooli võimla', '', '', '', ''),
(8, 1, 'Pärnu Raeküla Kooli võimla', '', '', '', ''),
(9, 1, 'Pärnu Spordihall', '', '', '', ''),
(10, 1, 'Pärnu Tammsaare Kooli võimla', '', '', '', ''),
(11, 1, 'Pärnu Vanalinna Põhikooli võimla', '', '', '', ''),
(12, 1, 'Raeküla Vanakooli keskus', '535353', 'test@test.ee', 'test@test.ee', ''),
(13, 1, 'Pärnu Rannastaadion', '', '', '', ''),
(19, 1, 'Raja tänava ujula', '', '', '', ''),
(20, 2, 'Pärnu Ülejõe Põhikooli spordisaalid', '', '', '', ''),
(21, 2, 'Pärnu Rääma Põhikooli võimla', '', '', '', ''),
(22, 2, 'Pärnu Vabakooli võimla ja jõusaal', '', '', '', ''),
(23, 2, 'Nooruse Maja', '58371731', 'johh@vanadtostjad.ee', 'roland.simanis@paikuse.eee', 'jhjhkjh'),
(35, 0, 'Pärnu Noorte Vabaajakeskus', '', '', '', '');

CREATE TABLE `regions` (
  `regionID` int(11) NOT NULL,
  `regionName` varchar(255) NOT NULL
);
INSERT INTO `regions` (`regionID`, `regionName`) VALUES
(1, 'Pärnu Kesklinn/Raeküla'),
(2, 'Pärnu Ülejõe'),
(3, 'Audru'),
(4, 'Tõstamaa'),
(5, 'Paikuse');


CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `buildingID` int(11) NOT NULL,
  `roomName` varchar(255) NOT NULL,
  `activeRoom` int(11) NOT NULL,
  `roomActive` tinyint(1) NOT NULL DEFAULT '1'
);
INSERT INTO `rooms` (`id`, `buildingID`, `roomName`, `activeRoom`, `roomActive`) VALUES
(1, 2, 'Suur saal', 1, 1),
(3, 5, 'Väike spordisaal', 1, 1),
(8, 3, 'Palliväljak 1', 1, 1),
(16, 5, 'Suur saal', 1, 1),
(20, 2, 'Väike saal', 1, 1),
(28, 1, 'Kesklinna Koolide Võimla', 1, 1),
(181, 23, 'Saal', 1, 1),
(182, 23, 'Väike saal', 1, 1),
(185, 8, 'Raeküla kooli võimla', 1, 1),
(186, 10, 'Tammsaare kooli spordisaal', 1, 1),
(187, 10, 'Tammsaare kooli aula', 1, 1),
(188, 11, 'Vanalinna spordisaal', 1, 1),
(189, 3, 'Palliväljak 2', 1, 1),
(190, 7, 'Mai võimla', 1, 1),
(191, 7, 'Mai aula', 1, 1),
(192, 9, 'Suur väljak', 1, 1),
(193, 9, 'Suur saal väljak 1', 1, 1),
(194, 9, 'Suur saal väljak 2', 1, 1),
(195, 9, 'Suur saal väljak 3', 1, 1),
(196, 9, 'Väike saal', 1, 1),
(197, 9, 'Aeroobika saal', 1, 1),
(198, 9, 'Nõupidamiste ruum', 1, 1),
(199, 13, 'Staadion (õues)', 1, 1),
(200, 13, 'Harjutusväljak (õues)', 1, 1),
(201, 35, 'Noortekeskuse võimla', 1, 1),
(202, 4, 'Audru võimla', 1, 1),
(203, 6, 'Pärnu Koidula Gümnaasiumi võimla', 1, 1),
(204, 12, 'Saal', 1, 1),
(205, 19, 'Raja ujula', 1, 1),
(206, 20, 'Ülejõe kooli võimla', 1, 1),
(207, 21, 'Rääma võimla', 1, 1),
(208, 22, 'Vabakooli võimla', 1, 1),
(209, 22, 'Vabakooli jõusaal', 1, 1);


CREATE TABLE `userRoles` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL
);
INSERT INTO `userRoles` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'Juht'),
(3, 'Haldur');
