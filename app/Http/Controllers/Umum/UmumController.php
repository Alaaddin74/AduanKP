<?php

namespace App\Http\Controllers\Umum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Ticket;

class UmumController extends Controller
{
    /**
     * Dashboard pengguna umum: tampilkan daftar tiket berdasarkan email (tanpa login).
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $email = $request->input('email');

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

    public function create()
    {
        return view('users.lapor');
    }

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

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('attachments', 'public');
        }

        Ticket::create([
            'ticket_number' => 'TIC-' . strtoupper(Str::random(8)),
            'category'      => $request->keluhan,
            'priority'      => $request->prioritas,
            'site_link'     => $request->link,
            'faculty_name'  => $request->okupasi,
            'email'         => $request->email,
            'attachment'    => $lampiranPath,
            'status'        => 'submitted',
            'description'   => 'Laporan pengguna umum',
        ]);

        return redirect()->route('dashboard', ['email' => $request->email])
                         ->with('success', 'Laporan berhasil dikirim!');
    }
    /**
     * Edit tiket (opsional untuk pengguna umum jika diizinkan).
     */
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        return view('users.edit', compact('ticket'));
    }

    /**
     * Update tiket.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'keluhan'   => 'required|in:konten_tidak_pantas,menghapus_index,pornografi,judi_online,lainnya',
            'prioritas' => 'required|in:low,medium,high',
            'link'      => 'required|url',
            'okupasi'   => 'required|string|max:255',
            'email'     => 'required|email',
            'lampiran'  => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->category     = $request->keluhan;
        $ticket->priority     = $request->prioritas;
        $ticket->site_link    = $request->link;
        $ticket->faculty_name = $request->okupasi;
        $ticket->email        = $request->email;

        if ($request->hasFile('lampiran')) {
            if ($ticket->attachment) {
                Storage::disk('public')->delete($ticket->attachment);
            }
            $ticket->attachment = $request->file('lampiran')->store('attachments', 'public');
        }

        $ticket->save();

        return redirect()->route('dashboard', ['email' => $request->email])
                         ->with('success', 'Tiket berhasil diperbarui!');
    }

    /**
     * Hapus tiket.
     */
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);

        if ($ticket->attachment) {
            Storage::disk('public')->delete($ticket->attachment);
        }

        $ticket->delete();

        return redirect()->route('dashboard', ['email' => $ticket->email])
                         ->with('success', 'Tiket berhasil dihapus.');
    }
}
