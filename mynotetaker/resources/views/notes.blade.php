<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager - Nhico Noel Ortazon</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .task-card { break-inside: avoid; border: 1px solid #e2e8f0 !important; box-shadow: none !important; margin-bottom: 1rem; }
            .print-header { display: block !important; }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen pb-20">
    <div class="max-w-4xl mx-auto px-6 py-12">
        <div class="hidden print-header text-center mb-10 border-b-2 border-slate-900 pb-6">
            <h1 class="text-3xl font-bold uppercase tracking-widest">Nhico Noel Ortazon Task Report</h1>
            <p class="text-slate-500 mt-2 italic">Official Activity Logs — Generated on {{ date('F d, Y') }}</p>
        </div>

        <header class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-6 no-print">
            <div>
                <h1 class="text-4xl font-extrabold tracking-tight text-slate-900">Task Center</h1>
                <p class="text-slate-500 mt-2">Welcome back, Nhico Noel Ortazon.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('notes.index', ['week' => 1]) }}" class="px-5 py-2.5 bg-white border rounded-2xl hover:bg-slate-100 font-semibold text-sm transition-all">This Week</a>
                <a href="{{ route('notes.export') }}" class="px-5 py-2.5 bg-slate-800 text-white rounded-2xl hover:bg-slate-700 font-semibold text-sm transition-all">CSV Export</a>
                <button onclick="window.print()" class="px-5 py-2.5 bg-indigo-600 text-white rounded-2xl hover:bg-indigo-700 font-semibold text-sm shadow-lg shadow-indigo-100 transition-all">Generate PDF</button>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10 no-print">
            <div class="bg-indigo-600 p-8 rounded-[2.5rem] text-white shadow-xl shadow-indigo-100 relative overflow-hidden">
                <p class="text-indigo-100 font-bold text-xs uppercase tracking-[0.2em]">Total Tasks This Week</p>
                <h2 class="text-6xl font-black mt-2 tracking-tighter">{{ $weekTotal }}</h2>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 flex flex-col justify-center">
                <p class="text-slate-400 text-sm font-medium italic">"Success is the sum of small efforts, repeated day in and day out."</p>
            </div>
        </div>

        <section class="no-print mb-12">
            <form action="{{ route('notes.store') }}" method="POST" class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                @csrf
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="title" placeholder="What is the task title?" class="w-full p-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-400 font-medium" required>
                        <input type="date" name="task_date" class="w-full p-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-400" required>
                    </div>
                    <textarea name="description" rows="3" placeholder="Add the ticket details..." class="w-full p-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-400"></textarea>
                    <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:scale-[1.01] transition-all">Add to Records</button>
                </div>
            </form>
        </section>

        <form action="{{ route('notes.massDelete') }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-between items-center mb-6 no-print px-2">
                <label class="flex items-center space-x-3 text-sm font-bold text-slate-500 cursor-pointer">
                    <input type="checkbox" onclick="toggleAll(this)" class="w-5 h-5 rounded-lg border-slate-300 text-indigo-600">
                    <span>Select All</span>
                </label>
                <button type="submit" onclick="return confirm('Delete selected?')" class="text-[10px] font-black text-red-400 uppercase tracking-widest">Bulk Delete</button>
            </div>

            <div class="space-y-4">
                @forelse($notes as $note)
                    <div class="task-card bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-start gap-5">
                        <input type="checkbox" name="ids[]" value="{{ $note->id }}" class="mt-2 w-5 h-5 rounded-lg border-slate-300 text-indigo-600 no-print">
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-xl font-bold text-slate-800 leading-none">{{ $note->title }}</h3>
                                    <p class="text-sm font-bold text-indigo-500 mt-2">{{ \Carbon\Carbon::parse($note->task_date)->format('l, F d, Y') }}</p>
                                </div>
                                <a href="{{ route('notes.edit', $note->id) }}" class="no-print p-2 bg-slate-50 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </a>
                            </div>
                            @if($note->description)
                                <div class="mt-4 p-4 bg-slate-50 rounded-2xl text-slate-600 text-sm border border-slate-100/50 italic">
                                    {{ $note->description }}
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 bg-white rounded-[3rem] border-2 border-dashed">
                        <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">No records</p>
                    </div>
                @endforelse
            </div>
        </form>
    </div>

    <script>
        function toggleAll(source) {
            const checkboxes = document.getElementsByName('ids[]');
            for(let i=0; i < checkboxes.length; i++) { checkboxes[i].checked = source.checked; }
        }
    </script>
</body>
</html>