<?php

class QueryBuilder
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // возвращает все записи из указанной таблицы
    public function all($table)
    {
        $statement = $this->pdo->prepare("select * from {$table}");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    // возвращает запись по id из указанной таблицы
    public function show($table, $id)
    {
        $statement = $this->pdo->prepare("select * from {$table} where id = ?");
        $statement->execute([$id]);
        return $statement->fetch(PDO::FETCH_OBJ);
    }

    public function count($table, $parameters)
    {
        $queryString = '';

        // если переданы дополнительные параметры
        if (count($parameters)>0) {

            foreach ($parameters as $key => $value) {
                $queryString .= "{$key} = :{$key}, ";
            }

            $queryString = rtrim($queryString,", ");

            $sql = sprintf(
                'select count(*) as count from %s where %s',
                $table,
                $queryString
            );

        } else {

            $sql = sprintf(
                'select count(*) as count from %s',
                $table
            );

        }

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($parameters);
            return $statement->fetch(PDO::FETCH_OBJ)->count;
        } catch (Exception $e) {
            //
        }
    }

    // возвращает записи удовлетворяющие заданному условию
    public function where($table, $parameters)
    {
        $queryString = '';

        foreach ($parameters as $key => $value) {
            $queryString .= "{$key} = :{$key}, ";
        }

        $queryString = rtrim($queryString,", ");

        $sql = sprintf(
            'select * from %s where %s',
            $table,
            $queryString
        );

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($parameters);
            return $statement->fetchAll(PDO::FETCH_CLASS);
        } catch (Exception $e) {
            //
        }
    }

    // вставляет запись в таблицу
    public function insert($table, $parameters)
    {
        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($parameters);
            return $this->pdo->lastInsertId();
        } catch (Exception $e) {
            //
        }
    }

    // обновляет таблицу переданными значениями
    public function update($table, $parameters)
    {
        $queryString = '';

        foreach ($parameters as $key => $value) {
            if ($key!='id') {
                $queryString .= "{$key} = :{$key}, ";
            }
        }

        $queryString = rtrim($queryString, ", ");

        $sql = sprintf(
            'update %s set %s where %s',
            $table,
            $queryString,
            "id = :id"
        );

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($parameters);
        } catch (Exception $e) {
            //
        }
    }

    // удаляет запись с заданным id
    public function delete($table, $parameters)
    {
        $sql = sprintf(
            'delete from %s where %s',
            $table,
            "id = :id"
        );

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($parameters);
        } catch (Exception $e) {
            //
        }
    }

    public function deleteWhere($table, $parameters)
    {
        $queryString = '';

        foreach ($parameters as $key => $value) {
            $queryString .= "{$key} = :{$key} AND ";
        }

        $queryString = rtrim($queryString," AND ");

        $sql = sprintf(
            'delete from %s where %s',
            $table,
            $queryString
        );

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($parameters);
//            return $statement->fetchAll(PDO::FETCH_CLASS);
        } catch (Exception $e) {
            //
        }
    }
}
