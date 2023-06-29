
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
                <div class="card-header">Data Monitoring <?php if($this->session->userdata('level')=='wali') echo 'Wali'; ?> Saya
                </div>
                <div class="card-body">
                    
                    <div class="table-responsive">
                    <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <?php if($this->session->userdata('level')=='wali'){ ?>
                                    <th>Nama Siswa</th>
                                    <th>Nama Kelas</th>
                                    <?php }?>
                                    <th>Pelanggaran</th>
                                    <th>Point</th>
                                    <th>Prestasi</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($monitoring as $i => $k){ ?>
                                <tr>
                                    <td><?=$i+1?></td>
                                    <?php if($this->session->userdata('level')=='wali'){ ?>
                                    <td><?=$k->nama_siswa?></td>
                                    <td><?=$k->nama_kelas?></td>
                                    <?php }?>
                                    <td><?=($k->pelanggaran)?'Ya':'-';?></td>
                                    <td><?=$k->point?></td>
                                    <td><?=($k->prestasi=="Bukan Prestasi")?"-":$k->prestasi;?></td>
                                    <td><?=$k->tanggal_pelanggaran?></td>
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
<div class="modal fade" id="modalKonsultasi" tabindex="-1" role="dialog" aria-labelledby="modalKonsultasiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalKonsultasiLabel">Form Keluhan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?=base_url('konsultasi/store')?>" method="POST">
            <div class="form-group">
              <label for="nama_kelas">Keluhan</label>
              <textarea name="keluhan" id="" cols="30" rows="10" class="form-control" required></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Kirim Keluhan</button>
        </form>
        </div>
      </div>
    </div>
  </div>