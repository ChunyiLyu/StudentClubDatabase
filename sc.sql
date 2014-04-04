CREATE TABLE students (
    id int PRIMARY KEY NOT NULL ,
    full_name character varying(50) NOT NULL,
    anticipated int,
    concentration character varying(50)
);

CREATE TABLE clubs (
	name character varying(50) NOT NULL,
	advisor character varying(50) NOT NULL,
	year_founded integer,     
    type character varying(50),
    PRIMARY KEY(name, advisor)
);

CREATE TABLE membership (
	name character varying(50) NOT NULL REFERENCES clubs(name),
	advisor character varying(50) NOT NULL REFERENCES clubs(advisor),
	year_participate integer,
    student_id integer NOT NULL REFERENCES students(id),     
    PRIMARY KEY(name, advisor, student_id)
);


INSERT INTO students (id, full_name, anticipated, concentration) VALUES (1, 'tesa green', 2014, 'sociology');
INSERT INTO students (id, full_name, anticipated, concentration) VALUES (2, 'betty gellar', 2015, 'Computer System');
INSERT INTO students (id, full_name, anticipated, concentration) VALUES (3, 'chris bing', 2015, 'Math');
INSERT INTO students (id, full_name, anticipated, concentration) VALUES (5, 'dana smith', 2017, 'psychology');
INSERT INTO students (id, full_name, anticipated, concentration) VALUES (8, 'zoe gastby', 2016, 'art history');

INSERT INTO clubs (name, advisor, year_founded, type) VALUES ('bird watching', 'phil', 2000, 'nature');
INSERT INTO clubs (name, advisor, year_founded, type) VALUES ('japanese study table', 'oyama',1980, 'language');
INSERT INTO clubs (name, advisor, year_founded, type) VALUES ('japanese study table', 'kate', 2000, 'literature');
INSERT INTO clubs (name, advisor, year_founded, type) VALUES ('orchestra', "sarah",1980, 'music');
INSERT INTO clubs (name, advisor, year_founded, type) VALUES ('golf', "frank",1980, 'sport');
INSERT INTO clubs (name, advisor, year_founded, type) VALUES ('horse back riding', "frank", 1980, 'music');


INSERT INTO membership (name, advisor, student_id, year_participate) VALUES ('bird watching', "phil", 2, 2013);
INSERT INTO membership (name, advisor, student_id, year_participate) VALUES ('bird watching', "phil", 1, 2011);
INSERT INTO membership (name, advisor, student_id, year_participate) VALUES ('japanese study table', "oyama", 2, 2013);
INSERT INTO membership (name, advisor, student_id, year_participate) VALUES ('japanese study table', "kate", 5, 2014);
INSERT INTO membership (name, advisor, student_id, year_participate) VALUES ('orchestra', "sarah", 1, 2011);
INSERT INTO membership (name, advisor, student_id, year_participate) VALUES ('orchestra', "sarah", 2, 2014);
INSERT INTO membership (name, advisor, student_id, year_participate) VALUES ('orchestra', "sarah", 5, 2014);
INSERT INTO membership (name, advisor, student_id, year_participate) VALUES ('golf', "frank", 8, 2014);
INSERT INTO membership (name, advisor, student_id, year_participate) VALUES ('horse back riding', "frank", 8, 2014);