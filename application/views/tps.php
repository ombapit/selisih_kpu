<button name="kembali" onclick="get_suara(<?php echo $prov_id;?>,<?php echo $kab_id;?>,<?php echo $kec_id;?>,<?php echo $kel_id;?>)" class="btn btn-primary marbot">Kembali</button>
<table class="table table-bordered">
	<thead>
		<tr>
			<th class="center">HASIL HITUNG SUARA PEMILU PRESIDEN & WAKIL PRESIDEN RI 2019</th>
		</tr>
		<tr>
			<th class="center">Wilayah Pemilihan <?php echo get_name('kecamatan',$kec_id,'id','nama').' '.get_name('kelurahan',$kel_id,'id','nama');?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<h5>DATA PEMILIH DAN PENGGUNAAN HAK PILIH</h5>
				<table class="table">
					<thead>
						<tr>
							<th>URAIAN</th>
							<th>JUMLAH (L+P)</th>
						</tr>	
					</thead>
					<tbody>
						<tr>
							<td>PEMILIH TERDAFTAR (DPT)</td>
							<td><?php echo number_format($data->jumlah_pemilih,0,',','.');?></td>
						</tr>
						<tr>
							<td>PENGGUNA HAK PILIH</td>
							<td><?php echo number_format($data->jumlah_pengguna,0,',','.');?></td>
						</tr>
					</tbody>
				</table>
				<h5>PEROLEHAN SUARA</h5>
				<table class="table">
					<thead>
						<tr>
							<th colspan="2">URAIAN</th>
							<th>SUARA SAH</th>
						</tr>	
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>(01) Ir. H. JOKO WIDODO - Prof. Dr. (H.C) KH. MA'RUF AMIN</td>
							<td><?php echo number_format($data->suara_1,0,',','.');?></td>
						</tr>
						<tr>
							<td>2</td>
							<td>(02) H. PRABOWO SUBIANTO - H. SANDIAGA SALAHUDIN UNO</td>
							<td><?php echo number_format($data->suara_2,0,',','.');?></td>
						</tr>
					</tbody>
				</table>

				<h5>JUMLAH SUARA SAH DAN TIDAK SAH</h5>
				<table class="table">
					<thead>
						<tr>
							<th colspan="2">URAIAN</th>
							<th>JUMLAH</th>
						</tr>	
					</thead>
					<tbody>
						<tr>
							<td>A</td>
							<td>JUMLAH SELURUH SUARA SAH</td>
							<td><?php echo number_format($data->suara_sah,0,',','.');?></td>
						</tr>
						<tr>
							<td>B</td>
							<td>JUMLAH SUARA TIDAK SAH</td>
							<td><?php echo number_format($data->suara_tidak_sah,0,',','.');?></td>
						</tr>
						<tr>
							<td>C</td>
							<td>JUMLAH SELURUH SUARA SAH DAN SUARA TIDAK SAH</td>
							<td><?php echo number_format($data->suara_total,0,',','.');?></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>