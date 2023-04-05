<?php


class User
{
  private static $pdo;

  public static function init()
  {
    include_once dirname(__DIR__) . '/db.php';
    self::$pdo = $pdo;
  }

  public static function getUserByEmail($email)
  {
    $stmt = self::$pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}

User::init();
