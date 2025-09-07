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
        foreach ($data as $k => $v) {
            if (property_exists($this, $k)) {
                // Handle status conversion from string to enum
                if ($k === 'status' && is_string($v)) {
                    $this->status = match ($v) {
                        'active' => VolunteerStatus::Active,
                        'inactive' => VolunteerStatus::Inactive,
                        default => VolunteerStatus::Inactive
                    };
                } else {
                    $this->$k = $v;
                }
            }
        }
    }

    public function save()
    {
        $sql = "INSERT INTO Volunteer (full_name,email,phone,skills,profile_picture,status)
                VALUES (?,?,?,?,?,?)";
        $st = self::getPDO()->prepare($sql);
        $st->execute([
            $this->full_name, $this->email, $this->phone,
            $this->skills, $this->profile_picture, $this->status->toString()
        ]);
        $this->volunteer_id = (int)self::getPDO()->lastInsertId();
        return $this->volunteer_id;
    }

    public static function find(int $id): ?Volunteer
    {
        $st = self::getPDO()->prepare("SELECT * FROM Volunteer WHERE volunteer_id = ?");
        $st->execute([$id]);
        $row = $st->fetch();
        return $row ? new Volunteer($row) : null;
    }

    public static function all()
    {
        $st = self::getPDO()->query("SELECT * FROM volunteer ORDER BY volunteer_id ASC");
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function availableForAccount(): array
    {
      $sql = "SELECT v.* FROM volunteer v LEFT JOIN user u ON v.volunteer_id = u.volunteer_id
              WHERE u.user_id IS NULL ORDER BY v.full_name ASC";
      $st = self::getPDO()->query($sql);
      return $st->fetchAll(PDO::FETCH_ASSOC);
    }


  public function update()
    {
        if ($this->volunteer_id === null) return false;
        $sql = "UPDATE Volunteer
                SET full_name=?, email=?, phone=?, skills=?, profile_picture=?, status=?
                WHERE volunteer_id=?";
        $st = self::getPDO()->prepare($sql);
        return $st->execute([
            $this->full_name, $this->email, $this->phone, $this->skills,
            $this->profile_picture, $this->status->toString(), $this->volunteer_id
        ]);
    }

    public function delete()
    {
        $st = self::getPDO()->prepare("DELETE FROM Volunteer WHERE volunteer_id=?");
        return $st->execute([$this->volunteer_id]);
    }

    public function getAssignedEvents()
    {
        $sql = "SELECT e.* FROM Event e
                JOIN Volunteer_Event ve ON ve.event_id = e.event_id
                WHERE ve.volunteer_id = ?";
        $st = self::getPDO()->prepare($sql);
        $st->execute([$this->volunteer_id]);
        return $st->fetchAll();
    }
}
