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
            <form action="<?= site_url('user/update')?>" method="post" enctype="multipart/form-data">
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
                            <option value="Section Head" <?= $dataUser[0]->ROLE_USERS == 'Section Head'?'selected' : '' ?> >Head</option>
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
                            <option value="Project Management" <?= $dataUser[0]->DIV_USERS == 'Project Management'? 'selected' : 'asd' ?>>Project Management</option>
                            <option value="General Service & Maintenances Management" <?= $dataUser[0]->DIV_USERS == 'General Service & Maintenances Management'? 'selected' : 'asd' ?>>General Service & Maintenance</option>
                            <option value="Budget, Asset & Building Management" <?= $dataUser[0]->DIV_USERS == 'Budget, Asset & Building Management'? 'selected' : 'asd' ?>>Budget, Asset & Building Management</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputUsername">Username</label>
                        <input type="text" value="<?= $dataUser[0]->USER_USERS ?>" class="form-control" name="USER_USERS" placeholder="Username" required>
                    </div>
                </div>
                <div class="">
                    <label for="image-source"></label>
                         <!-- wadah preview -->
                        <img id="image-preview-edit" src="<?= $dataUser[0]->PATH_TTD ?>" alt="image preview" style="height:200px;width:200px;"/>
                    <div class="form-group col-md-6">
                        <input type="file" value="<?= $dataUser[0]->PATH_TTD ?>" name="imageTtd" class="custom-file-input" id="image-source" onchange="previewImage();">
                        <label class="custom-file-label" for="image-source">Ubah Signature</label>
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

<script type="text/javascript">
    //preview sebelum upload
    function previewImage() {
        document.getElementById("image-preview-edit").style.display = "block";
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("image-source").files[0]);
        oFReader.onload = function(oFREvent) {
            document.getElementById("image-preview-edit").src = oFREvent.target.result;
        };
    };
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>