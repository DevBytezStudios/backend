<?php

namespace App\Http\Controllers\Dashboard;


use App\Models\Confeitaria;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Throwable;

class ConfeitariaController extends Controller
{
    public function setInfo(Request $request)
    {
        try {
            $data = json_decode($request->data, true);

            if ($request->logo) {
                $logo = ' ';
                if ($request->logo) {
                    $path = Storage::disk('public')->put('confeitarias', $request->logo);
                    $logo = basename($path);
                } else {
                    $logo = "semImagem.jpg";
                }
            }



            $confeitaria = Auth::user();
            $confeitaria = Confeitaria::find($confeitaria->id);
            $confeitaria->nome = $data['confeitaria']['nome'];
            $confeitaria->cor_princ = $data['confeitaria']['cor_princ'];
            $confeitaria->cor_sec = $data['confeitaria']['cor_sec'];

            if ($request->logo) {
                $confeitaria->logo = $logo;
            }
            $confeitaria->save();
            return [
                'success' => [
                    'titulo' => 'Atualizada!',
                    'confeitaria' => $confeitaria
                ]
            ];
        } catch (Throwable $error) {
            return [
                'error' => [
                    'titulo' => 'Algo de errado!',
                    'message' => $error->getMessage(),
                    'code' => $error->getCode(),
                ]
            ];
        }
    }
}
