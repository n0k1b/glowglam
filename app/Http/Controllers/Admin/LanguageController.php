<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
//JoeDixon
use JoeDixon\Translation\Drivers\Translation;

class LanguageController extends Controller
{
    private $translation;

    public function __construct(Translation $translation)
    {
        $this->translation = $translation;
    }

    public function index(Request $request)
    {
        if (auth()->user()->can('locale-view'))
        {
            App::setLocale(Session::get('currentLocal'));

            $languages = Language::orderBy('language_name','ASC')->get();

            return view('admin.pages.setting.language.index',compact('languages'));
        }
        return abort('403', __('You are not authorized'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->can('locale-store'))
        {
            if (env('USER_VERIFIED')!=1) {
                session()->flash('type','danger');
                session()->flash('message','Disabled for demo !');
                return redirect()->back();
            }


            $validator = Validator::make($request->only('language_name','local'),[
                'language_name' => 'required',
                'local'         => 'required|unique:languages',
            ]);

            if ($validator->fails()){
                session()->flash('type','danger');
                session()->flash('message','Something wrong');

                return redirect()->back()->withErrors($validator)->withInput();
            }

            $language = new Language();
            $language->language_name = htmlspecialchars($request->language_name);
            $language->local         = strtolower(htmlspecialchars(trim($request->local)));

            if (empty($request->default)) {
                $language->default   = 0;
            }
            else {

                Language::where('default', '=', 1)->update(['default' => 0]);

                $language->default       = $request->default;
            }

            $language->save();

            //New
            $this->translation->addLanguage($request->local, $request->language_name);

            session()->flash('type','success');
            session()->flash('message','Successfully Saved');
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        if (env('USER_VERIFIED')!=1) {
            session()->flash('type','danger');
            session()->flash('message','Disabled for demo !');
            return redirect()->back();
        }
        
        $language = Language::find($id);
        File::deleteDirectory('resources/lang/'.$language->local);
        $language->delete();

        session()->flash('type','success');
        session()->flash('message','Successfully Deleted');
        return redirect()->back();
    }

    public function update(Request $request)
    {
        if (env('USER_VERIFIED')!=1) {
            session()->flash('type','danger');
            session()->flash('message','Disabled for demo !');
            return redirect()->back();
        }


        if ($request->default) {
            Language::where('default',1)->update(['default'=>0]);
        }
        $language = Language::find($request->id);
        if ($language->local != $request->local) {
            $old_directory = 'resources/lang/'.$language->local;
            $new_directory = 'resources/lang/'.$request->local;
            File::copyDirectory($old_directory,$new_directory);
            File::deleteDirectory($old_directory);
        }
        $language->language_name = htmlspecialchars($request->language_name);
        $language->local         = strtolower(htmlspecialchars(trim($request->local)));
        $language->default       = $request->default ?? 0;
        $language->update();


        Session::put('currentLocal', $language->local);
        App::setLocale($language->local);

        session()->flash('type','success');
        session()->flash('message','Successfully Updated');
        return redirect()->back();
    }

    public function defaultChange($id)
    {
        Language::where('default',1)->update(['default'=>0]);

        $language = Language::find($id);
        $language->default = 1;
        $language->update();

        Session::put('currentLocal', $language->local);
        App::setLocale($language->local);

        session()->flash('type','success');
        session()->flash('message','Language Changed Successfully');
        return redirect()->back();
    }
}
