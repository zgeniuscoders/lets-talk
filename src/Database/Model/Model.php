<?php


namespace Zgeniuscoders\Zgeniuscoders\Database\Model;


use Zgeniuscoders\Zgeniuscoders\Database\DBConnection;

class Model
{
    protected string $table;

    public function __construct(private DBConnection $db)
    {
    }

    private function query(string $sql, array $params = [], bool $fetch = true)
    {
        if(strpos($sql,'INSERT') or strpos($sql,'DELETE') or strpos($sql,'UPDATE'))
        {

        }
        if (!is_null($params)) {
            $stmnt = $this->db->getPDO()->prepare($sql);
            $stmnt->execute($params);
        } else {
            $stmnt = $this->db->getPDO()->query($sql);
        }

        if ($fetch) {
            return $stmnt->fetch();
        }

        return $stmnt->fetchAll();
    }

    public function all()
    {
        return $this->query("SELECT * FROM $this->table");
    }

    public function create(array $data)
    {
        $paranthesis1 = "";
        $paranthesis2  = "";
        $i = 0;

        foreach ($data as $key => $value)
        {
            $comma = $i === count($data) ? "" : ", ";
            $paranthesis1 .= "{$key}{$comma}";
            $paranthesis2 .= ":{$key}{$comma}";
            $i++;
        }
        $sal = 'INSERTC INTO';
        return $this->query("INSERT INTO {$this->table}($paranthesis1) VALUES($paranthesis2)",$data);
    }

    public function take(int $lenght): array
    {
        return $this->query("SELECT * FROM $this->table ORDER BY created_at DESC LIMIT $lenght");
    }

    public function where(string $key,string $value)
    {
        return $this->query("SELECT $key FROM $this->table WHERE $key = ?",[$value]);
    }

    /**
     * verifie si une valeur existe dans la table
     * @param string $field
     * @param $value
     * @return bool
     */
    public function exists(string $field, $value, ?int $execpt = null): bool
    {
        $sql = "SELECT COUNT(id) FROM {$this->table} WHERE $field = ?";
        $params = [$value];
        if($execpt !== null)
        {
            $sql .= " AND id != ?";
            $params[] = $execpt;
        }
        $stmt = $this->db->getPDO()->prepare($sql);
        $stmt->execute($params);

        return (int)$stmt->fetch(\PDO::FETCH_NUM)[0] > 0;

    }
}
