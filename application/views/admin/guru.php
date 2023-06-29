
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
                <div class="card-header">Data Guru
                <button data-toggle="modal" data-target="#modalGuru" class="btn btn-primary btn-sm float-right">Tambah Guru</button>
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
                                    <th>Foto</th>
                                    <th>NIP</th>
                                    <th>Nama Guru</th>
                                    <th>Pendidikan Terakhir</th>
                                    <th>Jurusan</th>
                                    <th>Tanggal Lahir</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($guru as $i => $k){ ?>
                                <tr>
                                    <td><?=$i+1?></td>
                                    <td><img width="100" src="data:<?php echo $k->tipe_berkas; ?>;base64,<?php echo $k->foto; ?>"></td>
                                    <td><?=$k->nip?></td>
                                    <td><?=$k->nama_guru?></td>
                                    <td><?=$k->pendidikan_terakhir?></td>
                                    <td><?=$k->jurusan?></td>
                                    <td><?=$k->tanggal_lahir?></td>
                                    <td>
                                            <button onclick="
                                                document.getElementById('id').value = <?=$k->id?>;
                                                document.getElementById('nip').value = '<?=$k->nip?>';
                                                document.getElementById('nama_guru').value = '<?=$k->nama_guru?>';
                                                document.getElementById('pendidikan_terakhir').value = '<?=$k->pendidikan_terakhir?>';
                                                document.getElementById('jurusan').value = '<?=$k->jurusan?>';
                                                document.getElementById('tanggal_lahir').value = '<?=$k->tanggal_lahir?>';
                                            " type="button" data-toggle="modal" data-target="#modalGuruUbah" class="btn btn-warning btn-sm">ubah</button>
                                            
                                            <a onclick="return confirm('Hapus Data?')" href="<?=base_url('admin/guru/destroy/')?><?=$k->id?>" type="button" class="btn btn-danger btn-sm">hapus</a>
                                        
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
<div class="modal fade" id="modalGuru" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Form Guru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?=base_url('admin/guru/store')?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label for="foto">Foto</label>
              <input type="file" class="form-control" name="foto" required>
            </div>
            <div class="form-group">
              <label for="nip">NIP</label>
              <input type="number" class="form-control" name="nip" required>
            </div>
            <div class="form-group">
              <label for="nama_guru">Nama Guru</label>
              <input type="text" class="form-control" name="nama_guru" required>
            </div>
            <div class="form-group">
              <label for="pendidikan_terakhir">Pendidikan Terakhir</label>
              <input type="text" class="form-control" name="pendidikan_terakhir" required>
            </div>
            <div class="form-group">
              <label for="jurusan">Jurusan</label>
              <input type="text" class="form-control" name="jurusan" required>
            </div>
            <div class="form-group">
              <label for="tanggal_lahir">Tanggal Lahir</label>
              <input type="date" class="form-control" name="tanggal_lahir" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan Guru</button>
        </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
<div class="modal fade" id="modalGuruUbah" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Form Guru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?=base_url('admin/guru/update')?>" method="POST">
            <input type="hidden" name="id" id="id" required>
            <div class="form-group">
              <label for="foto">Foto</label>
              <input type="file" class="form-control" name="foto">
            </div>
            <div class="form-group">
              <label for="nip">NIP</label>
              <input type="number" class="form-control" id="nip" name="nip" required readonly>
            </div>
            <div class="form-group">
              <label for="nama_guru">Nama Guru</label>
              <input type="text" class="form-control" id="nama_guru" name="nama_guru" required>
            </div>
            <div class="form-group">
              <label for="pendidikan_terakhir">Pendidikan Terakhir</label>
              <input type="text" class="form-control" id="pendidikan_terakhir" name="pendidikan_terakhir" required>
            </div>
            <div class="form-group">
              <label for="jurusan">Jurusan</label>
              <input type="text" class="form-control" id="jurusan" name="jurusan" required>
            </div>
            <div class="form-group">
              <label for="tanggal_lahir">Tanggal Lahir</label>
              <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Ubah Guru</button>
        </form>
        </div>
      </div>
    </div>
  </div>