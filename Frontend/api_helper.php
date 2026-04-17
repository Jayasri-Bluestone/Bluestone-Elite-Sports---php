<?php
/**
 * Helper class to fetch data from the Node.js Backend API
 */
class ApiHelper {
    private $base_url;
    private $cache_dir = "cache/";
    private $cache_time = 300; // 5 minutes cache

    public function __construct($url = null) {
        if ($url) {
            $this->base_url = $url;
        } else {
            // Auto-detect environment
            $isLocal = in_array($_SERVER['SERVER_NAME'], ['localhost', '127.0.0.1']);
            $this->base_url = $isLocal 
                ? "http://localhost:5009/api" 
                : "https://bluestoneinternationalpreschool.com/bes_web_api/api";
        }
        
        // Ensure cache directory exists
        if (!is_dir($this->cache_dir)) {
            @mkdir($this->cache_dir, 0777, true);
        }
    }

    /**
     * Fetch all initial site data in one go
     */
    public function getSiteData() {
        return $this->fetch("/site-init", true);
    }

    /**
     * Fetch sports list from API
     */
    public function getSports() {
        $data = $this->fetch("/sports", true);
        
        // Filter active programs if viewing from frontend (not admin)
        if (is_array($data)) {
            $currentPage = basename($_SERVER['PHP_SELF']);
            if ($currentPage !== 'admin.php') {
                return array_filter($data, function($s) {
                    return ($s['status'] ?? 'Active') === 'Active';
                });
            }
        }
        return $data;
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
        return $this->fetch("/gallery", true);
    }

    /**
     * Fetch testimonials from API
     */
    public function getTestimonials() {
        return $this->fetch("/testimonials", true);
    }

    /**
     * Fetch statistics from API
     */
    public function getStats() {
        return $this->fetch("/stats", true);
    }

    /**
     * Fetch all active brochure sports
     */
    public function getAllActiveBrochures() {
        $sports = $this->getSports();
        if (!$sports) return [];
        $brochures = [];
        foreach ($sports as $s) {
            // Only show brochures for ACTIVE programs
            if (isset($s['is_brochure']) && $s['is_brochure'] == 1 && ($s['status'] ?? 'Active') === 'Active') {
                $brochures[] = $s;
            }
        }
        return $brochures;
    }

    /**
     * Resolve the best image for a sport based on its name
     */
    public function resolveSportImage($sport) {
        if (!is_array($sport)) return 'assets/hero.png';
        
        $name = strtolower($sport['name'] ?? '');
        $path = $sport['image_path'] ?? '';

        // Prioritize specific high-quality assets if they match the sport name
        if (strpos($name, 'silambam') !== false) return 'assets/silambbu.png';
        if (strpos($name, 'cricket') !== false) return 'assets/cricket team.png';
        if (strpos($name, 'karate') !== false) return 'assets/karate team.png';
        if (strpos($name, 'chess') !== false) return 'assets/chess.png';
        if (strpos($name, 'carrom') !== false) return 'assets/carrom.png';
        if (strpos($name, 'champ') !== false) return 'assets/champ.png';

        // Fallback to dynamic path or default hero
        return !empty($path) ? $path : 'assets/hero.png';
    }

    /**
     * Private method to handle cURL requests with tiered caching (Session > File > Network)
     */
    private function fetch($endpoint, $use_cache = false) {
        // 1. Tier 1: Session Cache (Instant Memory Access)
        if ($use_cache && isset($_SESSION['site_cache'][$endpoint])) {
            $sessionEntry = $_SESSION['site_cache'][$endpoint];
            if (time() - $sessionEntry['time'] < $this->cache_time) {
                return $sessionEntry['data'];
            }
        }

        // 2. Tier 2: File Cache (Next Fastest)
        $cache_file = $this->cache_dir . md5($endpoint) . ".json";
        if ($use_cache && file_exists($cache_file)) {
            if (time() - filemtime($cache_file) < $this->cache_time) {
                $fileData = json_decode(file_get_contents($cache_file), true);
                // Backfill session cache for the next page load
                if ($use_cache) {
                    $_SESSION['site_cache'][$endpoint] = ['data' => $fileData, 'time' => filemtime($cache_file)];
                }
                return $fileData;
            }
        }

        // 3. Tier 3: Network Request (Slowest - Fallback)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->base_url . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            error_log('cURL error: ' . curl_error($ch));
            // Return cached data even if expired on error if available
            if (file_exists($cache_file)) {
                return json_decode(file_get_contents($cache_file), true);
            }
            return [];
        }
        
        curl_close($ch);
        $data = json_decode($response, true) ?: [];

        // Save to both Session and File Cache
        if ($use_cache && !empty($data)) {
            $_SESSION['site_cache'][$endpoint] = ['data' => $data, 'time' => time()];
            file_put_contents($cache_file, json_encode($data));
        }

        return $data;
    }
}
?>
