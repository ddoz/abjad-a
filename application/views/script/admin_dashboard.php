<script src="https://code.highcharts.com/highcharts.js"></script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Data jumlah prestasi dan pelanggaran
    var data = {
      pelanggaran: <?=$pelanggaran?>,
      prestasiAkademik: <?=$akademik?>,
      prestasiNonAkademik: <?=$nonAkademik?>
    };

    // Membuat chart menggunakan Highcharts
    Highcharts.chart('chartContainer', {
      chart: {
        type: 'bar'
      },
      title: {
        text: 'Grafik Prestasi dan Pelanggaran Bulan Ini'
      },
      xAxis: {
        categories: ['']
      },
      yAxis: {
        title: {
          text: 'Jumlah'
        }
      },
      series: [{
        name: 'Pelanggaran',
        data: [data.pelanggaran],
        color: 'red'
      }, {
        name: 'Prestasi Akademik',
        data: [data.prestasiAkademik],
        color: 'green'
      }, {
        name: 'Prestasi Non-Akademik',
        data: [data.prestasiNonAkademik],
        color: 'blue'
      }],
      legend: {
        enabled: true
      }
    });
  });
</script>
