<?php

class Travel
{

    private $conn;
    private $table_name = "travels";

    // object properties
    public $Id;
    public $Name;
    public $Description;
    public $Location;
    public $Attendees;
    public $Reference;

    public function __construct($db)
    {
        $this->conn = $db;
    }



    public function read()
    {

        $query = "SELECT
                 travels.Id, travels.Name, travels.Description, travels.Location, travels.Attendees, travels.Reference
                 FROM
                   " . $this->table_name . " travels ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }





    public function create()
    {

        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                Name=:Name, Description=:Description, Location=:Location, Attendees=:Attendees, Reference=:Reference";

        $stmt = $this->conn->prepare($query);

        $this->Name = htmlspecialchars(strip_tags($this->Name));
        $this->Description = htmlspecialchars(strip_tags($this->Description));
        $this->Location = htmlspecialchars(strip_tags($this->Location));
        $this->Attendees = htmlspecialchars(strip_tags($this->Attendees));
        $this->Reference = htmlspecialchars(strip_tags($this->Reference));


        $stmt->bindParam(":Name", $this->Name);
        $stmt->bindParam(":Description", $this->Description);
        $stmt->bindParam(":Location", $this->Location);
        $stmt->bindParam(":Attendees", $this->Attendees);
        $stmt->bindParam(":Reference", $this->Reference);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }


    public function readSingle()
    {

        $query = "SELECT
    travels.Id, travels.Name, travels.Description, travels.Location, travels.Attendees, travels.Reference
    FROM
    " . $this->table_name . "
       WHERE id = ?;
       ";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['Name'];
        $this->description = $row['Description'];
        $this->location = $row['Location'];
        $this->attendees = $row['Attendees'];
        $this->reference = $row['Reference'];
    }

    public function update()
    {

        $query = "UPDATE
    " . $this->table_name . "
    SET
    Name=:Name,
    Description=:Description,
    Location=:Location,
    Attendees=:Attendees,
    Reference=:Reference
WHERE
    Id = :Id";


        $stmt = $this->conn->prepare($query);

        $this->Name = htmlspecialchars(strip_tags($this->Name));
        $this->Description = htmlspecialchars(strip_tags($this->Description));
        $this->Location = htmlspecialchars(strip_tags($this->Location));
        $this->Attendees = htmlspecialchars(strip_tags($this->Attendees));
        $this->Reference = htmlspecialchars(strip_tags($this->Reference));

        $stmt->bindParam(":Id", $this->Id);
        $stmt->bindParam(":Name", $this->Name);
        $stmt->bindParam(":Description", $this->Description);
        $stmt->bindParam(":Location", $this->Location);
        $stmt->bindParam(":Attendees", $this->Attendees);
        $stmt->bindParam(":Reference", $this->Reference);


        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete() {

        $query = 'DELETE FROM ' . $this->table_name . ' WHERE Id = :Id';

        $stmt = $this->conn->prepare($query);

        $this->Id = htmlspecialchars(strip_tags($this->Id));

        $stmt->bindParam(':Id', $this->Id);

        if($stmt->execute()) {
          return true;
        }

        return false;
  }



    public function search($keywords)
    {


        $query = "SELECT
                travels.Id, travels.Name, travels.Description, travels.Location, travels.Attendees, travels.Reference
            FROM
                " . $this->table_name .  "
            WHERE
                travels.Name LIKE ? OR travels.Attendees LIKE ?  ";

        $stmt = $this->conn->prepare($query);

        $keywords = htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";

        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);


        $stmt->execute();

        return $stmt;
    }
}
