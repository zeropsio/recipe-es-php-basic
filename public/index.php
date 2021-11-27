<?php

	date_default_timezone_set('Europe/Prague');
	// Include the SDK using the Composer auto-loader.
	require '../vendor/autoload.php';

	// Import relevant SDK classes.
	use Elasticsearch\ClientBuilder;

	try {
		// The chosen hostname of the Elasticsearch service.
		$hostname = "recipees";

		// Function returning an connectionString environment variable of the <$hostname> service.
		function getConnectionString($hostname) {
			// The requested environment variable name.
			$connectionString = "connectionString";
			$host = getenv("${hostname}_${connectionString}");
			if ($host) {
				return $host;
			}
			// If any environment variable not found, return only the null value.
			return null;
		}

		function getEsClient($hostname) {
			// For example, the result of the <host> would be: ["http://recipees:9200"]
			$host = getConnectionString($hostname);
			if ($host) {
				return ClientBuilder::create()
					->setHosts($host)
					// Sniffing should be disabled.
					->setSniffOnStart(false)
					->build();
			}
			return null;
		}

		print "Before getEsClient";

		// Declaration of the Elasticsearch SDK API client.
		$esClient = getEsClient($hostname);

		print "After getEsClient";

	} catch (Exception $e) {
		echo 'Error: ' . $e->getCode() . ':' . $e->getMessage();
	}
?>