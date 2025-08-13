<?php

namespace App\Http\Controllers\Umum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Ticket;
use App\Models\Faculty;
use App\Models\Category;
use Illuminate\Support\Facades\Mail;

class UmumController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $email  = $request->input('email');

        $tickets = Ticket::with(['assignment', 'faculty', 'category'])
            ->when($email, function ($q) use ($email) {
                $q->where('email', $email);
            })
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('ticket_number', 'like', "%$search%")
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
        $categories = Category::all();
        return view('users.lapor', compact('faculties', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'no_hp'    => 'nullable|string|max:20',
            'category_id' => 'required|exists:categories,id',
            'site_link'        => 'required|url',
            'faculty_id'     => 'required|string',
            'email'       => 'nullable|email',
            'description' => 'required|string|max:1000',
            'lampiran'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',

            // Ini captcha, gk bisa di lokal
            // 'g-recaptcha-response' => ['required', function ($attribute, $value, $fail) {
            //     $secret = env('NOCAPTCHA_SECRET');
            //     $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            //         'secret' => $secret,
            //         'response' => $value,
            //         'remoteip' => request()->ip(),
            //     ]);
            //     if (!$response->json('success')) {
            //         $fail('Verifikasi CAPTCHA gagal. Silakan coba lagi.');
            //     }
            // }],
        ]);

        $facultyId = $request->faculty_id;

        // Buat CPANEL

        // $lampiranPath = null;
        // if ($request->hasFile('lampiran') && $request->file('lampiran')->isValid()) {
        // $file = $request->file('lampiran');
        // $filename = time() . '_' . $file->getClientOriginalName();
        // $destination = base_path('../public_html/attachments');
        // $file->move($destination, $filename);
        // $lampiranPath = 'attachments/' . $filename;
        // }

        $lampiranPath = null;

        if ($request->hasFile('lampiran') && $request->file('lampiran')->isValid()) {
            $file = $request->file('lampiran');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Simpan di nama_project/public/attachments
            $destination = public_path('attachments');

            // Pastikan folder ada
            if (!file_exists($destination)) {
                mkdir($destination, 0777, true);
            }

            $file->move($destination, $filename);

            // Path relatif untuk disimpan di database
            $lampiranPath = 'attachments/' . $filename;
        }

        $ticket = Ticket::create([
            'ticket_number' => 'TIC-' . strtoupper(Str::random(8)),
            'name'          => $request->name,
            'no_hp'         => $request->no_hp,
            'category_id'   => $request->category_id,
            'site_link'    => $request->input('site_link'),
            'faculty_id'    => $facultyId,
            'email'         => $request->email,
            'attachment'    => $lampiranPath,
            'status'        => 'submitted',
            'description'   => $request->description,
            'created_at'    => now()->setTimezone('Asia/Jakarta'),
        ]);

        if ($ticket->email) {
            Mail::to($ticket->email)->send(new \App\Mail\TicketCreatedMail($ticket));
        }
        //Aktifkan klo mau dipake (di lokal gk bisa)

        // if ($ticket->email) {
        //     \Mail::to($ticket->email)->send(new \App\Mail\TicketCreatedMail($ticket));
        // }

        return redirect()->back()->with('success', 'Laporan berhasil dikirim. Nomor tiket Anda: #' . $ticket->ticket_number);
    }
}
