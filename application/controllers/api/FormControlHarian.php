<?php defined('BASEPATH') OR exit('No direct script access allowed');
// require APPPATH . '/libraries/REST_Controller.php';
use chriskacerguis\RestServer\RestController;

class FormControlHarian extends RestController {
    public function __construct() {
        parent::__construct();
        $this->load->helper("url");
        $this->load->library(array('upload', 'image_lib'));
    }

    public function index_post(){
        $param = $this->post();
        if(!empty($param['idUser']) && !empty($param['idMapping']) && !empty($param['kondisi']) && !empty($param['kendaraan']) && !empty($param['makanan']) && !empty($param['sample']) && !empty($param['kebersihan']) && $param['kondisiKet']!='' && $param['kendaraanKet']!='' && $param['makananKet']!='' && $param['pesananKet']!='' && $param['sampleKet']!='' && $param['kebersihanKet']!=''){
            $user       = $this->db->get_where('USERS', ['ID_USERS' => $param['idUser']])->result();
            $mapping    = $this->db->get_where('MAPPING', ['ID_MAPPING' => $param['idMapping']])->result();
            if($user != null && $mapping != null){
                $idTrans        = 'TRANS_'.md5(time()."trans");
                $idControl       = 'CONTROL_'.md5(time()."control");
                
                $storeTransaksi['ID_TRANS']         = $idTrans;
                $storeTransaksi['ID_USERS']         = $param['idUser'];
                $storeTransaksi['ID_MAPPING']       = $param['idMapping'];
                $this->db->insert('TRANSACTION', $storeTransaksi);

                $storeControl['ID_CONTROL']             = $idControl;
                $storeControl['ID_TRANS']               = $idTrans;
                $storeControl['KONDISI_CONTROL']        = $param['kondisi'].";".$param['kondisiKet'].";";
                $storeControl['KENDARAAN_CONTROL']      = $param['kendaraan'].";".$param['kendaraanKet'].";";
                $storeControl['MAKANAN_CONTROL']        = $param['makanan'].";".$param['makananKet'].";";
                $storeControl['PESANAN_CONTROL']        = $param['pesanan'].";".$param['pesananKet'].";";
                $storeControl['SAMPLE_CONTROL']         = $param['sample'].";".$param['sampleKet'].";";
                $storeControl['KEBERSIHAN_CONTROL']     = $param['kebersihan'].";".$param['kebersihanKet'].";";
                $this->db->insert('FORM_CONTROL', $storeControl);
                
                $flow = $this->db->get_where('FLOW', ['ID_MAPPING' => $mapping[0]->ID_MAPPING])->result_array();
                for($i = 1; $i <= 15; $i++){
                    if(!empty($flow[0]['APP_'.$i]) && $flow[0]['APP_'.$i] != null){
                        $this->db->insert('DETAIL_APPROVAL', ['ID_TRANS' => $idTrans, 'ROLE_APP' => $flow[0]['APP_'.$i]]);
                    }else if($flow[0]['APP_1'] == null){
                        $this->db->where('ID_TRANS', $idTrans)->update('TRANSACTION', ['STAT_TRANS' => '2']);
                    }
                }
                
                $resLinkGenerated = $this->ContentPdf->generate(['idTrans' => $idTrans, 'orientation' => 'portrait']);
                $this->db->where('ID_TRANS', $idTrans)->update('TRANSACTION', ['PATH_TRANS' => base_url($resLinkGenerated)]);
                $this->pusherjs->push();
                $this->response(['status' => true, 'message' => 'Data berhasil ditambahkan'], 200);
            }else{
                $this->response(['status' => false, 'message' => 'Data user atau mapping tidak ditemukan'], 200);
            }
        }else{
            $this->response(['status' => false, 'message' => 'Parameter tidak cocok'], 200);
        }
    }
}
