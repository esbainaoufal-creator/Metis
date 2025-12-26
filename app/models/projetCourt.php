<?php
require_once __DIR__ . '/projet.php'; 

class ProjetCourt extends Projet {
    public function getProjectType()
    {
        return "Court";
    }
}


