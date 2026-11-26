<?php
/**
 * Application Global Configuration
 * Nurtura Platform
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('APP_NAME', 'Nurtura');

// Timer Configuration
define('LOCK_TIMEOUT_HOURS', 48);     // Donatur Ghosting Auto-Release Timeout
define('AUTO_CONFIRM_HOURS', 72);     // Auto-complete if pregnant mother doesn't confirm & no dispute
define('LILA_KEK_THRESHOLD', 23.5);   // Ambang batas LILA KEK (cm)

// File Upload Directories
define('ROOT_DIR', dirname(__DIR__));
define('STORAGE_DIR', ROOT_DIR . '/storage');
define('KIA_UPLOAD_DIR', STORAGE_DIR . '/uploads/kia_documents');
define('PROOF_UPLOAD_DIR', STORAGE_DIR . '/uploads/drop_proofs');

// Ensure upload directories exist
if (!is_dir(KIA_UPLOAD_DIR)) {
    @mkdir(KIA_UPLOAD_DIR, 0755, true);
}
if (!is_dir(PROOF_UPLOAD_DIR)) {
    @mkdir(PROOF_UPLOAD_DIR, 0755, true);
}
