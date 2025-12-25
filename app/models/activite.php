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
    public function delete($id)
    {
        $sql = "DELETE FROM activites WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
    public function findByProjetId($projet_id)
    {
        $sql = "SELECT * FROM activites WHERE projet_id = :projet_id ORDER BY created_at ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':projet_id' => $projet_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
//$activity = new Activite(5, "Projet créé");
//echo $activity->getCreatedAt(); 
