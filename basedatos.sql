-- Crear base de datos
create database if not exists instituto;
use instituto;

-- Crear tablas
create table if not exists cursos(
	curso INT(10),
    nomcurso VARCHAR(30),
    numalum INT(11),
    PRIMARY KEY(curso)
) engine=innoDB;

create table if not exists alumnos(
	codalum INT(10),
    nombre VARCHAR(30),
    direccion VARCHAR(45),
    curso INT(10),
    PRIMARY KEY(codalum),
    CONSTRAINT fk_alummnos_cursos FOREIGN KEY(curso)
		REFERENCES cursos(curso)
        ON DELETE restrict
        ON UPDATE cascade
)engine=innoDB;

create table if not exists asignaturas(
	codasig INT(10),
    nomasig VARCHAR(30),
    horas INT(11),
    PRIMARY KEY(codasig)
)engine=innoDB;

create table if not exists notas(
	codalum INT(10),
    codasig INT(10),
    eval INT(11),
    nota INT(11),
    PRIMARY KEY(codalum, codasig, eval),
    CONSTRAINT fk_alumnos_has_asignaturas_asignaturas1
		FOREIGN KEY(codasig)
        REFERENCES asignaturas(codasig)
        ON DELETE restrict
        ON UPDATE cascade,
	CONSTRAINT fk_alumnos_has_asignaturas_alumnos1
		FOREIGN KEY(codalum)
        REFERENCES alumnos(codalum)
        ON DELETE restrict
        ON UPDATE cascade
    )engine=innoDB;

/*** Creo un usuario con privilegios de administrador
para modificar la base de datos, y uno con privilegios
de sólo lectura para las consultas ***/
CREATE USER 'admin'@'%' IDENTIFIED BY 'secreto';
GRANT ALL PRIVILEGES ON instituto.* TO 'admin'@'%';
CREATE USER 'lector'@'%' IDENTIFIED BY 'otrosecreto';
GRANT SELECT ON instituto.* TO 'lector'@'%';
