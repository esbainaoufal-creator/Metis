<?php
require_once __DIR__ . '/projet.php';

class ProjetLong extends Projet
{
    public function getProjectType()
    {
        return "Long";
    }
}
