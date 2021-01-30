CREATE TABLE `ArtikelArtikel` (
  `ID` int(11) NOT NULL,
  `DatumVpisa` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `RezervacijaArtikel` (
  `ID_rezervacija` int(11) NOT NULL,
  `IDArtikel` int(11) NOT NULL,
  `TelefonskaStevilka` varchar(15) NOT NULL,
  `DatumRezervacije` timestamp NOT NULL DEFAULT current_timestamp(),
  `JePrevzet` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `ArtikelArtikel` (`ID`, `DatumVpisa`) VALUES
(1, '2020-12-01 12:10:13'),
(2, '2020-12-01 12:10:16'),
(3, '2020-12-11 09:38:59'),
(4, '2020-12-11 09:38:59'),
(5, '2020-12-11 09:38:59'),
(6, '2020-12-11 09:38:59'),
(7, '2020-12-11 09:38:59');

INSERT INTO `RezervacijaArtikel` (`ID_rezervacija`, `IDArtikel`, `TelefonskaStevilka`, `DatumRezervacije`, `JePrevzet`) VALUES
(1, 1, '+386123455678', '2020-12-11 15:05:47', 0),
(2, 3, '+386123455678', '2020-12-11 15:05:55', 0),
(3, 4, '+386123455678', '2020-12-11 15:06:05', 0);


ALTER TABLE `ArtikelArtikel`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `RezervacijaArtikel`
  ADD PRIMARY KEY (`ID_rezervacija`),
  ADD KEY `IDArtikel` (`IDArtikel`);


ALTER TABLE `ArtikelArtikel`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `RezervacijaArtikel`
  MODIFY `ID_rezervacija` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
  

ALTER TABLE `RezervacijaArtikel`
  ADD CONSTRAINT `RezervacijaArtikel_ibfk_2` FOREIGN KEY (`IDArtikel`) REFERENCES `ArtikelArtikel` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

