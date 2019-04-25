<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		$this->load->view('dashboard');
	}

	public function get_suara() {
		$prov = $this->input->post('prov');
		$kab = $this->input->post('kab');
		$kec = $this->input->post('kec');
		$kel = $this->input->post('kel');
		$tps = $this->input->post('tps');

		if ($tps != "") {
			$this->gen_tps($prov,$kab,$kec,$kel,$tps);
		} else if ($kel != "") {
			$this->gen_kel($prov,$kab,$kec,$kel);
		} else if ($kec != "") {
			$this->gen_kec($prov,$kab,$kec);
		} else if ($kab != "") {
			$this->gen_kab($prov,$kab);
		} else if ($prov != "") {
			$this->gen_prov($prov);
		} else {
			$this->gen_nasional();
		}
	}

	function gen_nasional() {
		$this->db->select('a.*,sum(suara_1) tot_1, sum(suara_2) tot_2');
		$this->db->order_by('nama');
		$this->db->join('kabkota b','a.id=b.id_prov');
		$this->db->join('kecamatan c','b.id=c.id_kab');
		$this->db->join('kelurahan d','c.id=d.id_kec');
		$this->db->join('tps e','d.id=e.id_kel');
		$this->db->join('suara f','e.id=f.id_tps','left');
		$this->db->group_by('a.id');
		$q = $this->db->get('provinsi a');
		$res = $q->result();
		$data['data'] = $res;
		$this->load->view('nasional',$data);
	}

	function gen_prov($prov) {
		$this->db->select('b.*,sum(suara_1) tot_1, sum(suara_2) tot_2');
		$this->db->order_by('nama');
		$this->db->where('id_prov',$prov);
		$this->db->join('kecamatan c','b.id=c.id_kab');
		$this->db->join('kelurahan d','c.id=d.id_kec');
		$this->db->join('tps e','d.id=e.id_kel');
		$this->db->join('suara f','e.id=f.id_tps','left');
		$this->db->group_by('b.id');
		$q = $this->db->get('kabkota b');
		$res = $q->result();
		$data['data'] = $res;
		$this->load->view('provinsi',$data);
	}

	function gen_kab($prov,$kab) {
		$this->db->select('c.*,sum(suara_1) tot_1, sum(suara_2) tot_2');
		$this->db->order_by('nama');
		$this->db->where('id_kab',$kab);
		$this->db->join('kelurahan d','c.id=d.id_kec');
		$this->db->join('tps e','d.id=e.id_kel');
		$this->db->join('suara f','e.id=f.id_tps','left');
		$this->db->group_by('c.id');
		$q = $this->db->get('kecamatan c');
		$res = $q->result();
		$data['prov_id'] = $prov;
		$data['data'] = $res;
		$this->load->view('kabkota',$data);
	}

	function gen_kec($prov,$kab,$kec) {
		$this->db->select('d.*,sum(suara_1) tot_1, sum(suara_2) tot_2');
		$this->db->order_by('nama');
		$this->db->where('id_kec',$kec);
		$this->db->join('tps e','d.id=e.id_kel');
		$this->db->join('suara f','e.id=f.id_tps','left');
		$this->db->group_by('d.id');
		$q = $this->db->get('kelurahan d');
		$res = $q->result();
		$data['prov_id'] = $prov;
		$data['kab_id'] = $kab;
		$data['data'] = $res;
		$this->load->view('kecamatan',$data);
	}

	function gen_kel($prov,$kab,$kec,$kel) {
		$this->db->select('e.*,sum(suara_1) tot_1, sum(suara_2) tot_2');
		$this->db->order_by('nama');
		$this->db->where('id_kel',$kel);
		$this->db->join('suara f','e.id=f.id_tps','left');
		$this->db->group_by('e.id');
		$q = $this->db->get('tps e');
		$res = $q->result();
		$data['prov_id'] = $prov;
		$data['kab_id'] = $kab;
		$data['kec_id'] = $kec;
		$data['data'] = $res;
		$this->load->view('kelurahan',$data);
	}

	function gen_tps($prov,$kab,$kec,$kel,$tps) {
		$this->db->order_by('a.nama');
		$this->db->where('a.id',$tps);
		$this->db->join('suara b','a.id=b.id_tps','left');
		$q = $this->db->get('tps a');
		$res = $q->row();
		$data['prov_id'] = $prov;
		$data['kab_id'] = $kab;
		$data['kec_id'] = $kec;
		$data['kel_id'] = $kel;
		$data['data'] = $res;
		$this->load->view('tps',$data);
	}
}