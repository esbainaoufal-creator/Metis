<?php
require_once __DIR__ . '/../app/database/database.php';
require_once __DIR__ . '/../app/models/Membre.php';
require_once __DIR__ . '/../app/models/ProjetCourt.php';
require_once __DIR__ . '/../app/models/ProjetLong.php';
require_once __DIR__ . '/../app/models/Activite.php';

while (true) {
    echo "\n---- Menu CINEMA CLUB ----\n";
    echo "1. Gestion des membres\n";
    echo "2. Gestion des projets\n";
    echo "3. Gestion des activités\n";
    echo "4. Quitter\n";

    $choice = readline("Entrez votre choix: ");

    switch ($choice) {

        // --- MEMBERS ---
        case "1":
            $membreModel = new Membre();
            $members = $membreModel->findAll();
            echo "Liste des membres :\n";
            foreach ($members as $member) {
                echo "{$member['id']} - {$member['name']} ({$member['email']})\n";
            }

            $action = readline("Voulez-vous ajouter (a), modifier (m) ou supprimer (s) un membre? ");

            if ($action === 'a') {
                $name = readline("Nom: ");
                $email = readline("Email: ");
                $membre = new Membre();
                $membre->setName($name);
                $membre->setEmail($email);
                $membre->save();
                echo "Membre ajouté !\n";
            } elseif ($action === 'm') {
                $id = (int)readline("ID du membre à modifier: ");
                $membre = new Membre();
                $existing = $membre->findId($id);
                if ($existing) {
                    $newName = readline("Nouveau nom (laisser vide pour conserver '{$existing['name']}'): ");
                    $newEmail = readline("Nouvel email (laisser vide pour conserver '{$existing['email']}'): ");
                    $membre->setId($id);
                    $membre->setName($newName !== '' ? $newName : $existing['name']);
                    $membre->setEmail($newEmail !== '' ? $newEmail : $existing['email']);
                    $membre->save();
                    echo "Membre modifié !\n";
                } else {
                    echo "Membre introuvable.\n";
                }
            } elseif ($action === 's') {
                $id = (int)readline("ID du membre à supprimer: ");
                $membre = new Membre();
                $membre->delete($id);
                echo "Membre supprimé !\n";
            }
            break;

        // --- PROJECTS ---
        case "2":
            // merge ProjetCourt + ProjetLong
            $projects = array_merge(
                (new ProjetCourt())->findAll(),
                (new ProjetLong())->findAll()
            );
            echo "Liste des projets :\n";
            foreach ($projects as $project) {
                echo "{$project['id']} - {$project['title']} ({$project['member_id']})\n";
            }

            $action = readline("Voulez-vous ajouter (a), modifier (m) ou supprimer (s) un projet? ");

            if ($action === 'a') {
                $title = readline("Titre du projet: ");
                $type = readline("Type de projet (court/long): ");

                // select member
                $members = (new Membre())->findAll();
                foreach ($members as $member) {
                    echo "{$member['id']} - {$member['name']}\n";
                }
                $memberId = (int)readline("ID du membre responsable: ");

                if ($type === 'court') $projet = new ProjetCourt();
                else $projet = new ProjetLong();

                $projet->setTitle($title);
                $projet->setMemberId($memberId);
                $projet->save();
                echo "Projet ajouté !\n";

            } elseif ($action === 'm') {
                $id = (int)readline("ID du projet à modifier: ");
                $existing = null;
                foreach ($projects as $p) {
                    if ($p['id'] === $id) {
                        $existing = $p;
                        break;
                    }
                }
                if ($existing) {
                    $newTitle = readline("Nouveau titre (laisser vide pour conserver '{$existing['title']}'): ");
                    $projet = ($existing['type'] === 'court') ? new ProjetCourt() : new ProjetLong();
                    $projet->setId($id);
                    $projet->setTitle($newTitle !== '' ? $newTitle : $existing['title']);
                    $projet->setMemberId($existing['member_id']);
                    $projet->save();
                    echo "Projet modifié !\n";
                } else {
                    echo "Projet introuvable.\n";
                }
            } elseif ($action === 's') {
                $id = (int)readline("ID du projet à supprimer: ");
                $activities = (new Activite())->findByProjetId($id);
                if (!empty($activities)) {
                    echo "Impossible de supprimer : le projet contient des activités.\n";
                } else {
                    $projet = new ProjetCourt(); // temp delete, type doesn't matter here
                    $projet->delete($id);
                    echo "Projet supprimé !\n";
                }
            }
            break;

        // --- ACTIVITIES ---
        case "3":
            $activityModel = new Activite();
            $activities = $activityModel->findAll();
            echo "Liste des activités :\n";
            foreach ($activities as $activity) {
                echo "{$activity['id']} - Projet ID: {$activity['projet_id']} - {$activity['description']} ({$activity['created_at']})\n";
            }

            $action = readline("Voulez-vous ajouter (a), modifier (m) ou supprimer (s) une activité? ");

            if ($action === 'a') {
                // merge all projects
                $projects = array_merge(
                    (new ProjetCourt())->findAll(),
                    (new ProjetLong())->findAll()
                );

                foreach ($projects as $p) {
                    echo "{$p['id']} - {$p['title']}\n";
                }

                $projetId = (int)readline("ID du projet associé: ");

                $existingProject = null;
                foreach ($projects as $p) {
                    if ($p['id'] === $projetId) {
                        $existingProject = $p;
                        break;
                    }
                }
                if (!$existingProject) {
                    echo "Erreur : projet introuvable. Créez le projet avant d'ajouter une activité.\n";
                    break;
                }

                $description = readline("Description: ");
                $activity = new Activite($projetId, $description);
                $activity->save();
                echo "Activité ajoutée !\n";

            } elseif ($action === 'm') {
                $id = (int)readline("ID de l'activité à modifier: ");
                $existing = $activityModel->findId($id);
                if ($existing) {
                    $newDesc = readline("Nouvelle description (laisser vide pour conserver '{$existing['description']}'): ");
                    $activity = new Activite($existing['projet_id'], $newDesc !== '' ? $newDesc : $existing['description']);
                    $activity->setId($id);
                    $activity->save();
                    echo "Activité modifiée !\n";
                } else {
                    echo "Activité introuvable.\n";
                }
            } elseif ($action === 's') {
                $id = (int)readline("ID de l'activité à supprimer: ");
                $activity = new Activite(1, ""); // temporary
                $activity->delete($id);
                echo "Activité supprimée !\n";
            }
            break;

        case "4":
            echo "Au revoir !\n";
            exit;

        default:
            echo "Choix invalide, réessayez.\n";
            break;
    }
}
