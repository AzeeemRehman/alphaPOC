<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Shipment;

final class TrackingController
{
    public function index(): string
    {
        $no = strtoupper(trim((string) ($_GET['no'] ?? '')));
        $shipment = null;
        $events = [];
        $searched = $no !== '';

        if ($searched && preg_match('/^[A-Z0-9\-]{4,40}$/', $no)) {
            $shipment = Shipment::findByTracking($no);
            $events = $shipment ? Shipment::events((int) $shipment['id']) : [];
        }

        return view('pages/tracking', [
            'title'    => 'Track Your Shipment',
            'metaDesc' => 'Track your ALPHA Global Shipping & Logistics shipment status online.',
            'no'       => $no,
            'searched' => $searched,
            'shipment' => $shipment,
            'events'   => $events,
        ]);
    }
}
