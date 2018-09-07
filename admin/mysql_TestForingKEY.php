<?php

# FORING KEY CODE IN MYSQL 

# Chacking AND CONNECTING KEY TOGETHER

/*

ALTER TABLE items

ADD CONSTRAINT member_1

FOREIGN KEY(Member_ID)

REFERENCES users(UserID)

ON UPDATE CASCADE

ON DELETE CASCADE;

*/

/*

ALTER TABLE items

ADD CONSTRAINT cat_1

FOREIGN KEY(Cat_ID)

REFERENCES categories(ID)

ON UPDATE CASCADE

ON DELETE CASCADE;

*/

/*

# JOIN In SQL From All Shop

SELECT items.*, categories.Name AS category_name, users.Username FROM items 

INNER JOIN categories ON categories.ID = items.Cat_ID

INNER JOIN users ON users.UserID = items.Member_ID


*/

/*

# Relation With Comments Table #  // Efter Creating Comments Table

ALTER TABLE `comments` ADD CONSTRAINT items_comment

FOREIGN KEY(item_id) REFERENCES items(item_ID)

ON UPDATE CASCADE

ON DELETE CASCADE;

*/

/*

# Relation Comments With Users Table # 

ALTER TABLE `comments` ADD CONSTRAINT comment_user

FOREIGN KEY(user_id) REFERENCES users(UserID)

ON UPDATE CASCADE

ON DELETE CASCADE;


*/


/*
 // To Search How Meny Tags Have Same Name in Database  //

 //  But Must Be Approved To Show In Side //

SELECT * FROM `items` WHERE Tags LIKE '%RPG%'


*/


/* Add Tables Users

ALTER TABLE `users` ADD `Email` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `Pass`, ADD `FullName` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `Email`, ADD `GroupID` INT(11) NOT NULL DEFAULT '0' AFTER `FullName`, ADD `TrustStatus` INT(11) NOT NULL DEFAULT '0' AFTER `GroupID`, ADD `RegisterStatus` INT(11) NOT NULL DEFAULT '0' AFTER `TrustStatus`, ADD `Date` INT NOT NULL AFTER `RegisterStatus`, ADD `Avatar` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `Date`;


*/