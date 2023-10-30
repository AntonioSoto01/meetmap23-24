USE meetmap;

INSERT INTO Users (name, last_name, username, email, phone_number, image_url)
VALUES ('John', 'Doe', 'johndoe', 'john.doe@example.com', '123456789', 'https://example.com/johndoe.jpg');

INSERT INTO Users (name, last_name, username, email, phone_number, image_url)
VALUES ('Alice', 'Johnson', 'alicejohn', 'alice.j@example.com', '987654321', 'https://example.com/alicejohn.jpg');




INSERT INTO Activity (latitude, longitude, name, description, date, time, category, place_name, link)
VALUES (41.8781, -87.6298, '100 años de la Mesta (Fiesta de la Trashumancia)', '', '2023-10-01', '10:00', 'Exposiciones', 'Centro de Educación Ambiental de Casa de Campo', 'http://www.madrid.es/sites/v/index.jsp?vgnextchannel=ca9671ee4a9eb410VgnVCM100000171f5a0aRCRD&vgnextoid=e9b6122b8241b810VgnVCM1000001d4a900aRCRD');


INSERT INTO Activity (latitude, longitude, name, description, date, time, category, place_name, link)
VALUES (40.393619022093546, -3.6556016835101834, '20.000 especies de abejas', 'De Estibaliz Urresola Solaguren. Con Sofía Otero, Patricia López Arnaiz, Ane Gabaraín. España 2023. Duración: 129 minutos. No recomendada para menores de 7 años y especialmente recomendada para el fomento de la igualdad de género. Cocó, de ocho años, no encaja en las expectativas del resto y no entiende por qué. Todos a su alrededor insisten en llamarle Aitor pero no se reconoce en ese nombre ni en la mirada de los demás. Su madre Ane, (Patricia López Arnaiz), sumida en una crisis profesional y sentimental, aprovechará las vacaciones para viajar con sus tres hijos a la casa materna, donde reside su madre Lita (Itziar Lazkano) y su tía Lourdes (Ane Gabarain), estrechamente ligada a la cría de abejas y la producción de miel. Este verano que cambiará sus vidas obligará a estas mujeres de tres generaciones muy distintas a enfrentarse a sus dudas y temores.', '2023-10-01', '10:00', 'CineActividadesAudiovisuales', 'Centro Sociocultural Alberto Sánchez (Puente de Vallecas)', 'http://www.madrid.es/sites/v/index.jsp?vgnextchannel=ca9671ee4a9eb410VgnVCM100000171f5a0aRCRD&vgnextoid=4759a738045da810VgnVCM1000001d4a900aRCRD');

INSERT INTO Message (user_id, content, date_time, activity_id)
VALUES (1, 'Hello, this is an example message for activity 2!', '2023-10-26 16:00:00', 1);

INSERT INTO Subscribers (user_id, activity_id) VALUES (1, 1);
INSERT INTO Likes (user_id, activity_id) VALUES (2, 2);

INSERT INTO Message (user_id, content, date_time, activity_id)
VALUES (1, 'Este es un mensaje de ejemplo', NOW(), 1);


INSERT INTO Message (user_id, content, date_time, activity_id)
VALUES (2, 'Otro mensaje para la misma actividad', NOW(), 1);

INSERT INTO Message (user_id, content, date_time, activity_id)
VALUES (3, 'Mensaje para una actividad diferente', NOW(), 2);
