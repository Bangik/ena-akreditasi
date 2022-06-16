@extends('layouts.simulation.app')
@section('sim-css')
<style>
    .ui-state-disabled {
        opacity: 1;
    }

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
    <h1 style="text-align: center;">Lanjutkan Pengisian Simulasi Akreditasi</h1>
    <table data-role="table" class="ui-responsive" style="width: 30%">
        <thead>
            <tr>
                <th>Tanggal</th>
                <td>:</td>
                <td>{{Carbon\Carbon::parse($simulations->created_on)->format('d M Y H:i')}}</td>
            </tr>
            <tr>
                <th>Total Nilai</th>
                <td>:</td>
                <td>{{$simulations->total_score}} / {{$simulations->total_score_max}}</td>
            </tr>
            <tr>
                <th>Kelengkapan Dokumen</th>
                <td>:</td>
                <td>{{$simulations->score_doc}} / {{$simulations->score_doc_max}}</td>
            </tr>
        </thead>
    </table>

    <!-- Button Simulasi Nilai dan Kelengkapan Dokumen -->
    <div data-role="tabs" id="tabs">
        <div data-role="navbar" class="menu">
            <ul>
                <li><a href="#one" id="btn-one" class="ui-btn-active">Simulasi Nilai</a></li>
                <li><a href="#two" id="btn-two">Simulasi Kelengkapan Dokumen</a></li>
            </ul>
        </div>
        <form id="form">
        @csrf
        <input type="hidden" name="idSimulation" value="{{$simulations->id}}">
        <input type="hidden" name="timezone" id="timezone">
        <div id="one" class="ui-body-d ui-content">
            <div data-role="tabs" id="tabs1">
                <div data-role="navbar" class="menu2">
                    <ul>
                    @foreach ($simulations->scores->sortBy('scoretype_component_id') as $simulationScore)
                        <!-- TAB KOMPONEN -->
                        <li>
                            <input type="hidden" name="scoretypeComponentId[]" value="{{$simulationScore->scoretype_component->id}}">
                            <input type="hidden" name="weightComp[]" value="{{$simulationScore->scoretype_component->weight}}">
                            <a href="#satu-{{$loop->iteration}}" id="btn-satu-{{$loop->iteration}}" class="btn-satu {{$loop->iteration == 1 ? 'ui-btn-active' : ''}}">
                                @foreach ($simulationScore->simulationDetails as $simulation_detail)
                                    @if ($simulation_detail->score == null)
                                    <i class="fas fa-exclamation-triangle" style="color: #ffc107"></i>
                                    @break
                                    @endif
                                @endforeach
                                {{$simulationScore->scoretype_component->name}}
                            </a>
                        </li>
                    @endforeach
                    </ul>
                </div>

                @foreach ($simulations->scores->sortBy('scoretype_component_id') as $simulationScore)
                <div id="satu-{{$loop->iteration}}">
                    <div class="ui-corner-all custom-corners">
                        <div class="ui-bar ui-bar-a">
                            <!-- PERTANYAAN -->
                        @foreach ($simulationScore->simulationDetails as $simulation_detail)
                        @if ($simulation_detail->score == null)
                            <p>Pertanyaan yang masih belum diisi nilainya pada nomor:
                            @break
                        @endif
                        @endforeach

                        @foreach ($simulationScore->simulationDetails as $simulation_detail)
                            @if ($simulation_detail->score == null)
                                <span class="ui-btn-text">{{$loop->iteration}}</span>
                            @endif
                        @endforeach

                        @foreach ($simulationScore->simulationDetails as $simulation_detail)
                        @if ($simulation_detail->score == null)
                            </p>
                            <hr>
                            <br>
                            @break
                        @endif
                        @endforeach
                        
                        @foreach ($simulationScore->simulationDetails as $simulation_detail)
                        {{-- @dd($simulation_detail->toArray()) --}}
                            <p>{{$loop->iteration}}. {{$simulation_detail->component_questions->name}}</p>
                            <input type="hidden" name="componentQuestionId[{{$simulation_detail->component_questions->parent_id}}][]" value="{{$simulation_detail->component_questions_id}}">
                            <div class="ui-body ui-body-a">
                                <div class="ui-grid-a">
                                    <div class="ui-block-a">
                                        <div class="ui-bar ui-bar-a">Jawaban</div>
                                    </div>
                                    <div class="ui-block-b">
                                        <div class="ui-bar ui-bar-a" style="text-align: right">Nilai (1-4) &nbsp
                                            <input type="number" data-clear-btn="false" data-role="none" name="nilai[{{$simulation_detail->component_questions->parent_id}}][]" value="{{$simulation_detail->score}}" min="1" max="4" style="height: 15px; width:50px; float:right">
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
                                    <p style="font-weight:normal!important;">{{$loop->iteration}}. {!!$questionsIndicator->name!!}</p>
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
                <div data-role="navbar" class="menu2">
                    <ul>
                    @foreach ($simulations->scores->sortBy('scoretype_component_id') as $scoreDoc)
                        <!-- TAB KOMPONEN -->
                        @if($loop->iteration != 5)
                        <li>
                            <a href="#siji-{{$loop->iteration}}" id="btn-siji-{{$loop->iteration}}" class="{{$loop->iteration == 1 ? 'ui-btn-active' : ''}}">{{$scoreDoc->scoretype_component->name}}</a>
                        </li>
                        @endif
                    @endforeach
                    </ul>
                </div>

                @foreach ($simulations->scores->sortBy('scoretype_component_id') as $scoreDoc)
                @if($loop->iteration != 5)
                <div id="siji-{{$loop->iteration}}">
                    <div class="ui-corner-all custom-corners">
                        @foreach ($scoreDoc->scoretype_component->componentQuestions as $componentQuestions)           
                        <div class="ui-bar ui-bar-a">
                        <!-- PERTANYAAN -->
                            <p>{{$loop->iteration}}. {{$componentQuestions->name}}</p>
                            <div class="ui-body ui-body-a">
                                <div class="ui-bar ui-bar-a">Indikator</div>
                                @foreach ($scoreDoc->simulationDocIndic as $simulationDocIndic)
                                {{-- @dd($componentQuestions->toArray()) --}}
                                @if($componentQuestions->id == $simulationDocIndic->questionIndicator->parent_id)
                                <input type="hidden" name="questionIndicatorsId[{{$componentQuestions->parent_id}}][]" value="{{$simulationDocIndic->questions_indicator_id}}">
                                        <p style="font-weight:normal!important;">{{$simulationDocIndic->questionIndicator->seq}}. {!!$simulationDocIndic->questionIndicator->name!!}</p>
                                        <div class="ui-body ui-body-a">
                                            <div class="ui-bar ui-bar-a">Dokumen</div>
                                            @foreach ($simulationDocIndic->simulationDocDetail as $indicatorsDocuments)
                                            {{-- @dd($indicatorsDocuments->toArray()) --}}
                                                <label>
                                                {{$indicatorsDocuments->simulationIndicatorsDocument->name}}
                                                <input type="checkbox" name="isChecked[{{$indicatorsDocuments->simulationIndicatorsDocument->parent_id}}][]" {{$indicatorsDocuments->is_checked == 1 ? 'checked' : ''}} value="1">
                                                <input type="hidden" name="indicatorDocuments[{{$indicatorsDocuments->simulationIndicatorsDocument->parent_id}}][]" value="{{$indicatorsDocuments->indicators_documents_id}}">
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
                @endif
                @endforeach
            </div>
        </div>
        </form>
        <!-- Tombol Tambah Data -->
        <div data-role="footer" data-position="fixed" style="position:fixed">
            <div data-role="navbar">
                <ul>
                    <li><button type="button" data-icon="check" data-class="ui-btn" id="btn-simpan">Simpan</button></li>
                </ul>
            </div>  
        </div>
    </div>
