<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JoeDixon\Translation\Drivers\Translation;

class LocaleFileController extends Controller
{
    private $translation;

    public function __construct(Translation $translation)
    {
        $this->translation = $translation;
    }

    public function update(Request $request)
    {
        if ($request->get('group')) {
            $this->translation->addGroupTranslation($request->language, $request->get('group'), $request->get('key'), $request->get('value'));
        } else {
            $this->translation->addSingleTranslation($request->language, $request->get('group'), $request->get('key'), $request->get('value'));
        }

        return response()->json('ok');
    }
}
