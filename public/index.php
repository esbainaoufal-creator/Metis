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
            $members = $membreModel->findAll(); // you will implement findAll() in Membre
            foreach ($members as $member) {
                echo "{$member['id']} - {$member['name']} ({$member['email']})\n";
            }
            break;

        case "2":
            echo "Gestion des projets sélectionnée.\n";
            // TODO: call project management functions
            break;

        case "3":
            echo "Gestion des activités sélectionnée.\n";
            // TODO: call activity management functions
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
