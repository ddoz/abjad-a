
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
                <div class="card-header">Data User
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
                        <table class="table table-bordered exporting-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Level</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($user as $i => $k){ if($k->username!="admin"){ ?>
                                <tr>
                                    <td><?=$i+1?></td>
                                    <td><?=$k->username?></td>
                                    <td><?=$k->level?></td>
                                    <td>
                                      <a onclick="return confirm('Reset Password?')" href="<?=base_url('admin/user/reset/')?><?=$k->id?>" type="button" class="btn btn-warning btn-sm">reset password</a>
                                      <a onclick="return confirm('Hapus Data?')" href="<?=base_url('admin/user/destroy/')?><?=$k->id?>" type="button" class="btn btn-danger btn-sm">hapus</a>      
                                    </td>
                                </tr>
                                <?php  }}?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalKelas" tabindex="-1" role="dialog" aria-labelledby="modalKelasLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalKelasLabel">Form Kelas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?=base_url('admin/kelas/store')?>" method="POST">
            <div class="form-group">
              <label for="nama_kelas">Nama Kelas</label>
              <input type="text" class="form-control" name="nama_kelas">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan Kelas</button>
        </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
<div class="modal fade" id="modalKelasUbah" tabindex="-1" role="dialog" aria-labelledby="modalKelasLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalKelasLabel">Form Kelas</h5>
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