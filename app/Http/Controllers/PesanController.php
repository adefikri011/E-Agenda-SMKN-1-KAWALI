<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PesanController extends Controller
{
    public function kirim(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        // Kirim email ke kamu
        Mail::send('email.kontak', [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'pesan' => $request->message,
        ], function ($mail) use ($request) {
            $mail->to('fikriade257@gmail.com')  // email kamu
                ->subject($request->subject);
        });

        return back()->with('success', 'Pesan berhasil dikirim!');
    }

}
