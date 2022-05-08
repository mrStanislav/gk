<div class="container-fluid">
	<div class="row">
		<div class="col-md-6 offset-md-4">
			<div class="btn-group " role="group" aria-label="Button group with nested dropdown">
				<? foreach($list_menu as $key => $value):?>
					<? $corp_active = (strtr($key, ['к'=> 'k']) == $filter->corps) ? 'active' : ''; ?>
					<div class="btn-group" role="group">
						<button type="button" class="btn btn-secondary dropdown-toggle <?=$corp_active?>" data-toggle="dropdown">
							<?=$key?> 
						</button>
						<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
							<? foreach($value as $row => $porch):?>
								<? $porch_active = ($porch->GK_SECTION == $filter->porch && $porch->GK_KORPUS_ENG == $filter->corps) 
									? 'active' 
									: ''; 
								?>
								<a class="dropdown-item <?=$porch_active?>" href="/gk?corps=<?=$porch->GK_KORPUS_ENG?>&porch=<?=$porch->GK_SECTION?>">
									<?=$porch->GK_SECTION?> подъезд
								</a>
							<? endforeach;?>	
						</div>
					</div>
				<? endforeach;?>
			</div>		
		</div>
	
		<div class="col-md-6 offset-md-4 gk__display">
			<? foreach($section_info as $key => $value):?>
				<?php $margin = (isset($floor_margin[$key])) ? ($floor_margin[$key] * 33) : 0; ?>
				<div class="block__section" style="margin-top:<?=$margin?>px">
					<div style="padding:0px; margin:3px; border:1px solid #333; text-align:center;">
						<?=$filter->corps_rus; ?> подъезд <?=$key?>  
					</div>
					<div>
					<? $i = 0 ?>
					<? foreach($value as $section => $floor):?>
						<? $i++ ?>
						<? $floor_class = ($i == 2) ? 'active' : ''; ?>
						<? if($i == 2) $i = 0;?>
						<div class="block__floor"> 
							<div class="block__room floor_desc">				
								<?=$section?>
							</div>
							<? foreach($floor as $row => $room):?>
								<div class="block__room block__room__info <?=$floor_class?>" 
									data-room="<?=$room->GK_ROOM_PLAN_NUMBER ?>"
									data-corps="<?=$filter->corps_rus ?>"
									data-porch="<?=$filter->porch ?>"
									data-toggle="tooltip" title="Этаж <?=$section?>, квартира <?=$room->GK_ROOM_PLAN_NUMBER?>, щелкните чтобы узнать подробности.">
									<?=$room->GK_ROOM_PLAN_NUMBER?>
								</div>
							<? endforeach;?>
						</div>
					<? endforeach;?>	
					</div>
				</div>
			<? endforeach;?>
		</div>
	</div>
</div>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Modal</h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
			</div>
			<div class="modal-footer">				
				<button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Закрыть</button>
			</div>
		</div>
	</div>
</div>


<script>

	$( document ).ready(function() {
		
		$('[data-toggle="tooltip"]').tooltip();
		
		$(document).on("click", ".block__room__info", function() {
			
			var room_id = $(this).attr('data-room');
			var porch   = $(this).attr('data-porch');
			var corps   = $(this).attr('data-corps');
			
			$.ajax({
				type: "GET",
				url: '/gk/index.php?room_id='+room_id+'&porch='+porch+'&corps='+corps,
				success: function(data) {
					$('.modal-body').html(data);					
				},
				error:function(request, status, error) {
					console.log("ajax call went wrong:" + request.responseText);
				}
			});
			
			$('.modal-title').text("Информация о квартире № "+room_id);
			
			$('#myModal').modal('show');
		});
	});

</script>


<style>

	.gk__display {
		margin-top:20px;
	}

	.block__room.floor_desc {
		width: 30px!important;
		height: 30px!important;
		background-color:#b5b5b5;
		font-weight:bold;
		color:#000;
		text-align:center;
	}
	
	.block__room__info:hover {
		cursor:pointer;
		background-color:#ecc244bf;
	}
	
	.block__room__info.active {
		background-color:#fff0f0;
	}
	
	.block__room__info.active:hover {
		cursor:pointer;
		background-color:#ecc244bf;
	}
	
	.block__section {
		display: table;
		margin:5px;
		padding:2px;
		border:1px solid #333;
		border-spacing:3px;
		float:left;
		margin-left: 0px;
	}
	
	
	.block__floor {
		
		padding:2px;	
		margin:2px;
		display:table-row;
	}
	
	.block__room {		
		width:30px;
		height:30px;
		border:1px solid #ccc;
		color:#000;
		padding:2px;		
		margin:5px;
		display:table-cell;
		padding:5px;
		border:1px solid black;
		text-align:center;
		font-size:12px;
	}
	
	/* Modal style reset */
	
	.modal-header {
		padding:10px;		
	}
	
	.modal-dialog {
		max-width:800px;
	}
	

</style>