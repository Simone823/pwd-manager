<?php

namespace App\Http\Controllers;

use App\LogActivity;
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
        $this->middleware('hasRole:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // aggiungo il log attività
        LogActivity::addLog('Lista Log Attività');

        // recupero tutti i log dal db
        $logActivities = LogActivity::orderBy('created_at', 'desc')->paginate(10);

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
        // recupero il log by id
        $logActivity = LogActivity::find($id);

        // delete log
        $logActivity->delete();

        return redirect()->route('log-activities.index')->with('success', "Il Log Attività con Azione: {$logActivity->action}, IP: {$logActivity->ip} è stato eliminato.");
    }
}
