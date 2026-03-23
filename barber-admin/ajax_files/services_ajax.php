<?php include '../connect.php'; ?>
<?php include '../Includes/functions/functions.php'; ?>


<?php
	

	if(isset($_POST['do']) && $_POST['do'] == "Delete")
	{
		$service_id = $_POST['service_id'];

		$stmt = $con->prepare("SELECT service_image FROM services WHERE service_id = ?");
		$stmt->execute(array($service_id));
		$service = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($service && !empty($service['service_image'])) {
			$imagePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, str_replace('barber-admin/', '', $service['service_image']));
			if (file_exists($imagePath) && is_file($imagePath)) {
				@unlink($imagePath);
			}
		}

        $stmt = $con->prepare("DELETE from services where service_id = ?");
        $stmt->execute(array($service_id));    
	}
	
?>