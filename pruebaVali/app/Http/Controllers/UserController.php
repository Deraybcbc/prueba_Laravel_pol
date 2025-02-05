<?php

namespace App\Http\Controllers;

use App\Models\infoUser;
use App\Models\User;
use App\Services\MailService;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function getUser(Request $request)
    {

        $validate = $request->validate([
            'id' => 'required'
        ]);


        $user = User::with('roles')->findOrFail($validate['id']);

        //Generar PDF

        // Crear la instancia de PDF
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf.user', compact('user'));

        //Guardar temporalmente el PDF
        $pdfPath = storage_path('app/public/users_' . $user->id . '.pdf');
        $pdf->save($pdfPath);

        // Enviar el correo con el PDF adjunto
        $body = "Hola {$user->name}, <br><br>Adjunto encontrarás un PDF con tu información.";
        $this->mailService->enviarMail($user->name, $user->email, $body, $pdfPath);



        return response()->json(['status' => 'success', 'user' => $user]);

    }

    public function createInfo(Request $request)
    {
        $validate = $request->validate([
            'user_id' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'city' => 'required',
            'type' => 'required',
        ]);

        $info = new infoUser();

        $info->user_id = $validate['user_id'];
        $info->address = $validate['address'];
        $info->phone = $validate['phone'];
        $info->city = $validate['city'];
        $info->type = $validate['type'];

        $info->save();

        return response()->json(['status' => 'success', 'info' => $info]);
    }
}
