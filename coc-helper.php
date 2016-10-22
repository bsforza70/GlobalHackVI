<?php

require("db_manager.php");

// $identifier is either "id" or "name"
function getServicesListByIdentifier($identifier)
{
	$mysqli = getDB();
	$services_raw = $mysqli->query("SELECT * FROM services")->fetch_all(MYSQLI_ASSOC);
	return array_column($services_raw, $identifier);
}

function getServicesProvided($client_id)
{
	$mysqli = getDB();
	$service_ids = getServicesListByIdentifier("id");
	$services_provided = [];

	foreach ($service_ids as $service_id) {
		$service_record = $mysqli->query("SELECT * FROM provided_services WHERE client_id=$client_id AND service_id=$service_id");
		if ($service_record) {
			$services_provided[] = $service_record;
		}
	}

	return $services_provided;
}

function newServiceReport($client_id, $service_id, $host_or_coc, $provider_id, $completed, $comments) {
	$mysqli = getDB();

	$date = date("m/d/y");

	$statement = $mysqli->prepare("INSERT INTO provided_services (client_id, service_id, host_or_coc, provider_id, completed, comments, date) VALUES (?,?,?,?,?,?)");
	$statement->bind_param("iisiiss", $client_id, $service_id, $host_or_coc, $provider_id, $completed, $comments, $date);
	$statement->execute();
}

// report a client moving out of temporary shelter and into their own housing / a permanent housing service
// $rehousing_or_permanent_housing is either "rehousing" or "permanent_housing"
function clientMoveOut($client_id, $rehousing_or_permanent_housing, $new_address) {
	$mysqli = getDB();

	$date = date("m/d/y");

	$statement = $mysqli->prepare("INSERT INTO shelter_outputs (date, client_id, rehousing_or_permanent_housing, home_address) VALUES (?,?)");
	$statement->bind_param("siss", $date, $client_id, $rehousing_or_permanent_housing, $new_address);
	$statement->execute();

	$mysqli->query("UPDATE client SET moved_on=1 WHERE id=$client_id");
}