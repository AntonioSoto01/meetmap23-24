USE meetmap;
Select *  from Activty;
SELECT Likes.*, Subscribers.*
FROM User
LEFT JOIN Likes ON User.id = Likes.user_id
LEFT JOIN Subscribers ON User.id = Subscribers.user_id;
INSERT INTO Subscribers VALUES ('id', 'id_user','id_activity');
INSERT INTO Users (username, email)
VALUES ('valor_del_email', 'valor_del_nombre_de_usuario');
UPDATE Users
SET name = 'nuevo_nombre', last_name = 'nuevo_apellido'
WHERE username = 'nombre_de_usuario_web';
Select * from Activity where activity_id = 'nombre';
SELECT *
FROM Message
WHERE activity_id = 'nombre actividad' ORDER BY date_time;
INSERT INTO Message (user_id, content, date_time, activity_id)
SELECT Users.id, 'contenido_del_mensaje', NOW(), Actividades.id
FROM Users, Activity
WHERE Users.username = 'nombre_de_usuario' AND Activity.name = 'nombre_de_actividad';
