<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $query = Note::query();
        
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Stats for the dashboard (always shows this week's count)
        $weekTotal = Note::whereBetween('task_date', [$startOfWeek, $endOfWeek])->count();

        // FILTER LOGIC
        // If 'filter' is 'all', show everything. 
        // Otherwise (default), show only this week.
        if ($request->get('filter') === 'all') {
            $notes = $query->orderBy('task_date', 'desc')->get();
            $currentFilter = 'all';
        } else {
            $notes = $query->whereBetween('task_date', [$startOfWeek, $endOfWeek])
                           ->orderBy('task_date', 'asc')
                           ->get();
            $currentFilter = 'week';
        }

        return view('notes', compact('notes', 'weekTotal', 'currentFilter'));
    }

    // ... (Keep your other store, edit, update, massDelete methods the same)


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'task_date' => 'required|date',
        ]);

        Note::create($validated);
        return back()->with('success', 'Task added!');
    }

    // NEW: Show the Edit Page
    public function edit($id)
    {
        $note = Note::findOrFail($id);
        return view('edit', compact('note'));
    }

    // NEW: Update the Data
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'task_date' => 'required|date',
        ]);

        $note = Note::findOrFail($id);
        $note->update($validated);

        return redirect()->route('notes.index')->with('success', 'Task updated!');
    }

    public function massDelete(Request $request)
    {
        if ($request->has('ids')) {
            Note::whereIn('id', $request->ids)->delete();
            return back()->with('success', 'Selected notes deleted.');
        }
        return back()->with('error', 'No notes selected.');
    }

    public function exportCsv()
    {
        $notes = Note::all();
        $fileName = 'Nhico_Noel_Ortazon_Report.csv';
        $headers = ["Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=$fileName"];
        $callback = function() use ($notes) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Title', 'Description', 'Due Date']);
            foreach ($notes as $note) {
                fputcsv($file, [$note->title, $note->description, $note->task_date]);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}