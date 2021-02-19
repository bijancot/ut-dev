<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-warning"><?= $dataUser[0]->NAMA_USERS?></h6>
            </div>
        </div>
        <div class="card-body">
            <form action="<?= site_url('user/update')?>" method="post">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputNama">Nama</label>
                        <input type="text" class="form-control" value="<?= $dataUser[0]->NAMA_USERS ?>" placeholder="Nama" name="NAMA_USERS" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputRole">Role</label>
                        <select class="custom-select" name="ROLE_USERS" required>
                            <option value="">Role</option>
                            <option value="Head" <?= $dataUser[0]->ROLE_USERS == 'Head'?'selected' : '' ?> >Head</option>
                            <option value="Staff" <?= $dataUser[0]->ROLE_USERS == 'Staff'? 'selected' : '' ?> >Staff</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputDepartemen">Departemen</label>
                        <select class="custom-select" name="DEPT_USERS" required>
                            <option value="" >Departement</option>
                            <option value="General" <?= $dataUser[0]->DEPT_USERS == 'General'? 'selected' : '' ?>>General</option>
                            <option value="Affairs" <?= $dataUser[0]->DEPT_USERS == 'Affairs'? 'selected' : '' ?>>Affairs</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputDivisi">Divisi</label>
                        <select class="custom-select" name="DIV_USERS" required>
                            <option value="">Divisi</option>
                            <option value="Asset" <?= $dataUser[0]->DIV_USERS == 'Asset'? 'selected' : 'asd' ?>>Asset</option>
                            <option value="Project Management" <?= $dataUser[0]->DIV_USERS == 'Project Management'? 'selected' : 'asd' ?>>Project Management</option>
                            <option value="General Service & Maintenances" <?= $dataUser[0]->DIV_USERS == 'General Service & Maintenances'? 'selected' : 'asd' ?>>General Service & Maintenance</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputUsername">Username</label>
                        <input type="text" value="<?= $dataUser[0]->USER_USERS ?>" class="form-control" name="USER_USERS" placeholder="Username" required>
                    </div>
                </div>
                <!-- <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputPassword">Password</label>
                        <input type="text" clasIlham Sagita Putras="form-control" id="inputPassword">
                    </div>
                </div> -->
                <input type="hidden" value="<?= $dataUser[0]->ID_USERS?>" name="ID_USERS" />
                <a href="<?= site_url('user') ?>" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-warning">Simpan</button>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->