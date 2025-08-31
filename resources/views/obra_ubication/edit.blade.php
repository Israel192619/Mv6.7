<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    @php
        $url = action([\App\Http\Controllers\ObraUbicationController::class, 'update'], [$obra_id, $obra_ubicacion->id]);
    @endphp
    {!! Form::open(['url' => $url, 'method' => 'PUT', 'id' => 'obra_form' ]) !!}
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">Editar Ubicacion</h4>
    </div>
    <div class="modal-body">
        <div class="row">            
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('ubicacion', 'Ubicacion' . ':*' ) !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-building"></i>
                        </span>
                        {!! Form::text('ubicacion', $ubicacion, ['class' => 'form-control', 'placeholder'=>'Nombre de ubicacion','required'])!!}
                        <span class="input-group-addon">
                            _{{ $obra->codigo }}
                        </span>
                    </div>
                    {!! Form::hidden('obra_id', $obra_ubicacion->obra_id) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
      <button type="submit" class="tw-dw-btn tw-dw-btn-primary tw-text-white">Editar</button>
      <button type="button" class="tw-dw-btn tw-dw-btn-neutral tw-text-white" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}
  </div>
</div>