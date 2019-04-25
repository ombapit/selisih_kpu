<button name="kembali" onclick="get_suara()" class="btn btn-primary marbot">Kembali</button>
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Kab/Kota</th>
			<th colspan="2" class="center">Perolehan Suara</th>			
		</tr>
		<tr>
			<th>&nbsp;</th>
			<th>Jokowi/Ma'ruf</th>
			<th>Prabowo/Sandiaga</th>
		</tr>
	</thead>
	<?php foreach ($data as $row) { ?>
	<tr>
		<?php if ($row->tot_1 == "") { ?>
			<td><?php echo $row->nama;?></td>
			<td class="center" colspan="2">Data belum tersedia</td>
		<?php } else { ?>
			<td><a href="javascript:void(0)" onclick="get_suara(<?php echo $row->id_prov;?>,<?php echo $row->id;?>)"><?php echo $row->nama;?></a></td>
			<td class="center"><?php echo number_format($row->tot_1,0,',','.');?></td>
			<td class="center"><?php echo number_format($row->tot_2,0,',','.');?></td>
		<?php } ?>
	</tr>
	<?php } ?>
</table>