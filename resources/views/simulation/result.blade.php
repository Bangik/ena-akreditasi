@extends('layouts.simulation.app')
@section('sim-main')

    <center>
    <h1>Hasil Simulasi Akreditasi</h1>
    <h5>Tanggal {{Carbon\Carbon::parse($simulations->created_on)->format('d-M-Y H:i')}}</h5>
    <h6>Total Nilai : {{$simulations->total_score}} / {{$simulations->total_score_max}}</h6>
    <h6>Kelengkapan Dokumen : {{$simulations->score_doc}} / {{$simulations->score_doc_max}}</h6>
    </center>

    <!-- Button Simulasi Nilai dan Kelengkapan Dokumen -->
    <div data-role="tabs" id="tabs">
        <div data-role="navbar">
            <ul>
                <li><a href="#one">Simulasi Nilai</a></li>
                <li><a href="#two">Simulasi Kelengkapan Dokumen</a></li>
            </ul>
        </div>

        <div id="one" class="ui-body-d ui-content">
            <div data-role="tabs" id="tabs1">
                <div data-role="navbar">
                    <ul>
                    @foreach ($simulations->scores as $simulationScore)
                        <!-- TAB KOMPONEN -->
                        <li>
                            <a href="#satu-{{$loop->iteration}}">{{$simulationScore->scoretype_component->name}}</a>
                        </li>
                    @endforeach
                    </ul>
                </div>

                @foreach ($simulations->scores as $simulationScore)
                <div id="satu-{{$loop->iteration}}">
                    <div class="ui-corner-all custom-corners">
                        <div class="ui-bar ui-bar-a">
                            <!-- PERTANYAAN -->
                        @foreach ($simulationScore->simulationDetails as $simulation_detail)
                            <p>{{$loop->iteration}}. {{$simulation_detail->component_questions->name}}</p>
                            
                            <div class="ui-body ui-body-a">
                                <div class="ui-grid-a">
                                    <div class="ui-block-a">
                                        <div class="ui-bar ui-bar-a">Jawaban</div>
                                    </div>
                                    <div class="ui-block-b">
                                        <div class="ui-bar ui-bar-a" style="text-align: right">Nilai (1-4) &nbsp
                                            <input type="number" data-clear-btn="false" data-role="none" value="{{$simulation_detail->score}}" disabled min="1" max="4" style="height: 15px; width:50px; float:right">
                                        </div>
                                    </div>
                                </div>
                                @foreach ($simulation_detail->component_questions->questionsAnswers as $questionsAnswer)
                                <!-- JAWABAN -->
                                    <p style="font-weight: normal!important">{{$questionsAnswer->level}}. {{$questionsAnswer->name}}</p>
                                @endforeach
                                        
                                <div class="ui-bar ui-bar-a">Indikator</div>
                                @foreach ($simulation_detail->component_questions->questionsIndicators as $questionsIndicator)
                                <!-- INDIKATOR -->
                                    <p style="font-weight:normal!important;">{{$loop->iteration}}. {{$questionsIndicator->name}}</p>
                                @endforeach
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div id="two" class="ui-body-d ui-content">
            <div data-role="tabs" id="tabs2">
                <div data-role="navbar">
                    <ul>
                    @foreach ($simulations->scoreDoc as $scoreDoc)
                        <!-- TAB KOMPONEN -->
                        <li>
                            <a href="#siji-{{$loop->iteration}}">{{$scoreDoc->scoretypeComponent->name}}</a>
                        </li>
                    @endforeach
                    </ul>
                </div>

                @foreach ($simulations->scoreDoc as $scoreDoc)
                <div id="siji-{{$loop->iteration}}">
                    <div class="ui-corner-all custom-corners">
                        @foreach ($scoreDoc->scoretypeComponent->componentQuestions as $componentQuestions)           
                        <div class="ui-bar ui-bar-a">
                        <!-- PERTANYAAN -->
                            {{$loop->iteration}}. {{$componentQuestions->name}}
                            <div class="ui-body ui-body-a">
                                <div class="ui-bar ui-bar-a">Indikator</div>
                                @foreach ($scoreDoc->simulationDocIndic as $simulationDocIndic)
                                    @if($componentQuestions->id == $simulationDocIndic->questionIndicator->parent_id)
                                        <p>{{$simulationDocIndic->questionIndicator->seq}}. {{$simulationDocIndic->questionIndicator->name}}</p>
                                        <div class="ui-body ui-body-a">
                                            <div class="ui-bar ui-bar-a">Dokumen</div>
                                            @foreach ($simulationDocIndic->simulationDocDetail as $indicatorsDocuments)
                                                <label>
                                                {{$indicatorsDocuments->simulationIndicatorsDocument->name}}
                                                <input type="checkbox" {{$indicatorsDocuments->is_checked == 1 ? 'checked' : 'disabled'}}>
                                                </label>
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection