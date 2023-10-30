USE meetmap;
Select *  from Activity;
SELECT Activity.*
FROM Users
LEFT JOIN Likes ON Users.id = Likes.user_id
LEFT JOIN Subscribers ON Users.id = Subscribers.user_id
LEFT JOIN Activity ON (Likes.activity_id = Activity.id OR Subscribers.activity_id = Activity.id)
WHERE Likes.activity_id IS NOT NULL OR Subscribers.activity_id IS NOT NULL;
INSERT INTO Subscribers (user_id, activity_id) VALUES (1, 1);
INSERT INTO Users (username, email)
VALUES ('valor_del_email', 'valor_del_nombre_de_usuario');
UPDATE Users SET name = 'nuevo_nombre', last_name = 'nuevo_apellido' WHERE username = 'nombre_de_usuario_web';
Select * from Activity where id = 2;
SELECT *
FROM Message
WHERE activity_id = 1 ORDER BY date_time;
INSERT INTO Message (user_id, content, date_time, activity_id)
 Users.id, 'contenido_del_mensaje', NOW(), Activity.id;