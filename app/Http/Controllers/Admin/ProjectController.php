<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    private $projectRepo;

    public function __construct()
    {
        $this->projectRepo = new ProjectRepository;
    }

    public function index(Request $request)
    {
        $filters = $request->get('filters', []);
        if (count($filters) == 0) {
            $filters = [
                'search' => "",
                'project_type_id' => "",
                'developer_id' => "",
                'city_id' => "",
                'district_id' => "",
                'area_id' => "",
            ];
        }

        return Inertia::render('Admin/Project/Index', [
            'projects' => ProjectResource::collection($this->projectRepo->paginate([
                'search' => $filters['search'],
                'project_type_id' => $filters['project_type_id'],
                'developer_id' => $filters['developer_id'],
                'city_id' => $filters['city_id'],
                'district_id' => $filters['district_id'],
                'area_id' => $filters['area_id'],
            ])),
            'selectProjectTypes' => (new \App\Models\ProjectType)->selectProjectTypes('en'),
            'selectDevelopers' => (new \App\Models\Developer)->selectDevelopers('en'),
            'selectCities' => (new \App\Repositories\CityRepository)->selectCities('en'),
            'selectDistricts' => (new \App\Models\District)->selectDistricts(0, 'en'),
            'selectAreas' => (new \App\Models\Area)->selectAreas(0, 'en'),
            'filters' => $filters
        ]);
    }
}
