<?php
include "db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>homepagina</title>
</head>
<body>
    <form action="">
<label for="search">Search:</label>
    <input type="text" id="search" name="search" placeholder="Enter First or Last name" required>
    <button type="submit">Search</button>
    </form>
</body>
</html>
<?php
try{
    // Check if a search term is provided and sanitize it
    $searchTerm = isset($_GET['search']) ? htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8') : '';
    
    // Prepare and execute a query to retrieve information based on the search term
    $query = $conn->prepare("
        SELECT 
            persons.firstname,
            persons.infix,
            persons.lastname,
            addresses.street,
            addresses.nr,
            addresses.zip,
            addresses.place,
            addresses.country
        FROM 
            personsadresses
        LEFT JOIN 
            persons ON personsadresses.personsID = persons.ID
        LEFT JOIN 
            addresses ON personsadresses.addressesID = addresses.ID
        WHERE 
            persons.firstname LIKE :search 
            OR persons.infix LIKE :search 
            OR persons.lastname LIKE :search 
            OR addresses.street LIKE :search 
            OR addresses.zip LIKE :search 
            OR addresses.place LIKE :search 
            OR addresses.country LIKE :search
    ");
    
    $query->bindValue(':search', "%$searchTerm%", PDO::PARAM_STR);
    $query->execute();
    // Fetch all the results
    $people_data = $query->fetchAll(PDO::FETCH_ASSOC);
    
    // Print the form and checkboxes
echo "<form action='#' method='post'>";
echo "<label>Select people:</label>";

foreach ($people_data as $person) {
    $fullName = "{$person['firstname']} {$person['infix']} {$person['lastname']}";
    echo "<div><input type='checkbox' name='selected_people[]' value='$fullName'>$fullName</div>";
}

echo "<br>";
echo "<input type='submit' value='Submit'>";
echo "</form>";

// Display the selected people's information
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selected_people'])) {
    $selectedPeople = $_POST['selected_people'];

    // Loop through selected people
    foreach ($selectedPeople as $selectedPerson) {
        // Find the selected person in the array
        foreach ($people_data as $person) {
            $fullName = "{$person['firstname']} {$person['infix']} {$person['lastname']}";
            if ($fullName == $selectedPerson) {
                // Print the selected person's information
                echo "<table border='1'>";
                echo "<tr><td>Name</td><td>{$person['firstname']} {$person['infix']} {$person['lastname']}</td></tr>";
                echo "<tr><td>Address</td><td>{$person['street']} {$person['nr']}</td></tr>";
                echo "<tr><td>Postal Code</td><td>{$person['zip']}</td></tr>";
                echo "<tr><td>Place</td><td>{$person['place']}</td></tr>";
                echo "<tr><td>Country</td><td>{$person['country']}</td></tr>";
                echo "</table>";
                echo "<br>";
            }
        }
    }
}  
    } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    }
    
?>

