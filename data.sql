SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
INSERT INTO `volunteer` (`volunteer_id`, `full_name`, `email`, `phone`, `skills`, `profile_picture`, `status`) VALUES
(1, 'Austin Hinton', 'auctor.quis@hotmail.edu', '(04) 0003 4366', 'Asset Management', 'volunteer_1_1757236528.jpg', 'inactive'),
(2, 'Nathan Kane', 'curabitur.vel@outlook.org', '(05) 2777 1436', 'Customer Relations, Public Relations, Payroll', 'volunteer_2_1757236537.jpg', 'inactive'),
(3, 'Meredith Mcpherson', 'nisl.sem@icloud.couk', '(05) 0018 1447', 'Legal Department', 'volunteer_3_1757236547.jpg', 'inactive'),
(4, 'Dante Estrada', 'mauris.erat.eget@hotmail.couk', '(02) 4507 7434', 'Finances, Accounting, Advertising, Legal Department', 'volunteer_4_1757236822.jpeg', 'inactive'),
(5, 'Zahir Hinton', 'ante.iaculis@aol.edu', '(08) 2992 3148', 'Legal Department, Public Relations, Quality Assurance', 'volunteer_5_1757236833.jpeg', 'inactive'),
(6, 'Tallulah Long', 'et.ultrices@aol.edu', '(02) 7861 3487', 'Customer Relations, Media Relations', 'volunteer_6_1757236843.jpeg', 'inactive'),
(7, 'Caesar Caldwell', 'sed.pharetra@google.net', '(07) 3335 4793', 'Public Relations, Quality Assurance', 'volunteer_7_1757236863.jpeg', 'inactive'),
(8, 'Quinlan Parker', 'fringilla.mi@icloud.couk', '(09) 6775 2622', 'Media Relations, Finances, Asset Management, Sales and Marketing, Accounting', 'volunteer_8_1757236871.jpeg', 'inactive'),
(9, 'Jermaine Hernandez', 'tristique.pharetra.quisque@outlook.com', '(03) 4114 7128', 'Public Relations, Human Resources, Finances, Sales and Marketing', 'volunteer_9_1757236882.jpeg', 'inactive'),
(10, 'Nomlanga Merritt', 'iaculis.nec.eleifend@yahoo.ca', '(01) 0903 2525', 'Customer Service, Tech Support, Human Resources', 'volunteer_10_1757236891.jpeg', 'inactive'),
(11, 'Tiger Horn', 'ridiculus.mus.aenean@hotmail.net', '(05) 8833 0123', 'Tech Support', 'volunteer_11_1757236905.jpeg', 'inactive'),
(12, 'Bernard Melendez', 'non@aol.couk', '(05) 1693 8275', 'Accounting, Payroll', 'volunteer_12_1757236921.jpeg', 'inactive');

INSERT INTO `organisation` (`organisation_id`, `organisation_name`, `contact_person_full_name`, `email`, `phone`) VALUES
(1, 'Vitae Diam Institute', 'Urielle Garza', 'placerat.orci.lacus@protonmail.couk', '(03) 5324 6751'),
(2, 'Eu Turpis Institute', 'Brandon Christian', 'semper@icloud.net', '(06) 2806 3038'),
(3, 'Velit Pellentesque Associates', 'Honorato Mosley', 'molestie.tortor@icloud.couk', '(07) 5688 4653'),
(4, 'Gravida PC', 'Phillip Johnston', 'non.hendrerit.id@icloud.edu', '(03) 5568 9432'),
(5, 'Donec Vitae Associates', 'Alfreda Munoz', 'ut.sem.nulla@protonmail.net', '(01) 5554 5200'),
(6, 'Cras Dictum Ultricies Incorporated', 'Garrett Hopper', 'ac@outlook.org', '(07) 1611 1384'),
(7, 'Dolor Dolor Ltd', 'Whilemina Branch', 'ac.urna.ut@google.couk', '(05) 9221 6582'),
(8, 'Sed Industries', 'Robert Donovan', 'facilisis.magna@icloud.net', '(06) 8128 7071'),
(9, 'Ac Mi LLP', 'Carissa Fitzgerald', 'ligula@yahoo.net', '(04) 0284 1735'),
(10, 'Dolor Fusce Corporation', 'Vera Noel', 'sed.orci.lobortis@icloud.net', '(04) 3743 7756'),
(11, 'Luctus Et Ultrices Company', 'Abel Flowers', 'nullam@protonmail.net', '(02) 7976 6641'),
(12, 'Nec Industries', 'Hedda Dotson', 'ut.erat.sed@hotmail.org', '(01) 6451 2215'),
(13, 'Mi Duis Industries', 'Lysandra Yates', 'ut.nulla@outlook.edu', '(09) 1696 5123'),
(14, 'Tellus LLP', 'Hilel Aguirre', 'donec.tincidunt.donec@icloud.com', '(02) 4632 5613'),
(15, 'Vivamus Nibh Dolor Incorporated', 'Hiroko Dickson', 'adipiscing@outlook.ca', '(06) 7151 1315');




