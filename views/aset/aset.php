<h2 class="page-title"><b>Data Aset</b></h2>
<div class="row">
	<div class="col-md-12">
		<!-- TABLE NO PADDING -->
		<?= $this->session->flashdata('msg') ?>
		<div class="clearfix">
			<a class="btn btn-xs btn-success" href="#" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Catat Aset</a>
		</div>
		<hr>
		<div class="panel panel-default">
			<div class="panel-body">
				<table class="table table-striped table-responsive datatables-example responsive" id="table">
					<thead>
						<tr>
							<th>
								#
							</th>
							<th>
								Tanggal Catat
							</th>
							<th>
								Aset Toko
							</th>
							<th>
								Tabungan
							</th>
							<th>
								Perabotan Alat
							</th>
							<th>
								Lainnya
							</th>
							<th>
								Piutang
							</th>
							<th>
								Hutang
							</th>
							<th>
								Keterangan
							</th>
							<th>
								Aksi
							</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=0; foreach ($aset as $data): ?>
						<tr>
							<td>
								<?= ++$i ?>
							</td>
							<td>
								<?= TanggalIndo($data->tanggal) ?>
							</td>
							<td>
								<?= $data->aset_toko ?>
							</td>
							<td>
								<?= $data->tabungan ?>
							</td>
							<td>
								<?= $data->perabotan_alat ?>
							</td>
							<td>
								<?= $data->lainnya ?>
							</td>
							<td>
								<?= $data->piutang ?>
							</td>
							<td>
								<?= $data->hutang ?>
							</td>
							<td>
								<?= $data->keterangan ?>
							</td>
							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-danger btn-sm" onclick="deleteData(<?= $data->id ?>)">Delete</button>
								</div>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
	<!-- END TABLE NO PADDING -->
</div>
</div>

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Catat Aset</h4>
			</div>
			<?=form_open('barang/aset')?>
			<div class="modal-body">
				<div class="form-group">
					<label>Tanggal</label>
					<input class="form-control" type="date" name="tanggal" required="">
				</div>
				<div class="form-group">
					<label>Aset Toko</label>
					<input class="form-control" type="text" name="aset_toko">
				</div>
				<div class="form-group">
					<label>Aset Tabungan</label>
					<input class="form-control" type="text" name="tangungan">
				</div>
				<div class="form-group">
					<label>Aset Perabotan Alat</label>
					<input class="form-control" type="text" name="perabotan_alat">
				</div>
				<div class="form-group">
					<label>Aset Lainnya</label>
					<input class="form-control" type="text" name="lainnya">
				</div>
				<div class="form-group">
					<label>Aset Piutang</label>
					<input class="form-control" type="text" name="piutang">
				</div>
				<div class="form-group">
					<label>Hutang</label>
					<input class="form-control" type="text" name="hutang">
				</div>
				<div class="form-group">
					<label>Keterangan</label>
					<input class="form-control" type="text" name="keterangan">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				<input type="submit" class="btn btn-primary" name="tambah" value="Simpan">
			</div>
			<?=form_close()?>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>


<script type="text/javascript">
	
	function deleteData(id) {
		swal({
			title: "Apakah Anda Ingin Menghapus Data ini?",
			text: ' ',
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Ya",
			cancelButtonText: "Tidak",
			closeOnConfirm: true,
			closeOnCancel: true
		},
		function(isConfirm){
			if (isConfirm) {
				$.ajax({
					url: '<?= base_url('barang/aset') ?>',
					type: 'POST',
					data: {
						delete: true,
						id: id
					},
					success: function() {
						window.location = '<?= base_url('barang/aset') ?>';
					}
				});
			}
		});
	}
</script>