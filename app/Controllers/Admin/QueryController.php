<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Query;

final class QueryController
{
    public function index(): string
    {
        $type = (string) ($_GET['type'] ?? '');
        $status = (string) ($_GET['status'] ?? '');
        $search = trim((string) ($_GET['q'] ?? ''));
        return view('admin/queries/index', [
            'title'   => 'Queries & Quotes',
            'queries' => Query::filtered($type, $status, $search ?: null),
            'type' => $type, 'status' => $status, 'search' => $search,
        ], 'layouts/admin');
    }

    public function show(string $id): string
    {
        $query = Query::find((int) $id);
        if (!$query) {
            abort(404);
        }
        return view('admin/queries/show', ['title' => 'Query #' . $id, 'query' => $query], 'layouts/admin');
    }

    public function update(string $id): void
    {
        $query = Query::find((int) $id);
        if (!$query) {
            abort(404);
        }
        $status = (string) input('status', $query['status']);
        if (!in_array($status, Query::STATUSES, true)) {
            $status = $query['status'];
        }
        \App\Core\DB::update('queries', [
            'status'      => $status,
            'admin_notes' => mb_substr((string) input('admin_notes', ''), 0, 5000) ?: null,
        ], (int) $id);
        flash('success', 'Query updated.');
        redirect('/admin/queries/' . $id);
    }

    public function destroy(string $id): void
    {
        Query::delete((int) $id);
        flash('success', 'Query deleted.');
        redirect('/admin/queries');
    }

    public function export(): void
    {
        $rows = Query::filtered((string) ($_GET['type'] ?? ''), (string) ($_GET['status'] ?? ''));
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="queries-' . date('Y-m-d') . '.csv"');
        $out = fopen('php://output', 'w');
        fwrite($out, "\xEF\xBB\xBF");
        fputcsv($out, ['ID', 'Date', 'Type', 'Status', 'Name', 'Company', 'Email', 'Phone', 'Subject', 'Service', 'Origin', 'Destination', 'Commodity', 'Weight kg', 'Volume CBM', 'Message']);
        foreach ($rows as $r) {
            // Prefix formula-leading characters so spreadsheets do not execute them (CSV injection).
            $safe = fn($v) => preg_match('/^[=+\-@\t\r]/', (string) $v) ? "'" . $v : $v;
            fputcsv($out, array_map($safe, [
                $r['id'], $r['created_at'], $r['type'], $r['status'], $r['name'], $r['company'], $r['email'], $r['phone'],
                $r['subject'], $r['service_type'], $r['origin'], $r['destination'], $r['commodity'], $r['weight_kg'], $r['volume_cbm'], $r['message'],
            ]));
        }
        fclose($out);
    }
}
