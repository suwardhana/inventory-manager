<h2 class="page-title"><b>Data Kemampuan</b></h2>
<div class="row">
	<div class="col-md-12">
		<!-- TABLE NO PADDING -->
		<?= $this->session->flashdata('msg') ?>
		<div class="clearfix">
			<a class="btn btn-xs btn-success" href="#" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Catat Kemampuan</a>
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
								Nama
							</th>
							<th>
								Tanggal Catat
							</th>
							<th>
								Komunikasi
							</th>
							<th>
								Packing
							</th>
							<th>
								Inisiatif
							</th>
							<th>
								Kedisiplinan
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
						<?php $i=0; foreach ($kemampuan as $data):  ?>
						<tr>
							<td>
								<?= ++$i ?>
							</td>
							<td>
								<?= $data->nama ?>
							</td>
							<td>
								<?= TanggalIndo($data->tanggal) ?>
							</td>
							<td>
								<?= $data->komunikasi ?>
							</td>
							<td>
								<?= $data->packing ?>
							</td>
							<td>
								<?= $data->inisiatif ?>
							</td>
							<td>
								<?= $data->kedisiplinan ?>
							</td>
							<td>
								<?= $data->keterangan ?>
							</td>
							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-placement="bottom" data-target="#edit" onclick="edit(<?= $data->id ?>)">Edit</button>
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
				<h4 class="modal-title" id="myModalLabel">Catat Peminjaman</h4>
			</div>
			<?=form_open('absen/kemampuan')?>
			<div class="modal-body">
				<div class="form-group">
					<label>Nama</label>
					<input class="form-control" type="text" name="nama">
				</div>
				<div class="form-group">
					<label>Tanggal Catat</label>
					<input class="form-control" type="date" name="tanggal_catat" required="">
				</div>
				<div class="form-group">
					<label>Komunikasi</label>
					<input class="form-control" type="text" name="komunikasi">
				</div>
				<div class="form-group">
					<label>Packing</label>
					<input class="form-control" type="text" name="packing">
				</div>
				<div class="form-group">
					<label>Inisiatif</label>
					<input class="form-control" type="text" name="inisiatif">
				</div>
				<div class="form-group">
					<label>Kedisiplinan</label>
					<input class="form-control" type="text" name="kedisiplinan">
				</div>
				<div class="form-group">
					<label>Keterangan</label>
					<textarea name="keterangan" id="" cols="5" rows="5" class="form-control"></textarea>
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
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Edit</h4>
			</div>
			<?=form_open('absen/kemampuan')?>
			<div class="modal-body">
				<input type="hidden" name="id" id="id_kemampuan_edit">
				<div class="form-group">
					<label>Nama</label>
					<input class="form-control" type="text" name="nama" id="nama_edit">
				</div>
				<div class="form-group">
					<label>Tanggal Catat</label>
					<input class="form-control" type="date" name="tanggal_catat" required="" id="tanggal_catat_edit">
				</div>
				<div class="form-group">
					<label>Komunikasi</label>
					<input class="form-control" type="text" name="komunikasi" id="komunikasi_edit">
				</div>
				<div class="form-group">
					<label>Packing</label>
					<input class="form-control" type="text" name="packing" id="packing_edit">
				</div>
				<div class="form-group">
					<label>Inisiatif</label>
					<input class="form-control" type="text" name="inisiatif" id="inisiatif_edit">
				</div>
				<div class="form-group">
					<label>Kedisiplinan</label>
					<input class="form-control" type="text" name="kedisiplinan" id="kedisiplinan_edit">
				</div>
				<div class="form-group">
					<label>Keterangan</label>
					<input class="form-control" type="text" name="keterangan" id="keterangan_edit">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				<input type="submit" class="btn btn-primary" name="edit" value="Simpan">
			</div>
			<?=form_close()?>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>


<script type="text/javascript">
	function edit(id) {
		$.ajax({
			url: '<?= base_url('absen/kemampuan') ?>',
			type: 'POST',
			data: {
				id: id,
				get: true
			},
			success: function(response) {
				response = JSON.parse(response);
				console.log(response);
				$('#id_kemampuan_edit').val(response.id);
				$('#nama_edit').val(response.nama);
				$('#komunikasi_edit').val(response.komunikasi);
				$('#packing_edit').val(response.packing);
				$('#inisiatif_edit').val(response.inisiatif);
				$('#kedisiplinan_edit').val(response.kedisiplinan);
				$('#keterangan_edit').val(response.keterangan);
				$('#tanggal_catat_edit').val(response.tanggal_catat);
				
			}
		});
	}
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
					url: '<?= base_url('absen/kemampuan') ?>',
					type: 'POST',
					data: {
						delete: true,
						id: id
					},
					success: function() {
						window.location = '<?= base_url('absen/kemampuan') ?>';
					}
				});
			}
		});
	}
</script>