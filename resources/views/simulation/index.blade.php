@extends('layouts.simulation.app')
@section('sim-main')

    <center>
        <h1>Simulasi Akreditasi</h1>

        <div data-role="collapsible" data-collapsed="false">
            <h4>Riwayat Simulasi</h4>
            <table data-role="table" id="table-column-toggle" class="ui-responsive table-stroke">
                <thead>
                    <tr>
                        <td>Tanggal</td>
                        <td>Total Score</td>
                        <td>Total Score Max</td>
                        <td>Score Kelengkapan Dokumen</td>
                        <td>Score Max Kelengkapan Dokumen</td>
                        <td>Aksi</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($simulations as $simulation)
                        <tr>
                            <td>{{ Carbon\Carbon::parse($simulation->created_on)->format('d-M-Y H:i') }}</td>
                            <td>{{ $simulation->total_score }}</td>
                            <td>{{ $simulation->total_score_max }}</td>
                            <td>{{ $simulation->score_doc }}</td>
                            <td>{{ $simulation->score_doc_max }}</td>
                            <td>
                                <a href="{{ route('simulation.result', ['id' => $simulation->id]) }}" data-class="ui-btn">Lihat Hasil</a>
                                <form action="{{route('simulation.delete', ['id' => $simulation->id])}}" method="post" id="form-hapus-{{$loop->iteration}}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" data-class="ui-btn" id="btn-hapus-{{$loop->iteration}}">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <button id="btn-mulai" style="display: none"><span>Mulai Simulasi</span></button>
        <button id="btn-selesai" style="display: none"><span>Akhiri Simulasi</span></button>
    </center>

    <div data-role="tabs" id="tabs" style="display: none">
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
                $('#tabs').show();
            $('#btn-selesai').click(function(){
                $('#btn-selesai').hide();
                $('#tabs').hide();
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

        @foreach ($simulations as $simulation)
            $('#btn-hapus-{{$loop->iteration}}').click(function() {
                $.ajax({
                    url: $('#form-hapus-{{$loop->iteration}}').attr('action'),
                    type: 'DELETE',
                    data: $('#form-hapus-{{$loop->iteration}}').serialize(),
                    success: function(data) {
                        window.location.href = "{{route('simulation.index')}}";
                    }
                });
            });
        @endforeach
    })
</script>
@endsection