<?php

namespace App\Http\Controllers;

use App\Obra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $business_id = request()->session()->get('user.business_id');
        if(request()->ajax()){
            return datatables()->of(Obra::all())
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
                            $html .= '<li><a href="'.route('obras.ubicaciones.index', $row->id).'" class="add_obra_ubications_button">
                            <i class="glyphicon glyphicon-th-large"></i> Ubicaciones</a></li>';
                        }
                        if (auth()->user()->can('supplier.update')) {
                            $html .= '<li><a href="'.action([\App\Http\Controllers\ObraController::class, 'edit'], [$row->id]).'" class="edit_contact_button"><i class="glyphicon glyphicon-edit"></i>'.__('messages.edit').'</a></li>';
                        }
                        if (auth()->user()->can('supplier.delete')) {
                            $html .= '<li><a href="'.action([\App\Http\Controllers\ObraController::class, 'destroy'], [$row->id]).'" class="delete_obra_button"><i class="glyphicon glyphicon-trash"></i>'.__('messages.delete').'</a></li>';
                        }
                        return $html;
                    }
                )
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('obra.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('obra.create');
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
            'nombre' => 'required',
            'codigo' => 'required|unique:obras,codigo',
            // 'ubicacion' => 'nullable',
            // 'fecha_inicio' => 'nullable|date',
            // 'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);
        try {
            DB::beginTransaction();
            $obra = new Obra();
            $obra->nombre = $request->input('nombre');
            $obra->codigo = $request->input('codigo');
            //$obra->descripcion = $request->input('descripcion');
            // $obra->ubicacion = $request->input('ubicacion');
            // $obra->fecha_inicio = $request->input('fecha_inicio');
            // $obra->fecha_fin = $request->input('fecha_fin');
            $obra->save();
            DB::commit();
            $output = ['success' => true,
                'msg' => 'Obra creada exitosamente!',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $output = ['success' => false,
                'msg' => 'Error al crear la obra. Por favor intente de nuevo.',
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
    public function edit($id)
    {
        $obra = Obra::find($id);
        return view('obra.edit')
            ->with(compact('obra'))
            ->with('nombre', $obra->nombre)
            ->with('codigo', $obra->codigo);
            // ->with('ubicacion', $obra->ubicacion)
            // ->with('fecha_inicio', $obra->fecha_inicio)
            // ->with('fecha_fin', $obra->fecha_fin);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'codigo' => 'required|unique:obras,codigo,'.$id,
            // 'ubicacion' => 'nullable',
            // 'fecha_inicio' => 'nullable|date',
            // 'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);
        try {
            DB::beginTransaction();
            $obra = Obra::find($id);
            $obra->nombre = $request->input('nombre');
            $obra->codigo = $request->input('codigo');
            //$obra->descripcion = $request->input('descripcion');
            // $obra->ubicacion = $request->input('ubicacion');
            // $obra->fecha_inicio = $request->input('fecha_inicio');
            // $obra->fecha_fin = $request->input('fecha_fin');
            $obra->save();
            DB::commit();
            $output = ['success' => true,
                'msg' => 'Obra actualizada exitosamente!',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $output = ['success' => false,
                'msg' => 'Error al actualizar la obra. Por favor intente de nuevo.',
            ];
        }
        return $output;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $obra = Obra::find($id);
        if (empty($obra)) {
            $output = ['success' => false,
                'msg' => 'Obra no encontrada.',
            ];
        } else {
            try {
                $obra->delete();
                $output = ['success' => true,
                    'msg' => 'Obra eliminada exitosamente.',
                ];
            } catch (\Exception $e) {
                $output = ['success' => false,
                    'msg' => 'Error al eliminar la obra. Por favor intente de nuevo.',
                ];
            }
        }
        return $output;
    }
}
