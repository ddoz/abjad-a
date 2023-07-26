
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
                <div class="card-header">Data Monitoring
                <button data-toggle="modal" data-target="#modalMonitoring" class="btn btn-primary btn-sm float-right">Tambah Monitoring</button>
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
                                    <th>Nama Siswa</th>
                                    <th>Nama Kelas</th>
                                    <th>Pelanggaran</th>
                                    <th>Point</th>
                                    <th>Keterangan</th>
                                    <th>Prestasi</th>
                                    <th>Tanggal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($monitoring as $i => $k){ ?>
                                <tr>
                                    <td><?=$i+1?></td>
                                    <td><?=$k->nama_siswa?></td>
                                    <td><?=$k->nama_kelas?></td>
                                    <td><?=$k->pelanggaran?></td>
                                    <td><?=$k->point?></td>
                                    <td><?=$k->prestasi?></td>
                                    <td><?=$k->tanggal_pelanggaran?></td>
                                    <td><?=$k->keterangan?></td>
                                    <td>
                                        <a onclick="return confirm('Hapus Data?')" href="<?=base_url('admin/monitoring/destroy/')?><?=$k->id?>" type="button" class="btn btn-danger btn-sm">hapus</a>
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
<div class="modal fade" id="modalMonitoring" tabindex="-1" role="dialog" aria-labelledby="modalMonitoringLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalMonitoringLabel">Form Monitoring</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?=base_url('admin/monitoring/store')?>" method="POST">
          <div class="form-group">
            <label for="id_siswa">Siswa:</label>
            <select class="form-control" name="id_siswa" required>  
              <option value="">Pilih Siswa</option>
              <?php foreach($siswa as $s){ ?>
                <option value="<?=$s->id?>"><?=$s->nama_siswa?> - <?=$s->nama_kelas?></option>
              <?php }?>
            </select>
          </div>
          <div class="form-group">
            <label for="status">Pilih Jenis Monitoring:</label>
            <select class="form-control" name="status" required>
              <option value="Akademik">Prestasi Akademik</option>
              <option value="Non Akademik">Prestasi Non Akademik</option>
              <option value="Pelanggaran">Pelanggaran</option>
            </select>
          </div>
          <div class="form-group">
            <label for="point">Point:</label>
            <input type="number" class="form-control" name="point">
          </div>
          <div class="form-group">
            <label for="tanggal">Tanggal:</label>
            <input type="date" class="form-control" name="tanggal_pelanggaran">
          </div>
          <div class="form-group">
            <label for="keterangan">Keterangan:</label>
            <textarea class="form-control" name="keterangan" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan Monitoring</button>
        </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
<div class="modal fade" id="modalMonitoringUbah" tabindex="-1" role="dialog" aria-labelledby="modalMonitoringLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalMonitoringLabel">Form Kelas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?=base_url('admin/kelas/update')?>" method="POST">
            <input type="hidden" name="id" id="id">
            <div class="form-group">
              <label for="nama_kelas">Nama Kelas</label>
              <input type="text" class="form-control" id="nama_kelas" name="nama_kelas">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Ubah Kelas</button>
        </form>
        </div>
      </div>
    </div>
  </div>