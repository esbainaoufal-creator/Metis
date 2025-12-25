<?php
abstract class Projet extends BaseModel
{
    private $id;
    private $title;
    private $description;

    abstract public function getProjectType();
}