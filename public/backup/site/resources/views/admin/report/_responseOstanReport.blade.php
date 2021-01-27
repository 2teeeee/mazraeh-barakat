<table class="table table-striped">
	<thead>
		<tr class="bg-light">
			<th scope="col">ردیف</th>
			<th scope="col">شهرستان</th>
			<th scope="col">کل تخصیص به شهرستان <small>( تن )</small></th>
			<th scope="col">کل تخصیص داده شده به کارگزارها <small>( تن )</small></th>
			<th scope="col">درخواست ثبت شده <small>( تن )</small></th>
			<th scope="col">تحویل داده شده <small>( تن )</small></th>
		</tr>
	</thead>
	<tbody>
		<?php
			$citySum = 0;
			$kargozarSum = 0;
			$sellSum = 0;
			$sendSum = 0;
			$i = 0;
		?>
		@foreach($citys as $key => $city)
		<?php
			$cityValue = $city->koodAdd($kood_id);
		?>
		@if($cityValue)
		<?php $i = $i + 1; ?>
		<tr>
			<th scope="row">{{ $i }}</th>
			<td>{{ $city->title }}</td>
			<td>
				<?php
				$citySum += round($cityValue,2);
				echo number_format(round($cityValue,2));
				?>
			</td>
			<td>
				<?php
				$cityKar = $city->koodRemove($kood_id);
				$kargozarSum += round($cityKar,2);
				echo number_format(round($cityKar,2));
				?>
			</td>
			<td>
				<?php
				$citySell = $city->ReqKoodSumAll($kood_id,$ab_type,$product_id,$startDate,$endDate);
				$sellSum += round($citySell,2);
				echo number_format(round($citySell,2));
				?>
			</td>
			<td>
				<?php
				$citySend = $city->ReqKoodSumTahvil($kood_id,$ab_type,$product_id,$startDate,$endDate);
				$sendSum += round($citySend,2);
				echo number_format(round($citySend,2));
				?>
			</td>
		</tr>
		@endif
		@endforeach
		
		<tr class="border-top border-dark bg-dark text-light">
			<th scope="row" class="font-weight-bold">مجموع</th>
			<td></td>
			<td class="font-weight-bold">{{ number_format($citySum) }}</td>
			<td class="font-weight-bold">{{ number_format($kargozarSum) }}</td>
			<td class="font-weight-bold">{{ number_format($sellSum) }}</td>
			<td class="font-weight-bold">{{ number_format($sendSum) }}</td>
		</tr>
	</tbody>
</table>