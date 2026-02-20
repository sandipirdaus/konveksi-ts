@extends('layout.master')
@section('judul', 'Omset Tahunan')

@section('konten')

<div class="container">
      <div class="row">
            <div class="col-md-12">
                  <div class="card mt-2">
                    <form action="/omset_tahunan" method="POST">
                        @csrf
                        <div class="card-header">
                              <h3 class="card-title"><i class="fas fa-chart-line"> OMSET TAHUNAN </i></h3>
                        </div>
                        <div class="col-md-6 mt-2">
                              <div class="form-group row">
                                    <div class="col-sm-6">
                                        <select class="form-control" name="tahun">
                                            <option selected="selected" disabled>Cari Berdasarkan Tahun</option>
                                            <option value="2021">2021</option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                          </select>                        
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-secondary"><i class="fas fa-search"> Cari</i></button>
                                     </div>
                                    </form>
                                  </div>
                            <div class="card-body">
                                  <div id="grafik"></div>
                      </div>                    
                  </div>
            </div>
      </div>
</div>

<script>
       // Create the chart
       Highcharts.chart('grafik', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'OMSET TAHUNAN TAHUN 0'
    },
    subtitle: {
        text: 'Konveksi New Speed'
    },
    xAxis: {
        categories: ['2021', '2022', '2023', '2024', '2025']
    },
    yAxis: {
        title: {
            text: 'Omset Bulanan Konveksi Baju New Speed'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Omset Per-Tahun',
        data: [
           0,
           0,
           0,
           0,
           0
        ]
    }]
});
</script>
    
@endsection