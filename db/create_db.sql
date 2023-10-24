USE meetmap;
CREATE TABLE Usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255),
    apellidos VARCHAR(255),
    nombre_usuario VARCHAR(50),
    email VARCHAR(255),
    numero_telefono VARCHAR(15),
    imagen_url VARCHAR(255)
);

CREATE TABLE Actividad (
    id INT PRIMARY KEY AUTO_INCREMENT,
    latitud FLOAT,
    longitud FLOAT,
    nombre VARCHAR(255),
    descripcion TEXT,
    fecha DATE,
    hora TIME,
    categoria VARCHAR(255),
    nombre_lugar VARCHAR(255),
    link VARCHAR(255)
);


CREATE TABLE Mensaje (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    contenido TEXT,
    fecha_hora DATETIME,
    actividad_id INT,
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id),
    FOREIGN KEY (actividad_id) REFERENCES Actividad(id)
);

CREATE TABLE Suscritos(
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    actividad_id INT,
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id),
    FOREIGN KEY (actividad_id) REFERENCES Actividad(id)
);


CREATE TABLE Likes(
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    actividad_id INT,
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id),
    FOREIGN KEY (actividad_id) REFERENCES Actividad(id)
);

