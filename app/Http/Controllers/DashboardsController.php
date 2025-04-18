<?php
namespace App\Http\Controllers;

use App\Services\DashboardService;

class DashboardsController extends Controller
{
    private $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function get()
    {
        $dashboard = $this->dashboardService->getDatas();
        return response()->json($dashboard, 200);
    }
}
