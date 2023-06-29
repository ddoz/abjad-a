
        <div class="col-md-3">
            <div class="mb-2">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <?php if($this->session->userdata("level")=="siswa"){ ?>
                    <img class="rounded-circle" src="data:<?php echo profilSiswa()->tipe_berkas; ?>;base64,<?php echo profilSiswa()->foto; ?>" height="100%">
                    <?php }?>
                    <?php if($this->session->userdata("level")=="guru"){ ?>
                    <img width="150" class="rounded-circle" src="data:<?php echo profilGuru()->tipe_berkas; ?>;base64,<?php echo profilGuru()->foto; ?>" height="150">
                    <?php }?>
                    <h4 class="text-white"><?=$this->session->userdata('nama')?></h4>
                    <?php if($this->session->userdata("level")=="siswa"){ ?>
                        <div class="img-thumbnail" id="qrcode"></div>
                    <?php }?>
                </div>
            </div>
            <div class="">
                <div class="">
                    <ul class="list-group">
                        <li class="list-group-item active">
                            <small><?=strtoupper($this->session->userdata("level"))?></small>
                        </li>
                        <a class="list-group-item list-group-item-action" href="<?=base_url('dashboard')?>">Dashboard</a> 
                    </ul>
                </div>
            </div>
            <?php if($this->session->userdata('level')=="admin"){ ?>
                <div class="mt-2">
                    <div class="">
                        <ul class="list-group">
                            <li class="list-group-item active">
                                Admin
                            </li>
                            <a class="list-group-item list-group-item-action" href="<?=base_url('admin/user')?>">User</a> 
                        </ul>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="">
                        <ul class="list-group">
                            <li class="list-group-item active">
                                Data
                            </li>
                            <a class="list-group-item list-group-item-action" href="<?=base_url('admin/kelas')?>">Kelas</a>                        
                            <a class="list-group-item list-group-item-action" href="<?=base_url('admin/siswa')?>">Siswa</a> 
                            <a class="list-group-item list-group-item-action" href="<?=base_url('admin/guru')?>">Guru</a> 
                            <a class="list-group-item list-group-item-action" href="<?=base_url('admin/wali')?>">Wali Murid</a> 
                            <a class="list-group-item list-group-item-action" href="<?=base_url('admin/konsultasi')?>">Konsultasi</a> 
                            <a class="list-group-item list-group-item-action" href="<?=base_url('admin/monitoring')?>">Monitoring</a> 
                        </ul>
                    </div>
                </div>
            <?php }?>
            <?php if($this->session->userdata('level')=='siswa'){ ?>
                <div class="mt-2">
                    <div class="">
                        <ul class="list-group">
                            <li class="list-group-item active">
                                Data
                            </li>
                            <a class="list-group-item list-group-item-action" href="<?=base_url('monitoring')?>">Monitoring</a>
                            <a class="list-group-item list-group-item-action" href="<?=base_url('konsultasi')?>">Konsultasi</a>
                        </ul>
                    </div>
                </div>
            <?php }?>
            <?php if($this->session->userdata('level')=='wali'){ ?>
                <div class="mt-2">
                    <div class="">
                        <ul class="list-group">
                            <li class="list-group-item active">
                                Data
                            </li>
                            <a class="list-group-item list-group-item-action" href="<?=base_url('monitoring')?>">Monitoring</a>
                            <a class="list-group-item list-group-item-action" href="<?=base_url('konsultasi')?>">Konsultasi</a>
                        </ul>
                    </div>
                </div>
            <?php }?>
            <?php if($this->session->userdata('level')=='guru'){ ?>
                <div class="mt-2">
                    <div class="">
                        <ul class="list-group">
                            <li class="list-group-item active">
                                Data
                            </li>
                            <a class="list-group-item list-group-item-action" href="<?=base_url('admin/monitoring')?>">Monitoring</a>
                            <a class="list-group-item list-group-item-action" href="<?=base_url('admin/konsultasi')?>">Konsultasi</a>
                        </ul>
                    </div>
                </div>
            <?php }?>
            <div class="mt-2 mb-4">
                <div class="">
                    <ul class="list-group">
                        <li class="list-group-item active">
                            Akun
                        </li>
                        <a class="list-group-item list-group-item-action" href="<?=base_url('password')?>">Ganti Password</a> 
                        <a class="list-group-item list-group-item-action" href="<?=base_url('login/logout')?>">Logout</a> 
                    </ul>
                </div>
            </div>
        </div>