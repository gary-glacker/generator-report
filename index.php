<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Report</title>
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

        .view {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            color: #4CAF50;
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

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .btn a {
            color: white;
            text-decoration: none;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        button:hover {
            background-color: #45a049;
        }

        button a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="view">
            <h1>List of Students</h1>
            <button class="btn"><a href="create.php">Add New</a></button><br><br>
            <table>
                <tr>
                    <th>Position</th>
                    <th>Name</th>
                    <th>Marks %</th>
                    <th>View</th>
                    <th>Action</th>
                </tr>
                <?php
                include 'conn.php';

                $output2 = "SELECT * FROM student ORDER BY percent DESC";
                $query2 = mysqli_query($conn, $output2);

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

                while ($row = mysqli_fetch_assoc($query2)) {
                    $position = $ranks[$row['id']] ?? "N/A"; // Get position from ranks array
                ?>
                <tr>
                    <td><?php echo $position; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['percent']; ?></td>
                    <td>
                        <button><a href="report.php?get_id=<?php echo $row['id']; ?>">Overview</a></button>
                    </td>
                    <td>
                        <button><a href="delete.php?remove_data=<?php echo $row['id']; ?>">Delete</a></button>
                        <button><a href="update.php?update_id=<?php echo $row['id']; ?>">Update</a></button>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>