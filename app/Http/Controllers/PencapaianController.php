<?php

namespace App\Http\Controllers;

use App\Services\AchievementService;

class PencapaianController extends Controller
{
    public function index(AchievementService $service)
    {
        $data = $service->for(auth()->user());

        return view('pencapaian.index', $data);
    }
}
