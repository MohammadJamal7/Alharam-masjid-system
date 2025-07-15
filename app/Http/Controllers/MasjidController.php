<?php

namespace App\Http\Controllers;

use App\Models\Masjid;
use Illuminate\Http\Request;

class MasjidController extends Controller
{
    public function index()
    {
        $masjids = Masjid::all();
        return view('masjids.index', compact('masjids'));
    }

    public function create()
    {
        return view('masjids.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'total_area' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer',
            'gate_count' => 'nullable|integer',
            'wing_count' => 'nullable|integer',
            'prayer_hall_count' => 'nullable|integer',
            'tawaf_per_hour' => 'nullable|integer',
        ]);
        Masjid::create($validated);
        return redirect()->route('masjids.index')->with('success', 'تم إضافة المسجد بنجاح');
    }

    public function show(Masjid $masjid)
    {
        return view('masjids.show', compact('masjid'));
    }

    public function home(Masjid $masjid)
    {
        if (!$masjid) {
            abort(404, 'المسجد غير موجود');
        }
        $programs = $masjid->programs()->latest()->get();
        $announcements = $masjid->announcements()->latest()->get();
        $announcementsArray = $announcements->map(function($a) {
            return [
                'content' => $a->content,
                'is_urgent' => $a->is_urgent,
                'start' => $a->display_start_at,
                'end' => $a->display_end_at,
            ];
        })->values()->all();
        return view('masjids.home', compact('masjid', 'programs', 'announcements', 'announcementsArray'));
    }

    public function display(Request $request, Masjid $masjid)
    {
        if (!$masjid) {
            abort(404, 'المسجد غير موجود');
        }
        $type = $request->query('type');
        $filters = $request->except(['type']);
        $query = $masjid->programs()->latest();

        if ($type === 'scientific') {
            $query->where('program_type', 'درس علمي');
        } elseif ($type === 'halaqat') {
            $query->where('program_type', 'حلقة تحفيظ');
        } elseif ($type === 'imama') {
            $query->where('program_type', 'إمامة');
        }
        // (Optionally: apply more filters here)

        $programs = $query->get();
        $announcements = $masjid->announcements()->latest()->get();
        $announcementsArray = $announcements->map(function($a) {
            return [
                'content' => $a->content,
                'is_urgent' => $a->is_urgent,
                'start' => $a->display_start_at,
                'end' => $a->display_end_at,
            ];
        })->values()->all();
        return view('masjids.display', compact('masjid', 'programs', 'announcements', 'announcementsArray', 'type', 'filters'));
    }

    public function filterScientific(Request $request, Masjid $masjid)
    {
        $query = $masjid->programs()->where('program_type', 'درس علمي');
        if ($request->filled('field')) $query->where('field', $request->field);
        if ($request->filled('specialty')) $query->where('specialty', $request->specialty);
        if ($request->filled('teacher')) $query->where('teacher', 'like', '%'.$request->teacher.'%');
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('date')) $query->whereDate('date', $request->date);
        $programs = $query->latest()->get();
        return view('masjids.partials.table_scientific_rows', compact('programs'))->render();
    }
    public function filterHalaqat(Request $request, Masjid $masjid)
    {
        $query = $masjid->programs()->where('program_type', 'حلقة تحفيظ');
        if ($request->filled('instructor')) $query->where('instructor', 'like', '%'.$request->instructor.'%');
        if ($request->filled('group')) $query->where('group', $request->group);
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('date')) $query->whereDate('date', $request->date);
        $programs = $query->latest()->get();
        return view('masjids.partials.table_halaqat_rows', compact('programs'))->render();
    }
    public function filterImama(Request $request, Masjid $masjid)
    {
        $query = $masjid->programs()->where('program_type', 'إمامة');
        if ($request->filled('imam')) {
            $imam = $request->imam;
            $query->where(function($q) use ($imam) {
                $q->where('imam_fajr', 'like', "%$imam%")
                  ->orWhere('imam_dhuhr', 'like', "%$imam%")
                  ->orWhere('imam_asr', 'like', "%$imam%")
                  ->orWhere('imam_maghrib', 'like', "%$imam%")
                  ->orWhere('imam_isha', 'like', "%$imam%") ;
            });
        }
        if ($request->filled('prayer')) {
            $prayer = $request->prayer;
            $imamField = null;
            if ($prayer === 'fajr') $imamField = 'imam_fajr';
            if ($prayer === 'dhuhr') $imamField = 'imam_dhuhr';
            if ($prayer === 'asr') $imamField = 'imam_asr';
            if ($prayer === 'maghrib') $imamField = 'imam_maghrib';
            if ($prayer === 'isha') $imamField = 'imam_isha';
            if ($imamField) $query->whereNotNull($imamField)->where($imamField, '!=', '');
        }
        if ($request->filled('day')) $query->where('day', $request->day);
        if ($request->filled('date')) $query->whereDate('date', $request->date);
        $programs = $query->latest()->get();
        return view('masjids.partials.table_imama_rows', compact('programs'))->render();
    }

    public function filterAll(Request $request, Masjid $masjid)
    {
        $query = $masjid->programs();
        
        // Search across all fields
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('book', 'like', '%'.$search.'%')
                  ->orWhere('field', 'like', '%'.$search.'%')
                  ->orWhere('specialty', 'like', '%'.$search.'%')
                  ->orWhere('teacher', 'like', '%'.$search.'%')
                  ->orWhere('instructor', 'like', '%'.$search.'%')
                  ->orWhere('imam_name', 'like', '%'.$search.'%')
                  ->orWhere('status', 'like', '%'.$search.'%')
                  ->orWhere('program_type', 'like', '%'.$search.'%');
            });
        }
        
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }
        
        $programs = $query->latest()->get();
        return view('masjids.partials.table_all_rows', compact('programs'))->render();
    }

    // Add edit method
    public function edit(Masjid $masjid)
    {
        return view('masjids.edit', compact('masjid'));
    }

    // Add update method
    public function update(Request $request, Masjid $masjid)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'total_area' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer',
            'gate_count' => 'nullable|integer',
            'wing_count' => 'nullable|integer',
            'prayer_hall_count' => 'nullable|integer',
            'tawaf_per_hour' => 'nullable|integer',
        ]);
        $masjid->update($validated);
        return redirect()->route('masjids.index')->with('success', 'تم تحديث المسجد بنجاح');
    }

    // Add destroy method
    public function destroy(Masjid $masjid)
    {
        // Prevent deleting the first two masjids (by id ascending)
        $firstTwoIds = Masjid::orderBy('id')->limit(2)->pluck('id')->toArray();
        if (in_array($masjid->id, $firstTwoIds)) {
            return redirect()->route('masjids.index')->with('error', 'لا يمكن حذف المسجدين الأولين.');
        }
        $masjid->delete();
        return redirect()->route('masjids.index')->with('success', 'تم حذف المسجد بنجاح');
    }
} 