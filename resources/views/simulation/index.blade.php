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
        <div data-role="navbar" class="menu" id="navbar-simulation">
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
                                    <p style="font-weight: normal!important">{{$questionsAnswer->level}}. {!!$questionsAnswer->name!!}</p>
                                    @endforeach
                                    <div class="ui-bar ui-bar-a">Indikator</div>
                                    <!-- INDIKATOR -->
                                    @foreach ($componentQuestion->questionsIndicators as $questionsIndicator)
                                        <p style="font-weight:normal!important;">{{$loop->iteration}}. {!!$questionsIndicator->name!!}</p>
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

                    @foreach ($scoretypeComponents as $scoretypeComponent)
                    @if($loop->iteration != 5)
                    <div id="siji-{{$loop->iteration}}">
                        <div class="ui-corner-all custom-corners">
                            @foreach ($scoretypeComponent->componentQuestions as $componentQuestion)
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
                                                        <input type="checkbox" name="isChecked[{{$questionsIndicator->id}}][]" value="1">{{$indicatorDocument->name}}
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
    });
</script>
@endsection