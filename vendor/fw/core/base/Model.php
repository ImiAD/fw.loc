<?php

namespace fw\core\base;

use fw\core\Db;

abstract class Model
{

    protected $pdo;
    protected string $table;
    protected string $pk = 'id';

    public function __construct()
    {
        $this->pdo = Db::instance();
    }

    public function query(string $sql): bool
    {
        return $this->pdo->execute($sql);
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM {$this->table}";

        return $this->pdo->query($sql);
    }

    public function findOne($id, $field = ''): array
    {
        $field = $field ?: $this->pk;
        $sql = "SELECT * FROM {$this->table} WHERE $field = ? LIMIT 1";

        return $this->pdo->query($sql, [$id]);
    }

    public function findBySql(string $sql, array $params = []): array
    {
        return $this->pdo->query($sql, $params);
    }

    public function findLike(string $str, string $field, string $table =''): array
    {
        $table = $table ?: $this->table;
        $sql = "SELECT * FROM $table WHERE $field LIKE ?";

        return $this->pdo->query($sql, ['%'.$str.'%']);
    }
}