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
        <button id="btn-riwayat" style="display: none"><span>Riwayat Simulasi</span></button>
        <button id="btn-mulai" style="display: none"><span>Mulai Simulasi</span></button>
        <button id="btn-selesai" style="display: none"><span>Akhiri Simulasi</span></button>
    </center>
   
    <div data-role="tabs" id="tabs-simulation" style="display: none">
        <div data-role="navbar" class="menu">
            <ul>
                <li><a href="#one" id="btn-one" class="ui-btn-active">Simulasi Nilai</a></li>
                <li><a href="#two" id="btn-two"> Kelengkapan Dokumen</a></li>
            </ul>
        </div>
        
        <form id="form">
            @csrf
            <input type="hidden" name="timezone" id="timezone">
            <div id="one" class="ui-body-d ui-content">
                <div data-role="tabs" id="tabs1">
                    <div data-role="navbar" class="menu2">
                        <ul>
                        @foreach ($scoretypeComponents as $scoretypeComponent)
                            <!-- TAB KOMPONEN -->
                            <li>
                                <input type="hidden" name="scoretypeComponentId[]" value="{{$scoretypeComponent->id}}">
                                <input type="hidden" name="weightComp[]" value="{{$scoretypeComponent->weight}}">
                                <a href="#satu-{{$loop->iteration}}" id="btn-satu-{{$loop->iteration}}" class="btn-satu {{$loop->iteration == 1 ? 'ui-btn-active' : ''}}">{{$scoretypeComponent->name}}</a>
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
                                    <div class="ui-bar ui-bar-a">Indikator</div>
                                    <!-- INDIKATOR -->
                                    @foreach ($componentQuestion->questionsIndicators as $questionsIndicator)
                                        <p style="font-weight:normal!important;">{{$loop->iteration}}. {!!$questionsIndicator->name!!}</p>
                                    @endforeach
                                    <div class="ui-grid-a">
                                        <div class="ui-block-a">
                                            <div class="ui-bar ui-bar-a">Jawaban</div>
                                        </div>
                                        <div class="ui-block-b">
                                            <div class="ui-bar ui-bar-a" style="text-align: right">Nilai (1-4) &nbsp
                                                <input type="number" data-clear-btn="false" data-role="none" class="nilais" name="nilai[{{$scoretypeComponent->id}}][]" min="1" max="4" style="height: 15px; width:50px; float:right">
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ($componentQuestion->questionsAnswers->sortByDesc('level') as $questionsAnswer)
                                    <!-- JAWABAN -->
                                    <p style="font-weight: normal!important">{{$questionsAnswer->level}}. {!!$questionsAnswer->name!!}</p>
                                    {{-- <fieldset data-role="controlgroup">
                                        <label style="font-weight: normal!important">
                                            <input type="radio" name="{{$componentQuestion->seq}}" value="{{$questionsAnswer->level}}">{!!$questionsAnswer->name!!}
                                        </label>
                                    </fieldset> --}}
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
                    <div data-role="navbar" class="menu2">
                        <ul>
                        @foreach ($scoretypeComponents as $scoretypeComponent)
                        <!-- TAB KOMPONEN -->
                        @if($loop->iteration != 5)
                        <li><a href="#siji-{{$loop->iteration}}" id="btn-siji-{{$loop->iteration}}" class="{{$loop->iteration == 1 ? 'ui-btn-active' : ''}}">{{$scoretypeComponent->name}}</a></li>
                        @endif
                        @endforeach
                        </ul>
                    </div>
                    <br>
                    Ambil data Dokumen dari Simulasi Lain
                    <a href="#popupDialog" data-rel="popup" data-position-to="window" data-transition="pop" class="ui-btn ui-corner-all ui-shadow ui-btn-inline">Disini</a>
                    <div data-role="popup" id="popupDialog" data-overlay-theme="b" data-dismissible="false" style="width: 800px;">
                        <div data-role="header" data-theme="a">
                            <h1>Ambil data dokumen</h1>
                        </div>
                        <div role="main" class="ui-content">
                            <form id="form-doc-sim">
                            @foreach ($dataDocumentSims as $dataDocumentSim)
                                <label data-role="collapsible" data-collapsed-icon="carat-d" data-expanded-icon="carat-u">
                                    <h4> Tanggal : {{Carbon\Carbon::parse($dataDocumentSim->created_on)->format('d M Y H:i')}}</h4>
                                    @foreach ($dataDocumentSim->scores as $scoreDoc)
                                        @if($loop->iteration != 5)
                                        <h5 style="font-weight: bold;font-size: larger;margin: 0px;">{{$scoreDoc->scoretype_component->name}} ({{$scoreDoc->score_doc}} / {{$scoreDoc->score_doc_max}}) </h5>
                                            @foreach ($scoreDoc->simulationDocIndic as $simulationDocIndic)
                                                @foreach ($simulationDocIndic->simulationDocDetail as $indicatorsDocuments)
                                                    @if ($indicatorsDocuments->is_checked == 1)
                                                        <p style="font-weight: normal;">{{$indicatorsDocuments->simulationIndicatorsDocument->name}}</p>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                    @endforeach
                                    <input type="checkbox" value="{{$dataDocumentSim->id}}" name="dataDocSim[]" class="dataDocSim">
                                </label>
                            @endforeach
                            </form>
                            <a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline" data-rel="back" id="batal-ambil">Batal</a>
                            <a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline" data-rel="back" id="ambil-data">Submit</a>
                        </div>
                    </div>
                    <br>
                    <br>
                    @foreach ($scoretypeComponents as $scoretypeComponent)
                    @if($loop->iteration != 5)
                    <div id="siji-{{$loop->iteration}}">
                        <div class="ui-corner-all custom-corners">
                            @foreach ($scoretypeComponent->componentQuestions->sortBy('seq') as $componentQuestion)
                            <div class="ui-bar ui-bar-a">
                                <!-- PERTANYAAN -->
                                <p>{{$loop->iteration}}. {{$componentQuestion->name}}</p>

                                <div class="ui-body ui-body-a">
                                    <div class="ui-bar ui-bar-a">Indikator</div>
                                    @foreach ($componentQuestion->questionsIndicators as $questionsIndicator)
                                        <input type="hidden" name="questionIndicatorsId[{{$scoretypeComponent->id}}][]" value="{{$questionsIndicator->id}}">
                                        <!-- INDIKATOR -->
                                        <p style="font-weight:normal!important;">{{$loop->iteration}}. {!!$questionsIndicator->name!!}</p>
                                        @if($questionsIndicator->indicatorsDocuments->count() != 0)
                                        <div class="ui-corner-all custom-corners">
                                            <div class="ui-bar ui-bar-a">Dokumen</div>
                                                <!-- INDIKATOR -->
                                                @foreach($questionsIndicator->indicatorsDocuments as $indicatorDocument)
                                                    <label>
                                                        <!-- INDIKATOR DOKUMEN -->
                                                        <input type="checkbox" name="isChecked[{{$questionsIndicator->id}}][]" value="1" data-checkbox-id="{{$indicatorDocument->id}}" class="checkbox-doc">{{$indicatorDocument->name}}
                                                        <input type="hidden" name="indicatorDocuments[{{$questionsIndicator->id}}][]" value="{{$indicatorDocument->id}}">
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
    $(document).ready(function() {
        let MyDate = new Date();
        let MyString = MyDate.toTimeString();
        let MyOffset = MyString.slice(12,17);
        $('#timezone').val(MyOffset);

        // $('#btn-siji-5').remove();
        
        $('#btn-mulai').show();
            $('#btn-mulai').click(function(){
                $('#btn-mulai').hide();
                $('#btn-riwayat').hide();
                $('#btn-selesai').show();
                $('#tabs-simulation').show();
            $('#btn-selesai').click(function(){
                $('#btn-selesai').hide();
                $('#tabs-simulation').hide();
                $('#btn-mulai').show();
                $('#btn-riwayat').show();
            });
        });

        $('#btn-riwayat').show();
            $('#btn-riwayat').click(function(){
                window.location.href = "{{route('simulation.resultBasedOnQuestion')}}";
            })

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
                    if (data.status == 'success') {
                        window.location.href = "{{route('simulation.resultBasedOnQuestion')}}";
                    } else {
                        alert(data.message);
                    }
                }
            });
        });

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
        @foreach ($scoretypeComponents as $scoretypeComponent)
        $('#btn-satu-{{$loop->iteration}}').click(function(){
            @foreach ($scoretypeComponents as $scoretypeComponent)
            $('#btn-satu-{{$loop->iteration}}').removeClass('clicked-up');
            $('#btn-satu-{{$loop->iteration}}').removeClass('clicked-left');
            @endforeach
            $(this).addClass('clicked-up');
        });

        $('#btn-siji-{{$loop->iteration}}').click(function(){
            @foreach ($scoretypeComponents as $scoretypeComponent)
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

        $('.nilais').keyup(function(){
            if($(this).val() > 4 || $(this).val() < 1){
                alert('Nilai tidak boleh lebih dari 4 atau lebih kecil dari 1');
                $(this).val('');
            }
        });

        $('#ambil-data').click(function(){
            $.ajax({
                url: "{{route('simulation.getDataDoc')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: {
                    'dataDocSim': $('.dataDocSim:checked').serializeArray()
                },
                success: function(data) {
                    if (data.status == 'success') {
                        data.data.map(function(item){
                            $("[data-checkbox-id='"+ item + "']").prop('checked', true).checkboxradio('refresh');
                            $("[data-checkbox-id='"+ item + "']").attr('data-from-old', item);
                        });
                    } else {
                        $('[data-from-old]').prop('checked', false).checkboxradio('refresh');
                    }
                },
                error: function(data) {
                    alert('Terjadi kesalahan');
                }
            });
        });
    });
</script>
@endsection