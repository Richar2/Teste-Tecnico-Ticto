<?php
namespace App\Services\Report;

use Illuminate\Support\Facades\DB;

class TimeRecordReportService
{
    /**
     *
     * @param array $filters
     * @param int $perPage
     * @param int $offset
     * @return array
     */
    public function getReport(array $filters, int $perPage = 10, int $offset = 0): array
    {
        $limit  = (int) $perPage;
        $offset = (int) $offset;

        $conditions = [
            "tr.recorded_at BETWEEN :start_date AND :end_date",
        ];
        $params = [
            'start_date' => $filters['start_date'],
            'end_date'   => $filters['end_date'],
        ];

        if (! empty($filters['cpf'])) {
            $conditions[]  = "e.cpf = :cpf";
            $params['cpf'] = $filters['cpf'];
        }

        if (! empty($filters['type'])) {
            $conditions[]   = "tr.type = :type";
            $params['type'] = $filters['type'];
        }

        $where = implode(' AND ', $conditions);

        $sql = "
        SELECT
            tr.id AS record_id,
            e.name AS employee_name,
            e.cpf AS employee_cpf,
            e.position AS employee_position,
            TIMESTAMPDIFF(YEAR, e.birth_date, CURDATE()) AS employee_age,
            a.name AS admin_name,
            DATE_FORMAT(tr.recorded_at, '%Y-%m-%d %H:%i:%s') AS recorded_at,
            tr.type AS record_type
        FROM
            time_records tr
        INNER JOIN
            employees e ON tr.employee_id = e.id
        LEFT JOIN
            administrators a ON e.administrator_id = a.id
        WHERE
            {$where}
        ORDER BY
            tr.recorded_at ASC
        LIMIT {$limit} OFFSET {$offset}
    ";

        $records = DB::select($sql, $params);

        return $records;
    }

    /**
     *
     * @param array $filters
     * @return int
     */
    public function getTotal(array $filters): int
    {
        $totalQuery = DB::table('time_records as tr')
            ->join('employees as e', 'tr.employee_id', '=', 'e.id')
            ->whereBetween('tr.recorded_at', [
                $filters['start_date'],
                $filters['end_date'],
            ]);

        if (! empty($filters['cpf'])) {
            $totalQuery->where('e.cpf', $filters['cpf']);
        }

        if (! empty($filters['type'])) {
            $totalQuery->where('tr.type', $filters['type']);
        }

        return $totalQuery->count();
    }
}
