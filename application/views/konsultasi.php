
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
                <div class="card-header">Data Konsultasi Saya
                <button data-toggle="modal" data-target="#modalKonsultasi" class="btn btn-primary btn-sm float-right">Kirim Konsultasi</button>
                </div>
                <div class="card-body">
                    <?php 
                    if($this->session->flashdata('message')!="") { ?> <div class="alert alert-danger"><?=$this->session->flashdata('message'); ?> </div><?php } 
                    if (validation_errors()) {
                        echo '<div class="alert alert-danger">';
                        echo validation_errors();
                        echo '</div>';
                    }?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Keluhan</th>
                                    <th>Jawaban Guru BK</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($konsultasi as $i => $k){ ?>
                                <tr>
                                    <td><?=$i+1?></td>
                                    <td><?=$k->keluhan?></td>
                                    <td><?=$k->jawaban?></td>
                                    <td>
                                        
                                            <?php if($k->jawaban==null){ ?>
                                            <a onclick="return confirm('Hapus Data?')" href="<?=base_url('konsultasi/destroy/')?><?=$k->id?>" type="button" class="btn btn-danger btn-sm">hapus</a>
                                            <?php }?>
                                        
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