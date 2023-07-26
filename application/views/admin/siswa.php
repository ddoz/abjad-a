
<section class="top">
<?php
    $this->load->view('template/kop');
?>
</section>
<hr>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view("admin/menu"); ?>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Data Siswa
                <button data-toggle="modal" data-target="#modalSiswa" class="btn btn-primary btn-sm float-right">Tambah Siswa</button>
                </div>
                <div class="card-body">
                    <?php 
                    if($this->session->flashdata('message')!="") { ?> <div class="alert alert-danger"><?=$this->session->flashdata('message'); ?> </div><?php } 
                    if (validation_errors()) {
                        echo '<div class="alert alert-danger">';
                        echo validation_errors();
                        echo '</div>';
                    }?>

                    <div class="row mb-2">
                      <div class="col-md-4">
                        <form action="" id="formFilter" method="get">
                        <label for="">Filter Kelas</label>
                          <select onchange="document.getElementById('formFilter').submit()" name="kelas" id="kelas" class="form-control">
                            <option value="">Filter By Kelas</option>
                            <?php foreach($daftarKelas as $k){ ?>
                              <option <?php if($k->id == $this->input->get('kelas')) echo "selected"?> value="<?=$k->id?>"><?=$k->nama_kelas?></option>
                            <?php }?>
                          </select>
                        </form>
                      </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered exporting-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>NISN</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Tanggal Lahir</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($siswa as $i => $k){ ?>
                                <tr>
                                    <td><?=$i+1?></td>
                                    <td><img width="50" height="50" class="rounded-circle" src="data:<?php echo $k->tipe_berkas; ?>;base64,<?php echo $k->foto; ?>"></td>
                                    <td><?=$k->nisn?></td>
                                    <td><?=$k->nama_siswa?></td>
                                    <td><?=$k->nama_kelas?></td>
                                    <td><?=$k->tanggal_lahir?></td>
                                    <td>
                                            <button onclick="
                                                document.getElementById('id').value = <?=$k->id?>;
                                                document.getElementById('nisn').value = '<?=$k->nisn?>';
                                                document.getElementById('nama_siswa').value = '<?=$k->nama_siswa?>';
                                                document.getElementById('kelas_id').value = '<?=$k->kelas_id?>';
                                                document.getElementById('tanggal_lahir').value = '<?=$k->tanggal_lahir?>';
                                            " type="button" data-toggle="modal" data-target="#modalSiswaUbah" class="btn btn-warning btn-sm">ubah</button>
                                            
                                            <a onclick="return confirm('Hapus Data?')" href="<?=base_url('admin/siswa/destroy/')?><?=$k->id?>" type="button" class="btn btn-danger btn-sm">hapus</a>
                                        
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalSiswa" tabindex="-1" role="dialog" aria-labelledby="modalSiswaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalSiswaLabel">Form Siswa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?=base_url('admin/siswa/store')?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label for="nisn">Foto</label>
              <input type="file" class="form-control" name="foto" required>
            </div>
            <div class="form-group">
              <label for="nisn">NISN</label>
              <input type="number" class="form-control" name="nisn" required>
            </div>
            <div class="form-group">
              <label for="nama_siswa">Nama Siswa</label>
              <input type="text" class="form-control" name="nama_siswa" required>
            </div>
            <div class="form-group">
              <label for="kelas">Kelas</label>
              <select class="form-control" name="kelas_id" required>
                <option value="">Pilih Kelas</option>
                <!-- Generate opsi kelas menggunakan data dari database -->
                <?php foreach ($daftarKelas as $kelas): ?>
                  <option value="<?php echo $kelas->id; ?>"><?php echo $kelas->nama_kelas; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label for="tanggal_lahir">Tanggal Lahir</label>
              <input type="date" class="form-control" name="tanggal_lahir" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan Siswa</button>
        </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
<div class="modal fade" id="modalSiswaUbah" tabindex="-1" role="dialog" aria-labelledby="modalSiswaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalSiswaLabel">Form Siswa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?=base_url('admin/siswa/update')?>" method="POST">
            <input type="hidden" name="id" id="id" required>
            <div class="form-group">
              <label for="nisn">Foto</label>
              <input type="file" class="form-control" name="foto">
            </div>
            <div class="form-group">
              <label for="nisn">NISN</label>
              <input type="number" class="form-control" id="nisn" name="nisn" required readonly>
            </div>
            <div class="form-group">
              <label for="nama_siswa">Nama Siswa</label>
              <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" required>
            </div>
            <div class="form-group">
              <label for="kelas">Kelas</label>
              <select class="form-control" id="kelas_id" name="kelas_id" required>
                <option value="">Pilih Kelas</option>
                <!-- Generate opsi kelas menggunakan data dari database -->
                <?php foreach ($daftarKelas as $kelas): ?>
                  <option value="<?php echo $kelas->id; ?>"><?php echo $kelas->nama_kelas; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label for="tanggal_lahir">Tanggal Lahir</label>
              <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Ubah Siswa</button>
        </form>
        </div>
      </div>
    </div>
  </div>