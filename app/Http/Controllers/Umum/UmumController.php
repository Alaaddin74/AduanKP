<?php

namespace App\Http\Controllers\Umum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Ticket;
use App\Models\Faculty;

class UmumController extends Controller
{
    /**
     * Tampilkan dashboard pengguna umum berdasarkan email dan/atau pencarian.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $email  = $request->input('email');

        $tickets = Ticket::with(['assignment', 'faculty'])
            ->when($email, fn($q) => $q->where('email', $email))
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('ticket_number', 'like', "%$search%")
                        ->orWhere('category', 'like', "%$search%")
                        ->orWhere('status', 'like', "%$search%")
                        ->orWhere('priority', 'like', "%$search%");
                });
            })
            ->latest()
            ->get();

        return view('users.dashboard', compact('tickets', 'search', 'email'));
    }

    /**
     * Tampilkan form laporan untuk pengguna umum.
     */
    public function create()
    {
        $faculties = Faculty::all();
        return view('users.lapor', compact('faculties'));
    }

    /**
     * Simpan laporan pengguna ke database.
     */
    public function store(Request $request)
{
    $request->validate([
        'keluhan'     => 'required|in:konten_tidak_pantas,menghapus_index,pornografi,judi_online,lainnya',
        'prioritas'   => 'required|in:low,medium,high',
        'link'        => 'required|url',
        'okupasi'     => 'required|string',
        'email'       => 'nullable|email',
        'description' => 'required|string|max:1000',
        'lampiran'    => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
    ]);

    $facultyId = null;
    $facultyName = $request->okupasi;

    if ($facultyName === 'lainnya') {
        $request->validate(['okupasi_lainnya' => 'required|string|max:255']);
        $facultyName = $request->okupasi_lainnya;
    } else {
        // cari faculty_id berdasarkan nama fakultas yang dipilih
        $faculty = Faculty::where('name', $facultyName)->first();
        if ($faculty) {
            $facultyId = $faculty->id;
        }
    }


    // Simpan lampiran
    $lampiranPath = null;
if ($request->hasFile('lampiran') && $request->file('lampiran')->isValid()) {
    $file = $request->file('lampiran');
    $filename = time() . '_' . $file->getClientOriginalName();
    $file->move(public_path('attachments'), $filename);
    // jika ingin menyimpan di storage saat meggunakan cpanel
    // $destinationPath = base_path('../public_html/attachments');
    // $file->move($destinationPath, $filename);
    $lampiranPath =  $filename;
}

    // Simpan ke database
    $ticket = Ticket::create([
        'ticket_number' => 'TIC-' . strtoupper(Str::random(8)),
        'category'      => $request->keluhan,
        'priority'      => $request->prioritas,
        'site_link'     => $request->link,
        'faculty_id'    => $facultyId,
        'faculty_name'  => $facultyName,
        'email'         => $request->email,
        'attachment'    => $lampiranPath,
        'status'        => 'submitted',
        'description'   => $request->description,
    ]);

    return redirect()->route('user.dashboard', ['email' => $ticket->email])
                     ->with('success', 'Laporan berhasil dikirim!');
}
}
