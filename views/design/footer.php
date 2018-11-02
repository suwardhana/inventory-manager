        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <footer class="main-footer">
    	<div class="pull-right hidden-xs">

    	</div>
    	<strong>Copyright &copy;2016</strong>
    </footer>
</div><!-- ./wrapper --><!-- jQuery 2.1.3 -->

<script type="text/javascript">
	$(document).ready(function() {
		$('.datepicker').datepicker({format: "yyyy-mm-dd"});
		$('.datatables-example').DataTable({
			dom: 'Bfrtip',
			buttons: [
			{extend : 'excel', title: 'Laporan Invoice'},
			{extend : 'print',
			exportOptions:{columns: ':visible',stripHtml: false},
			customise: function (win){
				$(win.document.body).addClass('white-bg');
				$(win.document.body).css('font-size', '10px');
				$(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
			},
			orientation : 'landscape'
		},
		'colvis',
		'excel'
		],
		columnDefs:[{
			target: -1,
			visible: false
		}],
		responsive: true
		
	}
	
	);
	} );
</script>
</body>
</html>
