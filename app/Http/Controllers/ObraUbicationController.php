<?php

namespace App\Http\Controllers;

use App\Obra;
use App\ObraUbication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObraUbicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($obra_id)
    {   
        $obra = Obra::find($obra_id);
        if(request()->ajax()){
            return datatables()->of(ObraUbication::where('obra_id', $obra_id)->get())
                ->addColumn(
                    'action',
                    function ($row) {
                        $html = '<div class="btn-group">
                        <button type="button" class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline  tw-dw-btn-info tw-w-max  dropdown-toggle" 
                            data-toggle="dropdown" aria-expanded="false">'.
                            __('messages.actions').
                            '<span class="caret"></span><span class="sr-only">Toggle Dropdown
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-left" role="menu">';

                        /* if (auth()->user()->can('supplier.view') || auth()->user()->can('supplier.view_own')) {
                            $html .= '<li><a href="'.action([\App\Http\Controllers\ObraController::class, 'show'], [$row->id]).'"><i class="fas fa-eye" aria-hidden="true"></i>'.__('messages.view').'</a></li>';
                        } */
                        if (auth()->user()->can('supplier.update')) {
                            $html .= '<li>
                                <a href="' . action(
                                    [\App\Http\Controllers\ObraUbicationController::class, 'edit'], 
                                    [$row->obra_id, $row->id] 
                                ) . '" 
                                class="edit_contact_button">
                                    <i class="glyphicon glyphicon-edit"></i>'.__('messages.edit').'
                                </a>
                            </li>';
                        }
                        if (auth()->user()->can('supplier.delete')) {
                            $html .= '<li><a href="'.action([\App\Http\Controllers\ObraUbicationController::class, 'destroy'], [$row->obra_id, $row->id]).'" class="delete_obra_button"><i class="glyphicon glyphicon-trash"></i>'.__('messages.delete').'</a></li>';
                        }
                        return $html;
                    }
                )
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('obra_ubication.index')->with(compact('obra'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('obra_ubication.create')->with(['obra' => Obra::find($id)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'ubicacion' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $obra_ubicacion = new ObraUbication();
            $obra_ubicacion->ubicacion = $request->input('ubicacion');
            $obra_ubicacion->obra_id = $request->input('obra_id');
            $obra_ubicacion->save();
            DB::commit();
            $output = ['success' => true,
                'msg' => 'Ubicacion creada exitosamente!',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $output = ['success' => false,
                'msg' => 'Error al crear la ubicacion. Por favor intente de nuevo.',
            ];
        }
        return $output;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($obra_id, $id)
    {   
        //dump($obra_id);
        $obra_ubicacion = ObraUbication::find($id);
        $ubicacion = $obra_ubicacion->ubicacion;
        return view('obra_ubication.edit')->with(compact('obra_ubicacion', 'ubicacion', 'obra_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $obra_id, $id)
    {
        //return $output = ['success' => false, 'msg' => $id ];
        try {
            $request->validate([
                'ubicacion' => 'required|string|max:50',
                'obra_id' => 'required|exists:obras,id'
            ]);

            $ubicacion = ObraUbication::find($id);

            $ubicacion->update([
                'ubicacion' => $request->ubicacion,
                'obra_id' => $request->obra_id,
            ]);

            $output = ['success' => true, 'msg' => 'Ubicacion editada exitosamente!', ];
        } catch (\Exception $e) {
            $output = ['success' => false, 'msg' => 'Error al editar la ubicacion. Por favor intente de nuevo.', ];
        }
        return $output;
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($obra_id, $id)
    {
        try {
            ObraUbication::find($id)->delete();
            $output = ['success' => true,
                'msg' => 'Ubicacion eliminada exitosamente!',
            ];
        } catch (\Exception $e) {
            $output = ['success' => false,
                'msg' => 'Error al eliminar la ubicacion. Por favor intente de nuevo.',
            ];
        }
        return $output;
    }
}
