CREATE TABLE tx_twersatzteilservice_sortiment (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sorting int(10) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	bezeichnung varchar(255) DEFAULT '' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);

CREATE TABLE tx_twersatzteilservice_modellgruppe (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sorting int(10) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	bezeichnung varchar(255) DEFAULT '' NOT NULL,
	untertitel varchar(255) DEFAULT '' NOT NULL,
	fid_sortiment text,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);


CREATE TABLE tx_twersatzteilservice_produkt (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sorting int(10) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	bezeichnung varchar(255) DEFAULT '' NOT NULL,
	bestellnummer varchar(255) DEFAULT '' NOT NULL,
	bild text,
	fid_modellgruppe text,
	fid_ersatzteil text,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);

CREATE TABLE tx_twersatzteilservice_ersatzteil (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	bezeichnung varchar(255) DEFAULT '' NOT NULL,
	bestellnummer varchar(255) DEFAULT '' NOT NULL,
	beschreibung varchar(255) DEFAULT '' NOT NULL,
	preis tinytext,
	einheit varchar(255) DEFAULT '' NOT NULL,
	fid_produkt int(11) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);

CREATE TABLE tx_twersatzteilservice_produkt_ersatzteil (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sorting int(10) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	ersatzteilbezeichnung text,
	posnummer int(11) DEFAULT '0' NOT NULL,
	anzahl int(11) DEFAULT '0' NOT NULL,
	gueltigbis varchar(255) DEFAULT '' NOT NULL,
	produkt text,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);