<?php

return [
    'hpp_defaults' => [
        'kilo' => [
            'cmt' => 30000,
            'bordir' => 5000,
            'sablon' => 5000,
            'benang' => 2000,
            'packaging' => 1000,
            'harga_bahan' => 15000,
            'label' => 'Perhitungan berbasis berat (Kg)',
        ],
        'yard' => [
            'cmt' => 30000,
            'bordir' => 5000,
            'sablon' => 5000,
            'benang' => 1500,
            'packaging' => 1000,
            'harga_bahan' => 25000,
            'label' => 'Perhitungan berbasis panjang (Yard)',
        ],
        'roll' => [
            'cmt' => 25000,
            'bordir' => 5000,
            'sablon' => 5000,
            'benang' => 5000,
            'packaging' => 2000,
            'harga_bahan' => 30000,
            'label' => 'Perhitungan berbasis gulungan kain',
        ],
        'Roll/Gulungan' => [
            'cmt' => 25000,
            'bordir' => 5000,
            'sablon' => 5000,
            'benang' => 5000,
            'packaging' => 2000,
            'harga_bahan' => 30000,
            'label' => 'Perhitungan berbasis gulungan kain',
        ],
        'Eceran' => [
            'cmt' => 0,
            'bordir' => 0,
            'sablon' => 0,
            'benang' => 0,
            'packaging' => 0,
            'harga_bahan' => 0,
            'label' => 'Perhitungan Eceran',
        ],
    ],
    'bahan_defaults' => [
        'combed_30s' => ['label' => 'Cotton Combed 30s', 'harga_satuan' => 150000, 'harga_size_besar' => 5000],
        'combed_24s' => ['label' => 'Cotton Combed 24s', 'harga_satuan' => 65000, 'harga_size_besar' => 10000],
        'lacoste_cvc' => ['label' => 'Lacoste CVC', 'harga_satuan' => 85000, 'harga_size_besar' => 15000],
        'pe_double' => ['label' => 'PE Double', 'harga_satuan' => 45000, 'harga_size_besar' => 5000],
        'drill_japan' => ['label' => 'Japan Drill', 'harga_satuan' => 120000, 'harga_size_besar' => 20000],
        'drill_american' => ['label' => 'American Drill', 'harga_satuan' => 100000, 'harga_size_besar' => 15000],
    ],
];
