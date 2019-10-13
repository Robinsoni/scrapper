<div class="container">
			<form action="{{ action('HomeController@index') }}" method="GET">
				  <input type="text" name="domain" placeholder="Enter Domain Name" >
				  <!--<input type="checkbox" name="Truspilot" value="1">Truspilot<br>
				  <input type="checkbox" name="TrustedShops" value="1">TrustedShops<br>
				  -->
				  <input type="submit" value="Submit">
			</form>
</div>