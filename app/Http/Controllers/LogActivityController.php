<?php

namespace App\Http\Controllers;

use App\LogActivity;
use Auth;
use Illuminate\Http\Request;

class LogActivityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->isAdmin()) {
            abort(401);
        }

        // recupero i log
        $logActivities = LogActivity::sortable(['created_at' => 'desc'])->paginate(config('app.default_paginate'));

        return view('logActivities.index', compact('logActivities'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(401);
        }

        // elimino il log
        $logActivity = LogActivity::find($id);
        $logActivity->delete();

        return redirect()->back()->with('success', "Il Log Attività con Azione: {$logActivity->action}, IP: {$logActivity->ip} è stato eliminato.");
    }

    /**
     * Remove selected record
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteSelected(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(401);
        }

        // controllo se esiste almeno un id
        if(count($request->idsRecord) == 0) {
            return response()->json([
                'status' => 400,
                'message' => 'There are no selected record ids'
            ], 400);
        }
        
        // elimino tutt i log aventi gli id della request
        $logs = LogActivity::whereIn('id', $request->idsRecord)->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Selected Activity logs have been deleted.'
        ], 200);
    }
}