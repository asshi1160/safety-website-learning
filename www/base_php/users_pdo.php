<?php

class UsersPdo
{
    public function getPdo()
    {
        try {
            $dsn = $_ENV['DSN'];
            $db_user = $_ENV['DB_USER'];
            $db_pass = $_ENV['DB_PASS'];

            return new PDO($dsn, $db_user, $db_pass);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function searchUsers($keyword = [])
    {
        try {
            $pdo = $this->getPdo();
            $sql = "SELECT * FROM users";
            $where = [];

            foreach ($keyword as $key => $value) {
                if ($key == 'name') {
                    $where += ['name' => "name LIKE '%:name%'"];
                } else {
                    $where += [$key => "{$key} = :{$key}"];
                }
            }

            $sql = count($where) > 0 ? $sql . ' WHERE ' . join(' ', $where) : $sql;
            $stmt = $pdo->prepare($sql);

            foreach ($keyword as $key => $value) {
                if ($key == 'id') {
                    $stmt->bindValue('id', $value, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue($key, $value, PDO::PARAM_STR);
                }
            }

            $stmt->execute();
            $res_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt = null;
            $pdo = null;

            return $res_data;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function nameSearchUsers($name = '')
    {
        try {
            $pdo = $this->getPdo();
            $sql = "SELECT id, name, email FROM users WHERE name LIKE '%{$name}%'";
            $res_data = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            $stmt = null;
            $pdo = null;

            return $res_data;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function setSessionId($id, $session_id)
    {
        try {
            $pdo = $this->getPdo();
            $sql = 'UPDATE users SET session_id = :session_id WHERE id = :id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue('id', $id, PDO::PARAM_INT);
            $stmt->bindValue('session_id', $session_id, PDO::PARAM_INT);
            $stmt->execute();

            $stmt = null;
            $pdo = null;

            return true;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function login($name, $password)
    {
        try {
            $pdo = $this->getPdo();
            $sql = 'SELECT * FROM users WHERE name = :name AND password = :password';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue('name', $name, PDO::PARAM_STR);
            $stmt->bindValue('password', $password, PDO::PARAM_STR);
            $stmt->execute();

            $res_data = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt = null;
            $pdo = null;

            return $res_data;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function newPassword($new_password)
    {
        try {
            $pdo = $this->getPdo();
            $sql = 'UPDATE users SET password = :new_password WHERE id = 1';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue('new_password', $new_password, PDO::PARAM_STR);
            $stmt->execute();

            $stmt = null;
            $pdo = null;

            return true;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function checkSessionId($session_id)
    {
        try {
            $user1 = $this->searchUsers(['id' => 1]);

            $res_data = $session_id == $user1[0]['session_id'];

            $pdo = null;

            return $res_data;
        } catch (PDOException $e) {
            throw $e;
        }
    }
}
