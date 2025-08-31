<?php

require_once __DIR__ . '/Model.php';

class Event extends Model
{
    public ?int $event_id = null;
    public string $title;
    public ?string $location = null;
    public ?string $description = null;
    public ?string $date = null; //todo: use datetime
    public ?int $organisation_id = null;

    public function __construct(array $d = [])
    {
        foreach ($d as $k => $v) if (property_exists($this, $k)) $this->$k = $v;
    }

    public function save(): int
    {
        $st = self::getPDO()->prepare(
            "INSERT INTO Events (title,location,description,date,organisation_id) VALUES (?,?,?,?,?)"
        );
        $st->execute([$this->title, $this->location, $this->description, $this->date, $this->organisation_id]);
        $this->event_id = (int)self::$pdo->lastInsertId();
        return $this->event_id;
    }

    public static function find(int $id): ?Event
    {
        $st = self::getPDO()->prepare("SELECT * FROM Events WHERE event_id=?");
        $st->execute([$id]);
        $r = $st->fetch();
        return $r ? new Event($r) : null;
    }

    public static function allUpcoming(): array
    {
        $st = self::getPDO()->prepare("SELECT * FROM Events WHERE date >= CURDATE() ORDER BY date ASC");
        $st->execute();
        return array_map(fn($r) => new Event($r), $st->fetchAll());
    }

    public function update(): bool
    {
        $st = self::getPDO()->prepare(
            "UPDATE Events SET title=?, location=?, description=?, date=?, organisation_id=? WHERE event_id=?"
        );
        return $st->execute([$this->title, $this->location, $this->description, $this->date, $this->organisation_id, $this->event_id]);
    }

    public function delete(): bool
    {
        $st = self::getPDO()->prepare("DELETE FROM Events WHERE event_id=?");
        return $st->execute([$this->event_id]);
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
