INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('00506000000', 'TABUNGAN', 'ph/tabungan', 'index', '1', '1', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('00506000001', 'TABUNGAN - ADD', 'ph/tabungan', 'add', '0', '1', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('00506000002', 'TABUNGAN - EDIT', 'ph/tabungan', 'edit', '0', '1', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('00506000003', 'TABUNGAN - DELETE', 'ph/tabungan', 'delete', '0', '1', '0');
UPDATE `simapes`.`md_menu` SET `ID_MENU`='00509000000' WHERE `ID_MENU`='00505000000';
CREATE TABLE `simapes`.`ph_tabungan` (
  `ID_TABUNGAN` INT(11) NOT NULL AUTO_INCREMENT,
  `TA_TABUNGAN` INT(11) NULL,
  `SISWA_TABUNGAN` INT(11) NULL,
  `BATASAN_TABUNGAN` INT(11) NULL,
  `NILAI_TABUNGAN` DOUBLE NULL,
  `USER_TABUNGAN` INT(11) NULL,
  `CREATED_TABUNGAN` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID_TABUNGAN`));
ALTER TABLE `ph_tabungan` ADD INDEX( `TA_TABUNGAN`, `SISWA_TABUNGAN`, `BATASAN_TABUNGAN`, `USER_TABUNGAN`);
ALTER TABLE `ph_tabungan` ADD  FOREIGN KEY (`BATASAN_TABUNGAN`) REFERENCES `ph_batasan`(`ID_BATASAN`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `ph_tabungan` ADD  FOREIGN KEY (`SISWA_TABUNGAN`) REFERENCES `md_siswa`(`ID_SISWA`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `ph_tabungan` ADD  FOREIGN KEY (`TA_TABUNGAN`) REFERENCES `md_tahun_ajaran`(`ID_TA`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `ph_tabungan` ADD  FOREIGN KEY (`USER_TABUNGAN`) REFERENCES `md_user`(`ID_USER`) ON DELETE RESTRICT ON UPDATE CASCADE;
USE `simapes`;
DROP procedure IF EXISTS `gunakan_hafalan_tabungan`;

DELIMITER $$
USE `simapes`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `gunakan_hafalan_tabungan`(TA INT, TABUNGAN INT)
BEGIN
	START TRANSACTION;
	INSERT INTO ph_nilai
    (TA_PHN, SISWA_PHN, BATASAN_PHN, NILAI_PHN, USER_PHN)
    SELECT
    TA, SISWA_TABUNGAN, BATASAN_TABUNGAN, NILAI_TABUNGAN, USER_TABUNGAN
    FROM ph_tabungan
    WHERE ID_TABUNGAN=TABUNGAN;
    DELETE FROM ph_tabungan WHERE ID_TABUNGAN=TABUNGAN;
    COMMIT;
END$$

DELIMITER ;


INSERT INTO `simapes`.`md_hakakses` (`ID_HAKAKSES`, `NAME_HAKAKSES`, `COLOR_HAKAKSES`) VALUES ('14', 'BK', 'yellow');
INSERT INTO `simapes`.`md_hakakses_user` (`USER_HU`, `HAKAKSES_HU`) VALUES ('1', '14');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01401000000', 'DATA SISWA', 'akademik/siswa', 'index', '1', '1', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01402000001', 'POIN SISWA - ADD', 'bk/poin_siswa', 'add', '0', '1', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01402000002', 'POIN SISWA - EDIT', 'bk/poin_siswa', 'edit', '0', '1', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01402000003', 'POIN SISWA - DELETE', 'bk/poin_siswa', 'delete', '0', '1', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01402000000', 'POIN SISWA', 'bk/poin_siswa', 'index', '1', '1', '0');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('00000000000', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01401000000', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01402000000', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01402000001', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01402000002', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01402000003', '14');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01403000000', 'DCM', '#', '1', '1', '1');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01403001000', 'KELOMPOK', 'bk/kelompok', 'index', '1', '2', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01403001001', 'KELOMPOK - ADD', 'bk/kelompok', 'add', '0', '2', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01403001002', 'KELOMPOK - EDIT', 'bk/kelompok', 'edit', '0', '2', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01403001003', 'KELOMPOK - DELETE', 'bk/kelompok', 'delete', '0', '2', '0');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01403000000', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01403001001', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01403001000', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01403001002', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01403001003', '14');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01403002000', 'KATEGORI', 'bk/kategori', 'index', '1', '2', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01403002001', 'KATEGORI - ADD', 'bk/kategori', 'add', '0', '2', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01403002002', 'KATEGORI - EDIT', 'bk/kategori', 'edit', '0', '2', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01403002003', 'KATEGORI - DELETE', 'bk/kategori', 'delete', '0', '2', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01403003000', 'SOAL', 'bk/soal', 'index', '1', '2', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01403003001', 'SOAL - ADD', 'bk/soal', 'add', '0', '2', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01403003002', 'SOAL - EDIT', 'bk/soal', 'edit', '0', '2', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01403003003', 'SOAL - DELETE', 'bk/soal', 'delete', '0', '2', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01403004000', 'DCM SISWA', 'bk/dcm_siswa', 'index', '1', '2', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01403004001', 'DCM SISWA - ADD', 'bk/dcm_siswa', 'add', '0', '2', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01403004002', 'DCM SISWA - EDIT', 'bk/dcm_siswa', 'edit', '0', '2', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01403004003', 'DCM SISWA - DELETE', 'bk/dcm_siswa', 'delete', '0', '2', '0');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01403002000', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01403002001', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01403002002', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01403002003', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01403003000', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01403003001', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01403003002', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01403003003', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01403004000', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01403004001', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01403004002', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01403004003', '14');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01404000000', 'SURAT PEMANGGILAN', 'bk/surat_pemanggilan', 'index', '1', '1', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01405000000', 'PENANGAN SISWA', 'bk/penangan_siswa', 'index', '1', '1', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01405000001', 'PENANGAN SISWA - ADD', 'bk/penangan_siswa', 'add', '0', '1', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01405000002', 'PENANGAN SISWA - EDIT', 'bk/penangan_siswa', 'edit', '0', '1', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01405000003', 'PENANGAN SISWA - DELETE', 'bk/penangan_siswa', 'delete', '0', '1', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01406000000', 'LAPORAN', '#', '1', '1', '1');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01406001000', 'DCM', 'bk/laporan_dcm', 'index', '1', '2', '0');
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01406002000', 'PENANGANAN', 'bk/laporan_penanganan', 'index', '1', '2', '0');
UPDATE `simapes`.`md_menu` SET `NAME_MENU`='PENANGANAN SISWA', `CONTROLLER_MENU`='bk/penanganan_siswa' WHERE `ID_MENU`='01405000000';
UPDATE `simapes`.`md_menu` SET `NAME_MENU`='PENANGANAN SISWA - ADD', `CONTROLLER_MENU`='bk/penanganan_siswa' WHERE `ID_MENU`='01405000001';
UPDATE `simapes`.`md_menu` SET `NAME_MENU`='PENANGANAN SISWA - EDIT', `CONTROLLER_MENU`='bk/penanganan_siswa' WHERE `ID_MENU`='01405000002';
UPDATE `simapes`.`md_menu` SET `NAME_MENU`='PENANGANAN SISWA - DELETE', `CONTROLLER_MENU`='bk/penanganan_siswa' WHERE `ID_MENU`='01405000003';
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01404000000', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01405000000', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01405000001', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01405000002', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01405000003', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01406000000', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01406001000', '14');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01406002000', '14');
UPDATE `simapes`.`md_menu` SET `CONTROLLER_MENU`='komdis/laporan_poin' WHERE `ID_MENU`='01402000000';
DELETE FROM `simapes`.`md_menu` WHERE `ID_MENU`='01402000001';
DELETE FROM `simapes`.`md_menu` WHERE `ID_MENU`='01402000002';
DELETE FROM `simapes`.`md_menu` WHERE `ID_MENU`='01402000003';
CREATE TABLE `simapes`.`bk_kelompok` ( `ID_BKKEL` INT(12) NOT NULL AUTO_INCREMENT , `NAMA_BKKEL` VARCHAR(200) NOT NULL , `USER_BKKEL` INT(11) NOT NULL , `CREATED_BKKEL` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`ID_BKKEL`), INDEX (`USER_BKKEL`)) ENGINE = InnoDB;
ALTER TABLE `bk_kelompok` ADD FOREIGN KEY (`USER_BKKEL`) REFERENCES `md_user`(`ID_USER`) ON DELETE RESTRICT ON UPDATE CASCADE;
CREATE TABLE `simapes`.`bk_kategori` ( `ID_BKKAT` INT(11) NOT NULL AUTO_INCREMENT , `NAMA_BKKAT` VARCHAR(200) NOT NULL , `KELOMPOK_BKKAT` INT(11) NOT NULL , `USER_BKKAT` INT(11) NOT NULL , `CREATED_BKKAT` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`ID_BKKAT`), INDEX (`KELOMPOK_BKKAT`), INDEX (`USER_BKKAT`)) ENGINE = InnoDB;
ALTER TABLE `bk_kategori` ADD FOREIGN KEY (`KELOMPOK_BKKAT`) REFERENCES `bk_kelompok`(`ID_BKKEL`) ON DELETE RESTRICT ON UPDATE CASCADE; ALTER TABLE `bk_kategori` ADD FOREIGN KEY (`USER_BKKAT`) REFERENCES `md_user`(`ID_USER`) ON DELETE RESTRICT ON UPDATE CASCADE;
CREATE TABLE `simapes`.`bk_soal` ( `ID_BKSOAL` INT(11) NOT NULL AUTO_INCREMENT , `KATEGORI_BKSOAL` INT(11) NOT NULL , `KONTEN_BKSOAL` TEXT NOT NULL , `USER_BKSOAL` INT(11) NOT NULL , `CREATED_BKSOAL` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`ID_BKSOAL`), INDEX (`KATEGORI_BKSOAL`), INDEX (`USER_BKSOAL`)) ENGINE = InnoDB;
ALTER TABLE `bk_soal` ADD FOREIGN KEY (`KATEGORI_BKSOAL`) REFERENCES `bk_kategori`(`ID_BKKAT`) ON DELETE RESTRICT ON UPDATE CASCADE; ALTER TABLE `bk_soal` ADD FOREIGN KEY (`USER_BKSOAL`) REFERENCES `md_user`(`ID_USER`) ON DELETE RESTRICT ON UPDATE CASCADE;
CREATE TABLE `simapes`.`bk_dcm` ( `ID_DCM` INT(11) NOT NULL AUTO_INCREMENT , `SOAL_DCM` INT(11) NOT NULL , `TA_DCM` INT(11) NOT NULL , `TAHUN_DCM` YEAR NOT NULL , `USER_DCM` INT(11) NOT NULL , `CREATED_DCM` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`ID_DCM`), INDEX (`SOAL_DCM`), INDEX (`TA_DCM`), INDEX (`USER_DCM`)) ENGINE = InnoDB;
ALTER TABLE `bk_dcm` ADD `SISWA_DCM` INT(11) NOT NULL AFTER `TA_DCM`, ADD INDEX (`SISWA_DCM`);
ALTER TABLE `bk_dcm` ADD FOREIGN KEY (`SISWA_DCM`) REFERENCES `md_siswa`(`ID_SISWA`) ON DELETE RESTRICT ON UPDATE CASCADE; ALTER TABLE `bk_dcm` ADD FOREIGN KEY (`SOAL_DCM`) REFERENCES `bk_soal`(`ID_BKSOAL`) ON DELETE RESTRICT ON UPDATE CASCADE; ALTER TABLE `bk_dcm` ADD FOREIGN KEY (`TA_DCM`) REFERENCES `md_tahun_ajaran`(`ID_TA`) ON DELETE RESTRICT ON UPDATE CASCADE; ALTER TABLE `bk_dcm` ADD FOREIGN KEY (`USER_DCM`) REFERENCES `md_user`(`ID_USER`) ON DELETE RESTRICT ON UPDATE CASCADE;
CREATE TABLE `simapes`.`bk_pemanggilan` ( `ID_PANGGIL` INT(11) NOT NULL AUTO_INCREMENT , `TA_PANGGIL` INT(11) NOT NULL , `TANGGAL_PANGGIL` DATETIME NOT NULL , `NO_SURAT_PANGGIL` INT(11) NOT NULL , `POIN_PANGGIL` INT(11) NOT NULL , `DATA_KOMDIS_PANGGIL` TEXT NOT NULL , `USER_PANGGIL` INT(11) NOT NULL , `CREATED_PANGGIL` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`ID_PANGGIL`), INDEX (`TA_PANGGIL`), INDEX (`USER_PANGGIL`)) ENGINE = InnoDB;
ALTER TABLE `bk_pemanggilan` CHANGE `NO_SURAT_PANGGIL` `NO_SURAT_PANGGIL` INT(11) NULL DEFAULT NULL;
ALTER TABLE `bk_pemanggilan` ADD FOREIGN KEY (`TA_PANGGIL`) REFERENCES `md_tahun_ajaran`(`ID_TA`) ON DELETE RESTRICT ON UPDATE CASCADE; ALTER TABLE `bk_pemanggilan` ADD FOREIGN KEY (`USER_PANGGIL`) REFERENCES `md_user`(`ID_USER`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `bk_pemanggilan` ADD `SISWA_PANGGIL` INT(11) NOT NULL AFTER `TA_PANGGIL`, ADD INDEX (`SISWA_PANGGIL`);
ALTER TABLE `bk_pemanggilan` ADD FOREIGN KEY (`SISWA_PANGGIL`) REFERENCES `akad_siswa`(`ID_AS`) ON DELETE RESTRICT ON UPDATE CASCADE;
CREATE TABLE `simapes`.`bk_penanganan` ( `ID_PENANGANAN` INT(11) NOT NULL AUTO_INCREMENT , `TA_PENANGANAN` INT(11) NOT NULL , `SISWA_PENANGANAN` INT(11) NOT NULL , `KATEGORI_PENANGANAN` INT(11) NOT NULL , `PENYEBAB_PENANGANAN` TEXT NOT NULL , `SOLUSI_PENANGANAN` TEXT NOT NULL , `STATUS_PENANGANAN` ENUM('SELESAI','PROSES','BELUM') NOT NULL , `TANGGAL_PENANGANAN` DATETIME NOT NULL , `USER_PENANGANAN` INT(11) NOT NULL , `CREATED_PENANGANAN` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`ID_PENANGANAN`), INDEX (`TA_PENANGANAN`), INDEX (`SISWA_PENANGANAN`), INDEX (`KATEGORI_PENANGANAN`), INDEX (`USER_PENANGANAN`)) ENGINE = InnoDB;
ALTER TABLE `bk_penanganan` ADD FOREIGN KEY (`TA_PENANGANAN`) REFERENCES `md_tahun_ajaran`(`ID_TA`) ON DELETE RESTRICT ON UPDATE CASCADE; ALTER TABLE `bk_penanganan` ADD FOREIGN KEY (`SISWA_PENANGANAN`) REFERENCES `md_siswa`(`ID_SISWA`) ON DELETE RESTRICT ON UPDATE CASCADE; ALTER TABLE `bk_penanganan` ADD FOREIGN KEY (`KATEGORI_PENANGANAN`) REFERENCES `bk_kategori`(`ID_BKKAT`) ON DELETE RESTRICT ON UPDATE CASCADE; ALTER TABLE `bk_penanganan` ADD FOREIGN KEY (`USER_PENANGANAN`) REFERENCES `md_user`(`ID_USER`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `simapes`.`bk_kategori` 
ADD COLUMN `URUTAN_BKKAT` INT(11) NULL AFTER `KELOMPOK_BKKAT`;
ALTER TABLE `simapes`.`bk_kelompok` 
ADD COLUMN `URUTAN_BKKEL` INT(11) NULL AFTER `NAMA_BKKEL`;

INSERT INTO `bk_kategori` VALUES (1,'Kesehatan',1,1,1,'2018-08-11 22:17:09'),(2,'Keadaan Ekonomi',1,2,1,'2018-08-11 22:17:24'),(3,'Kehidupan Keluarga',1,3,1,'2018-08-11 22:17:43'),(4,'Agama dan Moral',1,4,1,'2018-08-11 22:17:52'),(5,'Rekreasi dan Hobi',1,5,1,'2018-08-11 22:18:02'),(6,'Hubungan Pribadi',2,1,1,'2018-08-11 22:18:17'),(7,'Kehidupan Sosial dan Organisasi',2,2,1,'2018-08-11 22:18:33'),(8,'Masalah Remaja',2,3,1,'2018-08-11 22:18:47'),(9,'Penyesuaian terhadap Sekolah',3,1,1,'2018-08-11 22:19:15'),(10,'Penyesuaian terhadap Kurikulum',3,2,1,'2018-08-11 22:19:25'),(11,'Kebiasaan Belajar',3,3,1,'2018-08-11 22:19:46'),(12,'Masa Depan dan Cita-cita',4,1,1,'2018-08-11 22:20:07');

INSERT INTO `bk_kelompok` VALUES (1,'PRIBADI',1,1,'2018-08-11 22:12:32'),(2,'SOSIAL',2,1,'2018-08-11 22:12:37'),(3,'BELAJAR',3,1,'2018-08-11 22:12:46'),(4,'KARIR',4,1,'2018-08-11 22:12:52');
ALTER TABLE `simapes`.`bk_soal` 
ADD COLUMN `URUTAN_BKSOAL` INT(11) NULL AFTER `KONTEN_BKSOAL`;
INSERT INTO `simapes`.`md_pengaturan` (`ID_PENGATURAN`, `NAMA_PENGATURAN`, `EDITABLE_PENGATURAN`, `USER_PENGATURAN`) VALUES ('bk_poin_minimal_dipanggil', '30', '1', '1');
INSERT INTO `simapes`.`md_pengaturan` (`ID_PENGATURAN`, `NAMA_PENGATURAN`, `EDITABLE_PENGATURAN`, `USER_PENGATURAN`) VALUES ('bk_poin_kelipatan_pemanggilan', '15', '1', '1');
ALTER TABLE `simapes`.`bk_penanganan` 
DROP FOREIGN KEY `bk_penanganan_ibfk_3`;
ALTER TABLE `simapes`.`bk_penanganan` 
CHANGE COLUMN `KATEGORI_PENANGANAN` `KATEGORI_PENANGANAN` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `PENYEBAB_PENANGANAN` `PENYEBAB_PENANGANAN` TEXT NULL DEFAULT NULL ,
CHANGE COLUMN `SOLUSI_PENANGANAN` `SOLUSI_PENANGANAN` TEXT NULL DEFAULT NULL ,
CHANGE COLUMN `STATUS_PENANGANAN` `STATUS_PENANGANAN` ENUM('SELESAI', 'PROSES', 'BELUM') NOT NULL DEFAULT 'BELUM' ,
CHANGE COLUMN `TANGGAL_PENANGANAN` `TANGGAL_PENANGANAN` DATETIME NULL DEFAULT NULL ;
ALTER TABLE `simapes`.`bk_penanganan` 
ADD CONSTRAINT `bk_penanganan_ibfk_3`
  FOREIGN KEY (`KATEGORI_PENANGANAN`)
  REFERENCES `simapes`.`bk_kategori` (`ID_BKKAT`)
  ON UPDATE CASCADE;
DROP TRIGGER IF EXISTS `simapes`.`tambah_penanganan`;

DELIMITER $$
USE `simapes`$$
CREATE DEFINER = CURRENT_USER TRIGGER `simapes`.`tambah_penanganan` AFTER INSERT ON `bk_pemanggilan` FOR EACH ROW
BEGIN
	INSERT INTO 
    bk_penanganan 
    (TA_PENANGANAN, SISWA_PENANGANAN, USER_PENANGANAN) 
    VALUES 
    (NEW.TA_PANGGIL, NEW.SISWA_PANGGIL, NEW.USER_PANGGIL);
END$$
DELIMITER ;
ALTER TABLE `simapes`.`bk_penanganan` 
ADD COLUMN `PEMANGGILAN_PENANGANAN` INT(11) NULL AFTER `SISWA_PENANGANAN`;
ALTER TABLE `simapes`.`bk_penanganan` 
CHANGE COLUMN `PEMANGGILAN_PENANGANAN` `PEMANGGILAN_PENANGANAN` INT(11) NULL ;
ALTER TABLE `simapes`.`bk_penanganan` 
ADD INDEX `bk_penanganan_ibfk_5_idx` (`PEMANGGILAN_PENANGANAN` ASC);
ALTER TABLE `simapes`.`bk_penanganan` 
ADD CONSTRAINT `bk_penanganan_ibfk_5`
  FOREIGN KEY (`PEMANGGILAN_PENANGANAN`)
  REFERENCES `simapes`.`bk_pemanggilan` (`ID_PANGGIL`)
  ON DELETE RESTRICT
  ON UPDATE CASCADE;
ALTER TABLE `simapes`.`bk_penanganan` 
DROP FOREIGN KEY `bk_penanganan_ibfk_5`;
ALTER TABLE `simapes`.`bk_penanganan` 
CHANGE COLUMN `PEMANGGILAN_PENANGANAN` `PEMANGGILAN_PENANGANAN` INT(11) NOT NULL ;
ALTER TABLE `simapes`.`bk_penanganan` 
ADD CONSTRAINT `bk_penanganan_ibfk_5`
  FOREIGN KEY (`PEMANGGILAN_PENANGANAN`)
  REFERENCES `simapes`.`bk_pemanggilan` (`ID_PANGGIL`)
  ON UPDATE CASCADE;
DROP TRIGGER IF EXISTS `simapes`.`tambah_penanganan`;

DELIMITER $$
USE `simapes`$$
CREATE DEFINER=`root`@`localhost` TRIGGER `simapes`.`tambah_penanganan` AFTER INSERT ON `bk_pemanggilan` FOR EACH ROW
BEGIN
	INSERT INTO 
    bk_penanganan 
    (TA_PENANGANAN, SISWA_PENANGANAN, PEMANGGILAN_PENANGANAN, USER_PENANGANAN) 
    VALUES 
    (NEW.TA_PANGGIL, NEW.SISWA_PANGGIL, NEW.ID_PANGGIL, NEW.USER_PANGGIL);
END$$
DELIMITER ;
INSERT INTO `simapes`.`md_pengaturan` (`ID_PENGATURAN`, `NAMA_PENGATURAN`, `EDITABLE_PENGATURAN`, `USER_PENGATURAN`) VALUES ('bk_no_surat_pemanggilan', '1', '1', '1');
ALTER TABLE `simapes`.`bk_pemanggilan` 
ADD COLUMN `CAWU_PANGGIL` INT(11) NOT NULL AFTER `TA_PANGGIL`;

ALTER TABLE `simapes`.`bk_pemanggilan` 
ADD CONSTRAINT `bk_pemanggilan_ibfk_4`
  FOREIGN KEY (`CAWU_PANGGIL`)
  REFERENCES `simapes`.`md_catur_wulan` (`ID_CAWU`)
  ON DELETE RESTRICT
  ON UPDATE CASCADE;
UPDATE `simapes`.`md_menu` SET `ID_MENU`='01406005000' WHERE `ID_MENU`='01406002000';
INSERT INTO `simapes`.`md_menu` (`ID_MENU`, `NAME_MENU`, `CONTROLLER_MENU`, `FUNCTION_MENU`, `SHOW_MENU`, `LEVEL_CHILD`, `HAVE_CHILD`) VALUES ('01406003000', 'PEMANGGILAN', 'bk/laporan_pemanggilan', 'index', '1', '2', '0');
INSERT INTO `simapes`.`md_levelmenu` (`MENU_LEVELMENU`, `HAKAKSES_LEVELMENU`) VALUES ('01406003000', '14');
