<table class="table table-striped">
	<thead>
		<tr>
			<th scope="col">ردیف</th>
			<th scope="col">عنوان کود</th>
			<th scope="col">تعداد درخواست <small>(کیسه 50 کیلویی)</small></th>
			<th scope="col">مقدار درخواست <small>(تن)</small></th>
			<th scope="col">مبلغ <small>(ریال)</small></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$sumKise = 0; 
		$sumVal = 0;
		$sumPrice = 0;
		?>
		@foreach($response as $key => $res)
		<?php 
		$sumKise += $res->kise; 
		$sumVal += $res->tone;
		$sumPrice += $res->price;
		?>
		<tr>
			<th scope="row">{{ $key + 1 }}</th>
			<th>{{ $res->title }}</th>
			<td>{{ number_format($res->kise) }}</td>
			<td>{{ number_format($res->tone,1) }}</td>
			<td>{{ number_format($res->price) }}</td>
		</tr>
		@endforeach
		
		<tr>
			<th scope="row" class="font-weight-bold">مجموع</th>
			<td></td>
			<td class="font-weight-bold">{{ number_format($sumKise) }}</td>
			<td class="font-weight-bold">{{ number_format($sumVal,1) }}</td>
			<td class="font-weight-bold">{{ number_format($sumPrice) }}</td>
		</tr>
	</tbody>
</table>