@extends('layouts.simulation.app')
@section('sim-css')
<style>
    .menu {
    color:#000000;
    position:relative;
    left:0px;
    width:100%;
    }
    .fixed {
        position:fixed;
        top:0;
        z-index:3;
    }

    .menu2 {
    color:#000000;
    position:relative;
    left:0px;
    width:100%;
    }

    .fixed2 {
        position:fixed;
        top:35px;
        z-index:3;
    }
    
    .clicked-up {
    background-color: #388ccc!important;
    color: #fff !important;
    text-shadow: none !important;
    }

    .clicked-left {
    background-color: #f4f4f4!important;
    border-color: #f4f4f4 !important;
    color: black !important;
    text-shadow: none !important;
    }
</style>
@endsection
@section('sim-main')

<center>
    <h1>Simulasi Akreditasi</h1>
    <button id="btn-kembali" style="display: none"><span>Kembali</span></button>
</center>

<div data-role="collapsible" data-collapsed="false" id="riwayat-simulasi">
    <h4>Riwayat dan Rekapitulasi Hasil Simulasi</h4>
    <div data-role="tabs" id="tabs">
        <div data-role="navbar">
            <ul>
                <li><a href="#simulation-score-result" id="btn-simulation-score-result" data-ajax="false" class="ui-btn-active">Hasil Simulasi Nilai</a></li>
                <li><a href="#simulation-doc-result" id="btn-simulation-doc-result" data-ajax="false">Hasil Simulasi Dokumen</a></li>
                <li><a href="#simulation-recap" id="btn-simulation-recap" data-ajax="false">Rekapitulasi</a></li>
            </ul>
        </div>
        <div id="simulation-score-result" class="ui-body-d ui-content">
            <div data-role="tabs" id="tabs-simulation-score-result">
                <div data-role="navbar">
                    <ul>
                        @foreach ($simulationScores as $key => $simulationScore)
                        
                            <li><a href="#simulation-score-result-{{ $loop->iteration }}" id="btn-simulation-score-result-{{ $loop->iteration }}" data-ajax="false" class="{{$loop->iteration == 1 ? 'ui-btn-active' : ''}}">{{ $key }}</a></li>
                        @endforeach
                    </ul>
                </div>
                @foreach ($simulationScores as $key => $simulationScore)
                <div id="simulation-score-result-{{$loop->iteration}}" class="ui-body-d ui-content">
                    <table data-role="table" id="temp-table" data-mode="reflow" class="ui-responsive table-stroke">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pertanyaan</th>
                                @foreach ($simulationScore->sortByDesc('created_on')->groupBy('created_on') as $date => $value)
                                <th>{{Carbon\Carbon::parse($date)->format('d M Y H:i')}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th colspan="2">Jumlah skor perolehan visitasi komponen {{$key}}</th>
                                @foreach ($simulationsResults as $simulationsResult)
                                    @foreach ($simulationsResult->scores as $scores)
                                    @if ($scores->scoretype_component->name == $key)
                                    <th >{{$scores->score}} / {{$scores->score_max}}</th>
                                    @endif
                                    @endforeach
                                @endforeach
                            </tr>
                            <tr>
                                <th colspan="2">Skor Komponen / Skor Maks Komponen X Bobot</th>
                                @foreach ($simulationsResults as $simulationsResult)
                                    @foreach ($simulationsResult->scores as $scores)
                                    @if ($scores->scoretype_component->name == $key)
                                    <th>{{$scores->score_comp}}</th>
                                    @endif
                                    @endforeach
                                @endforeach
                            </tr>
                            @foreach ($simulationScore->sortBy('component_questions.seq')->groupBy('component_questions.name') as $keyName => $component_questions)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$keyName}}</td>
                                @foreach ($component_questions->sortByDesc('created_on') as $score)
                                    <td>{{$score->score == null ? 0 : $score->score}}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endforeach
            </div>
        </div>
        <div id="simulation-doc-result" class="ui-body-d ui-content">
            <div data-role="tabs" id="tabs-simulation-doc-result">
                <div data-role="navbar">
                    <ul>
                        @foreach ($simulationDocDetails as $key => $simulationDocDetail)
                        <li><a href="#simulation-doc-result-{{$loop->iteration}}" id="btn-simulation-doc-result-{{$loop->iteration}}" data-ajax="false" class="{{$loop->iteration == 1 ? 'ui-btn-active' : ''}}">{{$key}}</a></li>
                        @endforeach
                    </ul>
                </div>
                @foreach ($simulationDocDetails as $key => $simulationDocDetail)
                <div id="simulation-doc-result-{{$loop->iteration}}" class="ui-body-d ui-content">
                    <table data-role="table" id="table-simulation-doc-result" data-mode="reflow" class="ui-responsive table-stroke">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Indikator dan Dokumen</th>
                                @foreach ($simulationDocDetail->sortByDesc('created_on')->groupBy('created_on') as $date => $value)
                                <th>{{Carbon\Carbon::parse($date)->format('d M Y H:i')}}</th>
                                @endforeach
                            </tr>
                            <tr>
                                <th colspan="2">Jumlah Skor Dokumen</th>
                                @foreach ($simulationsResults as $simulationsResultDoc)
                                @foreach ($simulationsResultDoc->scoreDoc as $scores)
                                    @if ($scores->scoretypeComponent->name == $key)
                                    <th>{{$scores->score}} / {{$scores->score_max}}</th>
                                    @endif
                                    @endforeach
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tbody>
                                @foreach ($simulationDocDetail->sortBy('simulationIndicatorsDocument.id')->groupBy('simulationIndicatorsDocument.indicatorsQuestions.name') as $key2 => $value)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        {{$key2}}
                                        <br>
                                        <p style="font-weight: 300; margin-top: 3px; margin-bottom: 3px;">Dokumen</p>
                                        @foreach ($value->groupBy('simulationIndicatorsDocument.id') as $document)
                                        <div style="border-bottom: 3px;">
                                            <p>{{$document[0]->simulationIndicatorsDocument->name}}</p>
                                        </div>
                                        @endforeach
                                    </td>
                                    @foreach ($value->sortByDesc('created_on')->groupBy('created_on') as $isCheckeds)
                                    <td style="vertical-align:bottom;">
                                        @foreach ($isCheckeds as $isChecked)
                                            @if ($isChecked->is_checked == 1)
                                            <div style="bottom:0; border-bottom: 3px;">
                                                <p><i class="fas fa-check"></i></p>
                                            </div>
                                            @else
                                            <div style="bottom:0; border-bottom: 3px;">
                                            <p><i class="fas fa-times"></i></p>
                                            </div>
                                            @endif
                                        @endforeach
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </tbody>
                    </table>
                </div>
                @endforeach
            </div>
        </div>
        <div id="simulation-recap" class="ui-body-d ui-content">
            <table data-role="table" id="table-simulation-recap" data-mode="reflow" class="ui-responsive table-stroke">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        @foreach ($simulationScores as $key => $simulation)
                        <th>{{$key}}</th>
                        @endforeach
                        <th>NA</th>
                        <th>Peringkat</th>
                        <th>Aksi</th>
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
                            <p class="font-weight-bold">Skor Dok : </p>
                            {{$simulationResult->scoreDoc[$key]->score}} / {{$simulationResult->scoreDoc[$key]->score_max}}
                        </td>
                        @endforeach
                        <td>{{$simulationResult->na}}</td>
                        <td>{{$simulationResult->rating}}</td>
                        <td>
                            <a href="{{ route('simulation.result', ['id' => $simulationResult->id]) }}" target="_blank" class="ui-btn">Lihat Hasil</a>
                            <button type="button" class="ui-btn" id="btn-del-{{$loop->iteration}}">Hapus</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('sim-js')
