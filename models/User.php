<?php

class User
{
    public static function register($name, $email, $password)
    {
        $db = Db::getConnection();

        $sql = 'INSERT INTO user (name, email, password) VALUES (:name, :email, :password)';

        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function checkName($name)
    {
        if(strlen($name) >= 2){
            // strlen -- Возвращает длину строки
            return true;
        }
        return false;
    }

    public static function checkPassword($password)
    {
        if(strlen($password) >= 6){
            return true;
        }
        return false;
    }

    public static function checkEmail($email)
    {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            // filter_var — Фильтрует переменную с помощью определенного фильтра
            return true;
        }
        return false;
    }

    public static function checkEmailExists($email)
    {
        $db = Db::getConnection();

        $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';

        $result = $db->prepare($sql);
        // PDO::prepare — Подготавливает запрос к выполнению и возвращает ассоциированный с этим запросом объект
        // С помощью prepare вы подготавливаете выражение.
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        // Назначает параметр с указанным именем переменной
        // PDOStatement::bindParam — С помощью bindParam или bindValue устанавливаете соответствия для указанных в подготовленном выражении параметрами.
        $result->execute();
        // PDOStatement::execute — Запускает подготовленный запрос на выполнение
        if($result->fetchColumn()){
        // PDOStatement::fetchColumn — Возвращает данные одного столбца следующей строки результирующего набора
            return true;
        }
        return false;
    }

    /**
     * Проверяем существует ли пользователь с задаными $email и $password
     * @param $email
     * @param $password
     * @return bool
     */
    public static function checkUserData($email, $password)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM user WHERE email = :email AND password = :password';

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->execute();

        $user = $result->fetch();
        if($user){
            return $user['id'];
        }
        return false;
    }

    public static function auth($userId)
    {
        session_start();
        $_SESSION['user'] = $userId;
    }
}