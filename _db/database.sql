CREATE TABLE pbbarang (
  id int(8) NOT NULL AUTO_INCREMENT,
  kode varchar(20) NOT NULL,
  nmBrg varchar(100) NOT NULL,
  satuan varchar(20) DEFAULT NULL,
  hrgBeli int(11) DEFAULT '0',
  hrgJual int(11) DEFAULT '0',
  stock int(11) DEFAULT '0',
  tgl_masuk datetime NOT NULL,
  tgl_robah timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  login varchar(100) NOT NULL,
  PRIMARY KEY(id),
  UNIQUE KEY(kode)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE pbpelanggan (
  id int(11) NOT NULL AUTO_INCREMENT,
  kode varchar(20) NOT NULL,
  nama varchar(100) NOT NULL,
  alamat text,
  telp varchar(15) DEFAULT NULL,
  kota varchar(50) DEFAULT NULL,
  tgl_masuk date NOT NULL,
  PRIMARY KEY(id),
  UNIQUE KEY(kode)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE pbpemasok (
  id int(11) NOT NULL,
  kode varchar(20) NOT NULL,
  nama varchar(100) NOT NULL,
  alamat text,
  telp varchar(15) DEFAULT NULL,
  kota varchar(50) DEFAULT NULL,
  tgl_masuk date NOT NULL,
  PRIMARY KEY(id),
  UNIQUE KEY(kode)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE pbnotabeli (
  noNota varchar(20) NOT NULL,
  tgl date DEFAULT NULL,
  kdPemasok varchar(20) NOT NULL,
  kdBrg varchar(20) NOT NULL,
  jml int(8) NOT NULL DEFAULT '0',
  potongan int(11) NOT NULL DEFAULT '0',
  ket varchar(100) DEFAULT NULL,
  PRIMARY KEY(noNota),
  FOREIGN KEY(kdPemasok) REFERENCES pbpemasok(kode) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY(kdBrg) REFERENCES pbbarang(kode) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE pbnotajual (
  noNota varchar(20) NOT NULL,
  tgl date DEFAULT NULL,
  kdPelanggan varchar(20) NOT NULL,
  kdBrg varchar(20) NOT NULL,
  jml int(8) NOT NULL DEFAULT '0',
  potongan int(8) NOT NULL DEFAULT '0',
  ket varchar(100) DEFAULT NULL,
  FOREIGN KEY(kdPelanggan) REFERENCES pbpelanggan(kode) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY(kdBrg) REFERENCES pbbarang(kode) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE pbuser (
  id tinyint(2) NOT NULL AUTO_INCREMENT,
  uname varchar(20) NOT NULL,
  upass varchar(100) NOT NULL,
  nama varchar(100) DEFAULT NULL,
  email varchar(50) DEFAULT NULL,
  level int(1) NOT NULL DEFAULT '2',
  tgl_masuk timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id),
  UNIQUE KEY(uname)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `pbuser` (`id`, `uname`, `upass`, `nama`, `email`, `level`, `tgl_masuk`) VALUES
(1, 'admin', 'admin', 'Suendri', 'phpbego@yahoo.co.id', 1, '2013-04-24 03:03:15'),
(2, 'operator', 'operator', 'Operator', 'phpbego@gmail.com', 2, '2014-03-30 10:32:05');
