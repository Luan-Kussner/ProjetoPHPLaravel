<?php 

namespace App\Services;

use App\Repositorys\DashboardRepository;

class DashboardService
{
    private $dashboardRepository;

    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function getDatas()
    {
        return $this->dashboardRepository->getDatas();
    }
}