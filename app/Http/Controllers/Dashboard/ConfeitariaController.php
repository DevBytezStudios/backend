<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Confeitaria;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ConfeitariaController extends Controller
{
    public function index(Request $request)
    {
        $confeitaria = DB::table('confeitarias')->select('id', 'nome', 'slug', 'cor_princ', 'cor_sec', 'logo')->where('id', 1)->first();
    }
}
