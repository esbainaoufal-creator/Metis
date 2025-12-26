<?php
require_once __DIR__ . '/../core/basemodel.php';

class Membre extends BaseModel
{
    protected $id;
    protected $name;
    protected $email;

    protected $table = 'members';

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getName() { return $this->name; }
    public function setName($name) { $this->name = $name; }

    public function getEmail() { return $this->email; }
    public function setEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email invalide");
        }
        $this->email = $email;
    }

    public function emailExists($email)
    {
        $sql = "SELECT 1 FROM {$this->table} WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return (bool) $stmt->fetchColumn();
    }

    public function save()
    {
        if ($this->emailExists($this->email)) {
            throw new Exception("Email deja utilise");
        }
        parent::save();
    }
}