<?php


namespace App\Model;


use Zgeniuscoders\Zgeniuscoders\Database\DBConnection;

class Model
{
    protected string $table = "users";

    public function __construct(DBConnection $db)
    {

    }
}