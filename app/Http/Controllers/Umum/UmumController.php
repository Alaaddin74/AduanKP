<?php

namespace App\Http\Controllers\Umum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Ticket;
use App\Models\Faculty;
use App\Mail\TicketCreated;
use Illuminate\Support\Facades\Mail;

class UmumController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $email  = $request->input('email');

        $tickets = Ticket::with(['assignment', 'faculty'])
            ->when($email, function ($q) use ($email) {
                $q->where('email', $email);
            })
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('ticket_number', 'like', "%$search%")
                        ->orWhere('category', 'like', "%$search%")
                        ->orWhere('status', 'like', "%$search%");
                });
            })
            ->latest()
            ->get();

        return view('users.dashboard', compact('tickets', 'search', 'email'));
    }

    public function create()
    {
        $faculties = Faculty::all();
        return view('users.lapor', compact('faculties'));
    }

    public function store(Request $request)
    {
       $request->validate([
    'name'        => 'required|string|max:255',
    'phone_number'=> 'nullable|string|max:20',
    'category'     => 'required|in:konten_tidak_pantas,menghapus_index,pornografi,judi_online,lainnya',
    'link'        => 'required|url',
    'okupasi'     => 'required|string',
    'email'       => 'nullable|email',
    'description' => 'required|string|max:1000',
    'lampiran'    => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
    'g-recaptcha-response' => ['required', function ($attribute, $value, $fail) {
        $secret = env('NOCAPTCHA_SECRET');
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret,
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

        if (! $response->json('success')) {
            $fail('Verifikasi CAPTCHA gagal. Silakan coba lagi.');
        }
    }],
]);

        $facultyId = null;
        $facultyName = $request->okupasi;

        if ($facultyName === 'lainnya') {
            $request->validate([
                'okupasi_lainnya' => 'required|string|max:255',
            ]);
            $facultyName = $request->okupasi_lainnya;
        } else {
            $faculty = Faculty::where('name', $facultyName)->first();
            if ($faculty) {
                $facultyId = $faculty->id;
            }
        }

        $lampiranPath = null;
        if ($request->hasFile('lampiran') && $request->file('lampiran')->isValid()) {
            $file = $request->file('lampiran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(base_path('../public_html/attachments'), $filename);
            $lampiranPath = 'attachments/' . $filename;
        }

       $ticket = Ticket::create([
    'ticket_number' => 'TIC-' . strtoupper(Str::random(8)),
    'name'          => $request->name,            // Tambahkan ini
    'phone_number'  => $request->phone_number,    // Tambahkan ini
    'category'      => $request->category,
    'site_link'     => $request->link,
    'faculty_id'    => $facultyId,
    'faculty_name'  => $facultyName,
    'email'         => $request->email,
    'attachment'    => $lampiranPath,
    'status'        => 'submitted',
    'description'   => $request->description,
]);

        // Kirim email jika ada email dari pengguna
        //  if ($ticket->email) {
        //      Mail::to($ticket->email)->send(new TicketCreated($ticket));
        //  }

       return redirect()->back()->with('success', 'Laporan berhasil dikirim. Nomor tiket Anda: #' . $ticket->ticket_number);
    }
<<<<<<< HEAD
=======


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
>>>>>>> origin/test-branch
}
