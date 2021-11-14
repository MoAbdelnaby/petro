<?php

namespace App\Http\Controllers\Setting;

use App\Datatables\Datatable;
use App\Http\Controllers\Controller;
use App\Language;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LanguageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-languages|edit-languages|delete-languages|create-languages', ['only' => ['index', 'store']]);
        $this->middleware('permission:create-languages', ['only' => ['store']]);
        $this->middleware('permission:edit-languages', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-languages', ['only' => ['destroy', 'delete_all']]);
    }

    public function data()
    {
        return Datatable::datatable(Language::all());
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('settings.languages.index');
    }

    public function store(Request $request)
    {
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:languages',
                'code' => 'required|unique:languages',
                'direction' => 'required',
                'flag' => 'required|string',
            ]);
            if ($validator->errors()->count()) {
                return response()->json(['errors' => $validator->errors()], 500);
            }
            Language::create([
                'name' => $request->name,
                'code' => $request->code,
                'direction' => $request->direction,
                'flag' => $request->flag,
                'user_id' => Auth::user()->id,
            ]);

            session()->put('success', __('app.languages.success_message'));
            return response()->json(['success' => 'Done']);
        }
    }

    public function edit(Request $request)
    {
        $language = Language::where('id', $request->id)->first();
        if ($language)
            return $language;
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:languages,name,' . $request->id,
            'code' => 'required',
            'direction' => 'required',
            'flag' => 'required|string',
        ]);

        if ($validator->errors()->count()) {
            return response()->json(['errors' => $validator->errors()], 500);
        }

        $languages = Language::where('id', $request->id)->first();
        if ($languages)
            $languages->update([
                'name' => $request->name,
                'code' => $request->code,
                'direction' => $request->direction,
                'flag' => $request->flag,
                'user_id' => Auth::user()->id,
            ]);
        session()->put('success', __('app.languages.success_message'));
        return response()->json(['success' => 'Done']);
    }

    public function destroy(Request $request)
    {
        $language = Language::where('id', $request->id)->first();
        if ($language) {
            $language->delete();
        }

        session()->put('success', __('app.languages.success_message'));
        return response()->json(['success' => 'Done']);
    }

    public function delete_all(Request $request)
    {
        foreach ($request->ids as $id) {
            $language = Language::where('id', $id)->first();
            if ($language) {
                $language->delete();
            }
        }

        session()->put('success', __('app.languages.delete_success_message'));
        return response()->json(['message' => "success"]);
    }

}
