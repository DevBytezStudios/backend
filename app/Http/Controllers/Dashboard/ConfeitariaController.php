<?php

namespace App\Http\Controllers\Dashboard;


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
            Data::where('id_con', $confeitaria->id)
                ->whereNotIn('dt_bloq', $blockdates)
                ->delete();

            if (is_array($blockdates)) {
                foreach ($blockdates as $date) {
                    Data::create([
                        'id_con' => $confeitaria->id,
                        'dt_bloq' => $date,
                    ]);
                }
            }

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
            // $datas = Confeitaria::with(['blockdates'])->find($confeitaria->id);
            $datas = DB::table('data')->where('id_con',$confeitaria->id)->pluck('dt_bloq');
            return $datas;
        } catch (Throwable $error) {
        }
    }
}
