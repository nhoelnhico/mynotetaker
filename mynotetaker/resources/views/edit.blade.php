<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Task - Nhico Noel Ortazon</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">
    <div class="max-w-xl w-full">
        <div class="bg-white p-10 rounded-[3rem] shadow-xl border border-slate-100">
            <div class="mb-8">
                <h1 class="text-3xl font-black text-slate-900">Edit Task</h1>
                <p class="text-slate-500">Update the details for this record.</p>
            </div>

            <form action="{{ route('notes.update', $note->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Task Title</label>
                    <input type="text" name="title" value="{{ $note->title }}" class="w-full p-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-400 font-semibold" required>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Date</label>
                    <input type="date" name="task_date" value="{{ $note->task_date }}" class="w-full p-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-400" required>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Description</label>
                    <textarea name="description" rows="4" class="w-full p-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-400">{{ $note->description }}</textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <a href="{{ route('notes.index') }}" class="flex-1 py-4 bg-slate-100 text-slate-600 rounded-2xl font-bold text-center hover:bg-slate-200 transition-all">Cancel</a>
                    <button type="submit" class="flex-[2] py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>