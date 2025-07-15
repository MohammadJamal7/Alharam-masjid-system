<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Masjid;
use App\Models\Location;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(Masjid $masjid)
    {
        $programs = $masjid->programs()->latest()->get();
        return view('programs.index', compact('masjid', 'programs'));
    }

    public function create(Masjid $masjid)
    {
        $programTypes = [
            'درس علمي' => 'درس علمي',
            'حلقة تحفيظ' => 'حلقة تحفيظ',
            'إمامة' => 'إمامة',
        ];
        $locations = Location::all();
        return view('programs.create', compact('masjid', 'programTypes', 'locations'));
    }

    public function store(Request $request, Masjid $masjid)
    {
        $validated = $request->validate([
            'program_type' => 'required|string',
            'name' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:255',
            'location_id' => 'nullable|exists:locations,id',
            'attendance_type' => 'nullable|string|max:255',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'notes' => 'nullable|string',
            // Type-specific fields will be validated in the view via JS
        ]);
        $validated['masjid_id'] = $masjid->id;
        // Save location detail as array
        $locationDetail = $request->input('location_detail', []);
        $validated['location'] = (array) $locationDetail;
        Program::create($validated + $request->only([
            'field','specialty','book','teacher','teacher_link',
            'group','instructor','instructor_link',
            'imam_name','day','date',
            'imam_fajr','imam_dhuhr','imam_asr','imam_maghrib','imam_isha',
            'adhan_fajr','iqama_fajr','adhan_dhuhr','iqama_dhuhr','adhan_asr','iqama_asr','adhan_maghrib','iqama_maghrib','adhan_isha','iqama_isha',
        ]));
        return redirect()->route('masjids.programs.index', $masjid)->with('success', 'تم إضافة البرنامج بنجاح');
    }

    public function edit(Masjid $masjid, Program $program)
    {
        if ($program->masjid_id !== $masjid->id) {
            abort(404, 'البرنامج لا ينتمي لهذا المسجد');
        }
        $programTypes = [
            'درس علمي' => 'درس علمي',
            'حلقة تحفيظ' => 'حلقة تحفيظ',
            'إمامة' => 'إمامة',
        ];
        $locations = Location::all();
        return view('programs.edit', compact('masjid', 'program', 'programTypes', 'locations'));
    }

    public function update(Request $request, Masjid $masjid, Program $program)
    {
        $validated = $request->validate([
            'program_type' => 'required|string',
            'name' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:255',
            'location_id' => 'nullable|exists:locations,id',
            'attendance_type' => 'nullable|string|max:255',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'notes' => 'nullable|string',
        ]);
        $validated['masjid_id'] = $masjid->id;
        $locationDetail = $request->input('location_detail', []);
        $validated['location'] = (array) $locationDetail;
        $program->update($validated + $request->only([
            'field','specialty','book','teacher','teacher_link',
            'group','instructor','instructor_link',
            'imam_name','day','date',
            'imam_fajr','imam_dhuhr','imam_asr','imam_maghrib','imam_isha',
            'adhan_fajr','iqama_fajr','adhan_dhuhr','iqama_dhuhr','adhan_asr','iqama_asr','adhan_maghrib','iqama_maghrib','adhan_isha','iqama_isha',
        ]));
        return redirect()->route('masjids.programs.index', $masjid)->with('success', 'تم تحديث البرنامج بنجاح');
    }

    public function destroy(Masjid $masjid, Program $program)
    {
        $program->delete();
        return redirect()->route('masjids.programs.index', $masjid)->with('success', 'تم حذف البرنامج بنجاح');
    }
} 