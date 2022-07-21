<?php

namespace App\Core;

use App\Core\MysqlBuilder as MysqlBuilder;
use App\Core\DBConnect;

abstract class Sql
{
    protected $pdo;
    protected $table;
    protected $builder;

    /**
	 * @return void
	**/
    public function __construct()
    {
        //Se connecter à la bdd
        //il faudra mettre en place le singleton
        $this->pdo = DBConnect::getInstance()->pdo;

        //Si l'id n'est pas null alors on fait un update sinon on fait un insert
        $calledClassExploded = explode("\\",get_called_class());
        $this->table = strtolower(DBPREFIXE.end($calledClassExploded));
        $this->builder = new MysqlBuilder();
        $this->builder->init();

    }

    /**
     * @param ?int $id
     */
    public function checkId(?int $id): object
    {
        $sql = "SELECT * FROM ".$this->table." WHERE id=".$id;
        $query = $this->pdo->query($sql);
        return $query->fetchObject(get_called_class());
    }

    public function save()
    {
        $this->reset();
        $columns = get_object_vars($this);

        $columns = array_diff_key($columns, get_class_vars(get_class()));

        $is_insert = false;

        if($this->getId() == null){
            $unset = ["id", "created_at"];
            foreach ($columns as $key => $val) {
                if (in_array($key, $unset)) {
                    unset($columns[$key]);
                }
            } 
            $sql = "INSERT INTO ".$this->table." (".implode(",",array_keys($columns)).") 
            VALUES ( :".implode(",:",array_keys($columns)).")";

            $is_insert = true;
        }else{
            $update = [];
            foreach ($columns as $column=>$value)
            {
                if (!is_null($value)) {
                    $update[] = $column."=:".$column;
                } else {
                    unset($columns[$column]);
                }
            }
            $sql = "UPDATE ".$this->table." SET ".implode(",",$update)." WHERE id=".$this->getId() ;
        }
        
        $queryPrepared = $this->pdo->prepare($sql);
        $res = $queryPrepared->execute( $columns );

        if (!$is_insert) {
            return $res;
        }

        return $this->pdo->lastInsertId();
        
    }

    public function select(array $where=array(), int $limit=null, string $orders=null)
    {
        $this->reset();
        $this->builder->select($this->table, ["*"]);

        if (count($where)>0) {
            foreach ($where as $col => $val) {
                $this->builder->where($col, $this->table);
            }
        }

        if (!is_null($limit)) {
            $this->builder->limit($limit);
        }

        if (!is_null($orders)) {

            foreach ($orders as $order) {
                $this->builder->order($order);
            }
        }

        $sql = $this->builder->getQuery();

        $stmt = $this->pdo->prepare($sql);
        if(count($where)>0){
            $stmt->execute($where);
        } else {
            $stmt->execute();
        }
        
        return $stmt->fetchAll($this->pdo::FETCH_CLASS, get_called_class());
    }

    public function getById(int $id, array $col=['*'])
    {
        $this->reset();
        $this->builder->select($this->table, $col);
        $this->builder->where("id", $this->table);
        $sql = $this->builder->getQuery();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["id"=>$id]);

        $stmt->setFetchMode($this->pdo::FETCH_CLASS, get_called_class());

        $res = $stmt->fetch();
        return $res;

    }

    public function getUnique(array $col, array $where)
    {
        $this->reset();
        $this->builder->select($this->table, $col);

        foreach ($where as $colu => $val) {
            $this->builder->where($colu, $this->table);
        }

        $sql = $this->builder->getQuery();
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($where);

        $stmt->setFetchMode($this->pdo::FETCH_CLASS, get_called_class());

        $res = $stmt->fetch();
        return $res;
    }

    public function delete(array $where=array()): ?bool
    {
        $this->reset();
        $this->builder->delete($this->table);

        if (count($where)==0) {
            $where = array(
                "id"=>$this->getId()
            );
        }

        foreach ($where as $col=>$val) {
            $this->builder->where($col, $this->table);
        }

        $sql = $this->builder->getQuery();

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($where);

    }

    public function execute(array $data=array(),bool $fetch=false, bool $obj=false)
    {

        if (is_array($data) && count($data)>0) {
            $stmt = $this->pdo->prepare($this->builder->getQuery());

            if (!$fetch) {
                return $stmt->execute($data);
            }
            $stmt->execute($data);
            
            if ($obj) {
                return $stmt->fetchAll($this->pdo::FETCH_CLASS, get_called_class());
            }

            return $stmt->fetchAll($this->pdo::FETCH_ASSOC);
        }

        $stmt = $this->pdo->query($this->builder->getQuery());

        if (!$fetch) {
            return $stmt->execute();
        }
        $stmt->execute();
        if($obj) {
            return $stmt->fetchAll($this->pdo::FETCH_CLASS, get_called_class());
        }
        return $stmt->fetchAll($this->pdo::FETCH_ASSOC);
    }

    public function getBuilder(): QueryBuilder
    {
        return $this->builder;
    }

    public function reset(): void
    {
        $this->builder->init();
    }

}