INSERT INTO `contact_messages` (`contact_messages_id`, `full_name`, `email`, `phone`, `message`, `replied`, `created_at`) VALUES
(1, 'Jenette Carey', 'elit@aol.ca', '(04) 0242 1346', 'ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque. Sed eget lacus. Mauris non dui nec urna suscipit nonummy. Fusce fermentum fermentum arcu. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae Phasellus ornare. Fusce mollis. Duis sit amet diam eu dolor egestas rhoncus. Proin nisl sem, consequat nec, mollis vitae, posuere at,', 1, '2025-09-07 08:36:30'),
(2, 'Jin Clarke', 'ante.maecenas@icloud.org', '(06) 6580 1723', 'commodo at, libero. Morbi accumsan laoreet ipsum. Curabitur consequat, lectus sit amet luctus vulputate, nisi sem semper erat, in consectetuer ipsum nunc id enim. Curabitur massa. Vestibulum accumsan neque et nunc. Quisque ornare tortor at risus. Nunc ac sem ut dolor dapibus gravida. Aliquam tincidunt, nunc ac mattis ornare, lectus ante dictum mi, ac mattis velit justo nec ante. Maecenas mi felis, adipiscing fringilla, porttitor vulputate, posuere vulputate, lacus. Cras interdum. Nunc sollicitudin commodo ipsum. Suspendisse non leo. Vivamus nibh dolor, nonummy ac, feugiat non, lobortis', 0, '2025-09-07 08:36:30'),
(3, 'Yoshio Alexander', 'ac.mattis.semper@icloud.net', '(04) 3442 2586', 'consectetuer, cursus et, magna. Praesent interdum ligula eu enim. Etiam imperdiet dictum magna. Ut tincidunt orci quis lectus. Nullam suscipit, est ac', 0, '2025-09-07 08:36:30'),
(4, 'Helen Cotton', 'sollicitudin.commodo@icloud.net', '(08) 6263 1892', 'risus. In mi pede, nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris eu elit. Nulla facilisi.', 1, '2025-09-07 08:36:30'),
(5, 'Dillon English', 'pellentesque.ultricies@aol.ca', '(05) 4564 2274', 'lobortis mauris. Suspendisse aliquet molestie tellus. Aenean egestas hendrerit neque. In ornare sagittis felis. Donec tempor, est ac mattis semper, dui lectus rutrum urna, nec luctus felis purus ac tellus. Suspendisse sed dolor. Fusce mi lorem, vehicula et, rutrum eu, ultrices sit amet, risus. Donec nibh enim, gravida sit amet, dapibus id, blandit at, nisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel nisl. Quisque fringilla euismod enim. Etiam gravida molestie arcu. Sed eu nibh vulputate mauris sagittis placerat. Cras dictum', 0, '2025-09-07 08:36:30'),
(6, 'Bertha Saunders', 'fusce.feugiat@yahoo.ca', '(02) 4817 1194', 'neque sed dictum eleifend, nunc risus varius orci, in consequat enim diam vel arcu. Curabitur ut odio vel est tempor bibendum. Donec felis orci, adipiscing non, luctus sit amet, faucibus ut, nulla. Cras eu tellus eu augue porttitor interdum. Sed', 0, '2025-09-07 08:36:30'),
(7, 'Ezra Phelps', 'ac.nulla@icloud.org', '(07) 4292 8714', 'tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id nunc interdum feugiat. Sed nec metus facilisis lorem tristique aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam', 0, '2025-09-07 08:36:30'),
(8, 'Emerald Joyner', 'ultrices@yahoo.couk', '(05) 7187 2516', 'Integer aliquam adipiscing lacus. Ut nec urna et arcu imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin a, malesuada id, erat. Etiam vestibulum massa rutrum magna. Cras convallis convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et pede. Nunc sed orci lobortis augue scelerisque mollis. Phasellus libero mauris, aliquam eu,', 0, '2025-09-07 08:36:30'),
(9, 'Mohammad Snider', 'ac.mi@outlook.ca', '(06) 4183 9540', 'vitae mauris sit amet lorem semper auctor. Mauris vel turpis. Aliquam adipiscing lobortis risus. In mi pede, nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque. Sed eget lacus. Mauris non dui nec urna suscipit nonummy.', 0, '2025-09-07 08:36:30'),
(10, 'Evan Benton', 'urna.vivamus@google.net', '(08) 6548 9164', 'sem egestas blandit. Nam nulla magna, malesuada vel, convallis in, cursus et, eros. Proin ultrices. Duis volutpat nunc sit', 1, '2025-09-07 08:36:30'),
(11, 'Howard Witt', 'blandit.enim.consequat@google.com', '(03) 3713 5381', 'ac orci. Ut semper pretium neque. Morbi quis urna. Nunc quis arcu vel quam dignissim pharetra. Nam ac nulla. In tincidunt congue turpis. In condimentum. Donec at arcu.', 1, '2025-09-07 08:36:30'),
(12, 'Hyacinth Mosley', 'sagittis.lobortis.mauris@aol.com', '(07) 6358 6173', 'orci lobortis augue scelerisque mollis. Phasellus libero mauris, aliquam eu, accumsan sed, facilisis vitae, orci. Phasellus dapibus quam quis diam. Pellentesque', 1, '2025-09-07 08:36:30'),
(13, 'Cally Martin', 'mauris.eu@icloud.com', '(06) 8704 1297', 'metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla vulputate dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id nunc interdum feugiat. Sed nec metus facilisis lorem tristique aliquet. Phasellus fermentum convallis ligula. Donec luctus', 0, '2025-09-07 08:36:30'),
(14, 'Roary Wolf', 'quam.vel@protonmail.net', '(02) 9789 8316', 'ornare, libero at auctor ullamcorper, nisl arcu iaculis enim, sit amet ornare lectus justo eu arcu. Morbi sit amet massa. Quisque porttitor eros nec tellus. Nunc lectus pede, ultrices a, auctor non, feugiat nec, diam. Duis mi enim, condimentum eget, volutpat ornare, facilisis eget, ipsum. Donec sollicitudin adipiscing ligula. Aenean gravida nunc sed pede. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel arcu eu odio tristique pharetra. Quisque ac libero', 0, '2025-09-07 08:36:30'),
(15, 'Dominic Sharpe', 'fringilla.mi.lacinia@google.net', '(04) 3244 9141', 'egestas, urna justo faucibus lectus, a sollicitudin orci sem eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer in magna. Phasellus dolor elit, pellentesque a, facilisis non, bibendum sed, est. Nunc laoreet lectus quis massa. Mauris vestibulum, neque sed dictum eleifend, nunc risus varius orci, in consequat enim diam vel arcu. Curabitur ut odio vel', 0, '2025-09-07 08:36:30');

