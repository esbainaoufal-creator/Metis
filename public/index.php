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

            $title = readline("Entrez le titre du projet: ");
            $type = readline("Entrez le type de projet (court/long): ");

            if ($type === "court") {
                $projet = new ProjetCourt();
            } else {
                $projet = new ProjetLong();
            }

            $projet->setTitle($title);
            $projet->save();

            echo "Projet ajouté avec succès !\n";

            $idToUpdate = readline("Entrez l'ID du projet à modifier: ");
            $projet = new Projet();
            $existing = $projet->findId($idToUpdate);

            if ($existing) {
                $newTitle = readline("Nouveau titre (laisser vide pour conserver '{$existing['title']}'): ");

                if ($newTitle !== '') $projet->setTitle($newTitle);

                $projet->save(); // implement update logic in save() or a separate update() method
                echo "Projet mis à jour avec succès !\n";
            } else {
                echo "Projet introuvable.\n";
            }

            $idToDelete = readline("Entrez l'ID du projet à supprimer: ");
            $projet = new Projet();
            $activities = (new Activite())->findByProjetId($idToDelete);

            if (!empty($activities)) {
                echo "Impossible de supprimer le projet : il contient des activités.\n";
            } else {
                $projet->delete($idToDelete);
                echo "Projet supprimé avec succès !\n";
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

            $projetId = readline("Entrez l'ID du projet associé: ");
            $description = readline("Entrez la description de l'activité: ");

            $activity = new Activite();
            $activity->setProjetId($projetId);
            $activity->setDescription($description);
            $activity->setCreatedAt(date('Y-m-d H:i:s'));
            $activity->save();

            echo "Activité ajoutée avec succès !\n";

            $idToUpdate = readline("Entrez l'ID de l'activité à modifier: ");
            $activity = new Activite();
            $existing = $activity->findId($idToUpdate);

            if ($existing) {
                $newDescription = readline("Nouvelle description (laisser vide pour conserver '{$existing['description']}'): ");

                if ($newDescription !== '') $activity->setDescription($newDescription);

                $activity->save(); // implement update logic in save() or a separate update() method
                echo "Activité mise à jour avec succès !\n";
            } else {
                echo "Activité introuvable.\n";
            }

            $idToDelete = readline("Entrez l'ID de l'activité à supprimer: ");
            $activity = new Activite();
            $existing = $activity->findId($idToDelete);

            if ($existing) {
                $activity->delete($idToDelete);
                echo "Activité supprimée avec succès !\n";
            } else {
                echo "Activité introuvable.\n";
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
