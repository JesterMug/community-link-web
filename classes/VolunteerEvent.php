<?php

require_once __DIR__ . '/Model.php';

class VolunteerEvent extends Model
{
   public function __construct()
   {
       parent::__construct();
   }

    public static function assign(int $volunteer_id, int $event_id): bool
    {
        $st = self::getPDO()->prepare("INSERT INTO Volunteer_Event (event_id, volunteer_id) VALUES (?, ?)");
        return $st->execute([$event_id, $volunteer_id]);
    }

    public static function unassign(int $volunteer_id, int $event_id): bool
    {
        $st = self::getPDO()->prepare("DELETE FROM Volunteer_Event WHERE event_id=? AND volunteer_id=?");
        return $st->execute([$event_id, $volunteer_id]);
    }

    public static function unassignAll(int $event_id): bool
    {
        $st = self::getPDO()->prepare("DELETE FROM volunteer_event WHERE event_id=?");
        return $st->execute([$event_id]);
    }

    public static function resetAssignments(int $event_id, array $volunteerIds): void
    {
        self::unassignAll($event_id);
        foreach ($volunteerIds as $vid) {
            self::assign((int)$vid, $event_id);
        }
    }

    public static function volunteersForEvent(int $event_id): array
    {
        $sql = "SELECT v.* FROM Volunteer v
                JOIN Volunteer_Event ve ON v.volunteer_id = ve.volunteer_id
                WHERE ve.event_id = ?";
        $st = self::getPDO()->prepare($sql);
        $st->execute([$event_id]);
        return $st->fetchAll();
    }
}
