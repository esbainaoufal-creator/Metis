<?php
while (true) {
    echo "\n---- Menu CINEMA CLUB ----\n";
    echo "1. Gestion des membres\n";
    echo "2. Gestion des projets\n";
    echo "3. Gestion des activités\n";
    echo "4. Quitter\n";

    $choice = readline("Entrez votre choix: ");

    switch ($choice) {
        case "1":
            echo "Gestion des membres sélectionnée.\n";
            require_once __DIR__ . '/../app/Models/Membre.php';
            echo "Liste des membres :\n";
            $membreModel = new Membre();
            $members = $membreModel->findAll();
            foreach ($members as $member) {
                echo "{$member['id']} - {$member['name']} ({$member['email']})\n";
            }

            $name = readline("Entrez le nom du membre: ");
            $email = readline("Entrez l'email du membre: ");

            $membre = new Membre();
            $membre->setName($name);
            $membre->setEmail($email);
            $membre->save();

            echo "Membre ajouté avec succès !\n";

            $name = readline("Entrez le nom du membre: ");
            $email = readline("Entrez l'email du membre: ");

            $membre = new Membre();
            $membre->setName($name);
            $membre->setEmail($email);
            $membre->save();

            echo "Membre ajouté avec succès !\n";

            
            break;

        case "2":
            echo "Gestion des projets sélectionnée.\n";
            require_once __DIR__ . '/../app/Models/Projet.php';

            echo "Liste des projets :\n";
            $projetModel = new Projet();
            $projects = $projetModel->findAll(); // you will implement findAll() in Projet
            foreach ($projects as $project) {
                echo "{$project['id']} - {$project['title']} ({$project['type']})\n";
            }

            break;

        case "3":
            echo "Gestion des activités sélectionnée.\n";
            require_once __DIR__ . '/../app/Models/Activite.php';

            echo "Liste des activités :\n";
            $activityModel = new Activite();
            $activities = $activityModel->findAll(); // you will implement findAll() in Activite
            foreach ($activities as $activity) {
                echo "{$activity['id']} - Projet ID: {$activity['projet_id']} - {$activity['description']} ({$activity['created_at']})\n";
            }

            break;

        case "4":
            echo "Au revoir !\n";
            exit; // stops the script
            break;

        default:
            echo "Choix invalide, réessayez.\n";
            break;
    }
}
