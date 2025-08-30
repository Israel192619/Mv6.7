<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    @php
        $url = action([\App\Http\Controllers\ObraController::class, 'store']);
    @endphp
    {!! Form::open(['url' => $url, 'method' => 'post', 'id' => 'obra_form' ]) !!}
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">Agregar nueva Obra</h4>
    </div>
    <div class="modal-body">
        <div class="row">            
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('nombre', 'Nombre de Obra' . ':*' ) !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-building"></i>
                        </span>
                        {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder'=>'Nombre de obra','required'])!!}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('Codigo', 'Codigo/Nombre-Corto' . ':*' ) !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-tag"></i>
                        </span>
                        {!! Form::text('codigo', null, ['class' => 'form-control', 'placeholder'=>'Codigo/Nombre-corto','required'])!!}
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