<script>
    $(document).ready(function(){
        $('#btn-kembali').show();
            $('#btn-kembali').click(function(){
                window.location.href = "{{route('simulation.index')}}";
            })

        $('#btn-simulation-score-result').click(function(){
            $('#btn-simulation-doc-result').removeClass('clicked-up');
            $('#btn-simulation-doc-result').removeClass('clicked-left');

            $('#btn-simulation-recap').removeClass('clicked-up');
            $('#btn-simulation-recap').removeClass('clicked-left');

            $(this).addClass('clicked-up');
        });

        $('#btn-simulation-doc-result').click(function(){
            $('#btn-simulation-score-result').removeClass('clicked-up');
            $('#btn-simulation-score-result').removeClass('clicked-left');
            
            $('#btn-simulation-recap').removeClass('clicked-up');
            $('#btn-simulation-recap').removeClass('clicked-left');

            $(this).addClass('clicked-up');
        });

        $('#btn-simulation-recap').click(function(){
            $('#btn-simulation-score-result').removeClass('clicked-up');
            $('#btn-simulation-score-result').removeClass('clicked-left');

            $('#btn-simulation-doc-result').removeClass('clicked-up');
            $('#btn-simulation-doc-result').removeClass('clicked-left');

            $(this).addClass('clicked-up');
        });

        //looping
        @foreach ($simulationScores as $key => $simulationScore)
        $('#btn-simulation-score-result-{{ $loop->iteration }}').click(function(){
            @foreach ($simulationScores as $key => $simulationScore)
            $('#btn-simulation-score-result-{{ $loop->iteration }}').removeClass('clicked-up');
            $('btn-simulation-score-result-{{ $loop->iteration }}').removeClass('clicked-left');
            @endforeach
            $(this).addClass('clicked-up');
        });
        @endforeach

        @foreach ($simulationDocDetails as $key => $simulationDocDetail)
        $('#btn-simulation-doc-result-{{$loop->iteration}}').click(function(){
            @foreach ($simulationDocDetails as $key => $simulationDocDetail)
            $('#btn-simulation-doc-result-{{$loop->iteration}}').removeClass('clicked-up');
            $('#btn-simulation-doc-result-{{$loop->iteration}}').removeClass('clicked-left');
            @endforeach
            $(this).addClass('clicked-up');
        });
        @endforeach

        @foreach ($simulationsResults as $simulationResult)
        $('#btn-del-{{$loop->iteration}}').click(function(){
            $.ajax({
                url: "{{route('simulation.delete', $simulationResult->id)}}",
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": "DELETE"
                },
                success: function(data) {
                    window.location.href = "{{route('simulation.index')}}";
                }
            });
        });
        @endforeach
    })
</script>
@endsection