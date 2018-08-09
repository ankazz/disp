<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Task;
use App\TaskList;
use DB;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::with('causes','status')->orderBy("id", "DESC")->paginate(5);

        return response()->json($tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'Substation_ID' => 'required|numeric'
        ]);

        $task = new Task();

        $task->Substation_ID = $request->get('Substation_ID');
        $task->Cause_ID = 1;
        $task->Status_ID = 1;
        $task->ServiceObject_Name = $request->get('ServiceObject_Name');
        $task->save();

        for($i = 0; $i < count($request->selectedCells); $i++){
            $TaskList = new TaskList();
            $TaskList->task_id = $task->id;
            $TaskList->Conductor_ID = $request->selectedCells[$i];
            $TaskList->save();
        }

        return response()->json($task);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::with('TaskList')->find($id);

        return response()->json($task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $task = Task::find($id);
        $task->Substation_ID = $request->get('Substation_ID');
        $task->Cause_ID = 1;
        $task->Status_ID = 1;
        $task->ServiceObject_Name = $request->get('ServiceObject_Name');
        $task->update();

        TaskList::where('task_id', $task->id)->delete();
        for($i = 0; $i < count($request->selectedCells); $i++){
            $TaskList = new TaskList();
            $TaskList->task_id = $task->id;
            $TaskList->Conductor_ID = $request->selectedCells[$i];
            $TaskList->save();
        }

        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::find($id)->delete();
        TaskList::where('task_id', $id)->delete();

        return response()->json('User Deleted');
    }

    public function searchSub($q)
    {
        $subs = DB::connection('akteh')->table('vwSubstations')
        ->join('Ref_UnitTypes', 'Ref_UnitTypes.UnitType_Code', '=', 'vwSubstations.UnitType_Code')
        ->where('ServiceObject_Name','like', '%'.$q.'%')
        ->get();

        $res = [
            'total_count' => $subs->count(),
            'incomplete_results' => true,
            'items' => $subs
        ];
        
        return response()->json($res);  
    }

    public function getServiceObjects($id)
    {
        $subs = DB::connection('akteh')->table('vwBays')
        ->join('Terminals', 'vwBays.Bay_ID', '=', 'Terminals.Bay_ID')
        ->join('ServiceObjects', 'Terminals.Conductor_ID', '=', 'ServiceObjects.ServiceObject_ID')
        ->where('Substation_ID', $id)
        ->where('Terminal_Name', '!=', 'ВН')
        ->selectRaw("vwBays.Bay_ID,Terminals.Conductor_ID,vwBays.ServiceObject_Name Cell, ServiceObjects.ServiceObject_Name")
        ->get();
        
        return response()->json($subs);   
    }

    public function getLegals(Request $request)
    {
        $legals = DB::connection('akteh')->table('esPhoneNumber')
        ->whereIn('Conductor_ID', $request->selected_f)
        ->get();
        
        return response()->json($legals);   
    }
}
