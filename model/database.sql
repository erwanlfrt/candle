DROP TABLE IF EXISTS Jury;
DROP TABLE IF EXISTS Prejury;
DROP TABLE IF EXISTS RequiredWord;
DROP TABLE IF EXISTS Novella;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Competition;


CREATE TABLE IF NOT EXISTS Competition(
	id SERIAL PRIMARY KEY,
	theme CHARACTER VARYING(100) NOT NULL,
	incipit CHARACTER VARYING(200),
	creationDate DATE NOT NULL,
	deadline DATE NOT NULL,
	CONSTRAINT ck_date CHECK (creationDate < deadline)
);


CREATE TABLE IF NOT EXISTS Users(
	mail CHARACTER VARYING(50) PRIMARY KEY,
	password CHARACTER VARYING(50) NOT NULL, -- to do
	name CHARACTER VARYING(30) NOT NULL,
	firstname CHARACTER VARYING(30) NOT NULL
);

CREATE TABLE IF NOT EXISTS Novella(
	id SERIAL PRIMARY KEY,
	title CHARACTER VARYING(50),
	text TEXT,
	verified BOOLEAN,
	competition INT NOT NULL,
	mailUser CHARACTER VARYING(50) NOT NULL,
	anonymousID CHARACTER VARYING(50) NOT NULL,
	CONSTRAINT fk_novella_user FOREIGN KEY (mailUser) REFERENCES Users(mail),
	CONSTRAINT fk_novella_competition  FOREIGN KEY (competition) REFERENCES Competition(id)
);

CREATE TABLE IF NOT EXISTS RequiredWord(
	competition INT,
	word CHARACTER VARYING(45), -- 45 represent the longest existing word
	CONSTRAINT pk_requiredWord PRIMARY KEY (competition, word),
	CONSTRAINT fk_requiredWord_competition FOREIGN KEY (competition) REFERENCES Competition(id)
);

CREATE TABLE IF NOT EXISTS Jury(
	competition INT,
	mailUser CHARACTER VARYING(50),
	points INT DEFAULT 1000 CHECK (points >=0 AND points <= 1000),
	CONSTRAINT pk_jury PRIMARY KEY (competition, mailUser),
	CONSTRAINT fk_jury_competiton FOREIGN KEY (competition) REFERENCES Competition(id)
);


CREATE TABLE IF NOT EXISTS Prejury(
	competition INT,
	mailUser CHARACTER VARYING(50),
	points INT DEFAULT 1000 CHECK (points >=0 AND points <= 1000),
	CONSTRAINT pk_prejury PRIMARY KEY (competition, mailUser),
	CONSTRAINT fk_prejury_competiton FOREIGN KEY (competition) REFERENCES Competition(id)
);

--functions

CREATE OR REPLACE FUNCTION is_competitor() RETURNS trigger AS $is_competitor$
	DECLARE count_contribution INT;
	BEGIN
		SELECT COUNT(*) INTO count_contribution FROM Novella
		WHERE competition = NEW.competition
		AND mailUser = NEW.mailUser
		GROUP BY(id);
		
		IF count_contribution !=0 THEN
			RAISE EXCEPTION '% is already involved as an author for this competition', NEW.mailUser;
		END IF;
		RETURN NEW;
	END;
$is_competitor$ LANGUAGE plpgsql;

--triggers

-- A user cannot be a jury if he's already involved as an author for this competition
CREATE TRIGGER jury_is_not_a_competitor
	BEFORE INSERT OR UPDATE
	ON Jury
	FOR EACH ROW
	EXECUTE PROCEDURE is_competitor();
		
CREATE TRIGGER prejury_is_not_a_competitor
	BEFORE INSERT OR UPDATE
	ON Prejury
	FOR EACH ROW
	EXECUTE PROCEDURE is_competitor();