<?php
header('Content-Type: application/json');
include "connect.php";

$faceShape = isset($_GET['face_shape']) ? strtolower(trim($_GET['face_shape'])) : '';
$gender = isset($_GET['gender']) ? strtolower(trim($_GET['gender'])) : 'any';

if (empty($faceShape)) {
    echo json_encode(['error' => 'Face shape parameter is required']);
    exit;
}

$shapeMap = [
    'oval' => 'Oval',
    'round' => 'Round',
    'square' => 'Square',
    'long' => 'Long',
    'heart' => 'Heart',
    'diamond' => 'Diamond'
];

if (!isset($shapeMap[$faceShape])) {
    echo json_encode(['error' => 'Invalid face shape']);
    exit;
}

$allowedGenders = ['any', 'male', 'female'];
if (!in_array($gender, $allowedGenders, true)) {
    echo json_encode(['error' => 'Invalid gender parameter']);
    exit;
}

$searchTerm = $shapeMap[$faceShape];

try {
    $sql = "
        SELECT s.service_id, s.service_name, s.service_description, s.service_price, s.service_duration
        FROM services s
        INNER JOIN service_categories sc ON s.category_id = sc.category_id
        WHERE sc.category_name = 'AI Haircut Recommendations'
        AND s.service_description LIKE :face_shape
    ";

    if ($gender !== 'any') {
        $sql .= " AND s.service_description LIKE :gender ";
    }

    $sql .= " ORDER BY s.service_id ";

    $stmt = $con->prepare($sql);
    
    $searchPattern = "%Face Shape: {$searchTerm}%";
    $stmt->bindParam(':face_shape', $searchPattern, PDO::PARAM_STR);

    if ($gender !== 'any') {
        $genderPattern = "%Gender: " . ucfirst($gender) . "%";
        $stmt->bindParam(':gender', $genderPattern, PDO::PARAM_STR);
    }

    $stmt->execute();
    
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $recommendations = [];
    foreach ($services as $service) {
        preg_match('/Maintenance:\s*([^.]+)\./', $service['service_description'], $matches);
        $maintenance = isset($matches[1]) ? trim($matches[1]) : 'Medium';
        
        $cleanDescription = preg_replace('/\s*Maintenance:.*?\..*?Face Shape:.*$/', '', $service['service_description']);
        
        $recommendations[] = [
            'id' => $service['service_id'],
            'style' => $service['service_name'],
            'description' => trim($cleanDescription),
            'maintenance' => $maintenance,
            'price' => '₱' . number_format($service['service_price'], 2),
            'duration' => $service['service_duration'] . ' mins'
        ];
    }
    
    $descriptions = [
        'oval' => 'Lucky you! Oval faces are well-balanced and can pull off almost any hairstyle.',
        'round' => 'Round faces benefit from styles that add height and create the illusion of length.',
        'square' => 'Strong jawline and forehead width. Soften angles with textured, medium-length styles.',
        'long' => 'Longer face shape benefits from styles that add width and minimize length.',
        'heart' => 'Wider forehead with a pointed chin. Balance with volume at the chin level.',
        'diamond' => 'Narrow forehead and chin with wider cheekbones. Add fullness at forehead and chin.'
    ];
    
    $response = [
        'shape' => ucfirst($searchTerm) . ' Face',
        'description' => $descriptions[$faceShape],
        'recommendations' => $recommendations
    ];
    
    echo json_encode($response);
    
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
