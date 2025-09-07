<?php
require_once __DIR__ . '/Model.php';

class ContactMessage extends Model
{
    public ?int $contact_messages_id = null;
    public string $full_name;
    public string $email;
    public ?string $phone;
    public string $message;
    public int $replied = 0;
    public string $created_at;

    public function __construct(array $d = [])
    {
      foreach ($d as $k => $v) {
        if (property_exists($this, $k)){
          $this->$k = $v;
        }
      }
    }

    public static function create(string $full_name, string $email, ?string $phone, string $message): bool
    {
      $st = self::getPDO()->prepare(
        "INSERT INTO contact_messages (full_name, email, phone, message) VALUES (?, ?, ?, ?)"
      );
      return $st->execute([$full_name, $email, $phone, $message]);
    }

    public static function all(): array
    {
      $st = self::getPDO()->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
      $st->execute();
      return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function markReplied(int $id): bool
    {
      $st = self::getPDO()->prepare("UPDATE contact_messages SET replied = 1 WHERE contact_messages_id = ?");
      return $st->execute([$id]);
    }

    public static function delete(int $id): bool
    {
      $st = self::getPDO()->prepare("DELETE FROM contact_messages WHERE contact_messages_id = ?");
      return $st->execute([$id]);
    }

    public static function find(int $id): ?ContactMessage
    {
      $st = self::getPDO()->prepare("SELECT * FROM contact_messages WHERE contact_messages_id = ?");
      $st->execute([$id]);
      $r = $st->fetch();
      return $r ? new ContactMessage($r) : null;
    }

    //Only for removing all the messages while developing
    public static function deleteAll() {
      $st = self::getPDO()->prepare("DELETE FROM contact_messages");
      return $st->execute();
    }
}
