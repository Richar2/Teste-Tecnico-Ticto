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
        $records = DB::select("
            SELECT 
                tr.id AS record_id,
                e.name AS employee_name,
                e.cpf AS employee_cpf,
                e.cargo AS employee_cargo,
                TIMESTAMPDIFF(YEAR, e.data_nascimento, CURDATE()) AS employee_age,
                a.name AS admin_name,
                DATE_FORMAT(tr.recorded_at, '%Y-%m-%d %H:%i:%s') AS recorded_at,
                tr.type AS record_type
            FROM 
                time_records tr
            INNER JOIN 
                employees e ON tr.employee_id = e.id
            INNER JOIN 
                admins a ON e.admin_id = a.id
            WHERE 
                tr.recorded_at BETWEEN :start_date AND :end_date
                AND (:cpf IS NULL OR e.cpf = :cpf)
                AND (:type IS NULL OR tr.type = :type)
            ORDER BY 
                tr.recorded_at ASC
            LIMIT :limit OFFSET :offset
        ", [
            'start_date' => $filters['start_date'],
            'end_date' => $filters['end_date'],
            'cpf' => $filters['cpf'] ?? null,
            'type' => $filters['type'] ?? null,
            'limit' => $perPage,
            'offset' => $offset
        ]);

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
                $filters['end_date']
            ]);

        if (!empty($filters['cpf'])) {
            $totalQuery->where('e.cpf', $filters['cpf']);
        }

        if (!empty($filters['type'])) {
            $totalQuery->where('tr.type', $filters['type']);
        }

        return $totalQuery->count();
    }
}