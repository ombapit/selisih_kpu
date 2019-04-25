<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gen extends CI_Controller {

	public function index()
	{
		$url = 'https://pemilu2019.kpu.go.id/static/json/wilayah/0.json';
		$data = file_get_contents($url);
		$dt = json_decode($data);
		
		foreach ($dt as $key=>$row) {
			$d['id'] = $key;
			$d['nama'] = $row->nama;
			$d['dapil'] = implode(',',$row->dapil);
			$this->db->insert('provinsi',$d);
		}
	}

	public function gen_kab() {
		$q = $this->db->get('provinsi');
		$res = $q->result();

		foreach ($res as $prov) {
			$url = 'https://pemilu2019.kpu.go.id/static/json/wilayah/'.$prov->id.'.json';
			$data = file_get_contents($url);
			$dt = json_decode($data);
			
			foreach ($dt as $key=>$row) {
				$d['id'] = $key;
				$d['id_prov'] = $prov->id;
				$d['nama'] = $row->nama;
				$d['dapil'] = implode(',',$row->dapil);
				$this->db->insert('kabkota',$d);
			}
		}
	}

	public function gen_kab_man($prov_id) {
		$url = 'https://pemilu2019.kpu.go.id/static/json/wilayah/'.$prov_id.'.json';
		$data = file_get_contents($url);
		$dt = json_decode($data);
		
		foreach ($dt as $key=>$row) {
			$d['id'] = $key;
			$d['id_prov'] = $prov_id;
			$d['nama'] = $row->nama;
			$d['dapil'] = implode(',',$row->dapil);
			$this->db->insert('kabkota',$d);
		}
	}

	public function gen_kec() {
		$this->db->select('a.*');
		$this->db->where('a.status',0);
		$this->db->join('provinsi b','a.id_prov=b.id');
		$q = $this->db->get('kabkota a');
		$res = $q->result();

		foreach ($res as $kab) {
			$url = 'https://pemilu2019.kpu.go.id/static/json/wilayah/'.$kab->id_prov.'/'.$kab->id.'.json';
			$data = file_get_contents($url);
			$dt = json_decode($data);
			
			if (isset($dt)) {
				foreach ($dt as $key=>$row) {
					$d['id'] = $key;
					$d['id_kab'] = $kab->id;
					$d['nama'] = $row->nama;
					$d['dapil'] = implode(',',$row->dapil);
					$this->db->insert('kecamatan',$d);

					$dk['status'] = 1;
					$this->db->where('id',$kab->id);
					$this->db->update('kabkota',$dk);
				}
				echo "Url Sukses: ".$url."\n";
			} else {
				echo "Error Data: ".$url."\n";
			}
		}
	}

	public function gen_kel() {
		$this->db->select('a.*,b.id id_kab,b.id_prov');
		$this->db->where('a.status',0);
		$this->db->join('kabkota b','a.id_kab=b.id');
		$q = $this->db->get('kecamatan a');
		$res = $q->result();

		foreach ($res as $kec) {
			$url = 'https://pemilu2019.kpu.go.id/static/json/wilayah/'.$kec->id_prov.'/'.$kec->id_kab.'/'.$kec->id.'.json';
			$data = file_get_contents($url);
			$dt = json_decode($data);
			
			if (isset($dt)) {
				foreach ($dt as $key=>$row) {
					$d['id'] = $key;
					$d['id_kec'] = $kec->id;
					$d['nama'] = $row->nama;
					$d['dapil'] = implode(',',$row->dapil);
					$this->db->insert('kelurahan',$d);

					$dk['status'] = 1;
					$this->db->where('id',$kec->id);
					$this->db->update('kecamatan',$dk);
				}
				echo "Url Sukses: ".$url."\n";
			} else {
				echo "Error Data: ".$url."\n";
			}
		}
	}

	public function gen_tps() {
		$cx=array(
		    "ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ),
		    "http"=>array(
		    	'timeout' => 15
		    )
		);

		$this->db->select('a.*,b.id id_kec,b.id_kab,c.id_prov');
		$this->db->where('a.status',0);
		$this->db->join('kecamatan b','a.id_kec=b.id');
		$this->db->join('kabkota c','b.id_kab=c.id');
		$q = $this->db->get('kelurahan a');
		$res = $q->result();

		foreach ($res as $kel) {
			$url = 'https://pemilu2019.kpu.go.id/static/json/wilayah/'.$kel->id_prov.'/'.$kel->id_kab.'/'.$kel->id_kec.'/'.$kel->id.'.json';
			$data = file_get_contents($url, false, stream_context_create($cx));
			$dt = json_decode($data);
		
			$this->db->trans_start();	
			if (isset($dt)) {
				foreach ($dt as $key=>$row) {
					try {
						$d['id'] = $key;
						$d['id_kel'] = $kel->id;
						$d['nama'] = $row->nama;
						$d['dapil'] = implode(',',$row->dapil);
						$this->db->insert('tps',$d);

						$dk['status'] = 1;
						$this->db->where('id',$kel->id);
						$this->db->update('kelurahan',$dk);
					} catch(Exception $e) {
					  echo 'Message: ' .$e->getMessage();
					}
				}
				echo "Url Sukses: ".$url."\n";
			} else {
				echo "Error Data: ".$url."\n";
			}
			$this->db->trans_complete();
		}
	}

	public function gen_suara() {
		$cx=array(
		    "ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ),
		);

		$this->db->select('a.*,b.id id_kec,b.id_kab,c.id_prov');
		$this->db->where('a.status_komplit',0);
		$this->db->where('a.status_temp',0);
		// $this->db->where('d.id',25823);//jakarta
		// $this->db->where('d.id',26141);//jabar
		$this->db->where('d.id',32676);//jawa tengah
		// $this->db->where('d.id',42385);//jawa timur
		// $this->db->where('d.id',51578);//banten
		$this->db->join('kecamatan b','a.id_kec=b.id');
		$this->db->join('kabkota c','b.id_kab=c.id');
		$this->db->join('provinsi d','c.id_prov=d.id');
		$q = $this->db->get('kelurahan a');
		$res = $q->result();

		foreach ($res as $kel) {
			$url = 'https://pemilu2019.kpu.go.id/static/json/hhcw/ppwp/'.$kel->id_prov.'/'.$kel->id_kab.'/'.$kel->id_kec.'/'.$kel->id.'.json';
			// $url = 'https://pemilu2019.kpu.go.id/static/json/hhcw/ppwp/6728/11635/11679/11695.json';
			$data = file_get_contents($url, false, stream_context_create($cx));
			$dt = json_decode($data);
			
			if (isset($dt->table)) {
				foreach ($dt->table as $key=>$row) {
					//check tps status
					$this->db->where('status',1);
					$this->db->where('id',$key);
					$q = $this->db->get('tps');
					$num = $q->num_rows();

					if ($num == 0 and @$row->{21} != null) {
						// echo 'lanjut';
						$url = 'https://pemilu2019.kpu.go.id/static/json/hhcw/ppwp/'.$kel->id_prov.'/'.$kel->id_kab.'/'.$kel->id_kec.'/'.$kel->id.'/'.$key.'.json';
						echo $url."\n";
						// $url = 'https://pemilu2019.kpu.go.id/static/json/hhcw/ppwp/6728/11635/11679/11695/'.$key.'.json';
						$det = file_get_contents($url, false, stream_context_create($cx));
						$row2 = json_decode($det);
						if (isset($row2)) {
							$this->db->trans_start();

							$d['id_tps'] = $key;
							$d['jumlah_pemilih'] = $row2->pemilih_j;
							$d['jumlah_pengguna'] = $row2->pengguna_j;
							$d['suara_sah'] = $row2->suara_sah;
							$d['suara_tidak_sah'] = $row2->suara_tidak_sah;
							$d['suara_total'] = $row2->suara_total;
							$d['suara_1'] = @$row2->chart->{21};
							$d['suara_2'] = @$row2->chart->{22};
							$d['c1_1'] = @$row2->images[0];
							$d['c1_2'] = @$row2->images[1];
							$this->db->insert('suara',$d);

							//download form c1
							if (@$row2->images[0] != null) {
								$folder = 'files/'.$kel->id_prov.'/'.$kel->id_kab.'/'.$kel->id_kec.'/'.$kel->id.'/'.$key;
								// mkdir($folder, 0775, true);
								$part1 = substr($key, 0, 3);
								$part2 = substr($key, 3, 3);

								// $img = $folder.'/'.@$row2->images[0];
								// $url = 'https://pemilu2019.kpu.go.id/img/c/'.$part1.'/'.$part2.'/'.$key.'/'.@$row2->images[0];
								// echo $url;
								// $content = $this->grab_image($url,$img);
								
								// $img2 = $folder.'/'.@$row2->images[1];
								// $url = 'https://pemilu2019.kpu.go.id/img/c/'.$part1.'/'.$part2.'/'.$key.'/'.@$row2->images[1];
								// echo $url;
								// $content2 = @file_get_contents($url);
								// if ($content2 === TRUE) {
								// 	$ret = file_put_contents($img2, $content2);
								// }

								// if ($content === true and $content2 === true) {
								// 	//update suara
								// 	$ds['status_c1'] = 1;
								// 	$this->db->where('id_tps',$key);
								// 	$this->db->update('suara',$ds);
								// }
							}

							//update tps
							$dtps['status'] = 1;
							$this->db->where('id',$key);
							$this->db->update('tps',$dtps);

							$this->db->trans_complete();
						}
					}
				}

				//update jika komplit
				if ($dt->progress->total == $dt->progress->proses) {
					$dk['status_komplit'] = 1;
					$this->db->where('id',$kel->id);
					$this->db->update('kelurahan',$dk);
				}

				//update temporary kelurahan
				$dtemp['status_temp'] = 1;
				$this->db->where('id',$kel->id);
				$this->db->update('kelurahan',$dtemp);
			}
		}
	}

	function grab_image($url,$saveto){
		$agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
	    $ch = curl_init ($url);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
		curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "\COMODO.crt");

		curl_setopt($ch, CURLOPT_USERAGENT, $agent);
	    curl_setopt($ch, CURLOPT_VERBOSE, true);
	    $raw=curl_exec($ch);
	    curl_close ($ch);
	    if(file_exists($saveto)){
	        unlink($saveto);
	    }
	    $fp = fopen($saveto,'x');
	    fwrite($fp, $raw);
	    fclose($fp);
	}
}
