<?php

require_once __DIR__ . '/Model.php';

class Event extends Model
{
    public ?int $event_id;
    public string $title;
    public ?string $location;
    public ?string $description;
    public ?string $date;
    public ?int $organisation_id;

    public function __construct(array $d = [])
    {
        foreach ($d as $k => $v) if (property_exists($this, $k)) $this->$k = $v;
    }

    public function save(): int
    {
        $st = self::getPDO()->prepare(
            "INSERT INTO Event (title, location, description, date, organisation_id) VALUES (?,?,?,?,?)"
        );
        $st->execute([$this->title, $this->location, $this->description, $this->date, $this->organisation_id]);
        $this->event_id = (int)self::getPDO()->lastInsertId();
        return $this->event_id;
    }

    public static function find(int $id): ?Event
    {
        $st = self::getPDO()->prepare("SELECT * FROM Event WHERE event_id=?");
        $st->execute([$id]);
        $r = $st->fetch();
        return $r ? new Event($r) : null;
    }

    public static function all(): array
    {
      $sql = "SELECT e.*, o.organisation_name 
                  FROM event e 
                  JOIN organisation o ON e.organisation_id = o.organisation_id 
                  ORDER BY e.date DESC";
      $st = self::getPDO()->query($sql);
      return $st->fetchAll(PDO::FETCH_ASSOC);
    }



    public static function allUpcoming(): array
    {
        $st = self::getPDO()->prepare("SELECT * FROM Event WHERE date >= CURDATE() ORDER BY date ASC");
        $st->execute();
        return array_map(fn($r) => new Event($r), $st->fetchAll());
    }

    public function update(): bool
    {
        $st = self::getPDO()->prepare(
            "UPDATE Event SET title=?, location=?, description=?, date=?, organisation_id=? WHERE event_id=?"
        );
        return $st->execute([$this->title, $this->location, $this->description, $this->date, $this->organisation_id, $this->event_id]);
    }

    public static function delete(int $id): bool
    {
        $st = self::getPDO()->prepare("DELETE FROM Event WHERE event_id=?");
        return $st->execute([$id]);
    }

    public function organisation(): ?array
    {
        if (!$this->organisation_id) return null;
        $st = self::getPDO()->prepare("SELECT * FROM Organisations WHERE organisation_id=?");
        $st->execute([$this->organisation_id]);
        return $st->fetch() ?: null;
    }

    public function volunteers(): array
    {
        $sql = "SELECT v.* FROM Volunteers v
                JOIN Volunteer_Event ve ON ve.volunteer_id = v.volunteer_id
                WHERE ve.event_id = ?";
        $st = self::getPDO()->prepare($sql);
        $st->execute([$this->event_id]);
        return $st->fetchAll();
    }


}
