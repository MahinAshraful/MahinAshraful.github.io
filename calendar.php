<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple Calendar Application</title>
    <style>
        /* CSS Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0; /* Background color */
        }
        #calendar-container {
            width: 700px;
            margin: 0 auto;
            background-color: #ffffff; /* Calendar container background color */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Shadow effect */
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            text-align: center;
            padding: 8px;
        }
        th {
            background-color: #007bff; /* Header background color */
            color: #ffffff; /* Header text color */
        }
        td {
            background-color: #e7f0ff; /* Cell background color */
        }
        .day {
            cursor: pointer; /* Change cursor to pointer on hover */
        }
        select, input[type="submit"] {
            padding: 8px;
            margin: 5px 0;
            border: none;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007bff; /* Button background color */
            color: #ffffff; /* Button text color */
            cursor: pointer; /* Change cursor to pointer on hover */
        }
        input[type="submit"]:hover {
            background-color: #0056b3; /* Darker background color on hover */
        }
    </style>
</head>
<body>
    <div id="calendar-container">
        <h1 style="color: #007bff;"> Work Calendar</h1> <!-- Calendar title -->

        <!-- Form for selecting month and year -->
        <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="month">Select Month:</label>
            <select name="month" id="month">
                <?php
                    // Loop to generate dropdown options for months
                    for ($m = 1; $m <= 12; $m++) {
                        $monthName = date('F', mktime(0, 0, 0, $m, 1));
                        printf("<option value='%02d'>%s</option>", $m, $monthName);
                    }
                ?>
            </select>

            <label for="year">Select Year:</label>
            <select name="year" id="year">
                <?php
                    // Loop to generate dropdown options for years
                    $currentYear = date("Y");
                    for ($y = $currentYear - 10; $y <= $currentYear + 10; $y++) {
                        echo "<option value='$y'>$y</option>";
                    }
                ?>
            </select>

            <input type="submit" value="Show Calendar">
        </form>

        <?php
// Function to build calendar with notes
function build_calendar_with_notes($month, $year, $conn) {
    // Get the number of days in the selected month
    $numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    // Get the first day of the month
    $firstDayOfMonth = new DateTime("$year-$month-01");
    $firstDayOfWeek = $firstDayOfMonth->format('N') % 7;

    // Start the table
    $calendar = "<table>";

    // Add table headers
    $calendar .= "<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>";

    // Start a new row
    $calendar .= "<tr>";

    // Fill in the empty cells before the first day of the month
    for ($i = 1; $i < $firstDayOfWeek; $i++) {
        $calendar .= "<td></td>";
    }

    // Fill in the days of the month
    for ($day = 1; $day <= $numDays; $day++) {
        // Add the day to the calendar
        $calendar .= "<td>$day";

        // Fetch notes for this date from the database
        $date = "$year-$month-$day";
        $notes_query = "SELECT description FROM notes WHERE due_date = '$date'";
        $notes_result = $conn->query($notes_query);

        if ($notes_result->num_rows > 0) {
            // Display notes for this date
            $calendar .= "<div style='color: blue; font-weight: bold; font-size: smaller;'>";
            while ($note_row = $notes_result->fetch_assoc()) {
                $calendar .= $note_row['description'] . "<br>";
            }
            $calendar .= "</div>";
        }

        $calendar .= "</td>";

        // Move to the next cell
        if (($day + $firstDayOfWeek - 1) % 7 == 0) {
            $calendar .= "</tr>";
            if ($day != $numDays) {
                $calendar .= "<tr>";
            }
        }
    }

    // Fill in the empty cells after the last day of the month
    $lastDayOfWeek = ($firstDayOfWeek + $numDays - 1) % 7;
    if ($lastDayOfWeek != 0) {
        for ($i = $lastDayOfWeek + 1; $i <= 7; $i++) {
            $calendar .= "<td></td>";
        }
    }

    // Close the table
    $calendar .= "</tr></table>";

    return $calendar;
}

            // Process form submission and display calendar
            if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['month']) && isset($_GET['year'])) {
                $month = $_GET['month'];
                $year = $_GET['year'];

                // Establish database connection
                $host = '127.0.0.1'; 
                $dbname = 'bmcc';
                $username = 'root';
                $password = '';
                
                $conn = new mysqli($host, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Display calendar with notes
                echo build_calendar_with_notes($month, $year, $conn);

                // Close database connection
                $conn->close();
            }
        ?>
    </div>
</body>
</html>