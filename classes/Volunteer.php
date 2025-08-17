<?php
require_once __DIR__ . '/Model.php';

enum VolunteerStatus {
    case Active;
    case Inactive;

    public function toString(): string {
        return match($this) {
            self::Active => 'active',
            self::Inactive => 'inactive'
        };
    }
}

class Volunteer extends Model
{
    public ?int $volunteer_id = null;
    public string $full_name;
    public string $email;
    public string $phone; // Changed from ?string to string
    public ?string $skills = null;
    public ?string $profile_picture = null;
    public VolunteerStatus $status = VolunteerStatus::Inactive;

    public function __construct(array $data = [])
    {
        foreach ($data as $k => $v) if (property_exists($this, $k)) $this->$k = $v;
    }

    public function save()
    {
        $sql = "INSERT INTO Volunteer (full_name,email,phone,skills,profile_picture,status)
                VALUES (?,?,?,?,?,?)";
        $st = self::$pdo->prepare($sql);
        $st->execute([
            $this->full_name, $this->email, $this->phone,
            $this->skills, $this->profile_picture, $this->status->toString()
        ]);
        $this->volunteer_id = (int)self::$pdo->lastInsertId();
        return $this->volunteer_id;
    }

    public static function find(int $id): ?Volunteer
    {
        $st = self::$pdo->prepare("SELECT * FROM Volunteer WHERE volunteer_id = ?");
        $st->execute([$id]);
        $row = $st->fetch();
        return $row ? new Volunteer($row) : null;
    }

    public static function all(int $limit = 50, int $offset = 0)
    {
        $st = self::$pdo->prepare("SELECT * FROM Volunteer ORDER BY volunteer_id DESC LIMIT ? OFFSET ?");
        $st->bindValue(1, $limit, PDO::PARAM_INT);
        $st->bindValue(2, $offset, PDO::PARAM_INT);
        $st->execute();
        return array_map(fn($r) => new Volunteer($r), $st->fetchAll());
    }

    public function update()
    {
        if ($this->volunteer_id === null) return false;
        $sql = "UPDATE Volunteer
                SET full_name=?, email=?, phone=?, skills=?, profile_picture=?, status=?
                WHERE volunteer_id=?";
        $st = self::$pdo->prepare($sql);
        return $st->execute([
            $this->full_name, $this->email, $this->phone, $this->skills,
            $this->profile_picture, $this->status->toString(), $this->volunteer_id
        ]);
    }

    public function delete()
    {
        if ($this->volunteer_id === null) return false;
        $st = self::$pdo->prepare("DELETE FROM Volunteer WHERE volunteer_id=?");
        return $st->execute([$this->volunteer_id]);
    }

    public function getAssignedEvents()
    {
        $sql = "SELECT e.* FROM Events e
                JOIN Volunteer_Event ve ON ve.event_id = e.event_id
                WHERE ve.volunteer_id = ?";
        $st = self::$pdo->prepare($sql);
        $st->execute([$this->volunteer_id]);
        return $st->fetchAll();
    }
}
