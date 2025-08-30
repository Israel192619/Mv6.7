<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    @php
        $url = action([\App\Http\Controllers\ObraUbicationController::class, 'store'], ['obra' => $obra->id]);
    @endphp
    {!! Form::open(['url' => $url, 'method' => 'post', 'id' => 'obra_form' ]) !!}
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">Agregar ubicacion a {{ $obra->nombre }}</h4>
    </div>
    <div class="modal-body">
        <div class="row">            
            <div class="col-md-4 center">
                <div class="form-group">
                    {!! Form::label('ubicacion', 'Ubicación:*') !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-layer-group"></i>
                        </span>
                        {{-- Input editable solo para el nombre de la ubicación --}}
                        {!! Form::text('ubicacion', null, ['class' => 'form-control', 'placeholder'=>'Nombre de la ubicación','required'])!!}

                        <span class="input-group-addon">
                            _{{ $obra->codigo }}
                        </span>
                        {!! Form::hidden('obra_id', $obra->id) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal-footer">
      <button type="submit" class="tw-dw-btn tw-dw-btn-primary tw-text-white">@lang( 'messages.save' )</button>
      <button type="button" class="tw-dw-btn tw-dw-btn-neutral tw-text-white" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>
    {!! Form::close() !!}
  </div>
</div>