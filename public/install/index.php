<?php
$dsn = getenv('DATABASE_URL'); // Récupérer la valeur de DATABASE_URL du fichier .env

if(isset($_POST['host'])){
    $host = htmlentities($_POST['host']);
    $user = htmlentities($_POST['user']);
    $password = htmlentities($_POST['password']);
    $database = htmlentities($_POST['db']);
    
    $mysqli = new mysqli($host, $user, $password, $database);
    
    // Vérifier la connexion
    if ($mysqli->connect_error) {
        die("La connexion a échoué : " . $mysqli->connect_error);
    }
    $envFile = __DIR__ . '../../.env'; // Assurez-vous que le chemin est correct
    $envContent = file_get_contents($envFile);

    $envContent = preg_replace('/DATABASE_URL=(.+)/', "DATABASE_URL=\"mysql://$user:$password@$host:3306/$database?serverVersion=10.11.2-MariaDB&charset=utf8mb4\"", $envContent);

    file_put_contents($envFile, $envContent);
    // Créer les tables
    $tablesCreated = true;
    $queries = [
        'CREATE TABLE IF NOT EXISTS roles (id INT PRIMARY KEY AUTO_INCREMENT, nom varchar(50) );',
        'CREATE TABLE IF NOT EXISTS utilisateurs (id INT AUTO_INCREMENT PRIMARY KEY, nom VARCHAR(50), courriel VARCHAR(100), motdepasse VARCHAR(255), role_id int(10), FOREIGN KEY (role_id) REFERENCES Roles(id) );',
        'CREATE TABLE IF NOT EXISTS marques (id INT AUTO_INCREMENT PRIMARY KEY, nom varchar(50) );',
        'CREATE TABLE IF NOT EXISTS voitures (id INT AUTO_INCREMENT PRIMARY KEY, marque_id INT(10), FOREIGN KEY (marque_id) REFERENCES Marques(id), modele VARCHAR(50), description TEXT, technique TEXT, prix DECIMAL(10, 2), image VARCHAR(100), miseencirculation DATE, kilometrage INT(10) ); ',
        'CREATE TABLE IF NOT EXISTS services (id INT AUTO_INCREMENT PRIMARY KEY, titre varchar(100), description TEXT, image VARCHAR(100) );',
        'CREATE TABLE IF NOT EXISTS horaires (id INT AUTO_INCREMENT PRIMARY KEY, jour int(10), tranche varchar(50) );',
        'CREATE TABLE IF NOT EXISTS temoignages (id INT AUTO_INCREMENT PRIMARY KEY, status INT(10), nom varchar(50), note DECIMAL(2, 1), commentaire TEXT );',
        'CREATE TABLE IF NOT EXISTS contact (id INT AUTO_INCREMENT PRIMARY KEY, nom varchar(100), prenom varchar(100), sujet varchar(100), message TEXT, email varchar(100), telephone varchar(40), dateenvoi DATE );',
        'INSERT IGNORE INTO marques (nom) VALUES ("Toyota"),("Honda"),("Ford"),("Chevrolet"),("Nissan"),("Volkswagen"),("BMW"),("Mercedes-Benz"),("Audi"),("Volvo"),("Kia"),("Hyundai"),("Mazda"),("Subaru"),("Jeep"),("Fiat"),("Mitsubishi"),("Lexus"),("Porsche"),("Jaguar"),("Land Rover"),("Chrysler"),("Dodge"),("Ram"),("Buick"),("Cadillac"),("GMC"),("Acura"),("Infiniti"),("Mini"),("Tesla"),("Alfa Romeo"),("Genesis"),("Maserati"),("Rolls-Royce"),("Bentley"),("Ferrari"),("Lamborghini"),("McLaren"),("Bugatti"),("Lotus"),("Aston Martin"),("Fiat"),("Peugeot"),("Renault"),("Citroen"),("Opel"),("Skoda"),("Seat"),("Fiat");',
        'INSERT INTO roles (id, nom) VALUES (NULL,"ROLE_ADMIN");',
        'INSERT INTO roles (id, nom) VALUES (NULL,"ROLE_EMPLOYE");',
        'INSERT INTO utilisateurs (id,nom, courriel, motdepasse, role_id) VALUES (NULL,"Admin","admin@admin.ch","$2y$13$/mxjHsHyXrNqjb8oqDQMBevSbK5o35xdrqybn0ZMU.p6sB1hGu0lK","1");',
        'INSERT INTO voitures (id, marque_id, modele, description, technique, prix, image, miseencirculation, kilometrage) VALUES (NULL, "16", "Punto", "Description exemple", "Description technique exemple", "19000", "exemple","2015-01-01","23000")',
        'INSERT INTO voitures (id, marque_id, modele, description, technique, prix, image, miseencirculation, kilometrage) VALUES (NULL, "16", "Punto", "Description exemple", "Description technique exemple", "14000", "exemple","2012-01-01","43000")',
        'INSERT INTO voitures (id, marque_id, modele, description, technique, prix, image, miseencirculation, kilometrage) VALUES (NULL, "16", "Punto", "Description exemple", "Description technique exemple", "29000", "exemple","2022-01-01","3000")',
        'INSERT INTO voitures (id, marque_id, modele, description, technique, prix, image, miseencirculation, kilometrage) VALUES (NULL, "16", "Punto", "Description exemple", "Description technique exemple", "5000", "exemple","2001-01-01","140000")',
        'INSERT INTO temoignages (id, status, nom, note, commentaire) VALUES (NULL, "1", "Ivan", "4", "Superbe expérience, ce garage est vraiment le meilleur.")',
        'INSERT INTO temoignages (id, status, nom, note, commentaire) VALUES (NULL, "1", "Marine", "5", "Très satisfaite de votre service.")',
        'INSERT INTO services (id, titre, description,image) VALUES (NULL, "Carrosserie","Description du service carrosserie.","carrosserie.jpg")',
        'INSERT INTO services (id, titre, description,image) VALUES (NULL, "Entretien","Description du service entretien.","entretien.jpg")',
        'INSERT INTO services (id, titre, description,image) VALUES (NULL, "Pneus","Description du service pneus.","pneu.jpg")',
        'INSERT INTO services (id, titre, description,image) VALUES (NULL, "Vente","Description du service vente.","vente.jpg")',
    ];

    foreach ($queries as $query) {
        if (!$mysqli->query($query)) {
            $tablesCreated = false;
            break;
        }
    }

    $mysqli->close();

    if ($tablesCreated) {
        echo '<center><h1>Installation OK, supprimez le dossier public/install</h1><h2><a href="/">Voir le site</a></h2><br/><br/>Login pour gestion:<br/>courriel: admin@admin.ch<br/>mot de passe: 12345678</center>';
    } else {
        echo "<center><h1>Erreur lors de la création des tables</h1></center>";
    }
}
else{
    ?>
    <center>
        <form name="dbconnect" method="post" action="#">
            <table>
                <tr>
                    <td>Hote</td>
                    <td><input type="text" name="host" /></td>
                </tr>
                <tr>
                    <td>Utilisateur</td>
                    <td><input type="text" name="user" /></td>
                </tr>
                <tr>
                    <td>Mot de passe</td>
                    <td><input type="password" name="password" /></td>
                </tr>
                <tr>
                    <td>Base de données</td>
                    <td><input type="text" name="db" /></td>
                </tr>                
                <tr>
                    <td colspan="2"><input type="submit" name="submit" value="Connexion" /></td>
                </tr>
            </table>
        </form>
    </center>
    <?php
}

