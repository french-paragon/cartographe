INSERT INTO `test`.`users` 
(`index`, `user_name`, `user_right`, `user_mail`, `userMaps`, `user_psw`) 
VALUES (NULL, 'laurentvj', '2', 'laurent.valentin.jospin@gmail.com', NULL, SHA1('Nadège$Intégrale$Css$Canaille4'));

SELECT *
FROM `users` 
WHERE `user_name` = "laurentvj"
