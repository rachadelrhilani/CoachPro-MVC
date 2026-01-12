CREATE TYPE role_type AS ENUM ('coach', 'sportif');
CREATE TYPE statut_type AS ENUM ('disponible', 'reservee');

CREATE TABLE utilisateur (
    id_user SERIAL PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role role_type NOT NULL, -- Utilisation du type ENUM créé plus haut
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE coach (
    id_coach SERIAL PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    discipline VARCHAR(100) NOT NULL,
    annees_experience INT NOT NULL,
    description TEXT,
    id_user INT NOT NULL UNIQUE,
    FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE CASCADE
);

CREATE TABLE sportif (
    id_sportif SERIAL PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    id_user INT NOT NULL UNIQUE,
    FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE CASCADE
);

CREATE TABLE seance (
    id_seance SERIAL PRIMARY KEY,
    date_seance DATE NOT NULL,
    heure TIME NOT NULL,
    duree INT NOT NULL,
    statut statut_type DEFAULT 'disponible',
    id_coach INT NOT NULL,
    FOREIGN KEY (id_coach) REFERENCES coach(id_coach) ON DELETE CASCADE
);

CREATE TABLE reservation (
    id_reservation SERIAL PRIMARY KEY,
    date_reservation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_seance INT NOT NULL UNIQUE,
    id_sportif INT NOT NULL,
    FOREIGN KEY (id_seance) REFERENCES seance(id_seance) ON DELETE CASCADE,
    FOREIGN KEY (id_sportif) REFERENCES sportif(id_sportif) ON DELETE CASCADE
);
