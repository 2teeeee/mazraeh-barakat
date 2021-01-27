<table class="table table-striped">
	<thead>
		<tr>
			<th scope="col">نام کارگزار</th>
			<th scope="col">نام شرکت</th>
			<th scope="col">عنوان کود</th>
			<th scope="col">تعداد درخواست <small>(کیسه 50 کیلویی)</small></th>
			<th scope="col">تعداد کشاورز</th>
			<th scope="col">سطح زیر کشت</th>
			<th scope="col">مقدار درخواست <small>(تن)</small></th>
			<th scope="col">مبلغ <small>(ریال)</small></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$sumKise = 0; 
		$sumVal = 0;
		$sumPrice = 0;
		$sumKeshavarz = 0;
		$sumZamin = 0;
		?>
		@foreach($response as $res)
		<?php 
		$sumKise += $res->kise; 
		$sumVal += $res->tone;
		$sumPrice += $res->price;
		$sumKeshavarz += $res->keshavarz;
		$sumZamin += $res->sathZirKesht;
		?>
		<tr>
			<th scope="row">{{ $res->name }}</th>
			<td>{{ $res->company }}</td>
			<td>{{ $res->title }}</td>
			<td>{{ number_format($res->kise) }}</td>
			<td>{{ $res->keshavarz }}</td>
			<td>{{ number_format($res->sathZirKesht,1) }}</td>
			<td>{{ number_format($res->tone,1) }}</td>
			<td>{{ number_format($res->price) }}</td>
			<td><a href="#{{ $res->id }}" onClick="showuser({{ $res->id }})" title="مشاهده بهره برداران"><i class="fas fa-eye text-dark"></i></i></a></td>
		</tr>
		@endforeach
		
		<tr>
			<th scope="row">مجموع</th>
			<td></td>
			<td></td>
			<td>{{ number_format($sumKise) }}</td>
			<td>{{ number_format($sumKeshavarz) }}</td>
			<td>{{ number_format($sumZamin,1) }}</td>
			<td>{{ number_format($sumVal,1) }}</td>
			<td>{{ number_format($sumPrice) }}</td>
			<td></td>
		</tr>
	</tbody>
</table>