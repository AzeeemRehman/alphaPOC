<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Mailer;
use App\Core\Spam;
use App\Core\Validator;
use App\Data\Services;
use App\Models\Query;

final class QueryController
{
    public function contact(): void
    {
        $this->guard('/contact');
        $data = $this->clean(['name', 'email', 'phone', 'company', 'subject', 'message']);

        $errors = Validator::make($data, [
            'name'    => 'required|max:100',
            'email'   => 'required|email|max:150',
            'phone'   => 'required|phone',
            'company' => 'max:150',
            'subject' => 'required|max:200',
            'message' => 'required|min:10|max:5000',
        ]);
        if ($errors) {
            back_with_errors($errors, '/contact');
        }

        $this->store('contact', $data);
        flash('success', 'Thank you! Your message has been received. Our team will contact you shortly.');
        redirect('/contact');
    }

    public function quote(): void
    {
        $this->guard('/quote');
        $data = $this->clean([
            'name', 'company', 'email', 'phone', 'service_type', 'origin', 'destination', 'commodity',
            'weight_kg', 'volume_cbm', 'container_type', 'incoterms', 'ship_date', 'message',
        ]);

        $errors = Validator::make($data, [
            'name'           => 'required|max:100',
            'company'        => 'max:150',
            'email'          => 'required|email|max:150',
            'phone'          => 'required|phone',
            'service_type'   => 'required|in:' . implode(',', Services::formOptions()),
            'origin'         => 'required|max:150',
            'destination'    => 'required|max:150',
            'commodity'      => 'required|max:200',
            'weight_kg'      => 'numeric',
            'volume_cbm'     => 'numeric',
            'container_type' => 'in:20ft,40ft,40ft HC,Not applicable',
            'incoterms'      => 'in:EXW,FOB,CIF,CFR,DAP,DDP',
            'ship_date'      => 'date',
            'message'        => 'max:3000',
        ]);
        if ($errors) {
            back_with_errors($errors, '/quote');
        }

        $data['subject'] = 'Quote request: ' . $data['service_type'] . ' – ' . $data['origin'] . ' to ' . $data['destination'];
        $this->store('quote', $data);
        flash('success', 'Thank you! Your quote request has been received. We will reply with rates shortly.');
        redirect('/quote');
    }

    private function guard(string $fallback): void
    {
        $problem = Spam::check();
        if ($problem !== null) {
            back_with_errors(['_form' => $problem], $fallback);
        }
    }

    private function clean(array $fields): array
    {
        $out = [];
        foreach ($fields as $f) {
            $v = $_POST[$f] ?? '';
            $out[$f] = is_string($v) ? trim(preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', '', $v)) : '';
        }
        return $out;
    }

    private function store(string $type, array $data): void
    {
        foreach (['company', 'phone', 'service_type', 'origin', 'destination', 'commodity', 'container_type', 'incoterms', 'message', 'subject'] as $f) {
            if (isset($data[$f]) && $data[$f] === '') {
                $data[$f] = null;
            }
        }
        foreach (['weight_kg', 'volume_cbm', 'ship_date'] as $f) {
            $data[$f] = ($data[$f] ?? '') === '' ? null : $data[$f];
        }
        $data['type'] = $type;
        $data['ip_address'] = client_ip();
        $id = Query::create($data);

        $this->notify($id, $type, $data);
    }

    private function notify(int $id, string $type, array $d): void
    {
        $rows = [
            'Type' => $type === 'quote' ? 'Quote request' : 'Contact message',
            'Name' => $d['name'], 'Company' => $d['company'] ?? '', 'Email' => $d['email'], 'Phone' => $d['phone'] ?? '',
            'Service' => $d['service_type'] ?? '', 'Route' => trim(($d['origin'] ?? '') . ' → ' . ($d['destination'] ?? ''), ' →'),
            'Commodity' => $d['commodity'] ?? '', 'Weight (kg)' => $d['weight_kg'] ?? '', 'Volume (CBM)' => $d['volume_cbm'] ?? '',
            'Container' => $d['container_type'] ?? '', 'Incoterms' => $d['incoterms'] ?? '', 'Ship date' => $d['ship_date'] ?? '',
            'Subject' => $d['subject'] ?? '', 'Message' => $d['message'] ?? '',
        ];
        $html = '<h2>New website ' . e($type) . ' #' . $id . '</h2><table cellpadding="6" style="border-collapse:collapse">';
        foreach ($rows as $label => $value) {
            if ((string) $value !== '') {
                $html .= '<tr><td style="border:1px solid #ddd"><b>' . e($label) . '</b></td><td style="border:1px solid #ddd">' . nl2br(e($value)) . '</td></tr>';
            }
        }
        $html .= '</table><p><a href="' . e(absolute_url('admin/queries/' . $id)) . '">Open in admin panel</a></p>';

        Mailer::send(setting('notify_email'), '[Website] ' . ($d['subject'] ?? 'New enquiry') . ' – ' . $d['name'], $html, $d['email']);

        $reply = '<p>Dear ' . e($d['name']) . ',</p>'
            . '<p>Thank you for contacting <b>' . e(setting('company_name')) . '</b>. We have received your ' . ($type === 'quote' ? 'quote request' : 'message')
            . ' (reference <b>#' . $id . '</b>) and a member of our team will respond shortly.</p>'
            . '<p>For urgent matters call us on ' . e(setting('phone')) . ' or WhatsApp ' . e(setting('mobile')) . '.</p>'
            . '<p>Regards,<br>' . e(setting('company_name')) . '<br>' . e(setting('address')) . '</p>';
        Mailer::send($d['email'], 'We received your enquiry (#' . $id . ')', $reply);
    }
}
