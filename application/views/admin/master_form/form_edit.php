<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Form</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-warning"><?= $form[0]->NAMA_FORM?></h6>
            </div>
        </div>
        <div class="card-body">
            <form action="<?= site_url('form/update')?>" method="post">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputNamaTabel">Nama Tabel</label>
                        <select class="custom-select" name="NAMA_TABEL" required>
                            <option value="" selected>Nama Tabel</option>
                            <?php
                                foreach($tables as $item){
                                    $isSelected = $item->table_name == $form[0]->NAMA_TABEL?"selected" : "";
                                    echo '
                                        <option value="'.$item->table_name.'" '.$isSelected.'>'.$item->table_name.'</option>
                                    ';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputNoDoc">No Doc</label>
                        <input type="text" class="form-control" name="NO_DOC" value="<?= $form[0]->NO_DOC?>" id="inputNoDoc" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputNamaForm">Nama Form</label>
                        <input type="text" class="form-control" name="NAMA_FORM" value="<?= $form[0]->NAMA_FORM?>" id="inputNamaTabel" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputSectionForm">Section Form</label>
                        <select class="custom-select" name="SECTION_FORM" required>
                            <option value="" selected>Departement</option>
                            <option value="General Affairs" <?= $form[0]->SECTION_FORM == 'General Affairs'? 'selected' : 'asd' ?>>General Affairs</option>
                            <option value="Others" <?= $form[0]->SECTION_FORM == 'Others'? 'selected' : 'asd' ?>>Others</option>
                        </select>
                    </div>
                </div>
                
                <input type="hidden" name="ID_MAPPING" value="<?= $form[0]->ID_MAPPING?>"/>
                <a href="<?= site_url('form') ?>" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-warning">Simpan</button>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->