INSERT INTO `event` (`event_id`, `title`, `location`, `description`, `date`, `organisation_id`) VALUES
(1, 'quis, tristique ac,', 'Ap #517-935 Dictum Street', 'lacus. Nulla tincidunt, neque vitae semper egestas, urna justo faucibus lectus, a sollicitudin orci sem eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer in magna. Phasellus dolor elit, pellentesque a, facilisis non, bibendum sed, est. Nunc laoreet lectus quis massa. Mauris vestibulum, neque sed dictum eleifend, nunc risus varius orci, in consequat enim diam vel arcu. Curabitur ut odio vel est tempor bibendum. Donec felis orci, adipiscing non, luctus sit amet, faucibus ut, nulla. Cras eu tellus eu augue porttitor interdum. Sed', '2026-05-17 21:50:00', 11),
(2, 'dui nec urna suscipit nonummy. Fusce', '396-9133 Nostra, Ave', 'Integer aliquam adipiscing lacus. Ut nec urna et arcu imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin a, malesuada id, erat. Etiam vestibulum', '2027-02-25 20:15:16', 4),
(3, 'risus. Quisque libero lacus, varius et,', '612-6137 Proin Rd.', 'luctus et ultrices posuere cubilia Curae Phasellus ornare. Fusce mollis. Duis sit amet diam eu dolor egestas rhoncus. Proin nisl sem, consequat nec, mollis vitae, posuere at, velit. Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue. Sed molestie. Sed id risus quis diam luctus lobortis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Mauris ut quam vel sapien imperdiet ornare. In faucibus. Morbi vehicula. Pellentesque tincidunt tempus risus. Donec egestas. Duis ac arcu. Nunc mauris. Morbi non sapien molestie orci tincidunt adipiscing. Mauris', '2027-01-02 10:03:47', 15),
(4, 'rutrum non, hendrerit id, ante. Nunc mauris sapien,', '9181 Curae Road', 'lorem semper auctor. Mauris vel turpis. Aliquam adipiscing lobortis risus. In mi pede, nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque. Sed eget lacus. Mauris non dui nec urna suscipit nonummy. Fusce fermentum fermentum arcu. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae Phasellus ornare. Fusce mollis. Duis sit amet diam eu dolor egestas rhoncus. Proin nisl sem, consequat nec, mollis vitae, posuere at, velit. Cras lorem lorem, luctus ut, pellentesque', '2027-02-13 09:42:28', 12),
(5, 'dui. Cras pellentesque. Sed dictum. Proin eget odio. Aliquam vulputate', '546-6175 Nam St.', 'dignissim pharetra. Nam ac nulla. In tincidunt congue turpis. In condimentum. Donec at arcu. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae Donec tincidunt. Donec vitae', '2026-07-27 14:09:19', 8),
(6, 'arcu. Nunc mauris.', 'Ap #273-9519 Quam Avenue', 'egestas. Aliquam nec enim. Nunc ut erat. Sed nunc est, mollis non, cursus non, egestas a, dui. Cras pellentesque. Sed dictum. Proin eget odio. Aliquam vulputate ullamcorper magna. Sed eu eros.', '2026-06-13 21:48:38', 15),
(7, 'facilisi. Sed neque. Sed eget lacus. Mauris non dui nec', 'P.O. Box 279, 3065 Lectus St.', 'Suspendisse ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla vulputate dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id nunc interdum feugiat. Sed nec metus facilisis lorem tristique aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero et tristique pellentesque, tellus sem mollis dui, in sodales elit erat vitae risus. Duis a mi fringilla mi', '2026-08-01 23:30:19', 7),
(8, 'quam, elementum at, egestas a, scelerisque sed,', '842-8270 Quis Road', 'feugiat tellus lorem eu metus. In lorem. Donec elementum, lorem ut aliquam iaculis, lacus pede sagittis augue, eu tempor erat neque non quam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam fringilla cursus purus. Nullam scelerisque neque sed sem egestas blandit. Nam nulla magna, malesuada vel, convallis in, cursus et, eros. Proin ultrices. Duis volutpat nunc sit amet metus. Aliquam erat volutpat. Nulla facilisis. Suspendisse commodo tincidunt nibh. Phasellus nulla. Integer vulputate, risus a ultricies adipiscing,', '2026-05-06 07:48:31', 4),
(9, 'sit amet, risus.', '569-7411 Semper Rd.', 'eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum. Phasellus in felis. Nulla tempor augue ac ipsum. Phasellus vitae mauris sit amet lorem semper auctor. Mauris vel turpis. Aliquam adipiscing lobortis risus. In mi pede, nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque. Sed eget lacus. Mauris non dui nec urna suscipit nonummy. Fusce', '2026-09-28 07:53:40', 11),
(10, 'tempor diam dictum sapien. Aenean massa. Integer vitae', '816-1988 Parturient Rd.', 'molestie pharetra nibh. Aliquam ornare, libero at auctor ullamcorper, nisl arcu iaculis enim, sit amet ornare lectus justo eu arcu. Morbi sit amet massa. Quisque porttitor eros nec tellus. Nunc lectus pede, ultrices a, auctor non, feugiat nec, diam. Duis mi enim, condimentum eget, volutpat ornare, facilisis', '2025-11-02 18:15:02', 5),
(11, 'Vivamus rhoncus. Donec', 'Ap #697-2985 Metus. Street', 'egestas. Fusce aliquet magna a neque. Nullam ut nisi a odio semper cursus. Integer mollis. Integer tincidunt aliquam arcu. Aliquam ultrices', '2027-04-09 12:29:33', 2),
(12, 'tellus justo sit amet nulla. Donec non justo. Proin', 'Ap #268-4153 Diam. Rd.', 'amet, consectetuer adipiscing elit. Etiam laoreet, libero et tristique pellentesque, tellus sem mollis dui, in sodales elit erat vitae risus. Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris a nunc. In at pede. Cras vulputate velit eu sem. Pellentesque ut ipsum', '2027-01-20 04:04:52', 11);

