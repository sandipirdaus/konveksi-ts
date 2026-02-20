@php
    $jenis_orderan = $item->jenis_orderan ?? [];
    $bahan = $item->bahan ?? [];
    $warna = $item->warna ?? [];
    $qty = $item->qty ?? [];
    $detail_size_besar = $item->detail_size_besar ?? [];
    
    // Ensure they are arrays
    $jenis_orderan = is_array($jenis_orderan) ? $jenis_orderan : [];
    $bahan = is_array($bahan) ? $bahan : [];
    $warna = is_array($warna) ? $warna : [];
    $qty = is_array($qty) ? $qty : [];
@endphp

<div class="p-3 bg-light rounded shadow-sm">
    <div class="row">
        @foreach($jenis_orderan as $index => $item_name)
            @if(!empty($item_name))
            <div class="col-md-6 mb-3">
                <div class="card h-100 border-info">
                    @php
                        $show_stok_info = in_array($item->status, [\App\OrderModel::STATUS_STOK_BARANG, \App\OrderModel::STATUS_SIAP_KIRIM]);
                        $stokItem = $item->stokBarang->where('nama_barang', $item_name)->first();
                    @endphp
                    <div class="card-header bg-info py-2">
                        <h6 class="card-title mb-0 text-white"><i class="fas fa-tag"></i> Item #{{ $index + 1 }}: <strong>{{ $item_name }}</strong></h6>
                    </div>
                    <div class="card-body p-3">
                        @if($show_stok_info)
                        <div class="mb-3">
                            @if($item->status_pembayaran)
                            <span class="badge {{ $item->status_pembayaran == 'lunas' ? 'badge-success' : 'badge-danger' }} p-2">
                                <i class="fas fa-money-bill-wave"></i> {{ $item->status_pembayaran == 'lunas' ? 'LUNAS' : 'BELUM LUNAS' }}
                            </span>
                            @endif
                            <div class="small text-secondary mt-1 ml-1">
                                <i class="fas fa-sticky-note mr-1"></i> Catatan: {{ $item->catatan_stok ?? ($stokItem->catatan ?? '-') }}
                            </div>
                        </div>
                        @endif
                        <div class="row mb-2">
                            <div class="col-4">
                                <label class="text-muted mb-0 text-uppercase font-weight-bold" style="font-size: 0.7rem; letter-spacing: 0.05em;">Bahan</label>
                                <div class="font-weight-bold text-dark">{{ $bahan[$index] ?? '-' }}</div>
                            </div>
                            <div class="col-4">
                                <label class="text-muted mb-0 text-uppercase font-weight-bold" style="font-size: 0.7rem; letter-spacing: 0.05em;">Warna</label>
                                <div class="font-weight-bold text-dark">{{ $warna[$index] ?? '-' }}</div>
                            </div>
                            <div class="col-4 text-right">
                                <label class="text-muted mb-0 text-uppercase font-weight-bold" style="font-size: 0.7rem; letter-spacing: 0.05em;">Harga Satuan</label>
                                <div class="font-weight-bold text-success">Rp. {{ number_format($item->harga_satuan[$index] ?? 0, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <label class="text-muted mb-1 text-uppercase font-weight-bold d-block border-bottom pb-1" style="font-size: 0.7rem; letter-spacing: 0.05em;">Size & Quantity (Total: {{ $qty[$index] ?? 0 }} Pcs)</label>
                            @php
                                // Try to get from Relationship if available (eager loading optimized)
                                if (method_exists($item, 'itemSizes')) {
                                    $detailed_sizes = $item->itemSizes->where('item_index', $index);
                                } else {
                                    $detailed_sizes = \App\OrderItemSizeModel::where('order_id', $item->id)
                                        ->where('item_index', $index)
                                        ->get();
                                }
                                
                                // Large sizes from JSON array
                                $large_sizes = isset($detail_size_besar[$index]) ? 
                                    (is_string($detail_size_besar[$index]) ? json_decode($detail_size_besar[$index], true) : $detail_size_besar[$index]) : [];
                            @endphp
                            
                            @if($detailed_sizes->count() > 0)
                            <div class="mb-2">
                                <label class="text-secondary font-weight-bold text-uppercase mb-1" style="font-size: 0.7rem;">Size Normal</label>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered text-center mb-0">
                                        <thead class="bg-light">
                                            <tr style="font-size: 0.75rem;">
                                                @foreach($detailed_sizes as $s)
                                                    <th class="py-1">{{ $s->size }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="font-weight-bold">
                                                @foreach($detailed_sizes as $s)
                                                    <td class="py-1">{{ $s->qty }}</td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif

                            @if(!empty($large_sizes) && is_array($large_sizes))
                            <div class="mb-2">
                                <label class="text-warning font-weight-bold text-uppercase mb-1" style="font-size: 0.7rem;">Extra Size (Size Besar)</label>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered text-center mb-0 border-warning">
                                        <thead class="text-dark" style="background-color: #fff9db;">
                                            <tr style="font-size: 0.75rem;">
                                                @foreach($large_sizes as $ls)
                                                    <th class="py-1">{{ $ls['size'] ?? '?' }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="font-weight-bold">
                                                @foreach($large_sizes as $ls)
                                                    <td class="py-1">{{ $ls['qty'] ?? 0 }}</td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif

                            @if($detailed_sizes->count() == 0 && empty($large_sizes))
                                <div class="text-center py-2 text-muted italic small">Data ukuran tidak merinci.</div>
                            @endif
                        </div>
                        
                        @if(isset($item->catatan[$index]) && !empty($item->catatan[$index]))
                        <div class="mt-2 pt-2 border-top">
                            <label class="text-muted mb-0 text-uppercase font-weight-bold" style="font-size: 0.7rem;">Catatan:</label>
                            <p class="small mb-0 text-secondary">{{ $item->catatan[$index] }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>
    
    <div class="mt-2 border-top pt-2 d-flex justify-content-between align-items-center">
        <div>
            <span class="badge badge-dark">Sistem DP: {{ strtoupper($item->sistem_dp) }}</span>
            @if($item->dp > 0)
                <span class="badge badge-warning ml-2 font-weight-bold text-dark">Total DP: Rp. {{ number_format($item->dp, 0, ',', '.') }}</span>
            @endif
        </div>
        <div class="text-right">
            <h5 class="mb-0 text-success">Total Order: <strong>Rp. {{ number_format($item->omset_total, 0, ',', '.') }}</strong></h5>
        </div>
    </div>
</div>


