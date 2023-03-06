<?php

namespace fw\core\base;

use fw\core\Db;
use Valitron\Validator;

abstract class Model
{

    protected $pdo;
    protected string $table;
    protected string $pk     = 'id';
    public array $attributes = [];
    public array $errors     = [];
    public array $rules      = [];

    public function __construct()
    {
        $this->pdo = Db::instance();
    }

    public function load(array $data)
    {
        foreach ($this->attributes as $name => $value) {
            if (isset($data[$name])) {
                $this->attributes[$name] = $data[$name];
            }
        }
    }

    public function validate($data): bool
    {
        Validator::langDir(WWW.'/valitron/lang');
        Validator::lang('ru');
        $v = new Validator($data);
        $v->rules($this->rules);

        if ($v->validate()) {
            return true;
        }

        $this->errors = $v->errors();

        return false;
    }

    public function save(string $table)
    {
        $tbl = \R::dispense($table);

        foreach ($this->attributes as $name => $value) {
            $tbl->$name = $value;
        }

        return \R::store($tbl);
    }

    public function getErrors()
    {
        $errors = '<ul>';

        foreach ($this->errors as $error) {
            foreach ($error as $item) {
                $errors .= "<li>$item</li>";
            }
        }

        $errors .= '</ul>';
        $_SESSION['error'] = $errors;
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