INSERT INTO `user` (`user_id`, `username`, `password`, `role`, `volunteer_id`) VALUES
(9, 'Amy', '$2y$10$bM1yAKHjdoqUgdJ2nh24I.yVfWWUbR3w3.tVV9ExliNDsQFCC.R1a', 'admin', NULL),
(21, 'Austin', '$2y$12$6Nm4GVCygXR8kCLgV.acmebCeM92w4Uo6hgcu3gkhfAvJv68mOaWe', 'volunteer', 1),
(22, 'Nathan', '$2y$12$nwVihjSyQGi5Z0JigYbyhOAfB.chBUQNIPjLQXMWx58BQSU505Mc6', 'volunteer', 2),
(23, 'Meredith', '$2y$12$eLQc8Kyg.OYuTm1MDJeDcuiCsMZkxe/0oWrJ/eRP8IMUzSy5kY7gi', 'volunteer', 3),
(24, 'Dante', '$2y$12$oescwm8RL49pd2eJkQzvj..o5QQZWv042xlNhLbzGwXd6.iSin6TC', 'volunteer', 4),
(25, 'Zahir', '$2y$12$JpVDFWPROJ.DmJ13R3sFpeoIAE858aDAQI6boxRkAuNAzGMKN0JpW', 'volunteer', 5),
(26, 'Tallulah', '$2y$12$uUc02em0.hX.ENqTX7fytupjzCAJsDm4SLBsMkUrjlq5Xj5zT4oqC', 'volunteer', 6),
(27, 'Caesar', '$2y$12$7WE.R8C/061eyxl/GPKlFes1Pn28xhIph27CeOvCRCGaACbYMWqj2', 'volunteer', 7),
(28, 'Quinlan', '$2y$12$fYF0Z3407H3pHjS3f0Bgj.nZwCEbwKcuTHkBeWi.4V52lLBVugawS', 'volunteer', 8),
(29, 'Jermaine', '$2y$12$BQ/9pOG3xuW524y5m6SKh.O80pqWbGAAHOupeVwB0PTBKwm0.WXqO', 'volunteer', 9),
(30, 'Nomlanga', '$2y$12$.tawCWq8DuHEF5ZqOy58ee3ODtPku3qoCMrfZyimv.PqE/N.pvdHW', 'volunteer', 10);

INSERT INTO `volunteer_event` (`event_id`, `volunteer_id`) VALUES
(9, 2),
(9, 3),
(11, 3),
(10, 4),
(2, 7),
(5, 9),
(12, 9),
(6, 10),
(6, 11),
(8, 12);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
