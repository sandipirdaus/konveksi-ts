<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrderModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class OmsetContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahun = date('Y');
        $request = new \Illuminate\Http\Request();
        $request->merge(['tahun' => $tahun]);
        return $this->cari_omset($request);
    }
  
    public function cari_omset(Request $request)
    {
        $tahun = $request->tahun ?? date('Y');
        
        // Ambil SEMUA data orderan yang selesai atau sudah dikirim di tahun tersebut
        $orders = OrderModel::whereYear('deadline', $tahun)
                            ->whereIn('status', [OrderModel::STATUS_PRODUKSI_SELESAI, OrderModel::STATUS_SELESAI_DIKIRIM])
                            ->get();

        // Inisialisasi array bulanan (index 1-12) dengan nilai 0
        $monthlyData = array_fill(1, 12, 0);

        foreach ($orders as $order) {
            // Use omset_total (Profit) field as requested - It represents Revenue - COGS
            $profit = $order->omset_total ?? 0;

            // Masukkan ke bucket bulan yang sesuai (berdasarkan deadline)
            $month = \Carbon\Carbon::parse($order->deadline)->format('n'); // 1-12
            $monthlyData[$month] += $profit;
        }

        // Mapping ke variabel view (casting ke int untuk chart)
        $januari = (int)$monthlyData[1];
        $februari = (int)$monthlyData[2];
        $maret = (int)$monthlyData[3];
        $april = (int)$monthlyData[4];
        $mei = (int)$monthlyData[5];
        $juni = (int)$monthlyData[6];
        $juli = (int)$monthlyData[7];
        $agustus = (int)$monthlyData[8];
        $september = (int)$monthlyData[9];
        $oktober = (int)$monthlyData[10];
        $november = (int)$monthlyData[11];
        $desember = (int)$monthlyData[12];

        return view('admin.omset.bulanan.index_req', compact(
            'januari',
            'februari',
            'maret',
            'april',
            'mei',
            'juni',
            'juli',
            'agustus',
            'september',
            'oktober',
            'november',
            'desember',
            'tahun'
        ));   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
