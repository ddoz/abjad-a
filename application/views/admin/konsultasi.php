
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
                <div class="card-header">Data Konsultasi
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
                                    <th>Nama Siswa</th>
                                    <th>Nama Kelas</th>
                                    <th>Keluhan</th>
                                    <th>Jawaban Guru</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($konsultasi as $i => $k){ ?>
                                <tr>
                                    <td><?=$i+1?></td>
                                    <td>
                                    <img width="50" height="50" class="rounded-circle" src="data:<?php echo $k->tipe_berkas; ?>;base64,<?php echo $k->foto; ?>" width="100">
                                    </td>
                                    <td><?=$k->nama_siswa?></td>
                                    <td><?=$k->nama_kelas?></td>
                                    <td><?=$k->keluhan?></td>
                                    <td><?=$k->jawaban?></td>
                                    <td>
                                            <button onclick="
                                                document.getElementById('id').value = <?=$k->id?>;
                                            " type="button" data-toggle="modal" data-target="#modalKeluhan" class="btn btn-warning btn-sm">Jawab</button>
                                            
                                            <a onclick="return confirm('Hapus Data?')" href="<?=base_url('admin/konsultasi/destroy/')?><?=$k->id?>" type="button" class="btn btn-danger btn-sm">hapus</a>
                                        
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
<div class="modal fade" id="modalKeluhan" tabindex="-1" role="dialog" aria-labelledby="modalKeluhanLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalKeluhanLabel">Form Jawab Keluhan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?=base_url('admin/konsultasi/update')?>" method="POST">
            <input type="hidden" name="id" id="id">
            <div class="form-group">
              <label for="jawaban">Jawaban</label>
              <textarea class="form-control" id="jawaban" rows="20" name="jawaban" required></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Kirim Jawaban</button>
        </form>
        </div>
      </div>
    </div>
  </div>