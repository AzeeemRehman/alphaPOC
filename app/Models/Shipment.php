<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

final class Shipment
{
    public const STATUSES = [
        'Booking Confirmed', 'Cargo Received', 'Departed Origin', 'In Transit',
        'Arrived at Port', 'Customs Clearance', 'Out for Delivery', 'Delivered', 'On Hold',
    ];

    public static function findByTracking(string $no): ?array
    {
        return DB::one('SELECT * FROM shipments WHERE tracking_no = ?', [strtoupper($no)]);
    }

    public static function find(int $id): ?array
    {
        return DB::one('SELECT * FROM shipments WHERE id = ?', [$id]);
    }

    public static function events(int $shipmentId): array
    {
        return DB::all('SELECT * FROM shipment_events WHERE shipment_id = ? ORDER BY event_time DESC, id DESC', [$shipmentId]);
    }

    public static function all(): array
    {
        return DB::all('SELECT * FROM shipments ORDER BY created_at DESC');
    }

    public static function count(): int
    {
        return (int) DB::value('SELECT COUNT(*) FROM shipments');
    }

    public static function addEvent(int $shipmentId, string $status, ?string $location, ?string $note, string $time): void
    {
        DB::insert('shipment_events', [
            'shipment_id' => $shipmentId,
            'status'      => $status,
            'location'    => $location ?: null,
            'note'        => $note ?: null,
            'event_time'  => $time,
        ]);
        DB::exec('UPDATE shipments SET current_status = ? WHERE id = ?', [$status, $shipmentId]);
    }

    public static function delete(int $id): void
    {
        DB::exec('DELETE FROM shipments WHERE id = ?', [$id]);
    }
}
