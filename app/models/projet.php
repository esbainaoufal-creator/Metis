<?php
require_once __DIR__ . '/../core/baseModel.php';


abstract class Projet extends BaseModel
{
    private $id;
    private $title;
    private $description;
    protected $member_id;
    protected $table = 'projects';
    protected $created_at; 

    abstract public function getProjectType();

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function getTitle() { return $this->title; }
    public function setTitle($title) { $this->title = $title; }
    public function getDescription() { return $this->description; }
    public function setDescription($description) { $this->description = $description; }
    public function setMemberId($member_id)
{
    $this->member_id = $member_id;
}

public function getMemberId()
{
    return $this->member_id;
}
public function save()
{
    $sql = "INSERT INTO {$this->table} (member_id, created_at, type)
            VALUES (:member_id, :created_at, :type)";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        ':member_id' => $this->member_id,
        ':created_at' => $this->created_at,
        ':type' => $this->getProjectType()
    ]);

    $this->id = $this->db->lastInsertId();
}

public function __construct()
{
    parent::__construct();
    $this->created_at = date('Y-m-d H:i:s');
}


}




// Concrete class
class ProjetModel extends Projet
{
    private $type;

    public function getProjectType()
    {
        return $this->type;
    }

    public function setType($type) { $this->type = $type; }
    public function getType() { return $this->type; }

    public function setMemberId($id) { $this->member_id = $id; }
    public function getMemberId() { return $this->member_id; }

    // Override save to include type and member_id
    public function save()
    {
        if ($this->getId()) {
            // Update
            $sql = "UPDATE {$this->table} SET title=?, description=?, type=?, member_id=? WHERE id=?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$this->getTitle(), $this->getDescription(), $this->getType(), $this->getMemberId(), $this->getId()]);
        } else {
            // Insert
            $sql = "INSERT INTO {$this->table} (title, description, type, member_id) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$this->getTitle(), $this->getDescription(), $this->getType(), $this->getMemberId()]);
            $this->setId($this->db->lastInsertId());
        }
    }
}
