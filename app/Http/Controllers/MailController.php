<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\MailModel;
use TransportException;
use Exception;

class MailController extends Controller
{
    public function send(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
        ]);

        // Check required environment variables
        $missingVariables = [];
        $requiredEnvVariables = [
            'MAIL_MAILER',
            'MAIL_HOST',
            'MAIL_PORT',
            'MAIL_USERNAME',
            'MAIL_PASSWORD',
            'MAIL_ENCRYPTION',
            'MAIL_FROM_ADDRESS',
            'MAIL_FROM_NAME',
        ];

        foreach ($requiredEnvVariables as $envVar) {
            if (empty(env($envVar))) {
                $missingVariables[] = $envVar;
            }
        }

        if (!empty($missingVariables)) {
            $status = 'Erro!';
            $message = 'O servidor SMTP não pode ser acedido devido à falta de variáveis ​​de ambiente:';
            $request->session()->flash('status', $status);
            $request->session()->flash('message', $message);
            $request->session()->flash('details', $missingVariables);
            return redirect()->route('posts');
        }

        // Retrieve the user by email
        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('status', 'Nenhum utilizador foi encontrado com este e-mail.');
        }

        // Prepare mail data
        $mailData = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
        ];

        try {
            // Send the email
            Mail::to($user->email)->send(new MailModel($mailData));
            $status = 'Sucesso!';
            $message = 'Um e-mail com link para redefinição da palavra-passe foi enviado para ' . $user->email;
        } catch (TransportException $e) {
            $status = 'Erro!';
            $message = 'Ocorreu um erro de conexão SMTP durante o processo de envio de e-mail.';
        } catch (Exception $e) {
            $status = 'Erro!';
            $message = 'Ocorreu uma exceção não tratada durante o processo de envio de e-mail.';
        }

        // Store feedback in the session
        $request->session()->flash('status', $status);
        $request->session()->flash('message', $message);

        return back();
    }
}
