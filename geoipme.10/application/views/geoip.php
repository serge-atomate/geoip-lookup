<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>GeoIP-Lookup Service</title>

	<!-- Including jQuery -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

	<!-- Including Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


	<!-- Including Vue.js -->
	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

	<!-- Including main CSS -->
	<link rel="stylesheet" id="main-css" href="/assets/css/main.css" type="text/css" media="all">
</head>
<body>

	<div class="container-fluid" id="geoip">
		<a href="/"></a>

		<div class="container">

			<div class="row justify-content-md-center">
				<div class="col-md-6">
					<form @submit="search" method="post" id="submitForm">
						<div v-if="errors.length" class="alert alert-danger" role="alert">
							<p v-for="error in errors">{{ error }}</p>
						</div>
						<div class="input-group mb-3">
							<input type="submit" class="btn btn-default form-rounded" name="submit" value="Search...">
							<input type="text" id="input" v-model="input" class="form-control form-rounded" required="required">
						</div>
					</form>
				</div>
			</div>

			<ul class="nav nav-tabs" id="resultsNav" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="results-tab" data-toggle="tab" href="#results" role="tab" aria-controls="results" aria-selected="true">Results</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="about-tab" data-toggle="tab" href="#about" role="tab" aria-controls="about" aria-selected="false">About</a>
				</li>
			</ul>

			<div class="tab-content" id="resultsContent">
				<div class="tab-pane fade show active" id="results" role="tabpanel" aria-labelledby="results-tab">

					<div class="row">
						<div class="col-md-6 left">
							<p class="sectionTitle">Result</p>

							<div id="searchResults" v-if="ip">
								<div id="ipAddress">
									<p>IP address</p>
									<h5>{{ ip }}</h5>
								</div>
								<div id="countryCode">
									<p>Country code</p>
									<h5>{{ countryCode }}</h5>
								</div>
								<div id="country">
									<p>Location</p>
									<h5>{{ country }}</h5>
								</div>
							</div>
							<div v-else>
								<p>No data received</p>
							</div>
						</div>

						<div class="col-md-6 right">
							<p class="sectionTitle">Previous searches</p>

							<table class="table" v-if="entries.length">
								<tbody>
									<tr v-for="(entry, index) in entries">
										<td>{{ entry.id }}.</td>
										<td>{{ entry.IP }}</td>
										<td>{{ entry.countryCode }}</td>
										<td>{{ entry.country }}</td>
										<td>{{ entry.date }}</td>
									</tr>
								</tbody>
							</table>

							<p class="noData" v-else>No data found</p>
						</div>
					</div>
				</div>

				<div class="tab-pane fade" id="about" role="tabpanel" aria-labelledby="about-tab">...</div>
			</div>
		</div>
	</div>

	<!-- Including main scripts -->
	<script type="text/javascript" src="/assets/js/main.js" ></script>
</body>
</html>