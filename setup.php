<?php

/**
 * Invoked right when the index page loads
 * @author Andrew Jarombek
 * @since 2/18/2019
 */

require('models/api_client.php');

// Initialize the static variables in the APIClient class.
APIClient::init();