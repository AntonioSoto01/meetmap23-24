USE meetmap;
Select *  from Activity;
SELECT Likes.*, Subscribers.*
FROM Users
LEFT JOIN Likes ON Users.id = Likes.user_id
LEFT JOIN Subscribers ON Users.id = Subscribers.user_id;
INSERT INTO Subscribers (user_id, activity_id) VALUES (1, 1);
INSERT INTO Users (username, email)
VALUES ('valor_del_email', 'valor_del_nombre_de_usuario');
UPDATE Users SET name = 'nuevo_nombre', last_name = 'nuevo_apellido' WHERE username = 'nombre_de_usuario_web';
Select * from Activity where id = 'nombre';
SELECT *
FROM Message
WHERE activity_id = 'nombre actividad' ORDER BY date_time;
INSERT INTO Message (user_id, content, date_time, activity_id)
SELECT Users.id, 'contenido_del_mensaje', NOW(), Activity.id
FROM Users, Activity
WHERE Users.username = 'nombre_de_usuario' AND Activity.name = 'nombre_de_actividad';
