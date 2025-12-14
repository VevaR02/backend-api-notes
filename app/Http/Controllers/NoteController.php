<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function store(Request $request)
    {
        try {
            $note = Note::create([
                'title' => $request->title,
                'body' => $request->body,
                'owner_id' => Auth::id(),
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $note
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 500);
        }
    }

    public function index()
    {
        $notes = Note::where('owner_id', Auth::id())
                     ->where('archived', false)
                     ->get();

        return response()->json(['status' => 'success', 'data' => $notes]);
    }

    public function archived()
    {
        $notes = Note::where('owner_id', Auth::id())
                     ->where('archived', true)
                     ->get();

        return response()->json(['status' => 'success', 'data' => $notes]);
    }

    public function show($id)
    {
        $note = Note::where('id', $id)->where('owner_id', Auth::id())->first();

        if ($note) {
            return response()->json(['status' => 'success', 'data' => $note]);
        }
        return response()->json(['status' => 'fail', 'message' => 'Note tidak ditemukan'], 404);
    }

    public function archiveNote($id)
    {
        $note = Note::where('id', $id)->where('owner_id', Auth::id())->first();
        if ($note) {
            $note->update(['archived' => true]);
            return response()->json(['status' => 'success', 'message' => 'Note archived']);
        }
        return response()->json(['status' => 'fail', 'message' => 'Note tidak ditemukan'], 404);
    }

    public function unarchiveNote($id)
    {
        $note = Note::where('id', $id)->where('owner_id', Auth::id())->first();
        if ($note) {
            $note->update(['archived' => false]);
            return response()->json(['status' => 'success', 'message' => 'Note unarchived']);
        }
        return response()->json(['status' => 'fail', 'message' => 'Note tidak ditemukan'], 404);
    }

    public function destroy($id)
    {
        $deleted = Note::where('id', $id)->where('owner_id', Auth::id())->delete();
        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => 'Note deleted']);
        }
        return response()->json(['status' => 'fail', 'message' => 'Note tidak ditemukan'], 404);
    }
}