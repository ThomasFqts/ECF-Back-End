create database afpa_wazaa_immo;
use afpa_wazaa_immo;
CREATE TABLE waz_options(
   opt_id INT AUTO_INCREMENT,
   opt_libelle VARCHAR(100)  NOT NULL,
   PRIMARY KEY(opt_id)
);

INSERT INTO waz_options (opt_libelle) values 
('Jardin'),
('Garage'),
('Parking'),
('Piscine'),
('Combles aménageables'),
('Cuisine ouverte'),
('Sans travaux'),
('Avec travaux'),
('Cave'),
('Plain-pied'),
('Ascenseur'),
('Terrasse/balcon'),
('Cheminée');

 CREATE TABLE waz_type_utilisateur(
   tp_ut_id INT AUTO_INCREMENT,
   tp_ut_libelle VARCHAR(50) ,
   PRIMARY KEY(tp_ut_id)
);

INSERT INTO waz_type_utilisateur (tp_ut_libelle) values ('Admin');
INSERT INTO waz_type_utilisateur (tp_ut_libelle) values ('Visiteur');

CREATE TABLE waz_type_offre(
   tp_ofr_id INT AUTO_INCREMENT,
   tp_ofr_libelle VARCHAR(1)  NOT NULL,
   PRIMARY KEY(tp_ofr_id)
);

INSERT INTO waz_type_offre (tp_ofr_libelle) values ('A');
INSERT INTO waz_type_offre (tp_ofr_libelle) values ('L');
INSERT INTO waz_type_offre (tp_ofr_libelle) values ('V');

CREATE TABLE waz_type_bien(
   tp_bn_id INT AUTO_INCREMENT,
   tp_bn_libelle VARCHAR(100) NOT NULL,
   PRIMARY KEY(tp_bn_id)
);

INSERT INTO waz_type_bien (tp_bn_libelle) values 
('Maison'),
('Appartement'),
('Immeuble'),
('Garage'),
('Terrain'),
('Locaux professionnels'),
('Bureaux');

CREATE TABLE waz_diagnostic(
   d_id INT AUTO_INCREMENT,
   d_libelle VARCHAR(5)  NOT NULL,
   PRIMARY KEY(d_id)
);

INSERT INTO waz_diagnostic (d_libelle) VALUES
('A'),
('B'),
('C'),
('D'),
('E'),
('F'),
('G');

CREATE TABLE waz_utilisateurs(
   ut_id INT AUTO_INCREMENT,
   ut_email VARCHAR(100)  NOT NULL,
   ut_mdp VARCHAR(500)  NOT NULL,
   tp_ut_id INT NOT NULL,
   PRIMARY KEY(ut_id),
   FOREIGN KEY(tp_ut_id) REFERENCES waz_type_utilisateur(tp_ut_id)
);

INSERT INTO waz_utilisateurs (ut_email,ut_mdp,tp_ut_id) values ('john.wick@test.com','$2y$12$TBwhz59iX7LdWqKB.q94EOF5b8eBWSPAHNEJ6AG/jmg1k.4LyBlGa',1);
INSERT INTO waz_utilisateurs (ut_email,ut_mdp,tp_ut_id) values ('clara.balade@test.com','$2y$12$TBwhz59iX7LdWqKB.q94EOF5b8eBWSPAHNEJ6AG/jmg1k.4LyBlGa',2);

CREATE TABLE waz_annonces(
   an_id INT AUTO_INCREMENT,
   an_numero VARCHAR(50)  NOT NULL,
   an_pieces INT NOT NULL,
   an_vue INT NOT NULL,
   an_ref VARCHAR(10)  NOT NULL,
   an_titre VARCHAR(200)  NOT NULL,
   an_description VARCHAR(5000)  NOT NULL,
   an_local VARCHAR(100)  NOT NULL,
   an_surf_hab DECIMAL(15,2)  ,
   an_surf_tot DECIMAL(15,2)   NOT NULL,
   an_prix DECIMAL(15,2)   NOT NULL,
   an_d_ajout DATE NOT NULL,
   an_d_modif DATETIME,
   an_etat BOOLEAN NOT NULL,
   d_id INT NOT NULL,
   ut_id INT NOT NULL,
   tp_bn_id INT,
   tp_ofr_id INT NOT NULL,
   PRIMARY KEY(an_id),
   FOREIGN KEY(d_id) REFERENCES waz_diagnostic(d_id),
   FOREIGN KEY(ut_id) REFERENCES waz_utilisateurs(ut_id),
   FOREIGN KEY(tp_bn_id) REFERENCES waz_type_bien(tp_bn_id),
   FOREIGN KEY(tp_ofr_id) REFERENCES waz_type_offre(tp_ofr_id)
);

INSERT INTO waz_annonces (an_numero, an_pieces,an_vue,an_ref,an_titre,an_description,an_local,an_surf_hab,an_surf_tot,an_prix,an_d_ajout,an_etat,d_id,ut_id,tp_ofr_id) 
values ('AN0001','5',0,'20A100','100 km de Paris, Appartement 85m2 avec jardin','Exclusivité : dans bourg tous commerces avec écoles, maison d\'environ 85m2 habitables, mitoyenne, offrant en rez-de-chaussée, une cuisine aménagée, un salon-séjour, un WC et une loggia et à l\'étage, 3 chambres dont 2 avec placard, salle de bains et WC séparé. 2 garages. Le tout sur une parcelle de 225m2. Chauffage individuel clim réversible, DPE : F. ',
'1h00 de Paris',85,225,197000,'2020-11-13',TRUE,6,1,1);


INSERT INTO waz_annonces (an_numero,an_pieces,an_vue,an_ref,an_titre,an_description,an_local,an_surf_hab,an_surf_tot,an_prix,an_d_ajout,an_etat,d_id,ut_id,tp_ofr_id) 
values ('AN0001','3',0,'40C015','25 km de Bordeau, Appartement 55m2','Tous commerces avec écoles à - de 1km, appartement d\'environ 55m2 habitables, une cuisine aménagée, un salon-séjour, une chambre avec WC. Chauffage individuel clim réversible, DPE : F. ',
'2h30 de Toulouse',55,70,100000,'2020-11-13',TRUE,5,1,2);

DROP TRIGGER IF EXISTS `tr_generate_num_annonce`;
DELIMITER $$
CREATE TRIGGER `tr_generate_num_annonce` BEFORE INSERT ON `waz_annonces` FOR EACH ROW 
BEGIN
    DECLARE prefix CHAR(2) DEFAULT 'AN';
    DECLARE num INT;

    SELECT COUNT(*) + 1 INTO num FROM waz_annonces;

    SET NEW.an_numero = CONCAT(prefix, LPAD(num, 4, '0'));
END
$$
DELIMITER ;

CREATE TABLE waz_photo(
   ft_id INT AUTO_INCREMENT,
   ft_nom VARCHAR(50) NOT NULL,
   an_id INT NOT NULL,
   PRIMARY KEY(ft_id),
   FOREIGN KEY(an_id) REFERENCES waz_annonces(an_id)
);

INSERT INTO waz_photo (ft_nom,an_id) values 
('annonce_1/1-1',1),
('annonce_1/1-2',1),
('annonce_2/2-1',2),
('annonce_2/2-2',2);

CREATE TABLE waz_an_opt(
   an_id INT,
   opt_id INT,
   PRIMARY KEY(an_id, opt_id),
   FOREIGN KEY(an_id) REFERENCES waz_annonces(an_id),
   FOREIGN KEY(opt_id) REFERENCES waz_options(opt_id)
);

INSERT INTO waz_an_opt (an_id,opt_id) values (1,1);