<table class="table table-hover">
	<thead>
		<tr>
			<th width="120">Người nhận</th>
			<th width="60">Nhuận bút</th>
			<th width="60">Thuế</th>
			<th width="70">Được nhận</th>
			<th width="150">Ghi chú</th>
			<th width="60">Đã nhận?</th>
			<th width="60"></th>
		</tr>
	</thead>
	<tbody>
		@if(isset($royalties))
		@foreach ($royalties as $royalty)
			<tr>
				<td>
					{{ $royalty->author->fullName() }}
				</td>
				<td>
					{{ $royalty->royalty }}
				</td>
				<td>
					{{ $royalty->tax }}
				</td>
				<td>
					{{ $royalty->total }}
				</td>
				<td>
					{{ $royalty->description }}
				</td>
				<td>
					{{ $royalty->received ? '<span class="label label-success">Đúng</span>' : '<span class="label label-success">Sai</span>' }}
				</td>
				<td>
					<a data-toggle="modal" href="{{ URL::to('admin/royalties/form?royal_id='.$royalty->id) }}" data-target="#modal_royaltyform" class="show-modal label label-default">Sửa</a>
					<a onclick="DeleteRoyalties('{{ $royalty->id }}');" href="javascript:void(0)" class="label label-danger">Xóa</a>
				</td>
			</tr>
		@endforeach
			<tr class="success">
				<td colspan="2"></td>
				<td>Tổng</td>
				<td>{{ $royalyTotal }}</td>
				<td colspan="3"></td>
			</tr>									
		@endif
	</tbody>
</table>