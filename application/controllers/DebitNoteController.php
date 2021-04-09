<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class DebitNoteController extends CI_Controller
{
    function __construct(){
        parent::__construct();
        $this->load->model('DebitNote');
		$this->load->library(array('upload','randomstring'));
        $this->load->helper('download');
    }
    public function vDN(){
        $datas['debitnotes'] = $this->DebitNote->getAll(['STAT_DEBITNOTE' => 0]);

		$this->load->view('template/admin_dn/header');
		$this->load->view('template/admin_dn/sidebar');
		$this->load->view('template/admin_dn/topbar');
		$this->load->view('admin_dn/master_dn/dn_raw', $datas);
		$this->load->view('template/admin_dn/footer');
    }
    public function vDNGenerated(){
        $datas['debitnotes'] = $this->DebitNote->getAll(['STAT_DEBITNOTE' => 1]);

		$this->load->view('template/admin_dn/header');
		$this->load->view('template/admin_dn/sidebar');
		$this->load->view('template/admin_dn/topbar');
		$this->load->view('admin_dn/master_dn/dn_generate', $datas);
		$this->load->view('template/admin_dn/footer');
    }
    public function vDNApproved(){
        $datas['debitnotes'] = $this->DebitNote->getAll(['STAT_DEBITNOTE' => 2]);

		$this->load->view('template/admin_dn/header');
		$this->load->view('template/admin_dn/sidebar');
		$this->load->view('template/admin_dn/topbar');
		$this->load->view('admin_dn/master_dn/dn_approved', $datas);
		$this->load->view('template/admin_dn/footer');
    }
    public function vDNRejected(){
        $datas['debitnotes'] = $this->DebitNote->getAll(['STAT_DEBITNOTE' => 3]);

		$this->load->view('template/admin_dn/header');
		$this->load->view('template/admin_dn/sidebar');
		$this->load->view('template/admin_dn/topbar');
		$this->load->view('admin_dn/master_dn/dn_rejected', $datas);
		$this->load->view('template/admin_dn/footer');
    }
    public function vDNProgress(){
        $datas['debitnotes'] = $this->DebitNote->getAll(['STAT_DEBITNOTE' => 4]);

		$this->load->view('template/admin_dn/header');
		$this->load->view('template/admin_dn/sidebar');
		$this->load->view('template/admin_dn/topbar');
		$this->load->view('admin_dn/master_dn/dn_progress', $datas);
		$this->load->view('template/admin_dn/footer');
    }
    public function vDNOverdue(){
        $datas['debitnotes'] = $this->DebitNote->getAll(['STAT_DEBITNOTE' => 5]);

		$this->load->view('template/admin_dn/header');
		$this->load->view('template/admin_dn/sidebar');
		$this->load->view('template/admin_dn/topbar');
		$this->load->view('admin_dn/master_dn/dn_overdue', $datas);
		$this->load->view('template/admin_dn/footer');
    }
    public function vDNFinished(){
        $datas['debitnotes'] = $this->DebitNote->getAll(['STAT_DEBITNOTE' => 6]);

		$this->load->view('template/admin_dn/header');
		$this->load->view('template/admin_dn/sidebar');
		$this->load->view('template/admin_dn/topbar');
		$this->load->view('admin_dn/master_dn/dn_finished', $datas);
		$this->load->view('template/admin_dn/footer');
    }



    public function vDNEdit($id){
    }

    public function store(){    
        $config['upload_path'] = './uploads/debitnote/'; //path folder
        $config['allowed_types'] = 'xls|xlsx|csv'; //type yang dapat diakses bisa anda sesuaikan
        $config['encrypt_name'] = TRUE; //Enkripsi nama yang terupload
 
        $this->upload->initialize($config);
        if(!empty($_FILES['FILEDN']['name'])){
            if($this->upload->do_upload('FILEDN')){
                $fileDN         = $this->upload->data();
                $filePath       = './uploads/debitnote/'.$fileDN['file_name'];
                $spreadsheet    = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
                $arrSpreadsheet = $spreadsheet->getActiveSheet()->toArray();
                $highestRow     = $spreadsheet->getActiveSheet()->getHighestRow();

                $value = $spreadsheet->getActiveSheet()->getCell('B5')->getValue();
                $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);

                $dataStore = array();
                for($i = 4; $i < $highestRow; $i++){
                    $date = date_create($arrSpreadsheet[$i][1]);

                    $data['ID_DEBITNOTE']               = 'DN_'.md5(time().$this->randomstring->getRandString(5));
                    $data['NOFAKTUR_DEBITNOTE']         = $arrSpreadsheet[$i][0];
                    $data['TGLFAKTUR_DEBITNOTE']        = date('Y-m-d', strtotime($arrSpreadsheet[$i][1]));
                    $data['TGLJATUH_DEBITNOTE']         = date('Y-m-d', strtotime($arrSpreadsheet[$i][2]));
                    $data['NOFAKTURPAJAK_DEBITNOTE']    = $arrSpreadsheet[$i][3];
                    $data['KURSPAJAK_DEBITNOTE']        = $arrSpreadsheet[$i][4];
                    $data['NOPELANGGAN_DEBITNOTE']      = $arrSpreadsheet[$i][5];
                    $data['EMAIL_DEBITNOTE']            = $arrSpreadsheet[$i][6];
                    $data['NOPELANGGAN_DEBITNOTE']      = $arrSpreadsheet[$i][7];
                    $data['TGLPESANAN_DEBITNOTE']       = date('Y-m-d', strtotime($arrSpreadsheet[$i][8]));
                    $data['MATAUANG']                   = $arrSpreadsheet[$i][9]; 
                    $data['NAMAPERUSAHAAN_DEBITNOTE']   = $arrSpreadsheet[$i][10];
                    $data['ALAMATPERUSAHAAN_DEBITNOTE'] = $arrSpreadsheet[$i][11]; 
                    $data['NPWP_DEBITNOTE']             = $arrSpreadsheet[$i][12];
                    $data['BARANGJASA_DEBITNOTE']       = $arrSpreadsheet[$i][13];
                    $data['HARGAJUAL_DEBITNOTE']        = str_replace(',', '', $arrSpreadsheet[$i][14]);
                    $data['TOTHARGAJUAL_DEBITNOTE']     = str_replace(',', '', $arrSpreadsheet[$i][15]);
                    $data['POTHARGA_DEBITNOTE']         = str_replace(',', '', $arrSpreadsheet[$i][16]);
                    $data['UANGMUKA_DEBITNOTE']         = str_replace(',', '', $arrSpreadsheet[$i][17]);
                    $data['HARGAPOTONGAN_DEBITNOTE']    = str_replace(',', '', $arrSpreadsheet[$i][18]);
                    $data['DPP_DEBITNOTE']              = str_replace(',', '', $arrSpreadsheet[$i][19]);
                    $data['PPN_DEBITNOTE']              = str_replace(',', '', $arrSpreadsheet[$i][20]);
                    $data['GRANDTOTAL_DEBITNOTE']       = str_replace(',', '', $arrSpreadsheet[$i][21]);
                    array_push($dataStore, $data);
                }
                $this->DebitNote->insertBatch($dataStore);
            }else {
                echo $this->upload->display_errors();	
            }
        }
        redirect('debitnote');
    }
    public function update(){
        $datas = $_POST;
        
        $this->Form->update($datas);
        redirect('form');
    }
    public function destroy(){
        $datas = $_POST;
        $this->Form->delete($datas);
        redirect('form');
    }

    public function downloadTemplate(){
        force_download('./assets/templates/DEBITNOTE_TEMPLATE.xlsx', NULL);
    }
}