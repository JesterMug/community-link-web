<?php


require_once __DIR__ . '/Model.php';

class User extends Model
{
    public ?int $user_id = null;
    public string $username;
    public string $password; // hashed

    public function __construct(array $d = [])
    {
        foreach ($d as $k => $v) if (property_exists($this, $k)) $this->$k = $v;
    }

    public static function create(string $username, string $plainPassword): int
    {
        $hash = password_hash($plainPassword, PASSWORD_DEFAULT);
        $st = self::$pdo->prepare("INSERT INTO Users (username, password) VALUES (?, ?)");
        $st->execute([$username, $hash]);
        return (int)self::$pdo->lastInsertId();
    }

    public static function authenticate(string $username, string $plainPassword): ?User
    {
        $st = self::$pdo->prepare("SELECT * FROM Users WHERE username=?");
        $st->execute([$username]);
        $row = $st->fetch();
        if ($row && password_verify($plainPassword, $row['password'])) {
            return new User($row);
        }
        return null;
    }

    public static function find(int $id): ?User
    {
        $st = self::$pdo->prepare("SELECT * FROM Users WHERE user_id=?");
        $st->execute([$id]);
        $r = $st->fetch();
        return $r ? new User($r) : null;
    }
}
