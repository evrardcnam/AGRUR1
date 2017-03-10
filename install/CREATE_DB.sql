SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
CREATE TABLE `certification` (
  `idCertification` int(11) NOT NULL,
  `libelleCertification` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `client` (
  `idClient` int(11) NOT NULL,
  `nomClient` varchar(255) NOT NULL,
  `adresseClient` varchar(255) DEFAULT NULL,
  `nomResAchats` varchar(255) DEFAULT NULL,
  `idUser` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `commande` (
  `numCommande` int(11) NOT NULL,
  `dateConditionnement` date DEFAULT NULL,
  `dateEnvoie` date DEFAULT NULL,
  `idConditionnement` int(11) NOT NULL,
  `idLot` int(11) NOT NULL,
  `idClient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `commune` (
  `idCommune` int(11) NOT NULL,
  `nomCommune` varchar(255) DEFAULT NULL,
  `communeAoc` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `conditionnement` (
  `idConditionnement` int(11) NOT NULL,
  `libelleConditionnement` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `livraison` (
  `idLivraison` int(11) NOT NULL,
  `dateLivraison` date DEFAULT NULL,
  `typeProduit` varchar(255) DEFAULT NULL,
  `idVerger` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `lot` (
  `idLot` int(11) NOT NULL,
  `codeLot` varchar(255) NOT NULL,
  `calibreLot` varchar(255) NOT NULL,
  `quantite` int(11) NOT NULL,
  `idLivraison` int(11) DEFAULT NULL,
  `numCommande` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `obtient` (
  `idCertification` int(11) NOT NULL,
  `idProducteur` int(11) NOT NULL,
  `dateObtention` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `producteur` (
  `idProducteur` int(11) NOT NULL,
  `nomProducteur` varchar(255) NOT NULL,
  `dateAdhesion` date DEFAULT NULL,
  `adherent` tinyint(1) DEFAULT NULL,
  `adresseProducteur` varchar(255) DEFAULT NULL,
  `idUser` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `role` enum('admin','producteur','client','') NOT NULL DEFAULT 'admin',
  `idProducteur` int(11) DEFAULT NULL,
  `idClient` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `variete` (
  `idVariete` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `varieteAoc` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `verger` (
  `idVerger` int(11) NOT NULL,
  `nomVerger` varchar(255) DEFAULT NULL,
  `superficie` int(11) DEFAULT NULL,
  `arbresParHectare` int(11) DEFAULT NULL,
  `idVariete` int(11) NOT NULL,
  `idCommune` int(11) DEFAULT NULL,
  `idProducteur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `certification`
  ADD PRIMARY KEY (`idCertification`);
ALTER TABLE `client`
  ADD PRIMARY KEY (`idClient`),
  ADD UNIQUE KEY `FK_client_users_idUser` (`idUser`);
ALTER TABLE `commande`
  ADD PRIMARY KEY (`numCommande`),
  ADD KEY `FK_commande_idConditionnement` (`idConditionnement`),
  ADD KEY `FK_commande_lot_codelot` (`idLot`),
  ADD KEY `FK_commande_nomClient` (`idClient`);
ALTER TABLE `commune`
  ADD PRIMARY KEY (`idCommune`);
ALTER TABLE `conditionnement`
  ADD PRIMARY KEY (`idConditionnement`);
ALTER TABLE `livraison`
  ADD PRIMARY KEY (`idLivraison`),
  ADD KEY `FK_livraison_idVerger` (`idVerger`);
ALTER TABLE `lot`
  ADD PRIMARY KEY (`idLot`),
  ADD KEY `FK_lot_idLivraison` (`idLivraison`),
  ADD KEY `FK_lot_commande_numcommande` (`numCommande`);
ALTER TABLE `obtient`
  ADD PRIMARY KEY (`idCertification`,`idProducteur`),
  ADD KEY `FK_obtient_nomProducteur` (`idProducteur`);
ALTER TABLE `producteur`
  ADD PRIMARY KEY (`idProducteur`),
  ADD KEY `FK_producteur_users_id` (`idUser`);
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `FK_users_producteur_nomproducteur` (`idProducteur`) USING BTREE,
  ADD UNIQUE KEY `FK_users_client_idClient` (`idClient`);
ALTER TABLE `variete`
  ADD PRIMARY KEY (`idVariete`);
ALTER TABLE `verger`
  ADD PRIMARY KEY (`idVerger`),
  ADD KEY `FK_verger_libelle` (`idVariete`),
  ADD KEY `FK_verger_idCommune` (`idCommune`),
  ADD KEY `FK_verger_nomProducteur` (`idProducteur`);
ALTER TABLE `certification`
  MODIFY `idCertification` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `client`
  MODIFY `idClient` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `commande`
  MODIFY `numCommande` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `commune`
  MODIFY `idCommune` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `conditionnement`
  MODIFY `idConditionnement` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `livraison`
  MODIFY `idLivraison` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `lot`
  MODIFY `idLot` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `producteur`
  MODIFY `idProducteur` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `variete`
  MODIFY `idVariete` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `verger`
  MODIFY `idVerger` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `client`
  ADD CONSTRAINT `FK_client_users_idUser` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_commande_idClient` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `FK_commande_idConditionnement` FOREIGN KEY (`idConditionnement`) REFERENCES `conditionnement` (`idConditionnement`),
  ADD CONSTRAINT `FK_commande_lot_idLot` FOREIGN KEY (`idLot`) REFERENCES `lot` (`idLot`);
ALTER TABLE `livraison`
  ADD CONSTRAINT `FK_livraison_idVerger` FOREIGN KEY (`idVerger`) REFERENCES `verger` (`idVerger`);
ALTER TABLE `lot`
  ADD CONSTRAINT `FK_lot_commande_numcommande` FOREIGN KEY (`numCommande`) REFERENCES `commande` (`numCommande`),
  ADD CONSTRAINT `FK_lot_idLivraison` FOREIGN KEY (`idLivraison`) REFERENCES `livraison` (`idLivraison`);
ALTER TABLE `obtient`
  ADD CONSTRAINT `FK_obtient_idCertification` FOREIGN KEY (`idCertification`) REFERENCES `certification` (`idCertification`),
  ADD CONSTRAINT `FK_obtient_idProducteur` FOREIGN KEY (`idProducteur`) REFERENCES `producteur` (`idProducteur`);
ALTER TABLE `producteur`
  ADD CONSTRAINT `FK_producteur_users_id` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`);
ALTER TABLE `users`
  ADD CONSTRAINT `FK_users_client_idClient` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `FK_users_producteur_idProducteur` FOREIGN KEY (`idProducteur`) REFERENCES `producteur` (`idProducteur`);
ALTER TABLE `verger`
  ADD CONSTRAINT `FK_verger_idCommune` FOREIGN KEY (`idCommune`) REFERENCES `commune` (`idCommune`),
  ADD CONSTRAINT `FK_verger_idProducteur` FOREIGN KEY (`idProducteur`) REFERENCES `producteur` (`idProducteur`),
  ADD CONSTRAINT `FK_verger_idVariete` FOREIGN KEY (`idVariete`) REFERENCES `variete` (`idVariete`);
CREATE TRIGGER `after_insert_commande` AFTER INSERT ON `commande` FOR EACH ROW UPDATE `lot` SET `numCommande` = NEW.numCommande WHERE `lot`.`idLot` LIKE NEW.idLot;
CREATE TRIGGER `after_update_commande` AFTER UPDATE ON `commande` FOR EACH ROW BEGIN
  IF (OLD.idLot <> NEW.idLot) THEN
    UPDATE `lot` SET `numCommande` = NEW.numCommande WHERE `lot`.`idLot` LIKE NEW.idLot;
    UPDATE `lot` SET `numCommande` = NULL WHERE `lot`.`idLot` LIKE OLD.idLot;
  END IF;
END;
CREATE TRIGGER `before_delete_commande` BEFORE DELETE ON `commande` FOR EACH ROW UPDATE `lot` SET `numCommande` = NULL WHERE `lot`.`idLot` LIKE OLD.idLot;
CREATE TRIGGER `after_insert_users` AFTER INSERT ON `users` FOR EACH ROW BEGIN
  CASE NEW.role
  	WHEN 'producteur' THEN UPDATE `producteur` SET `idUser` = NEW.id WHERE `producteur`.`idProducteur` = NEW.idProducteur;
    WHEN 'client' THEN UPDATE `client` SET `idUser` = NEW.id WHERE `client`.`idClient` = NEW.idClient;
    ELSE
      BEGIN
      END;
  END CASE;
END;
CREATE TRIGGER `after_update_users` AFTER UPDATE ON `users` FOR EACH ROW BEGIN
  UPDATE `producteur` SET `idUser` = NULL WHERE `producteur`.`idProducteur` = OLD.idProducteur;
  UPDATE `client` SET `idUser` = NULL WHERE `client`.`idClient` = OLD.idClient;
  CASE NEW.role
  	WHEN 'producteur' THEN UPDATE `producteur` SET `idUser` = NEW.id WHERE `producteur`.`idProducteur` = NEW.idProducteur;
    WHEN 'client' THEN UPDATE `client` SET `idUser` = NEW.id WHERE `client`.`idClient` = NEW.idClient;
  END CASE;
END;
CREATE TRIGGER `before_delete_users` BEFORE DELETE ON `users` FOR EACH ROW BEGIN
  UPDATE `producteur` SET `idUser` = NULL WHERE `producteur`.`idProducteur` = OLD.idProducteur;
  UPDATE `client` SET `idUser` = NULL WHERE `client`.`idClient` = OLD.idClient;
END;