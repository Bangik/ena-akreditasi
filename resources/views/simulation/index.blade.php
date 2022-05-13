@extends('layouts.simulation.app')
@section('sim-main')

    <center>
        <h1>Simulasi Akreditasi</h1>

        <div data-role="collapsible" data-collapsed="false">
            <h4>Riwayat dan Rekapitulasi Hasil Simulasi</h4>
            <div data-role="tabs" id="tabs">
                <div data-role="navbar">
                    <ul>
                        <li><a href="#simulation-score-result" data-ajax="false" class="ui-btn-active">Hasil Simulasi Nilai</a></li>
                        <li><a href="#simulation-doc-result" data-ajax="false">Hasil Simulasi Dokumen</a></li>
                        <li><a href="#simulation-recap" data-ajax="false">Rekapitulasi</a></li>
                    </ul>
                </div>
                <div id="simulation-score-result" class="ui-body-d ui-content">
                    <div data-role="tabs" id="tabs-simulation-score-result">
                        <div data-role="navbar">
                            <ul>
                                @foreach ($simulationScores as $key => $simulationScore)
                                    <li><a href="#simulation-score-result-{{ $loop->iteration }}" data-ajax="false" class="{{$loop->iteration == 1 ? 'ui-btn-active' : ''}}">{{ $key }}</a></li>
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
                                <li><a href="#simulation-doc-result-{{$loop->iteration}}" data-ajax="false" class="{{$loop->iteration == 1 ? 'ui-btn-active' : ''}}">{{$key}}</a></li>
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
                                    <a href="{{ route('simulation.result', ['id' => $simulationResult->id]) }}" class="ui-btn">Lihat Hasil</a>
                                    <button type="button" class="ui-btn" id="btn-del-{{$loop->iteration}}">Hapus</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <button id="btn-mulai" style="display: none"><span>Mulai Simulasi</span></button>
        <button id="btn-selesai" style="display: none"><span>Akhiri Simulasi</span></button>
    </center>

    <div data-role="tabs" id="tabs-simulation" style="display: none">
        <div data-role="navbar">
            <ul>
                <li><a href="#one" class="ui-btn-active">Simulasi Nilai</a></li>
                <li><a href="#two">Simulasi Kelengkapan Dokumen</a></li>
            </ul>
        </div>

        <form id="form">
            @csrf
            <div id="one" class="ui-body-d ui-content">
                <div data-role="tabs" id="tabs1">
                    <div data-role="navbar">
                        <ul>
                        @foreach ($scoretypeComponents as $scoretypeComponent)
                            <!-- TAB KOMPONEN -->
                            <li>
                                <input type="hidden" name="scoretypeComponentId[]" value="{{$scoretypeComponent->id}}">
                                <input type="hidden" name="weightComp[]" value="{{$scoretypeComponent->weight}}">
                                <a href="#satu-{{$loop->iteration}}" class="{{$loop->iteration == 1 ? 'ui-btn-active' : ''}}">{{$scoretypeComponent->name}}</a>
                            </li>
                        @endforeach
                        </ul>
                    </div>
                    
                    @foreach ($scoretypeComponents as $scoretypeComponent)
                    <div id="satu-{{$loop->iteration}}">
                        <div class="ui-corner-all custom-corners">
                            @foreach ($scoretypeComponent->componentQuestions->sortBy('seq') as $componentQuestion)
                            <div class="ui-bar ui-bar-a">
                                <!-- PERTANYAAN -->
                                <p>{{$componentQuestion->seq}}. {{$componentQuestion->name}}</p>
                                <input type="hidden" name="componentQuestionId[{{$scoretypeComponent->id}}][]" value="{{$componentQuestion->id}}">
                                <div class="ui-body ui-body-a">
                                    <div class="ui-grid-a">
                                        <div class="ui-block-a">
                                            <div class="ui-bar ui-bar-a">Jawaban</div>
                                        </div>
                                        <div class="ui-block-b">
                                            <div class="ui-bar ui-bar-a" style="text-align: right">Nilai (1-4) &nbsp
                                                <input type="number" data-clear-btn="false" data-role="none" name="nilai[{{$scoretypeComponent->id}}][]" min="1" max="4" style="height: 15px; width:50px; float:right">
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ($componentQuestion->questionsAnswers->sortByDesc('level') as $questionsAnswer)
                                    <!-- JAWABAN -->
                                    <p style="font-weight: normal!important">{{$questionsAnswer->level}}. {{$questionsAnswer->name}}</p>
                                    @endforeach
                                    <div class="ui-bar ui-bar-a">Indikator</div>
                                    <!-- INDIKATOR -->
                                    @foreach ($componentQuestion->questionsIndicators as $questionsIndicator)
                                        <p style="font-weight:normal!important;">{{$loop->iteration}}. {{$questionsIndicator->name}}</p>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>

            <div id="two" class="ui-body-d ui-content">
                <div data-role="tabs" id="tabs1">
                    <div data-role="navbar">
                        <ul>
                        @foreach ($scoretypeComponents as $scoretypeComponent)
                        <!-- TAB KOMPONEN -->
                        <li><a href="#siji-{{$loop->iteration}}" class="{{$loop->iteration == 1 ? 'ui-btn-active' : ''}}">{{$scoretypeComponent->name}}</a></li>
                        @endforeach
                        </ul>
                    </div>

                    @foreach ($scoretypeComponents as $scoretypeComponent)
                    <div id="siji-{{$loop->iteration}}">
                        <div class="ui-corner-all custom-corners">
                            @foreach ($scoretypeComponent->componentQuestions as $componentQuestion)
                            <div class="ui-bar ui-bar-a">
                                <!-- PERTANYAAN -->
                                {{$loop->iteration}}. {{$componentQuestion->name}}
                                <div class="ui-body ui-body-a">
                                    <div class="ui-bar ui-bar-a">Indikator</div>
                                    @foreach ($componentQuestion->questionsIndicators as $questionsIndicator)
                                        <input type="hidden" name="questionIndicatorsId[{{$scoretypeComponent->id}}][]" value="{{$questionsIndicator->id}}">
                                        <!-- INDIKATOR -->
                                        <p style="font-weight:normal!important;">{{$loop->iteration}}. {{$questionsIndicator->name}}</p>
                                        <div class="ui-corner-all custom-corners">
                                            <div class="ui-bar ui-bar-a">Dokumen</div>
                                                <!-- INDIKATOR -->
                                                @foreach($questionsIndicator->indicatorsDocuments as $indicatorDocument)
                                                    <label>
                                                        <!-- INDIKATOR DOKUMEN -->
                                                        <input type="checkbox" name="isChecked[{{$questionsIndicator->id}}][]" value="1">{{$indicatorDocument->name}}
                                                        <input type="hidden" name="indicatorDocuments[{{$questionsIndicator->id}}][]" value="{{$indicatorDocument->id}}">
                                                    </label>
                                                @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Tombol Tambah Data -->
            <div data-role="footer" data-position="fixed" style="position:fixed">
                <div data-role="navbar">
                    <ul>
                        <li><button type="button" data-icon="check" data-class="ui-btn" id="btn-simpan">Simpan</button></li>
                    </ul>
                </div>  
            </div>
        </form>
    </div>
@endsection

@section('sim-js')
<script>
    $(document).ready(function() {
        $('#btn-mulai').show();
            $('#btn-mulai').click(function(){
                $('#btn-mulai').hide();
                $('#btn-selesai').show();
                $('#tabs-simulation').show();
            $('#btn-selesai').click(function(){
                $('#btn-selesai').hide();
                $('#tabs-simulation').hide();
                $('#btn-mulai').show();
            });
        });

        $("#btn-simpan").click(function() {
            // to each unchecked checkbox
            $('#form').find('input[type=checkbox]:not(:checked)').prop('checked', true).val(0);
            $.ajax({
                url: "{{route('simulation.store')}}",
                type: 'POST',
                data: $('#form').serialize(),
                success: function(data) {
                    window.location.href = "{{route('simulation.index')}}";
                }
            });
        });

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
    });
</script>
@endsection