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
                                        @foreach ($simulation->sortByDesc('created_on')->groupBy('created_on') as $date)
                                            @php
                                                $total = 0;
                                            @endphp
                                            @foreach ($date as $score)
                                                @php
                                                    $total += $score->score;
                                                @endphp
                                            @endforeach
                                            <th class="text-center">{{$total}} / {{(4 * count($date))}}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="text-center">Skor Komponen / Skor Maks Komponen X Bobot</th>
                                        {{-- @dd($simulation->sortByDesc('created_on')->groupBy('created_on')->toArray()) --}}
                                        @foreach ($simulation->sortByDesc('created_on')->groupBy('created_on') as $date)
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
                                        @endforeach
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
                        @foreach ($simulationDocs as $key => $simulationDocs)
                        <a class="nav-link {{$loop->iteration == 1 ? 'active' : ''}}" id="nav-doc-{{$loop->iteration}}-tab" data-toggle="tab" href="#nav-doc-{{$loop->iteration}}" role="tab" aria-controls="nav-doc-{{$loop->iteration}}" aria-selected="{{$loop->iteration == 1 ? 'true' : 'false'}}">{{$key}}</a>
                        @endforeach
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    {{-- @foreach ($simulationDocs as $simulationDoc)
                    <div class="tab-pane fade {{$loop->iteration == 1 ? 'show active' : ''}}" id="nav-doc-{{$loop->iteration}}" role="tabpanel" aria-labelledby="nav-doc-{{$loop->iteration}}-tab">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Dokumen</th>
                                        @foreach ($simulationDocs->sortByDesc('created_on')->groupBy('created_on') as $date => $value)
                                            <th>{{Carbon\Carbon::parse($date)->format('d M Y H:i')}}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($simulationDoc as $key => $value)
                                    {{$key}}
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endforeach --}}
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-recap" role="tabpanel" aria-labelledby="nav-recap-tab">
        <div class="table-responsive">
            <table class="table">
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
                        @php
                            $totalC = 0;
                            $ipr = 0;
                            
                        @endphp
                        @foreach ($simulationResult->scores as $scores)
                            <td>{{$scores->score}} / {{$scores->score_max}}</td>
                            @php
                                if($loop->iteration == $simulationResult->scores->count()){
                                    $ipr = $scores->score / $scores->score_max * $scores->scoretype_component->weight;
                                }else {
                                    $totalC += $scores->score / $scores->score_max * $scores->scoretype_component->weight;
                                }
                            @endphp
                        @endforeach
                        @php
                            $na = round((0.15 * $ipr) + (0.85 * $totalC), 2);
                        @endphp
                        <td>{{$na}}</td>
                        <td>
                            @if ($na >= 91)
                                {{'A'}}
                            @elseif ($na >= 81)
                                {{'B'}}
                            @elseif ($na >= 71)
                                {{'C'}}
                            @elseif ($na < 71)
                                {{'Tidak Terakreditasi'}}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection