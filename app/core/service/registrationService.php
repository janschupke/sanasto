<?php

namespace io\schupke\sanasto\core\core\service;

use Utility;

/**
 * Service providing methods related to registrations.
 */
class RegistrationService extends AbstractService {
    /**
     * Generates new account verification token.
     * @return string new verification token.
     */
    public function generateVerificationToken() {
        $token = strtoupper(Utility::generateRandomString(6));

        return $token;
    }
}
