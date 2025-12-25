<?php
require_once __DIR__ . '/../Core/BaseModel.php';
class Activite extends BaseModel
{
    private $id;
    private $projet_id; //linking activity to one project
    private $description;
    private $created_at; //time

    public function __construct($projet_id, $description)
    {
        $this->projet_id = $projet_id;
        $this->description = $description;
        $this->created_at = date("T-m-d H:i:s");

    }
    public function getId()
    {
        return $this->id;
    }

    public function getProjectId()
    {
        return $this->projet_id;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    
    
    public function save()
    {
        $db = Database::getInstance();
        $sql = "INSERT INTO activites (projet_id, description, created_at) 
        VALUES (:projet_id, :description, :created_at)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':projet_id', $this->projet_id);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':created_at', $this->created_at);
        $stmt->execute();
    }
}
//$activity = new Activite(5, "Projet créé");
//echo $activity->getCreatedAt(); 
