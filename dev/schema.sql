--- drop tables if there exist tables 

drop table if exists appuser cascade;
drop table if exists appres cascade;
drop table if exists appResPairPool cascade;
drop table if exists appVotePool cascade;
drop table if exists appvote cascade;


--- User table
create table appuser (
	userID serial primary key,
	firstName varchar(50) NOT NULL,
	lastName varchar(50) NOT NULL, 
	username varchar(15) NOT NULL UNIQUE,
	password varchar(50) NOT NULL,
	gender varchar(50) NOT NULL,
	email varchar(50) NOT NULL,
	check (gender = 'male' or gender = 'female'),
	CONSTRAINT email_format check (email like '%_@_%._%')
);


--- Restaurant table 
create table appres(
	resID serial primary key,
	resName varchar(50) NOT NULL, 
	point float default 1000.0,
	losses int default 0,
	wins int default 0,
	draws int default 0,
	oldpoint1 float default 1000.0,
	oldpoint2 float default 1000.0
	CHECK (point >=0.0)
);

--- Default table for voting 
create table appResPairPool(
	resID1 int NOT NULL REFERENCES appres(resID) on delete restrict, 
	resID2 int NOT NULL REFERENCES appres(resID) on delete restrict,
	Check (resID1 > resID2)
);

---Pool table for voting 
create table appVotePool(
	userID int NOT NULL REFERENCES appuser(userID) on delete restrict, 
	resID1 int NOT NULL REFERENCES appres(resID) on delete restrict, 
	resID2 int NOT NULL REFERENCES appres(resID) on delete restrict,
	currentVote int not null default 0,
	Constraint check_current_vote check (currentVote = 1 or currentVote=0),
	Check (resID1 > resID2)
);

--- Voting table
create table appvote(
	userID int NOT NULL REFERENCES appuser(userID) on delete restrict, 
	resID1 int NOT NULL REFERENCES appres(resID) on delete restrict, 
	resID2 int NOT NULL REFERENCES appres(resID) on delete restrict, 
	vote int  NOT NULL,
	PRIMARY KEY (userID,resID1, resID2),
	CONSTRAINT vote_constrain check (vote = 1 or vote = 2 or vote = 0), 
	Check (resID1 > resID2)
);


---Add admin for easy access 

insert into appuser(firstName, lastName, username, password, email, gender) values ('Admin', 'Admin', 'admin', '111111', 'admin@info.com', 'male');

--- Add restaurants to restaurant table

\copy appres(resName) from './restaurants.txt'; 

--- Add default pool to be populated for app vote pool 

insert into appResPairPool(resID1, resID2) select t1.resID c1, t2.resID c2 from appres t1, appres t2 where t1.resID > t2.resID;


--- Populate restaurants pairs for admin 

insert into appVotePool select distinct * from (select userID from appuser where username='admin') a, appResPairPool;
