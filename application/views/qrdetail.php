
<section class="top">
<?php
    $this->load->view('template/kop');
    $this->load->view('template/navbar');
?>
</section>

<div class="container mt-4">
    <h4>Data Siswa</h4>

    <div class="row">
        <div class="col-md-2">
            <img width="150" class="img-thumbnail" src="data:<?php echo $siswa->tipe_berkas; ?>;base64,<?php echo $siswa->foto; ?>" height="150">
        </div>
            <div class="col-md-10">
                <ul class="list-group">
                <li class="list-group-item">NISN : <?=$siswa->nisn?></li>
                <li class="list-group-item">Nama Siswa : <?=$siswa->nama_siswa?></li>
                <li class="list-group-item">Kelas : <?=$siswa->nama_kelas?></li>
            </ul>
        </div>
    </div>
</div>