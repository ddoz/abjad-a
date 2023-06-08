<script src="https://code.highcharts.com/highcharts.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
      // Data jumlah pertanggal selama seminggu
      var data = [
        { tanggal: '2023-06-01', prestasi: 10, pelanggaran: 2 },
        { tanggal: '2023-06-02', prestasi: 8, pelanggaran: 3 },
        { tanggal: '2023-06-03', prestasi: 12, pelanggaran: 1 },
        { tanggal: '2023-06-04', prestasi: 5, pelanggaran: 4 },
        { tanggal: '2023-06-05', prestasi: 15, pelanggaran: 2 },
        { tanggal: '2023-06-06', prestasi: 9, pelanggaran: 3 },
        { tanggal: '2023-06-07', prestasi: 11, pelanggaran: 2 }
      ];

      // Mengubah format tanggal ke objek Date
      for (var i = 0; i < data.length; i++) {
        data[i].tanggal = new Date(data[i].tanggal).getTime();
      }

      // Mengurutkan data berdasarkan tanggal
      data.sort(function(a, b) {
        return a.tanggal - b.tanggal;
      });

      // Membuat array tanggal, jumlah prestasi, dan jumlah pelanggaran untuk chart
      var categories = [];
      var jumlahPrestasi = [];
      var jumlahPelanggaran = [];
      for (var i = 0; i < data.length; i++) {
        categories.push(new Date(data[i].tanggal).toLocaleDateString());
        jumlahPrestasi.push(data[i].prestasi);
        jumlahPelanggaran.push(data[i].pelanggaran);
      }

      // Membuat chart menggunakan Highcharts
      Highcharts.chart('chartContainer', {
        chart: {
          type: 'bar'
        },
        title: {
          text: 'Jumlah Prestasi dan Pelanggaran per Kategori'
        },
        xAxis: {
          categories: categories,
          title: {
            text: 'Tanggal'
          }
        },
        yAxis: {
          title: {
            text: 'Jumlah'
          }
        },
        legend: {
          reversed: true
        },
        plotOptions: {
          series: {
            stacking: 'normal'
          }
        },
        series: [{
          name: 'Prestasi',
          data: jumlahPrestasi
        }, {
          name: 'Pelanggaran',
          data: jumlahPelanggaran
        }]
      });
    });
  </script>