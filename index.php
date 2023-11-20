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
    <form action="#" method="post"> <!-- Added method="post" to the form -->
        <label for="search">Search:</label>
        <input type="text" id="search" name="search" placeholder="Enter First or Last name" required>
        <button type="submit">Search</button>
    </form>
</body>
</html>

<?php
try {
    // Check if a search term is provided and sanitize it
    $searchTerm = isset($_POST['search']) ? htmlspecialchars($_POST['search'], ENT_QUOTES, 'UTF-8') : '';

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
    echo "<input type='submit' name='submit_form' value='Submit'>"; // Added name attribute to the submit button
    echo "</form>";

    // Display the selected people's information
    if (isset($_POST['submit_form']) && isset($_POST['selected_people'])) {
        $selectedPeople = $_POST['selected_people'];
        $selectedPeopleInfo = array();

        // Loop through selected people
        foreach ($selectedPeople as $selectedPerson) {
            // Loop through people_data to find the selected person
            foreach ($people_data as $person) {
                $fullName = "{$person['firstname']} {$person['infix']} {$person['lastname']}";
                // Check if the current person's full name matches the selected person
                if ($fullName === $selectedPerson) {
                    $selectedPeopleInfo[] = $person;
                }
            }
        }

        // Generate the PDF after processing all selected people
        if (isset($_GET['download']) && !empty($selectedPeopleInfo)) {
            ob_end_clean();
            require('fpdf/fpdf.php');

            // Instantiate and use the FPDF class
            $pdf = new FPDF();

            // Add a new page
            $pdf->AddPage();

            // Set the font for the text
            $pdf->SetFont('Arial', '', 18);

            // Loop through selected people's information and print in the PDF
            foreach ($selectedPeopleInfo as $person) {
                $pdf->Cell(60, 10, $person['firstname'] . ' ' . $person['infix'] . ' ' . $person['lastname'], 0, 1);
                $pdf->Cell(60, 10, $person['street'] . ' ' . $person['nr'], 0, 1);
                $pdf->Cell(60, 10, $person['zip'] . ' ' . $person['place'], 0, 1);
                if ($person['country'] !== 'Netherlands' && $person['country'] !== 'Nederlands') {
                    $pdf->Cell(60, 10, $person['country'], 0, 1);
                }
            }

            // Output the generated PDF
            $pdf->Output();
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
