-- Author: Andrew Jarombek
-- Date: 10/19/2016 - 1/18/2017
-- Contains sample values to be added into the database for testing purposes
-- Version 0.4 (BETA) - 12/24/2016
-- Version 0.5 (FEEDBACK UPDATE) - 1/18/2017

use saintsxctf;

-- Insert some sample users
INSERT INTO users(username,first,last,salt,password,profilepic,profilepic_name,
	description,member_since,class_year,location,favorite_event)
	values("andy","Andrew","Jarombek","E3S3HgiKCNnRXuUe/iHDbu",
		"$2y$12$E3S3HgiKCNnRXuUe/iHDbudLMvbm2kltzRnuIJ3SF96A9TN83xv0W",null,null,"I sometimes like to run",
		"2016-10-08",2017,"Greenwich, CT","5K");

INSERT INTO users(username,first,last,salt,password,profilepic,profilepic_name,
	description,member_since,class_year,location,favorite_event)
	values("jarbek","Evan","Garvey","mS/URxFFIJx/IirGLHjFwQ",
		"$2y$12$mS/URxFFIJx/IirGLHjFwO4RqT03uiGiFQCYcX.wicjCof7wFKPti",null,null,"I have great calves",
		"2016-10-09",2017,"Websta, NY","800m");

INSERT INTO users(username,first,last,salt,password,profilepic,profilepic_name,
	description,member_since,class_year,location,favorite_event)
	values("lisag","Lisa","Grohn","mS/URxFFIJx/IirGLHjFwQ",
		"$2y$12$mS/URxFFIJx/IirGLHjFwO4RqT03uiGiFQCYcX.wicjCof7wFKPti",null,null,"I love to run!!!",
		"2016-10-09",2017,"NEW JERSEY!","5K, 10K, 6K (I love them all!)");

-- Insert some sample running logs
INSERT INTO logs(username,first,last,name,location,date,type,distance,metric,miles,time,pace,feel,description) 
	values("andy","Andrew","Jarombek","First Run","Canton, NY","2016-10-19","run",10.2,
           "miles",10.2,"01:10:00","00:06:52",8,"my first run, pretty long and felt pretty good");

INSERT INTO logs(username,first,last,name,location,date,type,distance,metric,miles,time,pace,feel,description) 
	values("jarbek","Evan","Garvey","First Run","Canton, NY","2016-10-10","run",5.1,
           "miles",5.1,"00:46:30","00:09:07",5,"didnt feel so good :(");

INSERT INTO logs(username,first,last,name,location,date,type,distance,metric,miles,time,pace,feel,description) 
	values("andy","Andrew","Jarombek","Second Run","Greenwich, CT","2016-10-21","run",7.25,
           "miles",7.25,"01:10:00","00:09:37",9,"second one in the books");

INSERT INTO logs(username,first,last,name,location,date,type,distance,metric,miles,time,pace,feel,description) 
	values("lisag","Lisa","Grohn","Yay!!1!","Canton, NY","2016-10-09","run",5,
           "kilometers",3.11,"00:17:38","00:05:40",10,"i smiled the entire time!");

INSERT INTO logs(username,first,last,name,location,date,type,distance,metric,miles,time,pace,feel,description) 
	values("andy","Andrew","Jarombek","First Run Back","Canton, NY","2016-10-31","run",1,
           "miles",1,"00:07:15","00:07:15",4,"my first run since getting sick");

INSERT INTO logs(username,first,last,name,location,date,type,distance,metric,miles,time,pace,feel,description) 
	values("jarbek","Evan","Garvey","Monday Run","Canton, NY","2016-10-31","run",7.25,
           "miles",7.25,"00:40:02","00:05:31",8,"was pretty solid, cold out");

INSERT INTO logs(username,first,last,name,location,date,type,distance,metric,miles,time,pace,feel,description) 
	values("lisag","Lisa","Grohn","More cross training","Canton, NY","2016-10-31","swim",5,
           "miles",15,"03:02:00","00:12:08",6,"i love cross training!");

-- Insert some sample comments on the logs
INSERT INTO comments(username,first,last,log_id,time,content) 
	values("lisag","Lisa","Grohn",4,"2016-12-10 13:49:54","Just wanted to add, I love running!");

INSERT INTO comments(username,first,last,log_id,time,content) 
	values("andy","Andrew","Jarombek",4,"2016-12-10 13:53:59","That was a great run!");

