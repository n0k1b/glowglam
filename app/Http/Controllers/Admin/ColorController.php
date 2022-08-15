<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    public function index()
    {
        if (auth()->user()->can('tag-view'))
        {
            App::setLocale(Session::get('currentLocal'));

            $colors = Color::get();

            if (request()->ajax())
            {
                return datatables()->of($colors)
                ->setRowId(function ($row){
                    return $row->id;
                })
                ->addColumn('action', function ($row)
                {
                    $actionBtn = "";
                    $actionBtn .= '<button type="button" title="Edit" class="edit btn btn-info btn-sm" data-id="'.$row->id.'"><i class="dripicons-pencil"></i></button>
                        &nbsp; ';
                    $actionBtn .= '<button type="button" title="Delete" class="delete btn btn-danger btn-sm" data-id="'.$row->id.'"><i class="dripicons-trash"></i></button>';

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
            return view('admin.pages.color.index');
        }
        return abort('403', __('You are not authorized'));
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->only('color_name','color_code'),[
                'color_name'  => 'required|unique:colors,color_name',
                'color_code'  => 'required|unique:colors,color_code',
            ]);

            if ($validator->fails()){
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $color  = new Color();
            $color->color_name = $request->color_name;
            $color->color_code = $request->color_code;
            $color->save();

            return response()->json(['success' => 'Data saved successfully']);
        }
    }

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            $color = Color::find($request->rowId);
            return response()->json(['color'=>$color]);
        }
    }

    public function update(Request $request){
        if ($request->ajax()) {

            $validator = Validator::make($request->only('color_name','color_code'),[
                'color_name'  => 'required|unique:colors,color_name,'.$request->color_id,
                'color_code'  => 'required|unique:colors,color_code,'.$request->color_id,
            ]);

            if ($validator->fails()){
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $color = Color::find($request->color_id);
            $color->color_name = $request->color_name;
            $color->color_code = $request->color_code;
            $color->update();

            return response()->json(['success' => 'Data Updated successfully']);
        }
    }

    public function delete(Request $request){
        if ($request->ajax()) {
            $color = Color::find($request->rowId);
            $color->delete();
            return response()->json(['success'=>'Data deleted successfully']);
        }
    }
}
