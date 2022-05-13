@extends('layouts.simulation.app')
@section('sim-main')
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-link active" id="nav-simulasi-nilai-tab" data-toggle="tab" href="#nav-simulasi-nilai" role="tab" aria-controls="nav-simulasi-nilai" aria-selected="true">Hasil Simulasi Nilai Akreditasi</a>
        <a class="nav-link" id="nav-simulasi-doc-tab" data-toggle="tab" href="#nav-simulasi-doc" role="tab" aria-controls="nav-simulasi-doc" aria-selected="false">Hasil Simulasi Dokumen Akreditasi</a>
        <a class="nav-link" id="nav-recap-tab" data-toggle="tab" href="#nav-recap" role="tab" aria-controls="nav-recap" aria-selected="false">Rekapitulasi</a>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-simulasi-nilai" role="tabpanel" aria-labelledby="nav-simulasi-nilai-tab">
        <div class="card mt-4 border-0">
            <div class="card-body">
                {{-- @dd($simulations->toArray()) --}}
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        @foreach ($simulations as $key => $simulation)
                        <a class="nav-link {{$loop->iteration == 1 ? 'active' : ''}}" id="nav-{{$loop->iteration}}-tab" data-toggle="tab" href="#nav-{{$loop->iteration}}" role="tab" aria-controls="nav-{{$loop->iteration}}" aria-selected="{{$loop->iteration == 1 ? 'true' : 'false'}}">{{$key}}</a>
                        @endforeach
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    @foreach ($simulations as $key => $simulation)
                    <div class="tab-pane fade {{$loop->iteration == 1 ? 'show active' : ''}}" id="nav-{{$loop->iteration}}" role="tabpanel" aria-labelledby="nav-{{$loop->iteration}}-tab">
                        @foreach ($simulation->groupBy('component_questions.scoretypeComponents.weight') as $weight => $weightSimulation)
                            <p>Bobot : {{$weight}}</p>
                        @endforeach
                        {{-- <P>Nilai Maksimal : {{$simulation->groupBy('created_on')}}</P> --}}
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pertanyaan</th>
                                        @foreach ($simulation->sortByDesc('created_on')->groupBy('created_on') as $date => $value)
                                            <th>{{Carbon\Carbon::parse($date)->format('d M Y H:i')}}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th colspan="2" class="text-center">Jumlah skor perolehan visitasi komponen {{$key}}</th>
                                        {{-- @dd($simulationsResults) --}}
                                        @foreach ($simulationsResults as $simulationsResult)
                                            @foreach ($simulationsResult->scores as $scores)
                                            @if ($scores->scoretype_component->name == $key)
                                            <th class="text-center">{{$scores->score}} / {{$scores->score_max}}</th>
                                            @endif
                                            @endforeach
                                        @endforeach
                                        {{-- @foreach ($simulation->sortByDesc('created_on')->groupBy('created_on') as $date)
                                            @php
                                                $total = 0;
                                            @endphp
                                            @foreach ($date as $score)
                                                @php
                                                    $total += $score->score;
                                                @endphp
                                            @endforeach
                                            <th class="text-center">{{$total}} / {{(4 * count($date))}}</th>
                                        @endforeach --}}
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="text-center">Skor Komponen / Skor Maks Komponen X Bobot</th>
                                        @foreach ($simulationsResults as $simulationsResult)
                                            @foreach ($simulationsResult->scores as $scores)
                                            @if ($scores->scoretype_component->name == $key)
                                            <th class="text-center">{{$scores->score_comp}}</th>
                                            @endif
                                            @endforeach
                                        @endforeach
                                        {{-- @foreach ($simulation->sortByDesc('created_on')->groupBy('created_on') as $date)
                                            @php
                                                $total = 0;
                                                $weight = 0;
                                            @endphp
                                            @foreach ($date as $score)
                                                @php
                                                    $total += $score->score;
                                                    $weight = $score->component_questions->scoretypeComponents->weight;
                                                @endphp
                                            @endforeach
                                            <th class="text-center">{{round($total / (4 * count($date)) * $weight, 2)}}</td>
                                        @endforeach --}}
                                    </tr>
                                    @foreach ($simulation->sortBy('component_questions.seq')->groupBy('component_questions.name') as $keyName => $component_questions)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$keyName}}</td>
                                        @foreach ($component_questions->sortByDesc('created_on') as $score)
                                            <td class="text-center">{{$score->score == null ? 0 : $score->score}}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>               
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-simulasi-doc" role="tabpanel" aria-labelledby="nav-simulasi-doc-tab">
        <div class="card mt-4 border-0">
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        @foreach ($simulationDocDetails as $key => $simulationDocDetail)
                        <a class="nav-link {{$loop->iteration == 1 ? 'active' : ''}}" id="nav-doc-{{$loop->iteration}}-tab" data-toggle="tab" href="#nav-doc-{{$loop->iteration}}" role="tab" aria-controls="nav-doc-{{$loop->iteration}}" aria-selected="{{$loop->iteration == 1 ? 'true' : 'false'}}">{{$key}}</a>
                        @endforeach
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    @foreach ($simulationDocDetails as $key => $simulationDocDetail)
                    {{-- @dd($simulationDocDetail->sortByDesc('created_on')->groupBy('created_on')->toArray()) --}}
                    <div class="tab-pane fade {{$loop->iteration == 1 ? 'show active' : ''}}" id="nav-doc-{{$loop->iteration}}" role="tabpanel" aria-labelledby="nav-doc-{{$loop->iteration}}-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Indikator dan Dokumen</th>
                                        @foreach ($simulationDocDetail->sortByDesc('created_on')->groupBy('created_on') as $date => $value)
                                        <th>{{Carbon\Carbon::parse($date)->format('d M Y H:i')}}</th>
                                        @endforeach
                                    </tr>
                                    <tr class="text-center" >
                                        <th colspan="2">Jumlah Skor Dokumen</th>
                                        {{-- @dd($simulationsResults->toArray()) --}}
                                        @foreach ($simulationsResults as $simulationsResultDoc)
                                        @foreach ($simulationsResultDoc->scoreDoc as $scores)
                                        {{-- @dd($scores->toArray()) --}}
                                            @if ($scores->scoretypeComponent->name == $key)
                                            <th class="text-center">{{$scores->score}} / {{$scores->score_max}}</th>
                                            @endif
                                            @endforeach
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @dd($simulationDocDetail->groupBy('simulationIndicatorsDocument.indicatorsQuestions.name')->toArray()) --}}
                                    @foreach ($simulationDocDetail->sortBy('simulationIndicatorsDocument.id')->groupBy('simulationIndicatorsDocument.indicatorsQuestions.name') as $key2 => $value)
                                    {{-- @dd($value->groupBy('simulationIndicatorsDocument.name')->toArray()) --}}
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            {{$key2}}
                                            <br>
                                            <p class="font-weight-bold mt-3 mb-0">Dokumen</p>
                                            @foreach ($value->groupBy('simulationIndicatorsDocument.id') as $document)
                                            <div class="border-bottom">
                                                {{-- @dd($document[0]->toArray()) --}}
                                                <p>{{$document[0]->simulationIndicatorsDocument->name}}</p>
                                            </div>
                                            @endforeach
                                        </td>
                                        @foreach ($value->sortByDesc('created_on')->groupBy('created_on') as $isCheckeds)
                                        <td style="vertical-align:bottom;" class="text-center">
                                        {{-- @dd($isCheckeds->toArray()) --}}
                                            @foreach ($isCheckeds as $isChecked)
                                                @if ($isChecked->is_checked == 1)
                                                <div class="border-bottom" style="bottom:0;">
                                                    <p><i class="fas fa-check"></i></p>
                                                </div>
                                                @else
                                                <div class="border-bottom" style="bottom:0;">
                                                <p><i class="fas fa-times"></i></p>
                                                </div>
                                                @endif
                                            @endforeach
                                        </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-recap" role="tabpanel" aria-labelledby="nav-recap-tab">
        <div class="table-responsive">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        @foreach ($simulations as $key => $simulation)
                        <th>{{$key}}</th>
                        @endforeach
                        <th>NA</th>
                        <th>Peringkat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($simulationsResults as $simulationResult)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{Carbon\Carbon::parse($simulationResult->created_on)->format('d M Y H:i')}}</td>
                        {{-- @dd($simulationResult->toArray()) --}}
                        @foreach ($simulationResult->scores as $key => $scores)
                        {{-- @dd($simulationResult->scoreDoc[$key]->toArray()) --}}
                        <td>
                            <p class="font-weight-bold">Nilai : </p>
                            {{$scores->score}} / {{$scores->score_max}}
                            <br>
                            <p class="font-weight-bold">Skor : </p>
                            {{$simulationResult->scoreDoc[$key]->score}} / {{$simulationResult->scoreDoc[$key]->score_max}}
                        </td>
                        @endforeach
                        <td>{{$simulationResult->na}}</td>
                        <td>{{$simulationResult->rating}}</td>
                    </tr>
                    {{-- <tr>
                        @foreach ($simulationResult->scoreDoc as $scoreDoc)
                        <td>
                            <p class="font-weight-bold">Skor : </p>
                            {{$scoreDoc->score}} / {{$scoreDoc->score_max}}
                        </td>
                        @endforeach
                    </tr> --}}
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection