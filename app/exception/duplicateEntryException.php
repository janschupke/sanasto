<?php

namespace io\schupke\sanasto\core\exception;

/**
 * Thrown when the user attempts to insert duplicate data into
 * an unique column in the database.
 */
class DuplicateEntryException extends \Exception {
}
