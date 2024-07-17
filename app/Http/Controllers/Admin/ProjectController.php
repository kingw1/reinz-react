<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Repositories\ProjectRepository;
use Inertia\Inertia;

class ProjectController extends Controller
{
    private $projectRepo;

    public function __construct()
    {
        $this->projectRepo = new ProjectRepository;
    }

    public function index()
    {
        return Inertia::render('Admin/Project/Index', [
            'projects' => ProjectResource::collection($this->projectRepo->paginate([
                // 'search' => $this->search,
                // 'project_type_id' => $this->project_type_id,
                // 'developer_id' => $this->developer_id,
                // 'city_id' => $this->city_id,
                // 'district_id' => $this->district_id,
                // 'area_id' => $this->area_id,
            ]))
        ]);
    }
}
