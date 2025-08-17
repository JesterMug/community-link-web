<?php


require_once __DIR__ . '/Model.php';

class Organisation extends Model
{
    public ?int $organisation_id = null;
    public string $org_name;
    public ?string $contact_person_full_name = null;
    public ?string $email = null;
    public ?string $phone = null;

    public function __construct(array $d = [])
    {
        foreach ($d as $k => $v) if (property_exists($this, $k)) $this->$k = $v;
    }

    public function save()
    {
        $st = self::$pdo->prepare("INSERT INTO Organisations (org_name,contact_person_full_name,email,phone)
                                   VALUES (?,?,?,?)");
        $st->execute([$this->org_name, $this->contact_person_full_name, $this->email, $this->phone]);
        $this->organisation_id = (int)self::$pdo->lastInsertId();
        return $this->organisation_id;
    }

    public static function find(int $id): ?Organisation
    {
        $st = self::$pdo->prepare("SELECT * FROM Organisations WHERE organisation_id=?");
        $st->execute([$id]);
        $r = $st->fetch();
        return $r ? new Organisation($r) : null;
    }

    public static function all(): array
    {
        $st = self::$pdo->query("SELECT * FROM Organisations ORDER BY org_name ASC");
        return array_map(fn($r) => new Organisation($r), $st->fetchAll());
    }

    public function update(): bool
    {
        $st = self::$pdo->prepare("UPDATE Organisations SET org_name=?, contact_person_full_name=?, email=?, phone=? WHERE organisation_id=?");
        return $st->execute([$this->org_name, $this->contact_person_full_name, $this->email, $this->phone, $this->organisation_id]);
    }

    public function delete(): bool
    {
        $st = self::$pdo->prepare("DELETE FROM Organisations WHERE organisation_id=?");
        return $st->execute([$this->organisation_id]);
    }
}
