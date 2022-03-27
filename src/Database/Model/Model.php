<?php


namespace Zgeniuscoders\Zgeniuscoders\Database\Model;


use Zgeniuscoders\Zgeniuscoders\Database\DBConnection;

class Model
{
    protected string $table;

    public function __construct(private DBConnection $db)
    {
    }

    /**
     * @param string $sql
     * @param array $params
     * @param bool $fetch
     * @return array|mixed
     */
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

    /**
     * get all data
     * @return array|mixed
     */
    public function all()
    {
        return $this->query("SELECT * FROM $this->table");
    }

    /**
     * insert data
     * @param array $data
     * @return void
     */
    public function create(array $data): void
    {
        $paranthesis1 = "";
        $paranthesis2  = "";
        $i = 1;

        foreach ($data as $key => $value)
        {
            $comma = $i === count($data) ? "" : ", ";
            $paranthesis1 .= "{$key}{$comma}";
            $paranthesis2 .= ":{$key}{$comma}";
            $i++;
        }
        $sal = 'INSERT INTO';
        $this->query("INSERT INTO {$this->table} ($paranthesis1) VALUES($paranthesis2)",$data);
    }

    /**
     * update data
     * @param int $id
     * @param array $data
     * @return void
     */
    public function update(int $id, array $data): void
    {
        $sqlRequestPart = "";
        $i = 1;

        foreach ($data as $key => $value)
        {
            $comma = $i = count($data) ? " " : ', ';
            $sqlRequestPart .= "{$key} = :{$key}{$comma}";
            $i++;
        }

        $data['id'] = $id;

        $this->query("UPDATE {$this->table} SET {$sqlRequestPart} WHERE id = :id",$data);
    }

    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        $this->query("DELETE * FROM {$this->table} WHERE id = ?",$id);
    }

    /**
     * @param int $lenght
     * @return array
     */
    public function take(int $lenght): array
    {
        return $this->query("SELECT * FROM $this->table ORDER BY created_at DESC LIMIT $lenght");
    }

    /**
     * @param string $key
     * @param string $value
     * @return array|mixed
     */
    public function where(string $key, string $value)
    {
        return $this->query("SELECT $key FROM $this->table WHERE $key = ?",[$value]);
    }

    /**
     * check if a value exist in the table
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
