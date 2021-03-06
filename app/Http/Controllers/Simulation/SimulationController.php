<?php

namespace App\Http\Controllers\Simulation;

use App\Http\Controllers\Controller;
use App\Models\IndicatorsDocuments;
use App\Models\Scoretype;
use App\Models\ScoretypeComponents;
use App\Models\Simulation;
use App\Models\SimulationScore;
use App\Models\SimulationScoreDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
// use Illuminate\Support\Facades\DB;

class SimulationController extends Controller
{
    public function index()
    {
        // DB::enableQueryLog();

        // data scortype components
        $scoretypeComponents = ScoretypeComponents::with(
            'componentQuestions.questionsAnswers',
            'componentQuestions.questionsIndicators.indicatorsDocuments',
        )->get();

        return view('simulation.index', compact(
            'scoretypeComponents',
        ));
    }

    public function store(Request $request)
    {
        // tabel simulasi
        $weight = Scoretype::get('weight');
        $timeNow = Carbon::now($request->timezone)->format('Y-m-d H:i:s');
        $timeUpdate = Carbon::now($request->timezone)->format('Y-m-d H:i:s');

        // jika edit
        if($request->idSimulation != null || isset($request->idSimulation)){
            $simulation = Simulation::find($request->idSimulation);
            $timeNow = $simulation->created_on;
            $simulation->delete();
        }

        $simulation = Simulation::create([
            'id' => 'sim.'. Str::random(10),
            'created_on' => $timeNow,
            'created_by' => 1,
            'modified_on' => $timeUpdate,
            'modified_by' => 1,
        ]);
        
        $total_score = 0;
        $total_score_max = 0;
        $score_doc = 0;
        $score_doc_max = 0;
        $ipr = 0;
        $total_score_comp = 0;
        $na = 0;
        $rating = '';

        // insert tabel simulasi_score dan tabel simulasi dokumens
        foreach($request->scoretypeComponentId as $key => $value){
            $scores = SimulationScore::create([
                'id' => 'sim.2.'.$key . Str::random(10),
                'parent_id' => $simulation->id,
                'scoretype_component_id' => $value,
                'created_on' => $timeNow,
                'created_by' => 1,
                'modified_on' => $timeUpdate,
                'modified_by' => 1,
            ]);
            
            $score = 0;
            $score_max = 0;
            $score_comp = 0;
            // insert tabel simulasi score detail / simulation_details
            foreach($request->nilai[$value] as $key2 => $value2){
                if($value2 > 4){
                    $simulation->delete();
                    return response()->json([
                        'code' => '400',
                        'status' => 'error',
                        'message' => 'Nilai tidak boleh lebih dari 4',
                    ]);
                }
                SimulationScoreDetail::create([
                    'id' => 'sim.2.'.$key.'.'.$key2 . Str::random(10),
                    'parent_id' => $scores->id,
                    'component_questions_id' => $request->componentQuestionId[$value][$key2],
                    'score' => $value2,
                    'created_on' => $timeNow,
                    'created_by' => 1,
                    'modified_on' => $timeUpdate,
                    'modified_by' => 1,
                ]);
                $score += $value2;
                $score_max = 4 * count($request->nilai[$value]);
            }

            $score_comp = $score / $score_max * $request->weightComp[$key];
            $ipr = $score_comp;
            if($key != count($request->weightComp) - 1){
                $total_score_comp += $score_comp;
            }
            
            ////////////////////////////////////////////////////////////////

            // update dokumen ke tabel simulation_document
            $score_sim_doc = 0;
            $score_sim_doc_max = 0;

            if(isset($request->questionIndicatorsId[$value])){
                foreach($request->questionIndicatorsId[$value] as $key => $value2){
                    $score_sim_doc_indic = 0;
                    $score_sim_doc_indic_max = 0;
    
                    if(isset($request->indicatorDocuments[$value2])){
                        foreach($request->indicatorDocuments[$value2] as $key3 => $value3){
                            IndicatorsDocuments::where('id', $request->indicatorDocuments[$value2][$key3])->update([
                                'is_checked' => $request->isChecked[$value2][$key3],
                                'modified_on' => $timeUpdate,
                            ]);
                            $score_sim_doc_indic += $request->isChecked[$value2][$key3];
                            $score_sim_doc_indic_max = count($request->indicatorDocuments[$value2]);
                        }
                    }

                    $score_sim_doc += $score_sim_doc_indic;
                    $score_sim_doc_max += $score_sim_doc_indic_max;
                }
            }
            
            SimulationScore::where('id', $scores->id)->update([
                'score' => $score,
                'score_max' => $score_max,
                'score_doc' => $score_sim_doc,
                'score_doc_max' => $score_sim_doc_max,
                'score_comp' => $score_comp,
            ]);

            $total_score += $score;
            $total_score_max += $score_max;

            $score_doc += $score_sim_doc;
            $score_doc_max += $score_sim_doc_max;
        }

        $na = ($weight[0]->weight * $ipr) + ($weight[1]->weight * $total_score_comp);
        $rating = $na >= 91 ? 'A' : ($na >= 81 ? 'B' : ($na >= 71 ? 'C' : 'Tidak Terakreditasi'));

        Simulation::where('id', $simulation->id)->update([
            'total_score' => $total_score,
            'total_score_max' => $total_score_max,
            'score_doc' => $score_doc,
            'score_doc_max' => $score_doc_max,
            'ipr' => $ipr,
            'total_score_comp' => $total_score_comp,
            'na' => $na,
            'rating' => $rating,
        ]);

        // return redirect()->route('simulation.index');
        return response()->json([
            'status' => 'success',
            'code' => '200',
            'message' => 'Simulasi berhasil disimpan',
        ]);

        // return $request->all();
    }

