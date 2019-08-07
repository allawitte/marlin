<?php

namespace app;

use Aura\SqlQuery\QueryFactory;
use PDO;
use app\Config;

class Db
{
    private $pdo;

    public function __construct()
    {
        $config = Config::get()['database'];
        $this->pdo = new PDO("{$config['connection']};dbname={$config['database']};charset={$config['charset']};", $config['username'], $config['password']);
        $this->queryFactory = new QueryFactory('mysql');
    }

    public function getPdo(){
        return $this->pdo;
    }

    public function getPostsTotal($table){
        $select = $this->queryFactory->newSelect();
        $select->cols([
            '*'
        ])
            ->from($table);
        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getAll($table)
    {

        $select = $this->queryFactory->newSelect();
        $select->cols([
            '*'
        ])
            ->limit(10)
            ->offset($_GET['page'] ?? 1)
            ->from($table);
        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($table, $data){
        $insert = $this->queryFactory->newInsert();

        $insert
            ->into($table)                   // INTO this table
            ->cols($data);
        $sth = $this->pdo->prepare($insert->getStatement());
        $sth->execute($insert->getBindValues());
    }

    public function update($table, $data, $id){
        $update = $this->queryFactory->newUpdate();

        $update
            ->table($table)                  // update this table
            ->cols($data)
            ->where('id = :id')
            ->bindValue('id', $id);
        $sth = $this->pdo->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
    }

    public function getOne($table, $id){
        $select = $this->queryFactory->newSelect();
        $select->cols([
            '*'
        ])
            ->where('id > :id')
            ->bindValue('id', $id)
            ->from($table);
        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($table, $id){
        $delete = $this->queryFactory->newDelete();

        $delete
            ->from($table)                   // FROM this table
            ->where('id = :id')           // AND WHERE these conditions
            ->bindValue('id', $id);   // bind one value to a placeholder
        $sth = $this->pdo->prepare($delete->getStatement());
        $sth->execute($delete->getBindValues());

    }

}