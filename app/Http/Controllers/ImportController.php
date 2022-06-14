<?php

namespace App\Http\Controllers;

use App\Imports\ComponentsQuestionsImport;
use App\Imports\IndicatorsDocumentsImport;
use App\Imports\QuestionsAnswersImport;
use App\Imports\QuestionsIndicatorsImport;
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
}
