<?php
require_once __DIR__ . '/../core/baseModel.php';

class Activite extends BaseModel
{
    private $id;
    private $projet_id;
    private $description;
    private $created_at;
    protected $table = 'activities'; // match your DB table name

    // Constructor with optional arguments
    public function __construct($projet_id = null, $description = null)
    {
        $this->projet_id = $projet_id;
        $this->description = $description;
        $this->created_at = date("Y-m-d H:i:s");
        parent::__construct();
    }

    // Getters
    public function getId() { return $this->id; }
    public function getProjetId() { return $this->projet_id; }
    public function getDescription() { return $this->description; }
    public function getCreatedAt() { return $this->created_at; }

    // Setters
    public function setProjetId($projet_id) { $this->projet_id = $projet_id; }
    public function setDescription($description) { $this->description = $description; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }

    // Save to DB
    public function save()
    {
        $sql = "INSERT INTO {$this->table} (projet_id, description, created_at) 
                VALUES (:projet_id, :description, :created_at)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':projet_id', $this->projet_id);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':created_at', $this->created_at);
        $stmt->execute();
        $this->id = $this->db->lastInsertId();
    }

    // Delete by ID
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    // Find all activities for a specific project
    public function findByProjetId($projet_id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE projet_id = :projet_id ORDER BY created_at ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':projet_id' => $projet_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
