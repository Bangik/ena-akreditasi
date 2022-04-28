@extends('layouts.simulation.app')
@section('sim-main')
<h1 class="text-center">Hasil Simulasi Akreditasi</h1>
<h5 class="text-center">Tanggal {{Carbon\Carbon::parse($simulations->created_on)->format('d-M-Y H:i')}}</h5>
<h6 class="text-center">Total Nilai : {{$simulations->total_score}} / {{$simulations->total_score_max}}</h6>
<h6 class="text-center">Kelengkapan Dokumen : {{$simulations->score_doc}} / {{$simulations->score_doc_max}}</h6>
<button class="btn btn-primary" type="button" id="btn-nilai">Simulasi Nilai</button>
<button class="btn btn-primary" type="button" id="btn-doc">Simulasi Kelengkapan dokumen</button>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card" id="card-nilai">
            <div class="card-header">
                <h5 class="card-title">Nilai</h5>
            </div>
            <div class="card-body">
                @foreach ($simulations->scores as $simulationScore)
                    <div class="page-item" style="display: inline;">
                        <button class="page-link" type="button" data-toggle="collapse" data-target="#collapse-{{$loop->iteration}}" aria-expanded="true" aria-controls="collapse-{{$loop->iteration}}">{{$simulationScore->scoretype_component->name}}</button>
                    </div>
                    <div class="collapse multi-collapse mb-3" id="collapse-{{$loop->iteration}}">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Nilai {{$simulationScore->score}} / {{$simulationScore->score_max}}</h5>
                            </div>
                            <div class="card-body">
                                @foreach ($simulationScore->simulationDetails as $simulation_detail)
                                    <p class="font-weight-bold">{{$loop->iteration}}. {{$simulation_detail->component_questions->name}}</p>
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <h5 class="card-title">Jawaban</h5>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-inline">
                                                        <div class="form-group">
                                                            <label for="" class="my-1 mr-2">Nilai : </label>
                                                            <input type="number" class="form-control" min="1" max="4" value="{{$simulation_detail->score}}" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            @foreach ($simulation_detail->component_questions->questionsAnswers as $questionsAnswer)
                                                <p>{{$questionsAnswer->level}}. {{$questionsAnswer->name}}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h5 class="card-title">Indikator</h5>
                                        </div>
                                        <div class="card-body">
                                            @foreach ($simulation_detail->component_questions->questionsIndicators as $questionsIndicator)
                                                <p>{{$loop->iteration}}. {{$questionsIndicator->name}}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card" id="card-doc" style="display: none;">
            <div class="card-header">
                <h5 class="card-title">Kelengkapan Dokumen</h5>
            </div>
            <div class="card-body">
                @foreach ($simulations->scoreDoc as $scoreDoc)
                    <p class="font-weight-bold">{{$loop->iteration}}. {{$scoreDoc->questionsIndicator->name}}</p>
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-10">
                                    <h5 class="card-title">Dokumen</h5>
                                </div>
                                <div class="col-sm-2">
                                    <p>Ceklist : {{$scoreDoc->score}} / {{$scoreDoc->score_max}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach ($scoreDoc->simulationDocDetail as $simulationDocDetail)
                                <div class="row border-bottom">
                                    <div class="col-sm-11">
                                        <label>{{$simulationDocDetail->simulationIndicatorsDocument->name}}</label>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="checkbox" class="form-check-input" {{$simulationDocDetail->is_checked == 1 ? 'checked' : 'disabled'}}>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('sim-js')
<script>
    $(document).ready(function(){
        $('#btn-nilai').click(function(){
            $(this).addClass('active');
            $('#btn-doc').removeClass('active');
            $('#card-doc').hide();
            $('#card-nilai').show();
        });

        $('#btn-doc').click(function(){
            $(this).addClass('active');
            $('#btn-nilai').removeClass('active');
            $('#card-doc').show();
            $('#card-nilai').hide();
        });
    });
</script>
@endsection