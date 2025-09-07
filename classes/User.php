<?php
require_once __DIR__ . '/Model.php';

enum UserRole: string
{
    case ADMIN = 'admin';
    case VOLUNTEER = 'volunteer';
}

class User extends Model
{
    public ?int $user_id = null;
    public string $username;
    public string $password;
    public UserRole $role = UserRole::VOLUNTEER;
    public ?int $volunteer_id = null;
    

    public function __construct(array $d = [])
    {
        foreach ($d as $k => $v) {
            if (property_exists($this, $k)) {
                if ($k === 'role' && is_string($v)) {
                    $this->$k = UserRole::from($v);
                } else {
                    $this->$k = $v;
                }
            }
        }
    }

    public static function create(string $username, string $plainPassword, UserRole $role, ?int $volunteer_id): int
    {
        $hash = password_hash($plainPassword, PASSWORD_DEFAULT);
        $st = self::getPDO()->prepare("INSERT INTO user (username, password, role, volunteer_id) VALUES (?, ?, ?, ?)");
        $st->execute([$username, $hash, $role->value, $volunteer_id]);
        return (int)self::getPDO()->lastInsertId();
    }

    public static function delete(int $id): bool
    {
      $st = self::getPDO()->prepare("DELETE FROM user WHERE user_id=?");
      return $st->execute([$id]);
    }

    public static function all(): array
    {
      $st = self::getPDO()->query("SELECT u.user_id, u.username, u.role, u.volunteer_id, v.full_name as volunteer_name FROM user u LEFT JOIN volunteer v ON u.volunteer_id = v.volunteer_id ORDER BY u.user_id ASC");
      return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function update(int $user_id, string $username, string $newPlainPassword): bool
    {
      $st = self::getPDO()->prepare("UPDATE user SET username=? WHERE user_id=?");
      $status = $st->execute([$username, $user_id]);
      if ($newPlainPassword !== '') {
        $hash = password_hash($newPlainPassword, PASSWORD_DEFAULT);
        $st = self::getPDO()->prepare("UPDATE user SET password = ? WHERE user_id = ?");
        $status = $st->execute([$hash, $user_id]);
      }
      return $status;
    }

    public static function usernameExists(string $username, ?int $excludeId = null): bool
    {
      $sql = "SELECT COUNT(*) FROM user WHERE username = ?";
      $params = [$username];

      if ($excludeId !== null) {
        $sql .= " AND user_id != ?";
        $params[] = $excludeId;
      }

      $st = self::getPDO()->prepare($sql);
      $st->execute($params);
      return $st->fetchColumn();
    }


  public static function authenticate(string $username, string $plainPassword): ?User
    {
        $st = self::getPDO()->prepare("SELECT * FROM user WHERE username=?");
        $st->execute([$username]);
        $row = $st->fetch();
        if ($row && password_verify($plainPassword, $row['password'])) {
            return new User($row);
        }
        return null;
    }

    public static function find(int $id): ?User
    {
        $st = self::getPDO()->prepare("SELECT * FROM user WHERE user_id=?");
        $st->execute([$id]);
        $r = $st->fetch();
        return $r ? new User($r) : null;
    }


}
