<?php
header('Content-Type: application/json');
require_once('connect.php');

try {
    $query = "SELECT service_id, service_name, service_description, service_price, service_duration 
              FROM services 
              ORDER BY service_name ASC";
    
    $stmt = $con->prepare($query);
    $stmt->execute();
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($services as &$service) {
        $service['formatted_price'] = '₱' . number_format($service['service_price'], 2);
        $service['formatted_duration'] = $service['service_duration'] . ' mins';
    }
    
    echo json_encode([
        'success' => true,
        'services' => $services
    ]);
    
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
?>
