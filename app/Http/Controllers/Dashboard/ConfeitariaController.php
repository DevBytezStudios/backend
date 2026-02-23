<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Capacidade;
use App\Models\Confeitaria;
use App\Models\Data;
use App\Models\Produto;
use Cocur\Slugify\Slugify;
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
            $limite = json_decode($request->limite, true);
            $slugify = new Slugify();

            // AJUSTES NAS DATAS BLOQUEADAS
            $blockdates = is_array($data['blockdates']) ? $data['blockdates'] : json_decode($data['blockdates'], true)->toArray() ?? [];
            if ($request->hasFile('logo')) {
                $logo = ' ';
                if ($request->logo) {
                    $path = Storage::disk('public')->put('confeitarias', $request->logo);
                    $logo = basename($path);
                }
            }

            // AJUSTES DA CONFEITARIA
            $confeitaria = Auth::user();
            $confeitaria = Confeitaria::find($confeitaria->id);
            $confeitaria->nome = $data['confeitaria']['nome'];
            $confeitaria->cor_princ = $data['confeitaria']['cor_princ'];
            $confeitaria->cor_sec = $data['confeitaria']['cor_sec'];
            $newSlug = $slugify->slugify($data['confeitaria']['nome']);
            $confeitaria->slug = $newSlug;

            if ($request->hasFile('logo')) {
                $confeitaria->logo = $logo;
            }
            $confeitaria->save();

            // MODIFICANDO AS DATAS BLOQUEADAS
            Data::where('id_con', $confeitaria->id)
                ->whereNotIn('dt_bloq', $blockdates)
                ->delete();

            if (is_array($blockdates)) {
                foreach ($blockdates as $date) {
                    Data::firstOrCreate([
                        'id_con' => $confeitaria->id,
                        'dt_bloq' => $date,
                    ]);
                }
            }

            // MODIFICANDO O LIMITE DIARIO
            $capacidade = Capacidade::where('id_con', $confeitaria->id)->first();
            $capacidade->limite = $limite;
            $capacidade->save();

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

    public function getBlockDates(Request $request)
    {
        try {
            $confeitaria = Auth::user();
            $datas = DB::table('data')->where('id_con', $confeitaria->id)->pluck('dt_bloq');
            return response()->json($datas);
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

    public function config(Request $request)
    {
        $confeitaria = Auth::user();
        $capacidade = Capacidade::where('id_con', $confeitaria->id)->firstOrCreate([
            'id_con' => $confeitaria->id
        ])->select('limite')->first();
        $limite = $capacidade->limite;
        return Inertia::render('Configurações', ['limite' => $limite]);
    }
}
