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

    .overflow-auto{
        overflow: auto;
        white-space: nowrap;
    }
</style>
@endsection
@section('sim-main')

@if ($simulationsResults->count() <= 0)
<div style="text-align: center;">
    <h1>Data Hasil Simulasi Akreditasi Kosong</h1>
    <button id="btn-kembali" style="display: none"><span>Kembali</span></button>
</div>
@else
<div style="text-align: center;">
    <h1>Riwayat dan Rekapitulasi Simulasi Akreditasi</h1>
    <button id="btn-kembali" style="display: none"><span>Kembali</span></button>
</div>

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
                    <div class="overflow-auto">
                        <table data-role="table" id="table-nilai-{{$loop->iteration}}" class="ui-responsive table-stroke display">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pertanyaan</th>
                                    @foreach ($simulationScore->sortByDesc('created_on')->groupBy('created_on') as $date => $value)
                                    <th>{{Carbon\Carbon::parse($date)->format('d M y, H:i')}}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>#</th>
                                    <th>Jumlah skor perolehan visitasi komponen {{$key}}</th>
                                    @foreach ($simulationsResults as $simulationsResult)
                                        @foreach ($simulationsResult->scores as $scores)
                                        @if ($scores->scoretype_component->name == $key)
                                        <th>{{$scores->score}} / {{$scores->score_max}}</th>
                                        @endif
                                        @endforeach
                                    @endforeach
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Skor Komponen / Skor Maks Komponen X Bobot</th>
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
                                    <td>{!!wordwrap($keyName, 70, '<br>')!!}</td>
                                    @foreach ($component_questions->sortByDesc('created_on') as $score)
                                        <td>{{$score->score == null ? 0 : $score->score}}</td>
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
        <div id="simulation-doc-result" class="ui-body-d ui-content">
            <div data-role="tabs" id="tabs-simulation-doc-result">
                <div data-role="navbar">
                    <ul>
                        @foreach ($scoretypeComponents as $scoretypeComponent)
                        @if($loop->iteration != 5)
                        <li><a href="#simulation-doc-result-{{$loop->iteration}}" id="btn-simulation-doc-result-{{$loop->iteration}}" data-ajax="false" class="{{$loop->iteration == 1 ? 'ui-btn-active' : ''}}">{{$scoretypeComponent->name}}</a></li>
                        @endif
                        @endforeach
                    </ul>
                </div>
                @foreach ($scoretypeComponents as $scoretypeComponent)
                @if($loop->iteration != 5)
                <div id="simulation-doc-result-{{$loop->iteration}}" class="ui-body-d ui-content">
                    <div class="overflow-auto">
                        <table data-role="table" id="table-doc-{{$loop->iteration}}" class="ui-responsive table-stroke display">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Indikator dan Dokumen</th>
                                    @foreach ($simulationsResults as $simulationsResult)
                                    @if($loop->iteration == 1)
                                    <th>Terakhir diubah : {{Carbon\Carbon::parse($simulationsResult->created_on)->format('d M Y H:i')}}</th>
                                    @endif
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>#</th>
                                    <th>Jumlah Skor Dokumen</th>
                                    @foreach ($simulationsResults as $simulationsResult)
                                        @if($loop->iteration == 1)
                                            @foreach ($simulationsResult->scores as $scores)
                                                @if ($scores->scoretype_component->id == $scoretypeComponent->id)
                                                <th>{{$scores->score_doc}} / {{$scores->score_doc_max}}</th>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                </tr>
                                @foreach ($scoretypeComponent->componentQuestions->sortBy('seq') as $componentQuestion)
                                @foreach ($componentQuestion->questionsIndicators as $questionsIndicator)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            <p style="font-weight: bold; margin-top: 0px; margin-bottom: 1px;">Indikator</p>
                                            {!!wordwrap($questionsIndicator->name, 70, '<br>')!!}
                                            <br>
                                            <p style="font-weight: bold; margin-top: 7px; margin-bottom: 1px;">Dokumen yang diperlukan</p>
                                        </td>
                                        <td> </td>
                                    </tr>
                                    @foreach ($questionsIndicator->indicatorsDocuments->sortBy('seq') as $indicatorsDocument)
                                        <tr>
                                            <td> </td>
                                            <td>{!!wordwrap($indicatorsDocument->name, 70, '<br>')!!}</td>
                                            <td>
                                                @if ($indicatorsDocument->is_checked == 1)
                                                    <i class="fas fa-check"></i>
                                                @else
                                                    <i class="fas fa-times"></i>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        <div id="simulation-recap" class="ui-body-d ui-content">
            <div class="overflow-auto">
                <table data-role="table" id="table-simulation-recap" class="ui-responsive table-stroke">
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
                            @foreach ($simulationResult->scores as $key => $scores)
                            <td>
                                <p class="font-weight-bold">Nilai : </p>
                                {{$scores->score}} / {{$scores->score_max}}
                                <br>
                                <p class="font-weight-bold">Skor Dok : </p>
                                {{$scores->score_doc}} / {{$scores->score_doc_max}}
                            </td>
                            @endforeach
                            <td>{{$simulationResult->na}}</td>
                            <td>{{$simulationResult->rating}}</td>
                            <td>
                                @if ($simulationResult->total_score < 44)
                                <a href="{{ route('simulation.edit', ['id' => $simulationResult->id]) }}" target="_blank" class="ui-btn"><i class="fas fa-exclamation-triangle" style="color: #ffc107"></i> Lanjutkan Pengisian</a>
                                @else
                                <a href="{{ route('simulation.result', ['id' => $simulationResult->id]) }}" target="_blank" class="ui-btn">Lihat Hasil</a>
                                @endif
                                <button type="button" class="ui-btn" id="btn-del-{{$loop->iteration}}">Hapus</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('sim-js')
<script>
    $(document).ready(function(){
        $('table.display').DataTable( {
            // scrollX: true,
            // scrollCollapse: true,
            paging: false,
            ordering: false,
            searching: false,
            fixedColumns:   {
                left: 2,
            },
        });

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

        @foreach ($scoretypeComponents as $scoretypeComponent)
        $('#btn-simulation-doc-result-{{$loop->iteration}}').click(function(){
            @foreach ($scoretypeComponents as $scoretypeComponent)
            $('#btn-simulation-doc-result-{{$loop->iteration}}').removeClass('clicked-up');
            $('#btn-simulation-doc-result-{{$loop->iteration}}').removeClass('clicked-left');
            @endforeach
            $(this).addClass('clicked-up');
        });
        @endforeach

        @foreach ($simulationsResults as $simulationResult)
        $('#btn-del-{{$loop->iteration}}').click(function(){
            let confirmation = confirm('Hapus data ini?');

            if (confirmation) {
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
            }
        });
        @endforeach
    })
</script>
@endsection