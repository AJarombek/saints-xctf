-- Author: Andrew Jarombek
-- Date: 10/19/2016 -
-- Contains sample values to be added into the database for testing purposes

-- Insert some sample users
INSERT INTO users(username,first,last,salt,password,profilepic,profilepic_name,
	description,member_since,class_year,location,favorite_event)
	values("andy","Andrew","Jarombek","M$XJ9DXn#uS{p#djljs&LTiLhfc*V)j|hLR[MkrhD*X[HQB!0G5m*WH!hH1Gd|Vs",
		"$2y$10$Ek8Ztjks9zl/a87y1lQVk.yaJ4INSyP3l.vSULrnbEFTl0..zabaK",null,null,"I sometimes like to run",
		"2016-10-08",2017,"Greenwich, CT","5K");

INSERT INTO users(username,first,last,salt,password,profilepic,profilepic_name,
	description,member_since,class_year,location,favorite_event)
	values("jarbek","Evan","Garvey","c8yAye*az%bw%8XMf1fY!XCiN)|[zPq3)6g!N|Kw8$9F|bEBj^&@R|9O45k3s1u*",
		"$2y$10$Ek8Ztjks9zl/a87y1lQVk.yaJ4INSyP3l.vSULrnbEFTl0..zabaK",null,null,"I have great calves",
		"2016-10-09",2017,"Websta, NY","800m");

INSERT INTO users(username,first,last,salt,password,profilepic,profilepic_name,
	description,member_since,class_year,location,favorite_event)
	values("lisag","lisa","Grohn","c8yAye*az%bw%8XMf1fY!XCiN)|[zP1345345345f$9F|bEBj^&@R|9O45k3s1u*",
		"$2y$10$Ek8Ztjks9zl/a87y1lQVk.yaJ4INSyP3l.vSULrnbEFTl0..zabaK",null,null,"I love to run!!!",
		"2016-10-09",2017,"NEW JERSEY!","5K, 10K, 6K (I love them all!)");

-- Insert some sample running logs
INSERT INTO logs(username,name,location,date,type,distance,metric,miles,time,feel,description) 
	values("andy","First Run","Canton, NY","2016-10-19","run",10.2,
           "miles",10.2,"01:10:00",8,"my first run, pretty long and felt pretty good");

INSERT INTO logs(username,name,location,date,type,distance,metric,miles,time,feel,description) 
	values("jarbek","First Run","Canton, NY","2016-10-10","run",5.1,
           "miles",5.1,"00:46:30",5,"didnt feel so good :(");

INSERT INTO logs(username,name,location,date,type,distance,metric,miles,time,feel,description) 
	values("andy","Second Run","Greenwich, CT","2016-10-21","run",7.25,
           "miles",7.25,"01:10:00",9,"second one in the books");

INSERT INTO logs(username,name,location,date,type,distance,metric,miles,time,feel,description) 
	values("lisag","Yay!!1!","Canton, NY","2016-10-09","run",5,
           "kilometers",3.11,"00:17:38",10,"i smiled the entire time!");

-- Insert some group memberships
INSERT INTO groupmembers(group_name,username) values("mensxc","andy");
INSERT INTO groupmembers(group_name,username) values("menstf","andy");
INSERT INTO groupmembers(group_name,username) values("mensxc","jarbek");
INSERT INTO groupmembers(group_name,username) values("menstf","jarbek");
INSERT INTO groupmembers(group_name,username) values("wmensxc","lisag");
INSERT INTO groupmembers(group_name,username) values("wmenstf","lisag");