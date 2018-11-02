<h2 class="page-title"><b>Data Peminjaman</b></h2>
<div class="row">
	<div class="col-md-12">
		<!-- TABLE NO PADDING -->
		<?= $this->session->flashdata('msg') ?>
		<div class="clearfix">
			<a class="btn btn-xs btn-success" href="#" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Catat Peminjaman</a>
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
								Tanggal Pinjam
							</th>
							<th>
								Tanggal Kembali
							</th>
							<th>
								Barang
							</th>
							<th>
								Keterangan
							</th>
							<th>
								Tanggal Bayar
							</th>
							<th>
								Penanggung Jawab
							</th>
							<th>
								Jumlah Bayar
							</th>
							<th>
								Aksi
							</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=0; foreach ($peminjaman as $data): $a=$data->keterangan ?>
						<tr>
							<td>
								<?= ++$i ?>
							</td>
							<td>
								<?= $data->nama ?>
							</td>
							<td>
								<?= TanggalIndo($data->tanggal_pinjam) ?>
							</td>
							<td>
								<?= TanggalIndo($data->tanggal_kembali); ?>
							</td>
							<td>
								<?php echo $data->barang ?>
							</td>
							<td>
								<?php  echo $data->keterangan ?>
							</td>
							<td>
								<?= TanggalIndo($data->tanggal_bayar) ?>
							</td>
							<td>
								<?= $data->pic ?>
							</td>
							<td>
								<?= $data->bayar ?>
							</td>
							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-placement="bottom" data-target="#edit" onclick="edit(<?= $data->id_peminjaman ?>)">Edit</button>
									<button type="button" class="btn btn-danger btn-sm" onclick="deleteData(<?= $data->id_peminjaman ?>)">Delete</button>
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
			<?=form_open('barang/peminjaman')?>
			<div class="modal-body">
				<div class="form-group">
					<label>Nama</label>
					<input class="form-control" type="text" name="nama">
				</div>
				<div class="form-group">
					<label>Tanggal Pinjam</label>
					<input class="form-control" type="date" name="tanggal_pinjam" required="">
				</div>
				<div class="form-group">
					<label>Tanggal Kembali</label>
					<input class="form-control" type="date" name="tanggal_kembali">
				</div>
				<div class="form-group">
					<label>Barang yang dipinjam</label>
					<textarea name="barang" class="form-control" id="" cols="30" rows="10"></textarea>
				</div>
				<div class="form-group">
					<label>Keterangan</label>
					<textarea name="keterangan" id="" cols="5" rows="5" class="form-control"></textarea>
				</div>
				<div class="form-group">
					<label>Tanggal Bayar</label>
					<input class="form-control" type="date" name="tanggal_bayar">
				</div>
				<div class="form-group">
					<label>Jumlah Bayar</label>
					<input class="form-control" type="text" name="bayar">
				</div>
				<div class="form-group">
					<label>PIC</label>
					<input class="form-control" type="text" name="pic">
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
			<?=form_open('barang/peminjaman')?>
			<div class="modal-body">
				<input type="hidden" name="id_peminjaman" id="id_peminjaman_edit">
				<div class="form-group">
					<label>Nama</label>
					<input class="form-control" type="text" name="nama" id="nama_edit">
				</div>
				<div class="form-group">
					<label>Tanggal Pinjam</label>
					<input class="form-control" type="date" name="tanggal_pinjam" required="" id="tanggal_pinjam_edit">
				</div>
				<div class="form-group">
					<label>Tanggal Kembali</label>
					<input class="form-control" type="date" name="tanggal_kembali" id="tanggal_kembali_edit">
				</div>
				<div class="form-group">
					<label>Barang yang dipinjam</label>
					<textarea name="barang" class="form-control" id="barang_edit" cols="30" rows="10"></textarea>
				</div>
				<div class="form-group">
					<label>Keterangan</label>
					<textarea name="keterangan" id="keterangan_edit" cols="5" rows="5" class="form-control"></textarea>
				</div>
				<div class="form-group">
					<label>Tanggal Bayar</label>
					<input class="form-control" type="date" name="tanggal_bayar" id="tanggal_bayar_edit">
				</div>
				<div class="form-group">
					<label>Jumlah Bayar</label>
					<input class="form-control" type="text" name="bayar" id="bayar_edit">
				</div>
				<div class="form-group">
					<label>PIC</label>
					<input class="form-control" type="text" name="pic" id="pic_edit">
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
			url: '<?= base_url('barang/peminjaman') ?>',
			type: 'POST',
			data: {
				id: id,
				get: true
			},
			success: function(response) {
				response = JSON.parse(response);
				console.log(response);
				$('#id_peminjaman_edit').val(response.id_peminjaman);
				$('#nama_edit').val(response.nama);
				$('#tanggal_pinjam_edit').val(response.tanggal_pinjam);
				$('#tanggal_kembali_edit').val(response.tanggal_kembali);
				$('#keterangan_edit').val(response.keterangan);
				$('#tanggal_bayar_edit').val(response.tanggal_bayar);
				$('#pic_edit').val(response.pic);
				$('#barang_edit').val(response.barang);
				$('#bayar_edit').val(response.bayar);
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
					url: '<?= base_url('barang/peminjaman') ?>',
					type: 'POST',
					data: {
						delete: true,
						id: id
					},
					success: function() {
						window.location = '<?= base_url('barang/peminjaman') ?>';
					}
				});
			}
		});
	}
</script>