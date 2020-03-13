<?php

namespace App\Http\Controllers;
use App\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Note::orderBy('created_at','DESC')->get();
        return view('notes.index',compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(strtolower($request->dataid)=='_new')
        {
            $newnote = new Note;
            $newnote->content = urldecode($request->get('content'));
            $newnote->created_by = 1;
            $newnote->title = urldecode($request->get("title"));
            $newnote->save();
        }
        else
        {
            $newnote = Note::find(decrypt($request->dataid));
            $newnote->content = urldecode($request->get('content'));
            $newnote->title = urldecode($request->get("title"));
            $newnote->save();
        }

        return response()->json(['dataid'=> encrypt($newnote->id)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $newnote = Note::find(decrypt($id));
        return response()->json(['dataid'=> encrypt($newnote->id),'content'=>$newnote->content,'title'=>$newnote->title]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