INSERT INTO comments(username,first,last,log_id,time,content) 
	values("andy","Andrew","Jarombek",2,"2016-12-11 10:50:44","Yay Garv!");

INSERT INTO comments(username,first,last,log_id,time,content) 
	values("jarbek","Evan","Garvey",2,"2016-12-11 11:02:10","Thanks bro");

-- Insert some group memberships
INSERT INTO groupmembers(group_name,username) values("mensxc","andy");
INSERT INTO groupmembers(group_name,username) values("menstf","andy");
INSERT INTO groupmembers(group_name,username) values("mensxc","jarbek");
INSERT INTO groupmembers(group_name,username) values("menstf","jarbek");
INSERT INTO groupmembers(group_name,username) values("wmensxc","lisag");
INSERT INTO groupmembers(group_name,username) values("wmenstf","lisag");

-- Insert some forgotpassword codes
INSERT INTO forgotpassword(username,forgot_code,expires) values("andy","MTT8DU","2017-01-10 12:00:00");
INSERT INTO forgotpassword(username,forgot_code,expires) values("andy","cBpG6Z","2017-01-09 17:30:00");
INSERT INTO forgotpassword(username,forgot_code,expires) values("andy","sST0Us","2017-01-09 07:30:00");

-- Insert activation codes to access the BETA
INSERT INTO codes(activation_code) values("BbXuat"),("TJTqIj"),("uLAPA7"),("MTT8DU"),
	("kDIC8Z"),("7Xm7bo"),("3ZY7hq"),("tTn9s8"),("FbsX06"),("koXbEE"),("ZRdDi9"),("aziL2K"),
	("XpUevg"),("6mwKR4"),("JDQATT"),("818Uza"),("KnaZIQ"),("Q44JBF"),("DmbzBX"),("B2Nc1k"),
	("3xpp91"),("GT9AgV"),("FBV37x"),("Zu4H43"),("dEpTsY"),("hEdTh1"),("quM6Ap"),("q1NMB1"),
	("55gXua"),("ptfXq1"),("jDPdZz"),("nR14Ww"),("7VUMY5"),("VGgyb2"),("Oj1A1L"),("DWvLcC"),
	("cOWyZ2"),("Vq4p21"),("g8Ucgy"),("MKCl68"),("rnWXUx"),("RFp0L3"),("kGjtck"),("g4uFPf"),
	("g5mp7I"),("vOwLz5"),("FOOnrw"),("Hi1lyM"),("Pg86Vc"),("bDxZH6"),("cBpG6Z"),("6j35tF"),
	("A82mCS"),("LrlUs6"),("7H4eOd"),("ajjQNz"),("7qGnAR"),("yY2dAt"),("ZthrHr"),("wcvQ2x"),
	("mHSmfE"),("s6L8m1"),("2jNfeX"),("ZtQz9O"),("eaPQPL"),("ne1cMw"),("6epKmJ"),("vvooqZ"),
	("T3TTfp"),("QGZjx6"),("TbrMTH"),("BooAJU"),("en3TzJ"),("TcyI8F"),("XYqeFB"),("3dJPeQ"),
	("Im2ETL"),("ZhpD6s"),("2g5s8K"),("N9MMWc"),("ouSoE5"),("Zp8b2c"),("aEFGBH"),("sM0Ovx"),
	("V3QKtl"),("dcNb32"),("3JwbDe"),("CXa2Y7"),("9vp38T"),("v52NGq"),("BYPnWW"),("fEiEUT"),
	("wXHr6S"),("wGG0wb"),("5nOCMW"),("32WA5V"),("eyrDOa"),("sST0Us"),("R02w5q"),("bWjYmJ");

-- Insert notifications
INSERT INTO notifications(username,time,link,description) values("andy", "2017-07-09 18:05:13", 
	"http://localhost/saints-xctf/log.php?logno=43", "andy commented on your log");
INSERT INTO notifications(username,time,link,description) values("lisag", "2017-07-09 05:15:45", 
	"http://localhost/saints-xctf/log.php?logno=41", "andy commented on your log");
INSERT INTO notifications(username,time,link,description) values("andy", "2017-07-08 10:55:00", 
	"http://localhost/saints-xctf/log.php?logno=26", "lisag commented on your log");