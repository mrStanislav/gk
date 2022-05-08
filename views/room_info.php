<div class="row">		
	<div class="col-md-12">
		<? if(isset($room_info[0])): ?>
			<table class="table table-bordered table-striped">
				<tbody>			
					<?foreach($room_info[0] as $key => $value):?>	
						<? $field_name  = (isset($remap_filed[$key])) ? $remap_filed[$key] : '--'  ?>
						<? $field_value = (!empty($value)) ? $value : '--' ?>
						<? if(isset($remap_filed[$key])): ?>
							<tr>
								<td style="width:40%"><?= $field_name ?> : </td>
								<td><?= $field_value ?></td>
							</tr>
						<? endif; ?>
					<?endforeach?>
				</tbody>
			</table>
		<? else: ?>
			<center> Нет информации для отображения! </center>
		<? endif; ?>
	</div>	
</div>

<style>
	.table td, .table th {
	   padding:5px!important;
	   vertical-align: middle;
	}
</style>