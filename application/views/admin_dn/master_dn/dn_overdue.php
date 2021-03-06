<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Debit Note (Overdue)</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-warning mb-2">Daftar Debit Note (Overdue)</h6>
                <div>
                    <button class="btn btn-sm btn-success shadow-sm" id="finishMultiple" data-toggle="modal" data-target="#mdlFinishMulti" disabled>
                        <i class="fas fa-check"></i>
                        Finish Multiple
                    </button>
                    <button class="btn btn-sm btn-info shadow-sm" id="downloadMultiple" data-toggle="modal" data-target="#mdlDownloadMulti" disabled>
                        <i class="fas fa-download"></i>
                        Download Multiple
                    </button>
                    <button class="btn btn-sm btn-danger shadow-sm" id="reverseMultiple" data-toggle="modal" data-target="#mdlReverseMulti" disabled>
                        <i class="fas fa-undo"></i>
                        Reverse Multiple
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tableTransaction" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>
                                <div class="custom-control custom-checkbox" style="text-align:center;">
                                    <input type="checkbox" class="custom-control-input" id="checkAll">
                                    <label class="custom-control-label" for="checkAll"></label>
                                </div>
                            </th>
                            <th>No. DN</th>
                            <th>Tanggal DN</th>
                            <th>Tanggal Jatuh Tempo</th>
                            <th>No. Faktur Pajak</th>
                            <th>Nama Perusahaan</th>
                            <th>Barang / Jasa Kena Pajak</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($debitnotes as $item) {
                            echo '
                                    <tr>
                                        <td>' . $no . '</td>
                                        <td>
                                            <div class="custom-control custom-checkbox" style="text-align:center;">
                                                <input type="checkbox" class="custom-control-input checkItem" id="chck_' . $no . '" value="' . $item->ID_DEBITNOTE . '">
                                                <label class="custom-control-label" for="chck_' . $no . '"></label>
                                            </div>
                                        </td>
                                        <td>' . $item->NOFAKTUR_DEBITNOTE . '</td>
                                        <td>' . date_format(date_create($item->TGLFAKTUR_DEBITNOTE), 'j F Y') . '</td>
                                        <td>' . date_format(date_create($item->TGLJATUH_DEBITNOTE), 'j F Y') . '</td>
                                        <td>' . $item->NOFAKTURPAJAK_DEBITNOTE . '</td>
                                        <td>' . $item->NAMAPERUSAHAAN_DEBITNOTE . '</td>
                                        <td>' . $item->BARANGJASA_DEBITNOTE . '</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-success btn-sm rounded mdlFinish" data-id="' . $item->ID_DEBITNOTE . '" data-toggle="modal" data-target="#mdlFinish" data-tooltip="tooltip" data-placement="top" title="Finished">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                <button type="button" data-toggle="modal" data-id="' . $item->PATH_DEBITNOTE . '" data-name="' . $item->NOFAKTUR_DEBITNOTE . '" data-target="#mdlDownload" class="btn btn-info btn-sm ml-1 rounded mdlDownload" data-tooltip="tooltip" data-placement="top" title="Download">
                                                    <i class="fas fa-download"></i>
                                                </button> 
                                                <button type="button" data-toggle="modal" data-src="' . $item->PATH_DEBITNOTE . '" data-target="#mdlView" class="btn btn-primary btn-sm ml-1 rounded mdlView" data-tooltip="tooltip" data-placement="top" title="Detail">
                                                    <i class="fa fa-eye"></i>
                                                </button>                                                
                                                <button type="button" data-toggle="modal" data-id="' . $item->ID_DEBITNOTE . '" data-name="' . $item->NOFAKTUR_DEBITNOTE . '" data-target="#mdlReverse" class="btn btn-danger btn-sm ml-1 rounded mdlReverse" data-tooltip="tooltip" data-placement="top" title="Reverse">
                                                    <i class="fa fa-undo"></i>
                                                </button>   
                                            </div>
                                        </td>
                                    </tr>
                                ';
                            $no++;
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
                <h5 class="modal-title" id="mdlAdd">Tambah Debit Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('debitnote/store') ?>" enctype="multipart/form-data" method="post">
                <div class="modal-body" style="padding-left:6%;padding-right:6%;">
                    <div class="col">
                        <input type="file" name="FILEDN" class="custom-file-input" id="fileDN">
                        <label class="custom-file-label" for="fileDN">Unggah Debit Note</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Finish -->
<div class="modal fade" id="mdlFinish" tabindex="-1" aria-labelledby="mdlFinish" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlApprove">Finish Debitnote?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Anda akan mevalidasi item ?
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="<?= site_url('debitnote/finish') ?>" method="post">
                    <input type="hidden" id="mdlFinish_id" name="ID_DEBITNOTE" />
                    <input type="hidden" id="mdlFinish_id" name="STAT_DEBITNOTE" value="6" />
                    <input type="hidden" name="page" value="overdue" />
                    <button type="submit" class="btn btn-warning">Selesai</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Download -->
<div class="modal fade" id="mdlDownload" tabindex="-1" aria-labelledby="mdlDownload" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlDownload">Download Debit Note?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Anda akan mengunduh Debit Note dengan No. Faktur <span id="mdlDownload_item"></span> ?
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="<?= site_url('debitnote/downloadPdf') ?>" id="formDownload" method="post">
                    <input type="hidden" id="mdlDownload_id" name="PATH_DEBITNOTE" />
                    <button type="submit" class="btn btn-success" onclick="submit_form();", data-dismiss="modal">Download</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Download Multiple -->
<div class="modal fade" id="mdlDownloadMulti" tabindex="-1" aria-labelledby="mdlGenerate" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlGenerate">Download Debit Note?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Anda akan men-download <span id="mdlDownloadMulti_count"></span> debitnote
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="<?= site_url('debitnote/downloadMultiDN') ?>" method="post">
                    <input type="hidden" id="mdlDownloadMulti_itemId" name="ID_DEBITNOTE" />
                    <button type="submit" class="btn btn-info">Download</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Finish Multiple -->
<div class="modal fade" id="mdlFinishMulti" tabindex="-1" aria-labelledby="mdlGenerate" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlGenerate">Finish Debit Note?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Anda akan mevalidasi <span id="mdlFinishMulti_count"></span> debitnote
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="<?= site_url('debitnote/finishMulti') ?>" method="post">
                    <input type="hidden" id="mdlFinishMulti_itemId" name="ID_DEBITNOTE" />
                    <input type="hidden" id="" name="page" value="overdue" />
                    <button type="submit" class="btn btn-success">Finish</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Reverse -->
<div class="modal fade" id="mdlReverse" tabindex="-1" aria-labelledby="mdlReverse" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlReject">Reverse Debit Note?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Anda akan me reverse Debit Note dengan No. Faktur <span id="mdlReverse_item"></span> ?
                </p>
                <form action="<?= site_url('debitnote/reverseDN') ?>" method="post">
                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea class="form-control" name="CATATANREVERSE_DEBITNOTE" required></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="mdlReverse_itemId" name="ID_DEBITNOTE" />
                <input type="hidden" id="" name="page" value="overdue" />
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Reverse</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Reverse Multiple -->
<div class="modal fade" id="mdlReverseMulti" tabindex="-1" aria-labelledby="mdlReverse" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlGenerate">Reverse Debit Note?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Anda akan men-reverse <span id="mdlReverseMulti_count"></span> debitnote
                </p>
                <form action="<?= site_url('debitnote/reverseMultiDN') ?>" method="post">
                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea class="form-control" name="CATATANREVERSE_DEBITNOTE" required></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <input type="hidden" id="mdlReverseMulti_itemId" name="ID_DEBITNOTE" />
                <input type="hidden" id="" name="page" value="overdue" />
                <button type="submit" class="btn btn-danger">Reverse</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal View PDF -->
<div class="modal fade" id="mdlView" tabindex="-1" aria-labelledby="mdlView" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlReject">Detail Debit Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe id="mdlView_src" src="" frameborder="0" width="100%" height="500px"></iframe>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
<script>
    function submit_form() {
      document.getElementById('formDownload').submit();
    }
</script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: 'resolve'
        });
    });
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    $('#tableTransaction tbody').on('click', '.mdlFinish', function() {
        const id = $(this).data("id")
        $('#mdlFinish_id').val(id)
    })
    $('#tableTransaction tbody').on('click', '.mdlDownload', function() {
        const id = $(this).data("id")
        const name = $(this).data('name')
        $('#mdlDownload_item').html(name)
        $('#mdlDownload_id').val(id)
    })
    $('#tableTransaction tbody').on('click', '.mdlView', function() {
        const src = $(this).data("src")
        $('#mdlView_src').attr('src', src);
    })
    $('#downloadMultiple').click(function() {
        const dnIds = $('.checkItem:checkbox:checked').map((_, elm) => elm.value).get()
        $('#mdlDownloadMulti_count').html(dnIds.length)
        $('#mdlDownloadMulti_itemId').val(dnIds.toString())

    })
    $('#finishMultiple').click(function() {
        const dnIds = $('.checkItem:checkbox:checked').map((_, elm) => elm.value).get()
        $('#mdlFinishMulti_count').html(dnIds.length)
        $('#mdlFinishMulti_itemId').val(dnIds.toString())

    })
    $('#tableTransaction tbody').on('click', '.mdlReverse', function() {
        const id = $(this).data("id")
        const name = $(this).data('name')
        $('#mdlReverse_item').html(name)
        $('#mdlReverse_itemId').val(id)
    })
    $('#reverseMultiple').click(function() {
        const dnIds = $('.checkItem:checkbox:checked').map((_, elm) => elm.value).get()
        $('#mdlReverseMulti_count').html(dnIds.length)
        $('#mdlReverseMulti_itemId').val(dnIds.toString())

    })
    $('#checkAll').change(function() {
        const isChecked = $(this).prop('checked')
        if (isChecked) {
            $('.checkItem').prop('checked', true)
        } else {
            $('.checkItem').prop('checked', false)
        }
        buttonMultipleAvailable()
    })
    $('.checkItem').change(function() {
        buttonMultipleAvailable()
    })
    const buttonMultipleAvailable = () => {
        const isChecked = $('.checkItem:checkbox:checked').prop('checked')
        if (isChecked) {
            $('#downloadMultiple').attr('disabled', false)
            $('#finishMultiple').attr('disabled', false)
            $('#reverseMultiple').attr('disabled', false)
        } else {
            $('#downloadMultiple').attr('disabled', true)
            $('#finishMultiple').attr('disabled', true)
            $('#reverseMultiple').attr('disabled', true)
        }
    }
</script>