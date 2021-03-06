<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class DebitNoteController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (empty($this->session->userdata('ROLE_USERS')) || $this->session->userdata('ROLE_USERS') != 'Admin Debitnote') {
            redirect('login');
        }

        $this->load->model('DebitNote');
        $this->load->library(array('upload', 'emailing', 'notification', 'zip'));
        $this->load->helper('download');
    }
    public function vDN()
    {
        $datas['debitnotes'] = $this->DebitNote->getAll(['STAT_DEBITNOTE' => 0]);

        $this->load->view('template/admin_dn/header');
        $this->load->view('template/admin_dn/sidebar');
        $this->load->view('template/admin_dn/topbar');
        $this->load->view('admin_dn/master_dn/dn_raw', $datas);
        $this->load->view('template/admin_dn/footer');
    }
    public function vDNGenerated()
    {
        $datas['debitnotes'] = $this->DebitNote->getAll(['STAT_DEBITNOTE' => 1]);

        $this->load->view('template/admin_dn/header');
        $this->load->view('template/admin_dn/sidebar');
        $this->load->view('template/admin_dn/topbar');
        $this->load->view('admin_dn/master_dn/dn_generate', $datas);
        $this->load->view('template/admin_dn/footer');
    }
    public function vDNApproved()
    {
        $datas['debitnotes'] = $this->DebitNote->getAll(['STAT_DEBITNOTE' => 2]);

        $this->load->view('template/admin_dn/header');
        $this->load->view('template/admin_dn/sidebar');
        $this->load->view('template/admin_dn/topbar');
        $this->load->view('admin_dn/master_dn/dn_approved', $datas);
        $this->load->view('template/admin_dn/footer');
    }
    public function vDNRejected()
    {
        $datas['debitnotes'] = $this->DebitNote->getAll(['STAT_DEBITNOTE' => 3]);

        $this->load->view('template/admin_dn/header');
        $this->load->view('template/admin_dn/sidebar');
        $this->load->view('template/admin_dn/topbar');
        $this->load->view('admin_dn/master_dn/dn_rejected', $datas);
        $this->load->view('template/admin_dn/footer');
    }
    public function vDNProgress()
    {
        $datas['debitnotes'] = $this->DebitNote->getAll(['STAT_DEBITNOTE' => 4]);

        $this->load->view('template/admin_dn/header');
        $this->load->view('template/admin_dn/sidebar');
        $this->load->view('template/admin_dn/topbar');
        $this->load->view('admin_dn/master_dn/dn_progress', $datas);
        $this->load->view('template/admin_dn/footer');
    }
    public function vDNOverdue()
    {
        $datas['debitnotes'] = $this->DebitNote->getAll(['STAT_DEBITNOTE' => 5]);

        $this->load->view('template/admin_dn/header');
        $this->load->view('template/admin_dn/sidebar');
        $this->load->view('template/admin_dn/topbar');
        $this->load->view('admin_dn/master_dn/dn_overdue', $datas);
        $this->load->view('template/admin_dn/footer');
    }
    public function vDNFinished()
    {
        $datas['debitnotes'] = $this->DebitNote->getAll(['STAT_DEBITNOTE' => 6]);

        $this->load->view('template/admin_dn/header');
        $this->load->view('template/admin_dn/sidebar');
        $this->load->view('template/admin_dn/topbar');
        $this->load->view('admin_dn/master_dn/dn_finished', $datas);
        $this->load->view('template/admin_dn/footer');
    }
    public function vDNReversed()
    {
        $datas['debitnotes'] = $this->DebitNote->getAll(['STAT_DEBITNOTE' => 7]);

        $this->load->view('template/admin_dn/header');
        $this->load->view('template/admin_dn/sidebar');
        $this->load->view('template/admin_dn/topbar');
        $this->load->view('admin_dn/master_dn/dn_reversed', $datas);
        $this->load->view('template/admin_dn/footer');
    }

    public function vDNMonitor()
    {
        $datas['debitnotes']   = $this->DebitNote->getAll(['STAT_DEBITNOTE' => 6]);
        $datas['total']        = $this->DebitNote->getdn();
        $datas['ovdtotal']     = $this->DebitNote->getovddn();
        $datas['rcvtotal']     = $this->DebitNote->getrcvdn();
        $datas['rentCharge']   = $this->DebitNote->getRentCharge();
        $datas['rentOverdue']  = $this->DebitNote->getRentOverdue();
        $datas['utilCharge']   = $this->DebitNote->getUtilCharge();
        $datas['utilOverdue']  = $this->DebitNote->getUtilOverdue();
        $datas['othersCharge'] = $this->DebitNote->getOthersCharge();
        $datas['othersOverdue'] = $this->DebitNote->getOthersOverdue();
        $datas['year_list']    = $this->DebitNote->getYearDN();
        $datas['tahunan']      = $this->DebitNote->getTahunanDN();
        $datas['tahunan2020']  = $this->DebitNote->getTahunanDN2020();
        $datas['totalTahunan'] = $this->DebitNote->grandTotal();
        $datas['topTenants']   = $this->DebitNote->getTopTenantsDN();
        $datas['agingTiga']    = $this->DebitNote->getAgingTigaPuluh();
        $datas['agingTigaEnam'] = $this->DebitNote->getAgingTigaEnam();
        $datas['agingEnam']    = $this->DebitNote->getAgingEnamPuluh();

        $this->load->view('template/admin_dn/header');
        $this->load->view('template/admin_dn/sidebar');
        $this->load->view('template/admin_dn/topbar');
        $this->load->view('admin_dn/master_dn/dn_dashboard', $datas);
        $this->load->view('template/admin_dn/monitoringfooter', $datas);
    }

    public function vDNEdit($id)
    {
    }

    public function store()
    {
        $config['upload_path'] = './uploads/debitnote/fileUploaded/';
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['file_name'] = time();

        $this->upload->initialize($config);
        if (!empty($_FILES['FILEDN']['name'])) {
            if ($this->upload->do_upload('FILEDN')) {
                $fileDN         = $this->upload->data();
                $filePath       = './uploads/debitnote/fileUploaded/' . $fileDN['file_name'];
                $spreadsheet    = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
                $arrSpreadsheet = $spreadsheet->getActiveSheet()->toArray();
                $highestRow     = $spreadsheet->getActiveSheet()->getHighestRow();

                $value = $spreadsheet->getActiveSheet()->getCell('B5')->getValue();
                $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);

                $dataStore = array();
                for ($i = 4; $i < $highestRow; $i++) {
                    $date = date_create($arrSpreadsheet[$i][1]);

                    $data['ID_DEBITNOTE']               = 'DN_' . md5(time() . $this->getRandString(5));
                    $data['NOFAKTUR_DEBITNOTE']         = $arrSpreadsheet[$i][0];
                    $data['TGLFAKTUR_DEBITNOTE']        = date('Y-m-d', strtotime($arrSpreadsheet[$i][1]));
                    $data['TGLJATUH_DEBITNOTE']         = date('Y-m-d', strtotime($arrSpreadsheet[$i][2]));
                    $data['NOFAKTURPAJAK_DEBITNOTE']    = $arrSpreadsheet[$i][3];
                    $data['KURSPAJAK_DEBITNOTE']        = $arrSpreadsheet[$i][4];
                    $data['NOPELANGGAN_DEBITNOTE']      = $arrSpreadsheet[$i][5];
                    $data['EMAIL_DEBITNOTE']            = $arrSpreadsheet[$i][6];
                    $data['NOPESANAN_DEBITNOTE']        = $arrSpreadsheet[$i][7];
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
                    $data['TIPE_DEBITNOTE']             = $arrSpreadsheet[$i][22];
                    array_push($dataStore, $data);
                }
                $this->DebitNote->insertBatch($dataStore);
            } else {
                echo $this->upload->display_errors();
            }
        }
        redirect('debitnote');
    }
    public function edit($idDebitNote)
    {
        $datas['debitnote'] = $this->DebitNote->get(['ID_DEBITNOTE' => $idDebitNote]);

        $this->load->view('template/admin_dn/header');
        $this->load->view('template/admin_dn/sidebar');
        $this->load->view('template/admin_dn/topbar');
        $this->load->view('admin_dn/master_dn/dn_raw_edit', $datas);
        $this->load->view('template/admin_dn/footer');
    }
    public function update()
    {
        $datas = $_POST;

        $this->DebitNote->update($datas);
        redirect('debitnote');
    }
    public function destroyDN()
    {
        $this->DebitNote->delete(['ID_DEBITNOTE' => $_POST['ID_DEBITNOTE']]);
        redirect('debitnote');
    }
    public function destroyMultiDN()
    {
        $this->DebitNote->deleteMulti(explode(',', $_POST['ID_DEBITNOTE']));
        redirect('debitnote');
    }
    public function reverseDN()
    {
        $datas                      = $_POST;
        $datas['STAT_DEBITNOTE']    = '7';

        $page = $datas['page'];
        unset($datas['page']);

        $this->DebitNote->update($datas);
        redirect('debitnote/' . $page);
    }
    public function reverseMultiDN()
    {
        $datas['ID_DEBITNOTES']             = explode(',', $_POST['ID_DEBITNOTE']);
        $datas['STATUS']                    = '7';
        $datas['CATATANREVERSE_DEBITNOTE']  = $_POST['CATATANREVERSE_DEBITNOTE'];

        $this->DebitNote->updateStatusMulti($datas);
        redirect('debitnote/' . $_POST['page']);
    }
    public function finish()
    {
        $datas = $_POST;
        $datas['TGLBAYAR_DEBITNOTE'] = date('Y-m-d');

        $page = $datas['page'];
        unset($datas['page']);

        $this->DebitNote->update($datas);
        redirect('debitnote/' . $page);
    }
    public function finishMulti()
    {
        $param                  = $_POST;

        $page   = $param['page'];
        $datas['ID_DEBITNOTES']         = explode(',', $_POST['ID_DEBITNOTE']);
        $datas['STATUS']                = '6';
        $datas['TGLBAYAR_DEBITNOTE']    = date('Y-m-d');

        $this->DebitNote->updateStatusMulti($datas);
        redirect('debitnote/' . $page);
    }

    public function downloadTemplate()
    {
        force_download('./assets/templates/DEBITNOTE_TEMPLATE.xlsx', NULL);
    }

    public function downloadPdf()
    {
        $param = $_POST;
        $path = str_replace(base_url(), '', $param['PATH_DEBITNOTE']);
        force_download($path, NULL);
    }

    public function getRandString($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function generateDN()
    {
        $param =  $_POST;

        $this->db->insert('DEBITNOTE_APPROVAL', ['ID_DEBITNOTE' => $param['ID_DEBITNOTE'], 'ROLE_APP' => 'Department Head']);
        $this->DebitNote->generate($param);

        $notif['title']     = 'Info Pengajuan Debit Note';
        $notif['message']   = 'Terdapat Pengajuan Debit Note';
        $notif['regisIds']  = $this->db->get_where('USERS', ['ROLE_USERS' => 'Department Head'])->result_array();
        $this->notification->push($notif);

        redirect('debitnote');
    }

    public function generateMultiDN()
    {
        $param      = explode(',', $_POST['ID_DEBITNOTE']);
        $dataStore  = array();

        foreach ($param as $item) {
            $temp['ID_DEBITNOTE']   = $item;
            $temp['ROLE_APP']       = 'Department Head';
            array_push($dataStore, $temp);
        }
        $this->db->insert_batch('DEBITNOTE_APPROVAL', $dataStore);
        $this->DebitNote->generateMulti($param);

        redirect('debitnote');
    }

    public function downloadMultiDN()
    {
        $param = explode(',', $_POST['ID_DEBITNOTE']);
        $debitNotes = $this->db->select('PATH_DEBITNOTE')->where_in('ID_DEBITNOTE', $param)->get('DEBITNOTE')->result();
        foreach ($debitNotes as $item) {
            $this->zip->read_file(str_replace(base_url(), '', $item->PATH_DEBITNOTE));
        }
        $this->zip->download(date('YmdHis') . '_Download Debitnotes.zip');
    }

    public function MonthlyDNChart()
    {
        isset($_POST["year"]) ? $year = $_POST["year"] : $year = date("Y");

        $terbitData = "";
        $receivedData = "";
        $bar_graph = "";

        $monthly = $this->DebitNote->getmonthlydn($year);
        $received = $this->DebitNote->getBulanFinishDN($year);

        $bulan = 1;
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            foreach ($monthly as $item) {
                if ($bulan == $item->BULAN) {
                    $terbitData .= '"' . $item->TOTAL . '",';
                    break;
                } else if ($item->BULAN > $bulan) {
                    $terbitData .= '"' . 0 . '",';
                    break;
                }
            }
        }
        $terbitData = substr($terbitData, 0, -1);

        $bulan = 1;
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            foreach ($received as $item) {
                if ($bulan == $item->BULAN) {
                    $receivedData .= '"' . $item->TOTAL . '",';
                    break;
                } else if ($item->BULAN > $bulan) {
                    $receivedData .= '"' . 0 . '",';
                    break;
                }
            }
        }
        $receivedData = substr($receivedData, 0, -1);

        $bar_graph = '
        <canvas id="graph" data-settings=
        \'
            {
                "labels": ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", 
                "Aug", "Sep", "Oct", "Nov", "Des"],
                "datasets":[{
                    "label": "DN Terbit",
                    "backgroundColor": "rgba(252, 131, 56, 1)",
                    "borderColor": "rgba(252, 131, 56, 1)",                    
                    "borderWidth": "1",
                    "data": [' . $terbitData . ']
                },{
                    "label": "Payment Received",
                    "backgroundColor": "rgba(49, 176, 87, 1)",
                    "borderColor": "rgba(49, 176, 87, 1)",                    
                    "borderWidth": "1",
                    "data": [' . $receivedData . ']
                }]
            }
        \'
        ></canvas>';

        echo $bar_graph;
    }

    public function PaymentDNChart()
    {
        isset($_POST["year"]) ? $year = $_POST["year"] : $year = date("Y");
        $pay_graph = "";

        $reports                = $this->DebitNote->getAllReportSummary(['TAHUN_REPORTINGYEARLY' => $year]);
        $datas['tahun']         = array();
        $datas['ListrikSisa']   = array();
        $datas['ListrikTotal']  = array();
        $datas['RentSisa']      = array();
        $datas['RentTotal']     = array();
        $datas['ServiceSisa']   = array();
        $datas['ServiceTotal']  = array();
        $datas['AirSisa']       = array();
        $datas['AirTotal']      = array();
        $datas['TelefonSisa']   = array();
        $datas['TelefonTotal']  = array();
        $datas['OthersSisa']    = array();
        $datas['OthersTotal']   = array();


        foreach ($reports as $item) {
            if(empty($datas['tahun']) || end($datas['tahun']) != $item->TAHUNBAYAR_REPORTINGYEARLY){
                array_push($datas['tahun'], $item->TAHUNBAYAR_REPORTINGYEARLY);
            }
            array_push($datas[$item->TIPE_REPORTINGYEARLY."Total"], $item->TOTAL_REPORTINGYEARLY);
            array_push($datas[$item->TIPE_REPORTINGYEARLY."Sisa"], $item->TARGET_REPORTINGYEARLY - $item->TOTAL_REPORTINGYEARLY);
        }


        $pay_graph = '
        <canvas id="payGraph" data-settings=
        \'{
                "labels": ['.implode(',', $datas['tahun']).'],
                "datasets":[{
                    "label": "Listrik Terbayar",
                    "backgroundColor": "rgba(55, 126, 87, 1)",
                    "borderColor": "rgba(55, 126, 87, 1)",                    
                    "borderWidth": "1",
                    "data": ['.implode(',', $datas['ListrikTotal']).'],
                    "stack": "Stack 0"
                },{
                    "label": "Listrik Belum Terbayar",
                    "borderColor": "rgba(99, 110, 114,1)",                    
                    "borderWidth": "1",
                    "data": ['.implode(',', $datas['ListrikSisa']).'],
                    "stack": "Stack 0"
                },{
                    "label": "Rent Terbayar",
                    "backgroundColor": "rgba(49, 176, 155, 1)",
                    "borderColor": "rgba(49, 176, 155, 1)",                    
                    "borderWidth": "1",
                    "data": ['.implode(',', $datas['RentTotal']).'],
                    "stack": "Stack 1"
                },{
                    "label": "Rent Belum Terbayar",
                    "borderColor": "rgba(99, 110, 114,1)",                    
                    "borderWidth": "1",
                    "data": ['.implode(',', $datas['RentSisa']).'],
                    "stack": "Stack 1"
                },{
                    "label": "Service Terbayar",
                    "backgroundColor": "rgba(252, 131, 56, 1)",
                    "borderColor": "rgba(252, 131, 56, 1)",                    
                    "borderWidth": "1",
                    "data": ['.implode(',', $datas['ServiceTotal']).'],
                    "stack": "Stack 2"
                },{
                    "label": "Service Belum Terbayar",
                    "borderColor": "rgba(99, 110, 114,1)",                    
                    "borderWidth": "1",
                    "data": ['.implode(',', $datas['ServiceSisa']).'],
                    "stack": "Stack 2"
                },{
                    "label": "Air Terbayar",
                    "backgroundColor": "rgba(56, 139, 242, 1)",
                    "borderColor": "rgba(56, 139, 242, 1)",                    
                    "borderWidth": "1",
                    "data": ['.implode(',', $datas['AirTotal']).'],
                    "stack": "Stack 3"
                },{
                    "label": "Air Belum Terbayar",
                    "borderColor": "rgba(99, 110, 114,1)",                    
                    "borderWidth": "1",
                    "data": ['.implode(',', $datas['AirSisa']).'],
                    "stack": "Stack 3"
                },{
                    "label": "Telepon Terbayar",
                    "backgroundColor": "rgba(155, 176, 87, 1)",
                    "borderColor": "rgba(155, 176, 87, 1)",                    
                    "borderWidth": "1",
                    "data": ['.implode(',', $datas['TelefonTotal']).'],
                    "stack": "Stack 4"
                },{
                    "label": "Telepon Belum Terbayar",
                    "borderColor": "rgba(99, 110, 114,1)",                    
                    "borderWidth": "1",
                    "data": ['.implode(',', $datas['TelefonSisa']).'],
                    "stack": "Stack 4"
                },{
                    "label": "Others Terbayar",
                    "backgroundColor": "rgba(155, 176, 155, 1)",
                    "borderColor": "rgba(155, 176, 155, 1)",                    
                    "borderWidth": "1",
                    "data": ['.implode(',', $datas['OthersTotal']).'],
                    "stack": "Stack 5"
                },{
                    "label": "Others Belum Terbayar",
                    "borderColor": "rgba(99, 110, 114,1)",                    
                    "borderWidth": "1",
                    "data": ['.implode(',', $datas['OthersSisa']).'],
                    "stack": "Stack 5"
                }]
            }
        \'
        ></canvas>';

        echo $pay_graph;
    }

    public function MonthlyTable()
    {
        isset($_POST["year"]) ? $year = $_POST["year"] : $year = date("Y");

        $monthly = $this->DebitNote->getmonthlydn($year);
        $received = $this->DebitNote->getBulanFinishDN($year);

        $terbitData = [];
        for ($i = 0; $i <= 11; $i++) {
            $terbitData[$i] = 0;
        };
        $bulan = 1;
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            foreach ($monthly as $item) {
                if ($bulan == $item->BULAN) {
                    $terbitData[$bulan - 1] = $item->TOTAL;
                    break;
                } else if ($item->BULAN > $bulan) {
                    $terbitData[$bulan - 1] = 0;
                    break;
                }
            }
        };

        $receivedData = [];
        for ($i = 0; $i <= 11; $i++) {
            $receivedData[$i] = 0;
        };
        $bulan = 1;
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            foreach ($received as $item) {
                if ($bulan == $item->BULAN) {
                    $receivedData[$bulan - 1] = $item->TOTAL;
                    break;
                } else if ($item->BULAN > $bulan) {
                    $receivedData[$bulan - 1] = 0;
                    break;
                }
            }
        };

        $dataList =
            '{
                "data": [
                    [
                        "DN Terbit",
                        "Rp. ' . number_format($terbitData[0], 0, ',', '.') . '",
                        "Rp. ' . number_format($terbitData[1], 0, ',', '.') . '",
                        "Rp. ' . number_format($terbitData[2], 0, ',', '.') . '",
                        "Rp. ' . number_format($terbitData[3], 0, ',', '.') . '",
                        "Rp. ' . number_format($terbitData[4], 0, ',', '.') . '",
                        "Rp. ' . number_format($terbitData[5], 0, ',', '.') . '",
                        "Rp. ' . number_format($terbitData[6], 0, ',', '.') . '",
                        "Rp. ' . number_format($terbitData[7], 0, ',', '.') . '",
                        "Rp. ' . number_format($terbitData[8], 0, ',', '.') . '",
                        "Rp. ' . number_format($terbitData[9], 0, ',', '.') . '",
                        "Rp. ' . number_format($terbitData[10], 0, ',', '.') . '",
                        "Rp. ' . number_format($terbitData[11], 0, ',', '.') . '"
                    ],
                    [
                        "Payment Received",
                        "Rp. ' . number_format($receivedData[0], 0, ',', '.') . '",
                        "Rp. ' . number_format($receivedData[1], 0, ',', '.') . '",
                        "Rp. ' . number_format($receivedData[2], 0, ',', '.') . '",
                        "Rp. ' . number_format($receivedData[3], 0, ',', '.') . '",
                        "Rp. ' . number_format($receivedData[4], 0, ',', '.') . '",
                        "Rp. ' . number_format($receivedData[5], 0, ',', '.') . '",
                        "Rp. ' . number_format($receivedData[6], 0, ',', '.') . '",
                        "Rp. ' . number_format($receivedData[7], 0, ',', '.') . '",
                        "Rp. ' . number_format($receivedData[8], 0, ',', '.') . '",
                        "Rp. ' . number_format($receivedData[9], 0, ',', '.') . '",
                        "Rp. ' . number_format($receivedData[10], 0, ',', '.') . '",
                        "Rp. ' . number_format($receivedData[11], 0, ',', '.') . '"
                    ]
                ]
            }';

        echo $dataList;
    }
    public function YearlyTable(){
        isset($_POST["year"]) ? $year = $_POST["year"] : $year = date("Y");

        $reports            = $this->DebitNote->getAllReportSummary(['TAHUN_REPORTINGYEARLY' => $year, 'ORDER_DESC' => 'DESC']);
        $tahunTemp          = '';
        $datas['Listrik']   = 0;
        $datas['Rent']      = 0;
        $datas['Service']   = 0;
        $datas['Air']       = 0;
        $datas['Telefon']   = 0;
        $datas['Others']    = 0;
        
        $loop = 0;
        foreach ($reports as $item) {
            if($loop == 6){
                break;
            }
            $datas[$item->TIPE_REPORTINGYEARLY] += $item->TARGETTOTAL_REPORTINGYEARLY;
            $loop++;
        }

        $dataList =
            '{
                "data": [
                    [

                        "'.$year.'",
                        "Rp. '.number_format($datas['Listrik'], 0, ',', '.').'",
                        "Rp. '.number_format($datas['Rent'], 0, ',', '.').'",
                        "Rp. '.number_format($datas['Service'], 0, ',', '.').'",
                        "Rp. '.number_format($datas['Air'], 0, ',', '.').'",
                        "Rp. '.number_format($datas['Telefon'], 0, ',', '.').'",
                        "Rp. '.number_format($datas['Others'], 0, ',', '.').'",
                        "Rp. '.number_format($datas['Listrik'] + $datas['Rent'] + $datas['Service'] + $datas['Air'] + $datas['Telefon'] + $datas['Others'], 0, ',', '.').'"
                    ]
                ]
            }';

        echo $dataList;
        // echo json_encode($datas);
    }

    public function YearlyDetailTable()
    {
        isset($_POST["year"]) ? $year = $_POST["year"] : $year = date("Y");

        $reports    = $this->DebitNote->getAllReportSummary(['TAHUN_REPORTINGYEARLY' => $year]);
        $tahunTemp  = '';
        $datas      = array();
        foreach ($reports as $item) {
            if($item->TAHUNBAYAR_REPORTINGYEARLY != $tahunTemp){
                $tahunTemp = $item->TAHUNBAYAR_REPORTINGYEARLY;
                $datas[$item->TAHUNBAYAR_REPORTINGYEARLY]            = array();
                $datas[$item->TAHUNBAYAR_REPORTINGYEARLY]['Year']    = $item->TAHUNBAYAR_REPORTINGYEARLY;
            }
            $datas[$item->TAHUNBAYAR_REPORTINGYEARLY][$item->TIPE_REPORTINGYEARLY] = $item->TOTAL_REPORTINGYEARLY;        
        }

        $totListrik = 0;
        $totRent    = 0;
        $totService = 0;
        $totAir     = 0;
        $totTelefon = 0;
        $totOthers  = 0;
        $totGrand   = 0;
        $dataTable  = array();
        foreach ($datas as $item) {
            $listrik        = (!empty($item['Listrik']) ? $item['Listrik'] : '0');
            $totListrik     += (!empty($item['Listrik']) ? $listrik : '0');
            $rent           = (!empty($item['Rent']) ? $item['Rent'] : '0');
            $totRent        += (!empty($item['Listrik']) ? $rent : '0');
            $service        = (!empty($item['Service']) ? $item['Service'] : '0');
            $totService     += (!empty($item['Listrik']) ? $service : '0');
            $air            = (!empty($item['Air']) ? $item['Air'] : '0');
            $totAir         += (!empty($item['Listrik']) ? $air : '0');
            $telefon        = (!empty($item['Telefon']) ? $item['Telefon'] : '0');
            $totTelefon     += (!empty($item['Listrik']) ? $telefon : '0');
            $others         = (!empty($item['Others']) ? $item['Others'] : '0');
            $totOthers      += (!empty($item['Listrik']) ? $others : '0');
            $grandTotal     = (int)$listrik + (int)$rent + (int)$service + (int)$air + (int)$telefon + (int)$others;
            $totGrand       += $grandTotal;
            
            $temp = '
                [

                    "'.$item['Year'].'",
                    "Rp. '.number_format($listrik, 0, ',', '.').'",
                    "Rp. '.number_format($rent, 0, ',', '.').'",
                    "Rp. '.number_format($service, 0, ',', '.').'",
                    "Rp. '.number_format($air, 0, ',', '.').'",
                    "Rp. '.number_format($telefon, 0, ',', '.').'",
                    "Rp. '.number_format($others, 0, ',', '.').'",
                    "Rp. '.number_format($grandTotal, 0, ',', '.').'"
                ]
            ';
            array_push($dataTable, $temp);
        }

        $dataList =
            '{
                "data": [
                    '.implode(',', $dataTable).'
                ]
            }';

        echo $dataList;
    }
}
