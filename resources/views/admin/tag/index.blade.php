@extends('layouts.backend.app')


@section('title')

@endsection

@push('css')
<link href="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">


@endpush

@section('content')
<div class="container-fluid">
    <div class="block-header">
        <h2>
        <a class="btn btn-primary waves-effect" href="{{route('admin.tag.create')}}">
            <i class="material-icons">add</i>
            <span>Adicionar Tag</span></a>
        </h2>
    </div>

    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        LISTA DE TAGS
                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                    <th>Ações</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($tags as $key=>$tag)
                                 <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $tag->name }}</td>
                                    <td>{{ $tag->created_at }}</td>
                                    <td>{{ $tag->updated_at }}</td>
                                 <td class="text-center">
                                    <a href="{{route('admin.tag.edit',$tag->id)}}" class="btn btn-info waves-effect">
                                        <i class="material-icons">edit</i>
                                    </a>
                                    <button class="btn btn-danger waves-effect" type="button" onclick="deleteTag({{ $tag->id }})">
                                        <i class="material-icons">delete</i>
                                    </button>
                                    <form id="delete-form-{{ $tag->id }}" action="{{ route('admin.tag.destroy',$tag->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                                 </tr>
                                @endforeach
                           </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Exportable Table -->
</div>


@endsection

@push('js')


    <!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>

    <script src="{{ asset('assets/backend/js/pages/tables/jquery-datatable.js') }}"></script>
    <script src="{{ asset('assets/backend/js/sweetalert2.all.js') }}"></script>

    <script type="text/javascript">

        function deleteTag(id) {
            swal({
                title: 'Deseja realmente excluir?',
                text: "Escolha uma das opções abaixo:",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, desejo excluir!',
                cancelButtonText: 'Não, cancele!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelado',
                        'Suas informações não foram excluidas :)',
                        'error'
                    )
                }
            })
        }
    </script>

    @endpush

