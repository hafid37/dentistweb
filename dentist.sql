-- قاعدة بيانات عيادة الأسنان
CREATE DATABASE IF NOT EXISTS `dentist` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `dentist`;

-- جدول قائمة الانتظار
CREATE TABLE `attente` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(250) NOT NULL,
  `age` VARCHAR(150) DEFAULT NULL,
  `heure` TIME NOT NULL DEFAULT CURRENT_TIME,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- جدول المصاريف
CREATE TABLE `charges` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `motif` VARCHAR(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- جدول المستخدمين (لتسجيل الدخول)
CREATE TABLE `comptes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(250) NOT NULL,
  `password` VARCHAR(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `comptes` (`nom`, `password`) VALUES ('admin', '1234');

-- جدول المرضى
CREATE TABLE `patients` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(200) NOT NULL,
  `date_naissance` VARCHAR(100) DEFAULT NULL,
  `age` VARCHAR(150) DEFAULT NULL,
  `sex` VARCHAR(200) NOT NULL,
  `adresse` VARCHAR(300) DEFAULT NULL,
  `maladie` VARCHAR(200) DEFAULT NULL,
  `telephone` VARCHAR(200) DEFAULT NULL,
  `date_premiere_visite` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `country` VARCHAR(255) DEFAULT NULL,
  `state` VARCHAR(255) DEFAULT NULL,
  `last_visit` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `patients` (`nom`, `date_naissance`, `age`, `sex`, `adresse`, `maladie`, `telephone`)
VALUES ('تراري أحمد', '1993-05-12', '32', 'ذكر', 'الجزائر', 'لا شيء', '0542857456');

-- جدول المواعيد
CREATE TABLE `rendezvous` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `patient` VARCHAR(250) NOT NULL,
  `motif` VARCHAR(250) NOT NULL,
  `date` DATE NOT NULL,
  `heure` TIME NOT NULL,
  `remarque` VARCHAR(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- جدول الخدمات
CREATE TABLE `soins` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `soin` VARCHAR(250) NOT NULL,
  `dent` VARCHAR(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- جدول الموردين
CREATE TABLE `fournisseur` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(250) NOT NULL,
  `telephone` VARCHAR(250) DEFAULT NULL,
  `adresse` VARCHAR(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- جدول الأدوية
CREATE TABLE `medicaments` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(250) NOT NULL,
  `dci` VARCHAR(250) DEFAULT NULL,
  `dosage` VARCHAR(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- جدول المصاريف الكاملة
CREATE TABLE `somme_charges` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `fournisseur` VARCHAR(250) NOT NULL,
  `article` VARCHAR(250) NOT NULL,
  `prix` FLOAT DEFAULT NULL,
  `qnt` INT(11) DEFAULT NULL,
  `total` FLOAT DEFAULT NULL,
  `versement` FLOAT DEFAULT NULL,
  `reste` FLOAT DEFAULT NULL,
  `date` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `heure` TIME NOT NULL DEFAULT CURRENT_TIME,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- جدول الوضعيات المالية
CREATE TABLE `situation` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(250) NOT NULL,
  `soin` VARCHAR(200) NOT NULL,
  `dent` VARCHAR(250) DEFAULT NULL,
  `cout` FLOAT NOT NULL,
  `versement` FLOAT NOT NULL,
  `reste` FLOAT NOT NULL,
  `date` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `heure` TIME DEFAULT CURRENT_TIME,
  `remarque` VARCHAR(250) DEFAULT NULL,
  `user` VARCHAR(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- جدول المستخدمين للنظام (إضافي)
CREATE TABLE `user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(250) NOT NULL,
  `password` VARCHAR(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `user` (`nom`, `password`) VALUES ('manager', 'admin');