    // fungsi view result simulasi
    public function result($id)
    {
        $simulations = Simulation::with(
            'scores.scoretype_component',
            'scores.simulationDetails.component_questions.questionsAnswers',
            'scores.simulationDetails.component_questions.questionsIndicators',
            'scores.scoretype_component.componentQuestions.questionsIndicators',
        )
        ->find($id);

        $scoretypeComponents = ScoretypeComponents::with(
            'componentQuestions.questionsAnswers',
            'componentQuestions.questionsIndicators.indicatorsDocuments',
        )->get();

        return view('simulation.result', compact(
            'simulations',
            'scoretypeComponents',
        ));
    }

    public function edit($id)
    {
        $simulations = Simulation::with(
            'scores.scoretype_component',
            'scores.simulationDetails.component_questions.questionsAnswers',
            'scores.simulationDetails.component_questions.questionsIndicators',
            'scores.scoretype_component.componentQuestions.questionsIndicators',
        )
        ->find($id);

        $scoretypeComponents = ScoretypeComponents::with(
            'componentQuestions.questionsAnswers',
            'componentQuestions.questionsIndicators.indicatorsDocuments',
        )->get();

        return view('simulation.edit', compact(
            'simulations',
            'scoretypeComponents',
    ));
    }

    // fungsi tampilan view result based on question
    public function resultBasedOnQuestion(){
        $simulationScores = SimulationScoreDetail::with(
            'component_questions.questionsAnswers',
            'component_questions.scoretypeComponents',
        )
        ->get()
        ->groupBy('component_questions.scoretypeComponents.name');

        $simulationsResults = Simulation::with(
            'scores.scoretype_component',
            'scores.simulationDetails.component_questions.questionsAnswers',
            'scores.simulationDetails.component_questions.questionsIndicators',
        )
        ->get()
        ->sortByDesc('created_on');

        $scoretypeComponents = ScoretypeComponents::with(
            'componentQuestions.questionsAnswers',
            'componentQuestions.questionsIndicators.indicatorsDocuments',
        )->get();

        return view('simulation.resultBasedQuest', compact(
            'simulationScores',
            'simulationsResults',
            'scoretypeComponents'
        ));
    }

    // fungsi hapus simulation
    public function destroy($id)
    {
        // cari id simulation
        $data = Simulation::find($id);
        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
