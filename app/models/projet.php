<?php
abstract class Project extends baseModel
{
    private $id;
    private $title;
    private $description;

    abstract public function getProjectType();
}