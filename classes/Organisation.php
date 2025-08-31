<?php


require_once __DIR__ . '/Model.php';

class Organisation extends Model
{
    public ?int $organisation_id = null;
    public string $organisation_name;
    public string $contact_person_full_name;
    public string $email;
    public string $phone;

    public function __construct(array $d)
    {

        // Validate required fields
        $required = ['organisation_name', 'contact_person_full_name', 'email', 'phone'];
        foreach ($required as $field) {
            if (!isset($d[$field]) || empty($d[$field])) {
                throw new InvalidArgumentException("$field is required");
            }
        }

        foreach ($d as $k => $v) if (property_exists($this, $k)) $this->$k = $v;



    }

    public function save()
    {
        $st = self::getPDO()->prepare("INSERT INTO Organisation (organisation_name,contact_person_full_name,email,phone)
                                   VALUES (?,?,?,?)");
        $st->execute([$this->organisation_name, $this->contact_person_full_name, $this->email, $this->phone]);
        $this->organisation_id = (int)self::getPDO()->lastInsertId();
        return $this->organisation_id;
    }

    public static function find(int $id): ?Organisation
    {
        $st = self::getPDO()->prepare("SELECT * FROM Organisation WHERE organisation_id=?");
        $st->execute([$id]);
        $r = $st->fetch();
        return $r ? new Organisation($r) : null;
    }

    public static function all(): array
    {
        $st = self::getPDO()->query("SELECT * FROM organisation ORDER BY organisation_name ASC");
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(): bool
    {
        $st = self::getPDO()->prepare("UPDATE Organisation SET organisation    _name=?, contact_person_full_name=?, email=?, phone=? WHERE organisation_id=?");
        return $st->execute([$this->organisation_name, $this->contact_person_full_name, $this->email, $this->phone, $this->organisation_id]);
    }

    public function delete(): bool
    {
        $st = self::getPDO()->prepare("DELETE FROM Organisation WHERE organisation_id=?");
        return $st->execute([$this->organisation_id]);
    }
}
