<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ClientManagement;
use Illuminate\Support\Facades\Auth;

class ClientManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
                        // default to today's date
                        $from = Carbon::now()->format('Y-m-d') . ' 00:00:00';
                        $to = Carbon::now()->format('Y-m-d') . ' 23:59:59';
                
                        if($request->has('daterange')) {
                            $date = explode(' - ',$request->daterange);
                            $from = date('Y-m-d', strtotime($date[0])) . ' 00:00:00';                                                                                                                                                      
                            $to = date('Y-m-d', strtotime($date[1])) . ' 23:59:59';
                        } 
                
                        $clients = ClientManagement::with('status')
                                            ->whereBetween('created_at', [$from, $to])
                                            ->whereIn('status_id', [8,9])
                                            ->whereDeleted(false)
                                            ->orderByDesc('id')
                                            ->get();
                
                        return view('ClientManagement.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $exist = ClientManagement::whereName($request->name)->whereDeleted(false)->first();
        if(!$exist) {
            $client = new ClientManagement();
            $client->uuid = Str::uuid();
            $client->name = $request->name;
            $client->description = $request->description;
            $client->created_by = Auth::user()->name;
            $client->save();
            return redirect()->back()->with('success', 'New Client has been created!');
        } else {
            return redirect()->back()->with('error', 'Client already exists!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClientManagement $clientManagement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $client = ClientManagement::whereUuid($uuid)->whereDeleted(false)->firstOrFail();
        $client->name = $request->name;
        $client->description = $request->description;
        $client->status_id = $request->status;
        $client->remarks = $request->remarks;
        $client->updated_by = Auth::user()->name;
        $client->update();

        return redirect('client-management')->with('success', 'Client has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClientManagement $clientManagement)
    {
        //
    }
}
