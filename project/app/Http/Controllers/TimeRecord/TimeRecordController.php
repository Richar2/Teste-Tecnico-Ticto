<?php
namespace App\Http\Controllers\TimeRecord;

use App\Http\Controllers\Controller;
use App\Services\TimeRecord\TimeRecordService;
use App\Services\Report\TimeRecordReportService;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeRecordController extends Controller
{
    protected $timeRecordService;
    protected $reportService;

    public function __construct(TimeRecordService $timeRecordService,TimeRecordReportService $reportService)
    {
        $this->timeRecordService = $timeRecordService;
        $this->reportService = $reportService;
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'type'        => 'required|in:entrada,saida',
            'description' => 'nullable|string|max:255',
        ]);
        try {
            $employee = Auth::user();

            $timeRecord = $this->timeRecordService->record(
                $employee,
                $request->input('type'),
                $request->input('description')
            );

            return $this->success('Ponto registrado com sucesso.', $timeRecord, 201);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function report(Request $request): JsonResponse
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'cpf' => 'nullable|string|size:11',
            'type' => 'nullable|in:entrada,saida',
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:100'
        ]);

        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 10);
        $offset = ($page - 1) * $perPage;

        $filters = [
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'cpf' => $request->input('cpf'),
            'type' => $request->input('type')
        ];

        try {
            $total = $this->reportService->getTotal($filters);

            $records = $this->reportService->getReport($filters, $perPage, $offset);

            $response = [
                'data' => $records,
                'meta' => [
                    'current_page' => $page,
                    'per_page' => $perPage,
                    'total' => $total,
                    'last_page' => ceil($total / $perPage)
                ]
            ];


            return $this->success('Relatório gerado com sucesso.', $response,200);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

}
