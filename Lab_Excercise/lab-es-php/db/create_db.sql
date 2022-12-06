Istruzioni per creare il database e la tabella

Andare in phpmyAdmin e andare nella voce di menu a tab "SQL".

1. Creare il DB

CREATE DATABASE giugno

2. Andare nel database appena creato e create la tabella

CREATE TABLE `insiemi` (
  `id` int(11) NOT NULL,
  `valore` int(11) NOT NULL,
  `insieme` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

ALTER TABLE `insiemi`
ADD PRIMARY KEY (`id`);

ALTER TABLE `insiemi`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

3. Popolare il DB

INSERT INTO `insiemi` (`id`, `valore`, `insieme`) VALUES
(1, 19, 1),
(2, 2, 1),
(3, 14, 1),
(4, 98, 2),
(5, 1, 2),
(6, 19, 2);