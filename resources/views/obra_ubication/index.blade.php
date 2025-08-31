@extends('layouts.app')
@section('title', 'Ubicaciones en la Obra')
@section('content')
    <section class="content-header">
        <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">{{ $obra->nombre ?? '' }}
            {{-- <small class="tw-text-sm md:tw-text-base tw-text-gray-700 tw-font-semibold">@lang('contact.manage_your_contact', ['contacts' => __('lang_v1.' . $type . 's')])</small> --}}
        </h1>
    </section>
    <section class="content">
        @component('components.widget', [
            'class' => 'box-primary',
            'title' => 'Ubicaciónes de la Obra',
        ])
            @if (auth()->user()->can('supplier.create') ||
                    auth()->user()->can('customer.create') ||
                    auth()->user()->can('supplier.view_own') ||
                    auth()->user()->can('customer.view_own'))
                @slot('tool')
                    <div class="box-tools">
                        <a class="tw-dw-btn tw-bg-gradient-to-r tw-from-indigo-600 tw-to-blue-500 tw-font-bold tw-text-white tw-border-none tw-rounded-full btn-modal"
                                data-href="{{ action([\App\Http\Controllers\ObraUbicationController::class, 'create'], ['obra' => $obra->id])  }}"
                                data-container=".contact_modal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                                </svg> @lang('messages.add')
                        </a>
                    </div>
                @endslot
            @endif
            @if (auth()->user()->can('supplier.view') ||
                    auth()->user()->can('customer.view') ||
                    auth()->user()->can('supplier.view_own') ||
                    auth()->user()->can('customer.view_own'))
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="obra_ubication_table">
                        <thead>
                            <tr>
                                <th {{-- class="tw-w-full" --}}>@lang('messages.action')</th>
                                <td >Ubicacion</td>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="bg-gray font-17 text-center footer-total">
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        @endcomponent
        <div class="modal fade contact_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </section>
@stop
@section('javascript')
    {{-- <script src="{{ asset('js/app.js?v=' . $asset_v) }}"></script> --}}
    <script>
        $(document).ready(function() {
            obra_ubication_table = $('#obra_ubication_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('obras.ubicaciones.index', ['obra' => $obra->id]) }}",
                    type: 'GET',
                },
                columnDefs: [{
                        targets: 0,
                        orderable: false,
                        searchable: false,
                    },
                ],
                columns: [
                    { data: 'action', name: 'action' },
                    { data: 'ubicacion', name: 'ubicacion' }
                ],
                /* fnDrawCallback: function(oSettings) {
                    __currency_convert_recursively($('#obra_ubication_table'));
                }, */
            });
        });
    </script>
    <script>
    $(document).on('submit', '#obra_form', function(e){
        e.preventDefault(); // evita el envío normal

        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            method: "POST", // Laravel PUT via _method
            url: url,
            data: data,
            dataType: 'json',
            success: function(data) {
                if(data.success) {
                    toastr.success(data.msg); // o Swal.fire(...)
                    $('.contact_modal').modal('hide'); // cerrar modal
                    if(typeof $('#obra_ubication_table').DataTable === 'function') {
                        $('#obra_ubication_table').DataTable().ajax.reload();
                    }
                } else {
                    toastr.error(data.msg);
                }
            },
            error: function() {
                $('.contact_modal').modal('hide');
                toastr.error('Ocurrió un error inesperado.');
            }
        });
    });
    </script>
    <script>
    $(document).on('click', '.delete_obra_button', function(e) {
        e.preventDefault();

        var href = $(this).attr('href');

        swal({
            title: LANG.sure,
            text: "Desea eliminar esta ubicacion?",
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    method: 'POST', // Laravel DELETE via _method
                    url: href,
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'DELETE'
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success) {
                            toastr.success(result.msg);
                            if(typeof $('#obra_ubication_table').DataTable === 'function') {
                                $('#obra_ubication_table').DataTable().ajax.reload();
                            }
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                    error: function() {
                        toastr.error('Ocurrió un error inespersado.');
                    }
                });
            }
        });
    });
    </script>


@endsection
<style>
    .obra-codigo {
    background-color: #b6c9da9a; /* gris oscuro */
    border-radius: 3px; /* casi cuadrado */
    padding: 2px 5px;   /* ajusta tamaño */
    font-weight: bold;
    font-size: 1em;
}
</style>