@extends('layouts.app')
@section('title', 'Obras')
@section('content')
    <section class="content-header">
        <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black"> Obras
            <small class="tw-text-sm md:tw-text-base tw-text-gray-700 tw-font-semibold">@lang('contact.manage_your_contact', ['contacts' => __('lang_v1.' . $type . 's')])</small>
        </h1>
    </section>
    <section class="content">
        @component('components.widget', [
            'class' => 'box-primary',
            'title' => 'Todas tus obras',
        ])
            @if (auth()->user()->can('supplier.create') ||
                    auth()->user()->can('customer.create') ||
                    auth()->user()->can('supplier.view_own') ||
                    auth()->user()->can('customer.view_own'))
                @slot('tool')
                    <div class="box-tools">
                        <a class="tw-dw-btn tw-bg-gradient-to-r tw-from-indigo-600 tw-to-blue-500 tw-font-bold tw-text-white tw-border-none tw-rounded-full btn-modal"
                                data-href="{{ action([\App\Http\Controllers\ContactController::class, 'create'], ['type' => $type]) }}"
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
                    <table class="table table-bordered table-striped" id="obra_table">
                        <thead>
                            <tr>
                                <th {{-- class="tw-w-full" --}}>@lang('messages.action')</th>
                                <td >Nombre</td>
                                <td>Codigo</td>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="bg-gray font-17 text-center footer-total">
                                <td></td>
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
{{-- @stop
@section('javascript')
    <script>
        $(document).ready(function() {
            obra_table = $('#obra_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ action([\App\Http\Controllers\ObraController::class, 'index']) }}',
                columnDefs: [{
                        targets: 0,
                        orderable: false,
                        searchable: false,
                    },
                ],
                columns: [
                    { data: 'action', name: 'action' },
                    { data: 'nombre', name: 'nombre' },
                    { data: 'codigo', name: 'codigo' },
                ],
                /* fnDrawCallback: function(oSettings) {
                    __currency_convert_recursively($('#obra_table'));
                }, */
            });
        });
    </script> --}}
@endsection