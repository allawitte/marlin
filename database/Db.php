<?php

/**
 * Created by PhpStorm.
 * User: HP
 * Date: 7/26/2019
 * Time: 12:54 PM
 */
class Db
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll($table){
        $statement = $this->pdo->prepare("SELECT * FROM {$table}");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($table, $data){
        $keys = array_keys($data);
        $fields = implode(' ,', $keys);
        $values = ':'.implode(', :', $keys);
        $sql = "INSERT INTO {$table} ({$fields}) VALUES({$values})";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);
    }

    public function getOne($table, $id){
        $sql = "SELECT * FROM {$table} WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($id);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function update($table, $id, $data){

        $dataKeys = array_keys($data);
        $set = '';
        foreach ($dataKeys as $key){
            $set = $set . $key.'=:'.$key.',';
        }
        $set = substr($set, 0, -1);
        $where = $this->getWhere($id);

        $sql = "UPDATE  $table SET {$set} WHERE {$where}";
        $data['id'] = $id['id'];
        $statement = $this->pdo->prepare($sql);
        //$statement->bindValue(':id', $id['id']);
        $statement->execute($data);
    }

    public function delete($table, $id){
        $where = $this->getWhere($id);
        $sql = "DELETE FROM $table WHERE $where";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($id);
    }

    private function getWhere($id){
        $where = '';
        $getKey = array_keys($id);
        foreach ($getKey as $key){
            $where = $where . $key.'=:'.$key;
        }
        return $where;
    }

}