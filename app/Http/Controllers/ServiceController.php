<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::where('user_id', auth()->id())->get();

        return view('customer.service.index', [
            'services' => $services,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.service.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'image' => 'mimes:jpg,jpeg,png',
        ]);

        $data['user_id'] = auth()->id();
        if ($request->has('image')) {
            $data['image'] = Storage::disk('uploads')->put('service', $request->image);
        }

        Service::create($data);

        return redirect()->route('service.index')->with('success', 'Service has been created successfully');
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
        try {
            $service = Service::where('user_id', auth()->id())->findOrFail($id);
        } catch (\Throwable $th) {
            return back()->with('danger', 'Service not found');
        }

        return view('customer.service.edit', [
            'service' => $service,
        ]);
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
        $data = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'image' => 'mimes:jpg,jpeg,png',
        ]);

        try {
            $service = Service::where('user_id', auth()->id())->findOrFail($id);
        } catch (\Throwable $th) {
            return back()->with('danger', 'Service not found');
        }

        if ($request->has('image')) {
            $data['image'] = Storage::disk('uploads')->put('service', $request->image);
            Storage::disk('uploads')->delete($service->image);
        }

        $service->update($data);

        return redirect()->route('service.index')->with('success', 'Service has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $services = Service::where('user_id', auth()->id())->findOrFail($id);
        } catch (\Throwable $th) {
            return back()->with('danger', 'Service not found');
        }

        $services->delete();

        return back()->with('success', 'Service has been deleted successfully');

    }
}
