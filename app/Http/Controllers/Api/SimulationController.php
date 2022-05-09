<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Simulation;
use App\Models\ComponentsQuestions;
use Illuminate\Http\Request;
use App\Models\ScoretypeComponents;

class SimulationController extends Controller
{
    public function index()
    {
        // DB::enableQueryLog();
        // $simulations = Simulation::all()->sortByDesc('created_on');

        $scoretypeComponents = ScoretypeComponents::with(
            'componentQuestions.questionsAnswers',
            'componentQuestions.questionsIndicators.indicatorsDocuments',
            )->get();
        // $dataComponentQuestions = ComponentsQuestions::with('questionsIndicators.indicatorsDocuments')->get();
        // dd($scoretypeComponents->toArray());
        return json_encode($scoretypeComponents);
    }
}
