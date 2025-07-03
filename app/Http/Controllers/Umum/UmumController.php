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
     * Tampilkan dashboard berdasarkan email dan/atau kata kunci pencarian.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $email  = $request->input('email');

        $tickets = Ticket::with('assignment')
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
     * Tampilkan form laporan dari pengguna umum.
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
            'keluhan'   => 'required|in:konten_tidak_pantas,menghapus_index,pornografi,judi_online,lainnya',
            'prioritas' => 'required|in:low,medium,high',
            'link'      => 'required|url',
            'okupasi'   => 'required|string|max:255',
            'email'     => 'required|email',
            'lampiran'  => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Jika pilih "lainnya", gunakan input manual
        $facultyName = $request->okupasi;
        if ($facultyName === 'lainnya') {
            $request->validate([
                'okupasi_lainnya' => 'required|string|max:255',
            ]);
            $facultyName = $request->okupasi_lainnya;
        }

        // Upload lampiran jika tersedia
        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('attachments', 'public');
        }

        // Simpan ke database
        Ticket::create([
            'ticket_number' => 'TIC-' . strtoupper(Str::random(8)),
            'category'      => $request->keluhan,
            'priority'      => $request->prioritas,
            'site_link'     => $request->link,
            'faculty_name'  => $facultyName,
            'email'         => $request->email,
            'attachment'    => $lampiranPath,
            'status'        => 'submitted',
            'description'   => 'Laporan pengguna umum',
        ]);

        return redirect()->route('dashboard', ['email' => $request->email])
                         ->with('success', 'Laporan berhasil dikirim!');
    }

    /**
     * Hapus laporan dan lampiran berdasarkan ID.
     */
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);

        // Hapus file jika ada
        if ($ticket->attachment) {
            Storage::disk('public')->delete($ticket->attachment);
        }

        $ticket->delete();

        return redirect()->route('dashboard', ['email' => $ticket->email])
                         ->with('success', 'Tiket berhasil dihapus.');
    }
}
