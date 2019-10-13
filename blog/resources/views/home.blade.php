<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<title>SearchEngine</title>
	<link href="{{ asset('css/searchEngine.css') }}" rel="stylesheet" type="text/css" >
</head>
<body>

 <?php //echo '<pre>';print_r($fruits);exit;?>
	@foreach($result as $res)
		
		<div class="container">
			<div class="content_container">
				<span class="domain">{{$res['domain']}}</span>
				<div class="im">
					<img src = {{'http:'.$res['img']}} />
				</div>
				<div class="content">
					<img src = {{$res['rating']['numberOfStars']}} />
					<span class= "review_count">Reviews - {{$res['reviewCount']}}</span>
					<span class="trusScore">{{$res['rating']['trustScore']}}</span>
					@if(isset($res['category'][0]))
						<span class="category">Category - {{$res['category'][0]}}</span>
					@else
						Category- No Category Available for this Domain
					@endif
				</div>
			</div>
		</div>
	@endforeach
</body>