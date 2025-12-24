<?php
class Membre extends baseModel
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
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            throw new Exception("Email invalide");
        }
        $this->email = $email;
    }

}
