<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <link rel="stylesheet" href="style.css"> <!-- External CSS file -->
    <style>
        /* Internal CSS for animations and additional styling */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form {
            animation: fadeIn 1.5s ease-in-out; /* Fade-in animation */
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        fieldset {
            border: 2px solid #4CAF50;
            border-radius: 8px;
            padding: 20px;
        }

        legend {
            font-size: 1.2em;
            font-weight: bold;
            color: #4CAF50;
            padding: 0 10px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        input[type="submit"],
        input[type="reset"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 10px;
        }

        input[type="submit"]:hover,
        input[type="reset"]:hover {
            background-color: #45a049;
        }

        h3 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 15px;
        }

        .alert {
            padding: 10px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="form">
        <fieldset>
            <legend>Update Student</legend>
            <form action="" method="POST">
                <?php
                // Step 1: Get the ID of the student to update
                $connect = new mysqli('localhost', 'root', '', 'gary');
                if (isset($_GET['update_id'])) {
                    $updated_id = $_GET['update_id'];
                }

                // Step 2: Fetch the student's data and populate the form fields
                $output2 = "SELECT * FROM student WHERE `id`='$updated_id'";
                $query2 = mysqli_query($connect, $output2);
                while ($row = mysqli_fetch_assoc($query2)) {
                ?>
                <label>Username: </label>
                <input type="text" name="name" value="<?php echo $row['name']; ?>" required><br><br>
                <h3><u>Student Marks</u></h3>
                <label>Math: </label><input type="number" name="math" value="<?php echo $row['math']; ?>" required><br><br>
                <label>KINY: </label><input type="number" name="kiny" value="<?php echo $row['kiny']; ?>" required><br><br>
                <label>ENG: </label><input type="number" name="eng" value="<?php echo $row['eng']; ?>" required><br><br>
                <label>SET: </label><input type="number" name="set" value="<?php echo $row['set']; ?>" required><br><br>
                <label>FR: </label><input type="number" name="fr" value="<?php echo $row['fr']; ?>" required><br><br>
                <label>SS: </label><input type="number" name="ss" value="<?php echo $row['ss']; ?>" required><br><br>
                <input type="submit" name="send" value="Update">
                <input type="reset" name="Clear" value="Clear"><br><br>
                <?php } ?>
            </form>
            <?php
            // Step 3: Handle the update query
            $conn = mysqli_connect("localhost", "root", "", "gary");

            if ($conn) {
                echo "<div class='alert'>Connection successful!</div>";
            }

            if (isset($_POST["send"])) {
                $name = $_POST["name"];
                $math = intval($_POST["math"]);
                $kiny = intval($_POST["kiny"]);
                $eng = intval($_POST["eng"]);
                $ss = intval($_POST["ss"]);
                $fr = intval($_POST["fr"]);
                $set = intval($_POST["set"]);

                // Calculate total, average, and percentage
                $total = $math + $kiny + $eng + $ss + $fr + $set;
                $average = $total / 6;
                $percent = ($total * 100) / 600;

                // Update query
                $send = "UPDATE `student` SET 
                         `name`='$name', 
                         `math`='$math', 
                         `kiny`='$kiny', 
                         `eng`='$eng', 
                         `set`='$set', 
                         `fr`='$fr', 
                         `ss`='$ss', 
                         `total`='$total', 
                         `average`='$average', 
                         `percent`='$percent' 
                         WHERE `id`='$updated_id'";

                $query = mysqli_query($conn, $send);

                if ($query) {
                    echo "<script>
                            alert('Data updated successfully!');
                            window.location.href = 'index.php';
                          </script>";
                } else {
                    echo "<script>alert('Failed to update data.');</script>";
                }
            }
            ?>
        </fieldset>
    </div>
</body>
</html>