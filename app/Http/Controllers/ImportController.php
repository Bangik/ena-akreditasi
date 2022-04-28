<?php

namespace App\Http\Controllers;

use App\Imports\ComponentsQuestionsImport;
use App\Imports\IndicatorsDocumentsImport;
use App\Imports\QuestionsAnswersImport;
use App\Imports\QuestionsIndicatorsImport;
use App\Models\Scoretype;
use App\Models\Simulation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function index ()
    {
        return view('import');
    }

    public function importComQues()
    {
        $import = Excel::import(new ComponentsQuestionsImport, request()->file('file'));
        if ($import) {
            return redirect()->back()->with('success', 'Import Components Question Successful.');
        } else {
            return redirect()->back()->with('error', 'Import Failed.');
        }
    }
    
    public function importQuesAns()
    {
        $import = Excel::import(new QuestionsAnswersImport, request()->file('file-ques-ans'));
        if ($import) {
            return redirect()->route('import.index')->with('success', 'Import Questions Answers Successful.');
        } else {
            return redirect()->route('import.index')->with('error', 'Import Failed.');
        }
    }

    public function importQuesInd()
    {
        $import = Excel::import(new QuestionsIndicatorsImport, request()->file('file-ques-ind'));
        if ($import) {
            return redirect()->route('import.index')->with('success', 'Import Questions Indicators Successful.');
        } else {
            return redirect()->route('import.index')->with('error', 'Import Failed.');
        }
    }

    public function importIndDoc()
    {
        $import = Excel::import(new IndicatorsDocumentsImport, request()->file('file-ind-doc'));
        if ($import) {
            return redirect()->route('import.index')->with('success', 'Import Indicators Documents Successful.');
        } else {
            return redirect()->route('import.index')->with('error', 'Import Failed.');
        }
    }

    public function testing()
    {
        $data = Scoretype::with(
            'scoretypeComponent',
            'scoretypeComponent.componentQuestions',
            'scoretypeComponent.componentQuestions.questionsAnswers',
            'scoretypeComponent.componentQuestions.questionsIndicators',
            'scoretypeComponent.componentQuestions.questionsIndicators.indicatorsDocuments'
            )->get();
        // $data = Scoretype::with('scoretypeComponent.componentQuestions')->get();
        dd($data->toArray());
        return view('testing', compact('data'));
    }

    public function testingApi()
    {
        $data = Scoretype::with(
            'scoretypeComponent',
            'scoretypeComponent.componentQuestions',
            'scoretypeComponent.componentQuestions.questionsAnswers',
            'scoretypeComponent.componentQuestions.questionsIndicators',
            'scoretypeComponent.componentQuestions.questionsIndicators.indicatorsDocuments'
            )->get();
        // $data = Scoretype::with('scoretypeComponent.componentQuestions')->get();
        // dd($data->toArray());
        return response()->json($data);
    }

    public function testingSimulation()
    {
        // DB::enableQueryLog();
        $data = Simulation::with(
            'scores',
            'scores.scoretype_component',
            'scores.simulationDetails.component_questions',
            'scoreDoc.simulationDocDetail.simulationIndicatorsDocument',
        )->get();

        dd($data->toArray());
        return view('testing', compact('data'));
    }
}
