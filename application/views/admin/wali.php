
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
                <div class="card-header">Data Wali
                <button data-toggle="modal" data-target="#modalWali" class="btn btn-primary btn-sm float-right">Tambah Wali</button>
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
                                    <th>NIK</th>
                                    <th>Nama Wali</th>
                                    <th>No Hp</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Siswa</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($wali as $i => $k){ ?>
                                <tr>
                                    <td><?=$i+1?></td>
                                    <td><?=$k->nik?></td>
                                    <td><?=$k->nama_wali?></td>
                                    <td><?=$k->no_hp?></td>
                                    <td><?=$k->tanggal_lahir?></td>
                                    <td>
                                    <button onclick="
                                            document.getElementById('id_wali').value = <?=$k->id?>;
                                        " type="button" data-toggle="modal" data-target="#modalAddSiswa" class="btn btn-success btn-sm">Tambah Siswa</button>
                                        
                                      <ul>
                                        <?php 
                                          $this->db->select("wali_murid_detail.*, siswa.nama_siswa");
                                          $this->db->from('wali_murid_detail');
                                          $this->db->join("siswa","siswa.id=wali_murid_detail.id_siswa");
                                          $this->db->where('id_wali',$k->id);
                                          $murid = $this->db->get()->result(); 
                                          foreach($murid as $m) {
                                        ?>
                                          <li><?=$m->nama_siswa?> <a class="text text-danger" onclick="return confirm('Hapus Data?')" href="<?=base_url('admin/wali/hapussiswa/'.$m->id)?>">hapus</a></li>
                                        <?php }?>
                                      </ul>
                                    </td>
                                    <td>
                                            <button onclick="
                                                document.getElementById('id').value = <?=$k->id?>;
                                                document.getElementById('nik').value = '<?=$k->nik?>';
                                                document.getElementById('nama_wali').value = '<?=$k->nama_wali?>';
                                                document.getElementById('no_hp').value = '<?=$k->no_hp?>';
                                                document.getElementById('tanggal_lahir').value = '<?=$k->tanggal_lahir?>';
                                            " type="button" data-toggle="modal" data-target="#modalWaliUbah" class="btn btn-warning btn-sm">ubah</button>
                                            
                                            <a onclick="return confirm('Hapus Data?')" href="<?=base_url('admin/wali/destroy/')?><?=$k->id?>" type="button" class="btn btn-danger btn-sm">hapus</a>
                                        
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
<div class="modal fade" id="modalWali" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Form Wali Murid</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?=base_url('admin/wali/store')?>" method="POST" enctype="multipart/form-data">
         
            <div class="form-group">
              <label for="nik">NIK (No KTP Untuk Username Login)</label>
              <input type="number" class="form-control" name="nik" required>
            </div>
            <div class="form-group">
              <label for="nama_wali">Nama Wali</label>
              <input type="text" class="form-control" name="nama_wali" required>
            </div>
            <div class="form-group">
              <label for="no_hp">No HP</label>
              <input type="text" class="form-control" name="no_hp" required>
            </div>
            <div class="form-group">
              <label for="tanggal_lahir">Tanggal Lahir</label>
              <input type="date" class="form-control" name="tanggal_lahir" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan Wali Murid</button>
        </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
<div class="modal fade" id="modalWaliUbah" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Form Wali Murid</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?=base_url('admin/wali/update')?>" method="POST">
            <input type="hidden" name="id" id="id" required>
            <div class="form-group">
              <label for="nik">NIK (No KTP Untuk Username Login)</label>
              <input type="number" class="form-control" name="nik" id="nik" required>
            </div>
            <div class="form-group">
              <label for="nama_wali">Nama Wali Murid</label>
              <input type="text" class="form-control" id="nama_wali" name="nama_wali" required>
            </div>
            <div class="form-group">
              <label for="no_hp">No HP</label>
              <input type="text" class="form-control" id="no_hp" name="no_hp" required>
            </div>
            <div class="form-group">
              <label for="tanggal_lahir">Tanggal Lahir</label>
              <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Ubah Wali Murid</button>
        </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalAddSiswa" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Form Tambah Siswa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?=base_url('admin/wali/siswa')?>" method="POST">
            <input type="hidden" name="id_wali" id="id_wali" required>
           
            <div class="form-group">
              <label for="nama_wali">Nama Siswa</label>
              <select name="id_siswa" id="id_siswa" required class="form-control">
                <option value="">Pilih Siswa</option>
                <?php foreach($siswa as $s){ ?>
                  <option value="<?=$s->id?>"><?=$s->nama_siswa?></option>
                <?php }?>
              </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Tambah Siswa</button>
        </form>
        </div>
      </div>
    </div>
  </div>