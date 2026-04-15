<?php
// Load CI4
require 'public/index.php';
$db = \Config\Database::connect();

$query = $db->query("SELECT id_startup, nama_perusahaan, logo_perusahaan, uuid_startup FROM startups LIMIT 10");
$results = $query->getResultArray();

echo "--- STARTUP DATA ---\n";
foreach ($results as $row) {
    echo "ID: " . $row['id_startup'] . "\n";
    echo "Nama: " . $row['nama_perusahaan'] . "\n";
    echo "Logo: [" . $row['logo_perusahaan'] . "]\n";
    echo "UUID: " . $row['uuid_startup'] . "\n";
    
    $path = FCPATH . 'uploads/file_startup/logo_startup/' . $row['logo_perusahaan'];
    echo "Path: " . $path . "\n";
    echo "Exists: " . (file_exists($path) ? "YES" : "NO") . "\n";
    echo "--------------------\n";
}
