<?php

namespace App\Http\Controllers;

use App\Models\Inote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InoteController extends Controller
{
    public function store(Request $request)
    {   
        $validator =  Validator::make($request->all(),[
            'title' => 'required',
            'content' => 'required',
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->errors()->first(),
            ]);
        }else{
            $note = new Inote();
            $note->title = $request->input('title');
            $note->content = $request->input('content');
            

            if ($request->hasFile('image')) {
                
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time(). '.' .$extension;
                $file->move('uploads/note/',$filename);
                $note->image = $filename;
            }
            $note->save();
            return response()->json([
                'status'=>200,
                'message'=>'Note Image Data Added Successfully'
            ]);
        }
    }

    public function getNoteById($id)
    {
        $note = Inote::findOrFail($id);
        return response()->json($note);
    }

    public function destroy($id)
    {
        $note = Inote::findOrFail($id);
        $note->delete();
        return response()->json(['success'=>'Record has been deleted']);
    }
} 

