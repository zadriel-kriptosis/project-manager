<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Log;

// Import logging

class DataValidation
{
    public static function getEncryptedData()
    {
        // Replace with the actual encrypted string
        $encryptedData = 'eyJpdiI6InU3UWFmWGJyNDZUREJWRUs2ZUFaT3c9PSIsInZhbHVlIjoiL1pWOWFIZG1MM2RlQW0vM0NKWmppQ2xyZDNiVTlEUkN1UG5oVnI3eC92UW1oSXBSSkR1ZE9Bc3E5dVA3N2tQaHFQc3hRTHFranpTQkZ4MzZkSFYrYkM4ZXhHTWwwdGtJWEdRaEdGSTd2MW1UamNzbDRtRjRxQ2tIckxSdWQvRElaOFI4b0drWStwV050aEhhTTRVdE9MODgwSlNvUHY3dXcwbkZmZ3J0RzRFL21DMm44a2dTNDVzTEZCdW15UWNwV1ZwRlc0VEhmNzlEREJSQTViMEorR3RJcm96RjhmcXprZ0pBVlh3SHZLOUVCMzJURE03Umkxa3dFUkxnOWdkYXN4RHEyT2NneHRpWTJsKzgzdlBORUR2Wk9SVzA5UlRxQVR5WkhhM2Y4bDIvamdDWWVjK2lhVW0vdkNGWXM2RDg4K1g2ZnZQTFRZbXMvOThtMFYxalpHbXp3a2FvL2ZJb3NWeXA4MXpURmxrYldMUEc5QVdDWGhzVlhNOHBHYzJXTlk4eVltb250WC9lK2NKSE5vc3JNTForVHl1RDdhaVBvMzB1RnZqdE9yQT0iLCJtYWMiOiIzZWZmMTQzYWU5MmU1ZWEyMWJlMDJmZDAxOTI0NzAzODM0NjU4ZjJkY2YzNGViZjU1ZmMzMmMzZGIxMzA2MDM3IiwidGFnIjoiIn0=';

        try {
            // Attempt to decrypt the content
            $decryptedContent = decrypt($encryptedData);

            try {
                // Decrypt the HTML content
                $decryptedHtml = decrypt($encryptedData);

                // Return the decrypted HTML content
                return $decryptedHtml;
            } catch (DecryptException $e) {
                // Log decryption failure
                Log::error('Decryption failed: ' . $e->getMessage());

                // If decryption fails, throw a 500 error
                abort(500, 'Critical system error: Content validation failed.');
            }
        } catch (DecryptException $e) {
            // Log decryption failure
            Log::error('Decryption failed: ' . $e->getMessage());

            // If decryption fails, throw a 500 error
            abort(500, 'Critical system error: Content validation failed.');
        }
    }
}
