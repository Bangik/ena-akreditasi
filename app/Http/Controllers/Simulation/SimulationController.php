<?php

namespace App\Http\Controllers\Simulation;

use App\Http\Controllers\Controller;
use App\Models\ComponentsQuestions;
use App\Models\ScoretypeComponents;
use App\Models\Simulation;
use App\Models\SimulationDocDetail;
use App\Models\SimulationDocIndic;
use App\Models\SimulationDocument;
use App\Models\SimulationScore;
use App\Models\SimulationScoreDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SimulationController extends Controller
{
    public function index()
    {
        // DB::enableQueryLog();
        $simulations = Simulation::all()->sortByDesc('created_on');

        $scoretypeComponents = ScoretypeComponents::with(
            'componentQuestions.questionsAnswers',
            'componentQuestions.questionsIndicators.indicatorsDocuments',
            )->get();
        $dataComponentQuestions = ComponentsQuestions::with('questionsIndicators.indicatorsDocuments')->get();
        // dd($scoretypeComponents->toArray());
        return view('simulation.index', compact(
            'simulations',
            'scoretypeComponents',
            'dataComponentQuestions'
        ));
    }

    public function store(Request $request)
    {
        // tabel simulasi
        $simulation = Simulation::create([
            'id' => 'sim.'. Str::random(10),
            'total_score' => 1,
            'total_score_max' => 1,
            'score_doc' => 1,
            'score_doc_max' => 1,
            'created_on' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_by' => 1,
            'modified_on' => Carbon::now()->format('Y-m-d H:i:s'),
            'modified_by' => 1,
        ]);
        
        $total_score = 0;
        $total_score_max = 0;
        $score_doc = 0;
        $score_doc_max = 0;
        // insert tabel simulasi score / score
        foreach($request->scoretypeComponentId as $key => $value){
            $scores = SimulationScore::create([
                'id' => 'sim.2.'.$key . Str::random(10),
                'parent_id' => $simulation->id,
                'scoretype_component_id' => $value,
                'score' => 1,
                'score_max' => 1,
                'score_doc' => 1,
                'score_doc_max' => 1,
                'created_on' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by' => 1,
                'modified_on' => Carbon::now()->format('Y-m-d H:i:s'),
                'modified_by' => 1,
            ]);
            
            $score = 0;
            $score_max = 0;
            // insert tabel simulasi score detail / simulation_details
            foreach($request->nilai[$value] as $key2 => $value2){
                SimulationScoreDetail::create([
                    'id' => 'sim.2.'.$key.'.'.$key2 . Str::random(10),
                    'parent_id' => $scores->id,
                    'component_questions_id' => $request->componentQuestionId[$value][$key2],
                    'score' => $value2,
                    'created_on' => Carbon::now()->format('Y-m-d H:i:s'),
                    'created_by' => 1,
                    'modified_on' => Carbon::now()->format('Y-m-d H:i:s'),
                    'modified_by' => 1,
                ]);
                $score += $value2;
                $score_max = 4 * count($request->nilai[$value]);
            }

            SimulationScore::where('id', $scores->id)->update([
                'score' => $score,
                'score_max' => $score_max,
            ]);

            $total_score += $score;
            $total_score_max += $score_max;

            // insert ke tabel simulation_document
            $simDoc = SimulationDocument::create([
                'id' => 'sim.2.'.$key . Str::random(10),
                'parent_id' => $simulation->id,
                'scoretype_component_id' => $value,
                'score' => 1,
                'score_max' => 1,
                'created_on' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by' => 1,
                'modified_on' => Carbon::now()->format('Y-m-d H:i:s'),
                'modified_by' => 1,
            ]);

            $score_sim_doc = 0;
            $score_sim_doc_max = 0;

            foreach($request->questionIndicatorsId as $key => $value){

                $simDocIndic = SimulationDocIndic::create([
                    'id' => 'sim.2.'.$key . Str::random(10),
                    'parent_id' => $simDoc->id,
                    'questions_indicator_id' => $value,
                    'score' => 1,
                    'score_max' => 1,
                    'created_on' => Carbon::now()->format('Y-m-d H:i:s'),
                    'created_by' => 1,
                    'modified_on' => Carbon::now()->format('Y-m-d H:i:s'),
                    'modified_by' => 1,
                ]);

                if(isset($request->indicatorDocuments[$value])){
                    foreach($request->indicatorDocuments[$value] as $key2 => $value2){
                        SimulationDocDetail::create([
                            'id' => 'sim.2.'.$key.'.'.$key2 . Str::random(10),
                            'parent_id' => $simDocIndic->id,
                            'indicators_documents_id' => $request->indicatorDocuments[$value][$key2],
                            'is_checked' => $request->isChecked[$value][$key2],
                            'created_on' => Carbon::now()->format('Y-m-d H:i:s'),
                            'modified_on' => Carbon::now()->format('Y-m-d H:i:s'),
                        ]);
                        $score_sim_doc += $request->isChecked[$value][$key2];
                        $score_sim_doc_max = count($request->indicatorDocuments[$value]);
                    }
                }
            }

            SimulationDocument::where('id', $simDoc->id)->update([
                'score' => $score_sim_doc,
                'score_max' => $score_sim_doc_max,
            ]);

            $score_doc += $score_sim_doc;
            $score_doc_max += $score_sim_doc_max;
        }

        Simulation::where('id', $simulation->id)->update([
            'total_score' => $total_score,
            'total_score_max' => $total_score_max,
            'score_doc' => $score_doc,
            'score_doc_max' => $score_doc_max,
        ]);

        // return redirect()->route('simulation.index');

        return $request->all();
    }

    public function result($id)
    {
        $simulations = Simulation::with(
            'scores.scoretype_component',
            'scores.simulationDetails.component_questions.questionsAnswers',
            'scores.simulationDetails.component_questions.questionsIndicators',
            'scoreDoc.scoretypeComponent',
            'scoreDoc.scoretypeComponent.componentQuestions',
            'scoreDoc.simulationDocIndic.simulationDocDetail.simulationIndicatorsDocument',
            'scoreDoc.simulationDocIndic.questionIndicator.indicatorsDocuments',
        )
        ->find($id);
        // dd($simulations->toArray());
        return view('simulation.result', compact('simulations'));
    }

    public function destroy($id)
    {
        $data = Simulation::find($id);
        $data->delete();
        return redirect()->route('simulation.index');
    }
}
