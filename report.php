<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Report</title>
    <link rel="stylesheet" href="style.css"> <!-- External CSS file -->
    <style>
        /* Internal CSS for animations and additional styling */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .container {
            animation: fadeIn 1.5s ease-in-out; /* Fade-in animation */
        }

        .report {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table td, table th {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        button a {
            color: white;
            text-decoration: none;
        }

        .copyright {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="report">
            <!-- Go Back Button -->
            <button><a href="index.php">Go Back</a></button>

            <?php
            // Database connection
            $conn = mysqli_connect("localhost", "root", "", "gary");

            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Get student ID from URL parameter
            if (isset($_GET['get_id'])) {
                $selected_id = $_GET['get_id'];
            } else {
                die("No student ID provided.");
            }

            // Fetch selected student's details
            $output = "SELECT * FROM student WHERE `id`='$selected_id'";
            $query = mysqli_query($conn, $output);

            if (!$query) {
                die("Error fetching student details: " . mysqli_error($conn));
            }

            // Fetch all students' total marks and rank them
            $rank_query = "SELECT id, total, 
                            RANK() OVER (ORDER BY total DESC) AS position 
                            FROM student";
            $rank_result = mysqli_query($conn, $rank_query);

            if (!$rank_result) {
                die("Error calculating ranks: " . mysqli_error($conn));
            }

            // Store ranks in an associative array [id => position]
            $ranks = [];
            while ($row = mysqli_fetch_assoc($rank_result)) {
                $ranks[$row['id']] = $row['position'];
            }

            // Display selected student's details
            while ($row = mysqli_fetch_assoc($query)) {
                $position = $ranks[$row['id']] ?? "N/A"; // Get position from ranks array
            ?>
                <table>
                    <tr>
                        <th colspan="3">Students Report</th>
                    </tr>
                    <tr>
                        <td colspan="3" style="padding-left:10px;">Name: <?php echo $row['name']; ?></td>
                    </tr>
                    <tr>
                        <th>Subject</th>
                        <th>Marks / 100</th>
                        <th>Decision</th>
                    </tr>
                    <tr>
                        <td>KINY</td><td><?php echo $row['kiny']; ?></td><td></td>
                    </tr>
                    <tr>
                        <td>SET</td><td><?php echo $row['set']; ?></td><td></td>
                    </tr>
                    <tr>
                        <td>MATH</td><td><?php echo $row['math']; ?></td><td></td>
                    </tr>
                    <tr>
                        <td>SS</td><td><?php echo $row['ss']; ?></td><td></td>
                    </tr>
                    <tr>
                        <td>FR</td><td><?php echo $row['fr']; ?></td><td></td>
                    </tr>
                    <tr>
                        <td>ENG</td><td><?php echo $row['eng']; ?></td><td></td>
                    </tr>
                    <tr>
                        <td>TOTAL</td><td><?php echo $row['total']; ?> /600</td><td></td>
                    </tr>
                    <tr>
                        <td>Percentage</td>
                        <td><?php echo $row['percent']; ?></td>
                        <td>/100</td>
                    </tr>
                    <tr>
                        <td>Position</td>
                        <td><?php echo $position; ?></td>
                        <td>/<?php echo count($ranks); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="copyright">Copyright &copy; L4 SOD 2025</td>
                    </tr>
                </table>
            <?php } ?>
        </div>
    </div>
</body>
</html>