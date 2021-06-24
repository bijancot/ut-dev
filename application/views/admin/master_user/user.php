<!-- Begin Page Content -->
<?php    
    if(empty($this->session->userdata('ROLE_USERS')) || $this->session->userdata('ROLE_USERS') != 'Admin GA'){
        redirect('login');
    }
?>
<div class="container-fluid">
    <!-- <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" style="opacity: 1;position:absolute;right:0;z-index:1;" data-delay="2000">
        <div class="toast-header text-success">
            <i data-feather="bell"></i>
            <strong class="mr-auto">Success</strong>
            <small class="text-muted ml-2">just now</small>
            <button class="ml-2 mb-1 close" type="button" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="toast-body">Data berhsil disimpan.</div>
    </div> -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengguna</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-warning mb-2">Daftar Pengguna</h6>
                <button class="btn btn-sm btn-warning shadow-sm" data-toggle="modal" data-target="#mdlAdd">
                    <i class="fas fa-plus fa-sm text-white-50"></i>
                    Tambah
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tableUser" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Departemen</th>
                            <th>Divisi</th>
                            <th>Username</th>
                            <th>Status</th>
                            <th>Aksi</th>                            
                            <th>TS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($listData as $item) {
                            if($item->ROLE_USERS != 'Admin GA' && $item->ROLE_USERS != 'Admin Debitnote'){
                                echo '
                                        <tr>
                                            <td>' . $item->NAMA_USERS . '</td>
                                            <td>' . $item->ROLE_USERS . '</td>
                                            <td>' . $item->DEPT_USERS . '</td>
                                            <td>' . $item->DIV_USERS . '</td>
                                            <td>' . $item->USER_USERS . '</td>
                                            <td>'.($item->STAT_USERS == 0 ? 'Belum Diverifikasi' : 'Terverifikasi' ).'</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="' . site_url("user/edit/" . $item->ID_USERS) . '" class="btn btn-primary btn-sm rounded mr-1" data-tooltip="tooltip" data-placement="top" title="Ubah">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    '.($item->STAT_USERS == 0 ? 
                                                        '<button type="button" data-toggle="modal" data-id="' . $item->ID_USERS . '" data-name="' . $item->NAMA_USERS . '" data-target="#mdlApprove" class="btn btn-success btn-sm mr-1 rounded mdlApprove" data-tooltip="tooltip" data-placement="top" title="Menyetujui">
                                                            <i class="fa fa-check"></i>
                                                        </button>'
                                                        :
                                                        '<button type="button" data-toggle="modal" data-target="#mdlApprove" class="btn btn-success btn-sm mr-1 rounded mdlApprove d-none" data-tooltip="tooltip" data-placement="top" title="Approve">
                                                            <i class="fa fa-check"></i>
                                                        </button>'
                                                    ).'                                                
                                                    <button type="button" data-toggle="modal" data-id="' . $item->ID_USERS . '" data-name="' . $item->NAMA_USERS . '" data-target="#mdlReset" class="btn btn-secondary btn-sm mr-1 rounded mdlRstPassUserItem" data-tooltip="tooltip" data-placement="top" title="Reset">
                                                        <i class="fa fa-key"></i>
                                                    </button>
                                                    <button type="button" data-toggle="modal" data-id="' . $item->ID_USERS . '" data-name="' . $item->NAMA_USERS . '" data-target="#mdlDelete" class="btn btn-danger btn-sm rounded mdlDelete" data-tooltip="tooltip" data-placement="top" title="Hapus">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td>' . $item->TS_USERS . '</td>
                                        </tr>
                                    ';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

<!-- Modal Add -->
<div class="modal fade" id="mdlAdd" tabindex="-1" aria-labelledby="mdlAdd" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlAdd">Tambah Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('user/store') ?>" enctype="multipart/form-data" method="post">
                <div class="modal-body">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Nama Lengkap" name="NAMA_USERS" required>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="col">
                        <input type="tel" class="form-control" placeholder="Telepon" name="NOTELP_USERS" required>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="col">
                        <select class="custom-select" name="ROLE_USERS" required>
                            <option value="" selected>Jabatan</option>
                            <option value="Staff">Staff</option>
                            <option value="Staff Catering">Staff Catering</option>
                            <option value="PICK">PIC Kendaraan</option>
                            <option value="PICG">PIC Gudang</option>
                            <option value="PICA">PIC Admin</option>
                            <option value="PICM">PIC Maintenance</option>
                            <option value="PICC">PIC Catering</option>
                            <option value="Section Head">Section Head</option>
                            <option value="Department Head">Department Head</option>
                            <option value="Division Head">Division Head</option>
                        </select>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="col">
                        <select class="custom-select" name="DEPT_USERS" required>
                            <option value="" selected>Departemen</option>
                            <option value="General Affairs">General Affairs</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="col">
                        <select class="custom-select" name="DIV_USERS" required>
                            <option value="" selected>Divisi</option>
                            <option value="Corporate Finance">Corporate Finance</option>
                            <option value="Corporate Huma Capital & Corpu">Corporate Huma Capital & Corpu</option>
                            <option value="Corporate ESR, Security GA dan Communication">Corporate ESR, Security GA dan Communication</option>
                            <option value="Procurement and Investment">Procurement and Investment</option>
                            <option value="Corporate Audit">Corporate Audit</option>
                            <option value="Group Legal">Group Legal</option>
                            <option value="Digitalization and Differentation">Digitalization and Differentation</option>
                            <option value="Cosporate Strategy and Technology">Cosporate Strategy and Technology</option>
                            <option value="Service Division">Service Division</option>
                            <option value="Parts Division">Parts Division</option>
                            <option value="Truck Mining Operation">Truck Mining Operation</option>
                            <option value="Sales Operation Division">Sales Operation Division</option>
                            <option value="Truck Sales Operation">Truck Sales Operation</option>
                            <option value="Marketing Division">Marketing Division</option>
                            <option value="Board of Direction">Board of Direction</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="col">
                        <input type="text" class="form-control" name="USER_USERS" placeholder="NRP" required>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="col">
                        <input type="text" class="form-control" value="123ut456" placeholder="Password" disabled>
                        <input type="hidden" name="PASS_USERS" value="123ut456" />
                    </div>
                </div>
                <div class="modal-body" style="padding-left:6%;padding-right:6%;">
                    <div class="col">
                        <input type="file" name="imageTtd" class="custom-file-input" id="image-source" onchange="previewImage();">
                        <label class="custom-file-label" for="image-source">Upload Signature</label>
                    </div>
                </div>                
                <input type="hidden" name="STAT_USERS" value="1" />
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Approve -->
<div class="modal fade" id="mdlApprove" tabindex="-1" aria-labelledby="mdlApprove" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlApprove">Verifikasi Pengguna?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Anda akan menyetujui pengguna ? <span id="mdlApprove_item"></span>
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="<?= site_url('user/verif') ?>" method="post">
                    <input type="hidden" id="mdlApprove_itemId" name="ID_USERS" />
                    <button type="submit" class="btn btn-warning">Verifikasi</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reset -->
<div class="modal fade" id="mdlReset" tabindex="-1" aria-labelledby="mdlReset" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reset Password Pengguna?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Anda akan mereset password pengguna <span id="mdlRstPassUserItem_item"></span>
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="<?= site_url('user/reset-password') ?>" method="post">
                    <input type="hidden" id="mdlRstPassUserItem_itemId" name="ID_USERS" />
                    <button type="submit" class="btn btn-warning">Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="mdlDelete" tabindex="-1" aria-labelledby="mdlDelete" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlDelete">Hapus Pengguna?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Anda akan menghapus item <span id="mdlDelete_item">asdfs</span>
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="<?= site_url('user/destroy') ?>" method="post">
                    <input type="hidden" id="mdlDelete_itemId" name="ID_USERS" />
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Custom Javascript -->
<script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    $(document).ready(function() {
        // $('.toast').toast('show')
        <?php
        if (empty($notif)) {
            echo "$('.toast').toast('show')";
        }
        ?>
    })
    $(document).ready( function () {
        var table = $('#tableUser').DataTable({
        "aaSorting": [[ 7, "desc" ]],
        "aoColumnDefs": [{ "bVisible": false, "aTargets": [7] }]
        });
    } );
    $('#tableUser tbody').on('click', '.mdlDelete', function() {
        const id = $(this).data('id')
        const name = $(this).data('name')
        $('#mdlDelete_item').html(name)
        $('#mdlDelete_itemId').val(id)
    })
    $('#tableUser tbody').on('click', '.mdlRstPassUserItem', function() {
        const id = $(this).data('id')
        const name = $(this).data('name')
        $('#mdlRstPassUserItem_item').html(name)
        $('#mdlRstPassUserItem_itemId').val(id)

    })
    $('#tableUser tbody').on('click', '.mdlApprove', function() {
        const id = $(this).data('id')
        const name = $(this).data('name')
        $('#mdlApprove_item').html(name)
        $('#mdlApprove_itemId').val(id)

    })
</script>
<!-- End Custom Javascript -->