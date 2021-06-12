INSERT INTO Competition (id, theme, incipit, creationDate, deadline) VALUES 
	(0,'theme1', 'incipit1', '2020-01-01', '2020-02-01');

INSERT INTO Users VALUES 
	('test@gmail.com', 'toto', 'Nom', 'Prenom'),
	('test2@gmail.com', 'toto', 'Nom', 'Prenom');

INSERT INTO Novella (title, text, verified, competition, mailUser, anonymousID) VALUES 
	('Titre', 'blabla', NULL, 0, 'test@gmail.com', 'aeiouy34654z6efzef');

INSERT INTO RequiredWord VALUES 
	(0, 'test');

INSERT INTO Jury VALUES 
	(0,'test2@gmail.com', 1000);

INSERT INTO Prejury VALUES 
	(0,'test2@gmail.com', 1000);