<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\DB;
use App\Core\Validator;
use App\Models\Shipment;

final class ShipmentController
{
    public function index(): string
    {
        return view('admin/shipments/index', ['title' => 'Shipments', 'shipments' => Shipment::all()], 'layouts/admin');
    }

    public function store(): void
    {
        $data = [
            'tracking_no'   => strtoupper((string) input('tracking_no', '')),
            'customer_name' => (string) input('customer_name', ''),
            'origin'        => (string) input('origin', ''),
            'destination'   => (string) input('destination', ''),
            'mode'          => (string) input('mode', 'Ocean'),
            'eta'           => (string) input('eta', ''),
        ];
        $errors = Validator::make($data, [
            'tracking_no' => 'required|max:40', 'customer_name' => 'max:150', 'origin' => 'required|max:150',
            'destination' => 'required|max:150', 'mode' => 'required|in:Ocean,Air,Land', 'eta' => 'date',
        ]);
        if (!$errors && !preg_match('/^[A-Z0-9\-]{4,40}$/', $data['tracking_no'])) {
            $errors['tracking_no'] = 'Use 4–40 letters, numbers or dashes.';
        }
        if (!$errors && Shipment::findByTracking($data['tracking_no'])) {
            $errors['tracking_no'] = 'This tracking number already exists.';
        }
        if ($errors) {
            back_with_errors($errors, '/admin/shipments');
        }
        $data['customer_name'] = $data['customer_name'] ?: null;
        $data['eta'] = $data['eta'] ?: null;
        $id = DB::insert('shipments', $data);
        Shipment::addEvent($id, 'Booking Confirmed', $data['origin'], null, date('Y-m-d H:i:s'));
        flash('success', 'Shipment created.');
        redirect('/admin/shipments/' . $id);
    }

    public function show(string $id): string
    {
        $shipment = Shipment::find((int) $id);
        if (!$shipment) {
            abort(404);
        }
        return view('admin/shipments/show', [
            'title' => $shipment['tracking_no'], 'shipment' => $shipment, 'events' => Shipment::events((int) $id),
        ], 'layouts/admin');
    }

    public function addEvent(string $id): void
    {
        if (!Shipment::find((int) $id)) {
            abort(404);
        }
        $status = (string) input('status', '');
        $time = (string) input('event_time', '');
        $errors = Validator::make(
            ['status' => $status, 'location' => (string) input('location', ''), 'note' => (string) input('note', ''), 'event_time' => $time],
            ['status' => 'required|in:' . implode(',', Shipment::STATUSES), 'location' => 'max:150', 'note' => 'max:300', 'event_time' => 'date']
        );
        if ($errors) {
            back_with_errors($errors, '/admin/shipments/' . $id);
        }
        Shipment::addEvent(
            (int) $id, $status, (string) input('location', ''), (string) input('note', ''),
            $time !== '' ? date('Y-m-d H:i:s', strtotime($time)) : date('Y-m-d H:i:s')
        );
        flash('success', 'Status update added.');
        redirect('/admin/shipments/' . $id);
    }

    public function destroy(string $id): void
    {
        Shipment::delete((int) $id);
        flash('success', 'Shipment deleted.');
        redirect('/admin/shipments');
    }
}
