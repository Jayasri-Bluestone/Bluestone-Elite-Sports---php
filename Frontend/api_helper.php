<?php
/**
 * Helper class to fetch data from the Node.js Backend API
 */
class ApiHelper {
    private $base_url = "http://localhost:5004/api"; // Default dev port

    public function __construct($url = null) {
        if ($url) $this->base_url = $url;
    }

    /**
     * Fetch sports list from API
     */
    public function getSports() {
        return $this->fetch("/sports");
    }

    /**
     * Fetch single sport by ID
     */
    public function getSportById($id) {
        return $this->fetch("/sports/" . $id);
    }

    /**
     * Fetch gallery list from API
     */
    public function getGallery() {
        return $this->fetch("/gallery");
    }

    /**
     * Fetch statistics from API
     */
    public function getStats() {
        return $this->fetch("/stats");
    }

    /**
     * Private method to handle cURL requests
     */
    private function fetch($endpoint) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->base_url . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            error_log('cURL error: ' . curl_error($ch));
            return [];
        }
        
        curl_close($ch);
        return json_decode($response, true) ?: [];
    }
}
?>
