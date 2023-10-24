USE meetmap;

INSERT INTO Usuarios (nombre, email) VALUES ('Usuario3', 'usuario3@example.com');

INSERT INTO Actividad (latitud, longitud, nombre, descripcion, fecha, hora, categoria, nombre_lugar, link)
VALUES (41.8781, -87.6298, 'Ejemplo de Actividad 2', 'Descripción de la actividad 2', '2023-10-26', '15:30', 'Cultura', 'Museo de Arte', 'https://www.ejemplo2.com');

INSERT INTO Mensaje (usuario_id, contenido, fecha_hora, actividad_id)
VALUES (1, '¡Hola, esto es un mensaje de ejemplo para la actividad 2!', '2023-10-26 16:00:00', 1);

INSERT INTO Suscritos (usuario_id, actividad_id) VALUES (1, 1);
