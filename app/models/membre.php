<?php
class Membre extends BaseModel
{ //extends baseModel : receives all properties and methods from BaseModel
    private $id;
    private $name;
    private $email;

    //getter for getting
    //setter for setting 
    //hhh

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email invalide");
        }
        $this->email = $email;
    }
    public function emailExists($email)
    {
        $sql = "SELECT COUNT(*) FROM membres WHERE email = :email"; // checks if email exists or not
        $stmt = self::$db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }
    public function save()
    {
        if ($this->emailExists($this->email)) {
            throw new Exception("Email deja utilise");
        }
        parent::save();
    }
}
