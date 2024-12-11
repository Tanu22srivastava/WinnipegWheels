<?php
// Function to fetch vehicle data
function getVehicleInfo($vin) {
    // NHTSA API URL with the provided VIN
    $apiUrl = "https://vpic.nhtsa.dot.gov/api/vehicles/DecodeVin/" . $vin . "?format=json";

    // Initialize cURL
    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    // Execute the API request
    $response = curl_exec($curl);

    // Check for errors
    if (curl_errno($curl)) {
        return "Error: " . curl_error($curl);
    }

    // Close cURL
    curl_close($curl);

    // Decode JSON response
    return json_decode($response, true);
}

// Check if form is submitted
if (isset($_POST['vin'])) {
    $vin = trim($_POST['vin']); // Trim input to avoid whitespace issues
    $vehicleInfo = getVehicleInfo($vin); // Fetch vehicle data
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Information Lookup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        h1 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input, button {
            padding: 10px;
            margin: 5px 0;
            font-size: 16px;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .result {
            margin-top: 20px;
            background-color: #fff;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <h1>Vehicle Information Lookup</h1>
    <form method="POST" action="">
        <label for="vin">Enter Vehicle VIN:</label><br>
        <input type="text" id="vin" name="vin" placeholder="e.g., 1HGCM82633A123456" required>
        <br>
        <button type="submit">Get Vehicle Info</button>
    </form>

    <?php if (isset($vehicleInfo)): ?>
        <div class="result">
            <h2>Vehicle Details:</h2>
            <?php if (!empty($vehicleInfo['Results'])): ?>
                <ul>
                    <?php foreach ($vehicleInfo['Results'] as $result): ?>
                        <?php if (!empty($result['Value'])): ?>
                            <li><strong><?= htmlspecialchars($result['Variable']) ?>:</strong> <?= htmlspecialchars($result['Value']) ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No data found for the provided VIN.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</body>
</html>
