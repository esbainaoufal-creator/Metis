<?php
class baseModel
{
    protected $db; //stores the database object
    protected $table; // Name of the database table
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection(); // Get the single PDO connection from Database singleton
    }

    public function save()
    {
        // TODO : Build SQL insert query here
        $props = get_object_vars($this);
        $columns = [];
        $placeholders = [];
        $values = [];
        foreach ($props as $key => $value) //loop throught all object properties
        {
            if ($key === 'db' || $key === 'table') continue;

            $columns[] = $key; //add the name prop as a column for sql
            $placeholders[] = ":$key"; //add PDO placeholder for prepared statement
            $values[":$key"] = $value; //Store the actual value to bind to the statement
        }

        $sql = "INSERT INTO {$this->table} (" . implode(',', $columns) . ")
        VALUES (" . implode(',', $placeholders) . ")";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);
    }

    public function delete($id){ //public : accessible from child;
        $sql = "DELETE FROM {$this->table} WHERE id = :id";// :id : PDO placeholder
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]); //bind id to its placeholder :id
    }

    public function findId($id){ //take the record ID as input
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql); //PREPARING SQL QUERY 
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); //return the row as an associative array
    }
}
