<?php
abstract class Projet extends baseModel
{
    private $id;
    private $title;
    private $description;

    abstract public function getProjectType();
}