@endsection

@section('sim-js')
<script>
    $(document).ready(function(){
        let MyDate = new Date();
        let MyString = MyDate.toTimeString();
        let MyOffset = MyString.slice(12,17);
        $('#timezone').val(MyOffset);

        $('#btn-one').click(function(){
            $('#btn-two').removeClass('clicked-up');
            $('#btn-two').removeClass('clicked-left');
            $(this).addClass('clicked-up');
        });

        $('#btn-two').click(function(){
            $('#btn-one').removeClass('clicked-up');
            $('#btn-one').removeClass('clicked-left');
            $(this).addClass('clicked-up');
        });

        //looping
        @foreach ($simulations->scores as $simulationScore)
        $('#btn-satu-{{$loop->iteration}}').click(function(){
            @foreach ($simulations->scores as $simulationScore)
            $('#btn-satu-{{$loop->iteration}}').removeClass('clicked-up');
            $('#btn-satu-{{$loop->iteration}}').removeClass('clicked-left');
            @endforeach
            $(this).addClass('clicked-up');
        });

        $('#btn-siji-{{$loop->iteration}}').click(function(){
            @foreach ($simulations->scores as $simulationScore)
            $('#btn-siji-{{$loop->iteration}}').removeClass('clicked-up');
            $('#btn-siji-{{$loop->iteration}}').removeClass('clicked-left');
            @endforeach
            $(this).addClass('clicked-up');
        });
        @endforeach

        var num = 200; //number of pixels before modifying styles

        $(window).bind('scroll', function () {
            if ($(window).scrollTop() > num) {
                $('.menu').addClass('fixed');
            } else {
                $('.menu').removeClass('fixed');
            }
        });

        $(window).bind('scroll', function () {
            if ($(window).scrollTop() > num) {
                $('.menu2').addClass('fixed2');
            } else {
                $('.menu2').removeClass('fixed2');
            }
        });

        $("#btn-simpan").click(function() {
            if($('.nilais').val() > 4){
                alert('Nilai tidak boleh lebih dari 4');
                return false;
            }
            // to each unchecked checkbox
            $('#form').find('input[type=checkbox]:not(:checked)').prop('checked', true).val(0);
            $.ajax({
                url: "{{route('simulation.store')}}",
                type: 'POST',
                data: $('#form').serialize(),
                success: function(data) {
                    window.location.href = "{{route('simulation.resultBasedOnQuestion')}}";
                }
            });
        });

        $('.nilais').keyup(function(){
            if($(this).val() > 4 || $(this).val() < 1){
                alert('Nilai tidak boleh lebih dari 4 atau lebih kecil dari 1');
                $(this).val('');
            }
        });
    });

</script>
@endsection