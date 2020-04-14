@extends('layouts.backend.app')

@section('title')
    
@endsection

@push('css')
    
@endpush

@section('content')

<div class="container-fluid">
    <div class="block-header">
        <h2>FORM EXAMPLES</h2>
    </div>


    <!-- Vertical Layout | With Floating Label -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>Adicione a Nova Tag</h2>      
                </div>
                <div class="body">
                <form  action="{{route('admin.tag.store')}}" method="POST">
                    @csrf
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="name" name="name" class="form-control">
                                <label class="form-label">Nome da Tag</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">Salvar</button>
                    <a href="{{route('admin.tag.index')}}" type="button" 
                        class="btn btn-danger m-t-15 waves-effect">Voltar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
   
</div>
    
@endsection

@push('js')
    
@endpush