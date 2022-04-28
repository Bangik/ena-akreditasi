@extends('layouts.simulation.app')
@section('sim-main')
<h1 class="text-center">Simulasi Akreditasi</h1>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title">Riwayat Simulasi</h5>
    </div>
    <div class="card-body">
        <table class="table">
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
                            <a href="{{ route('simulation.result', ['id' => $simulation->id]) }}" class="btn btn-primary">Lihat Hasil</a>
                            <form action="{{route('simulation.delete', ['id' => $simulation->id])}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<button class="btn btn-primary mb-4" type="button" id="btn-mulai">Mulai Simulasi</button> <br>
<button class="btn btn-outline-primary" type="button" id="btn-nilai" style="display: none;">Simulasi Nilai</button>
<button class="btn btn-outline-primary" type="button" id="btn-doc" style="display: none;">Simulasi Kelengkapan dokumen</button>
<div class="row mt-4">
    <div class="col-md-12">
        <form action="{{route('simulation.store')}}" method="post" id="form">
        <div class="card" id="card-nilai" style="display: none;">
            <div class="card-header">
                <h5 class="card-title">Nilai</h5>
            </div>
            <div class="card-body">
                    <div>
                        @foreach ($scoretypeComponents as $scoretypeComponent)
                            <input type="hidden" name="scoretypeComponentId[]" value="{{$scoretypeComponent->id}}">
                            <div class="page-item" style="display: inline;">
                                <button class="page-link" type="button" data-toggle="collapse" data-target="#collapse-{{$loop->iteration}}" aria-expanded="true" aria-controls="collapse-{{$loop->iteration}}">{{$scoretypeComponent->name}}</button>
                            </div>
                            <div class="collapse multi-collapse mb-3" id="collapse-{{$loop->iteration}}">
                                <div class="card card-body">
                                    @foreach ($scoretypeComponent->componentQuestions as $componentQuestion)
                                        <p class="font-weight-bold">{{$loop->iteration}}. {{$componentQuestion->name}}</p>
                                        <input type="hidden" name="componentQuestionId[{{$scoretypeComponent->id}}][]" value="{{$componentQuestion->id}}">
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
                                                                <input type="number" name="nilai[{{$scoretypeComponent->id}}][]" class="form-control" min="1" max="4">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                @foreach ($componentQuestion->questionsAnswers as $questionsAnswer)
                                                    <p>{{$questionsAnswer->level}}. {{$questionsAnswer->name}}</p>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <h5 class="card-title">Indikator</h5>
                                            </div>
                                            <div class="card-body">
                                                @foreach ($componentQuestion->questionsIndicators as $questionsIndicator)
                                                    <p>{{$loop->iteration}}. {{$questionsIndicator->name}}</p>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        @csrf
                    </div>                
            </div>
        </div>
        <div class="card" id="card-doc" style="display: none;">
            <div class="card-header">
                <h5 class="card-title">Kelengkapan Dokumen</h5>
            </div>
            <div class="card-body">
                @foreach ($dataComponentQuestions as $componentQuestion)
                    <p class="font-weight-bold">{{$loop->iteration}}. {{$componentQuestion->name}}</p>
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title">Indikator</h5>
                        </div>
                        <div class="card-body">
                            @foreach ($componentQuestion->questionsIndicators as $questionsIndicator)
                                <input type="hidden" name="questionIndicatorsId[]" value="{{$questionsIndicator->id}}">
                                <p>{{$loop->iteration}}. {{$questionsIndicator->name}}</p>
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Dokumen</h5>
                                        {{-- <div class="row">
                                            <div class="col-sm-10">
                                                <h5 class="card-title">Dokumen</h5>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check form-check-inline">
                                                    <label for="" class="form-check-label mr-3">Checklist</label>
                                                    <input type="checkbox" class="form-check-input" id="select-all-{{$questionsIndicator->id}}">
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="card-body">
                                        @foreach ($questionsIndicator->indicatorsDocuments as $indicatorsDocument)
                                            <div class="row border-bottom">
                                                <div class="col-sm-11">
                                                    <label>{{$indicatorsDocument->name}}</label>
                                                </div>
                                                <div class="col-sm-1">
                                                    <input type="hidden" name="indicatorDocuments[{{$questionsIndicator->id}}][]" value="{{$indicatorsDocument->id}}">
                                                    <input type="checkbox" class="form-check-input" name="isChecked[{{$questionsIndicator->id}}][]" value="1">
                                                </div>
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
        <button type="submit" class="btn btn-primary mt-3" style="display: none;" id="btn-simpan">Simpan</button>
    </form>
    </div>
</div>
@endsection

@section('sim-js')
<script>
    $(document).ready(function(){
        $('#btn-mulai').click(function(){
            $('#btn-nilai').show();
            $('#btn-doc').show();
        });

        $('#btn-nilai').click(function(){
            $(this).addClass('active');
            $('#btn-doc').removeClass('active');
            $('#card-doc').hide();
            $('#card-nilai').show();
            $('#btn-simpan').show();
        });

        $('#btn-doc').click(function(){
            $(this).addClass('active');
            $('#btn-nilai').removeClass('active');
            $('#card-doc').show();
            $('#card-nilai').hide();
            $('#btn-simpan').show();
        });

        $("#form").on('submit', function() {
            // to each unchecked checkbox
            $(this).find('input[type=checkbox]:not(:checked)').prop('checked', true).val(0);
        })


        // $('#select-all').click(function() {
        //     var checked = this.checked;
        //     $('input[type="checkbox"]').each(function() {
        //         this.checked = checked;
        //     });
        // });
    });
</script>
@endsection