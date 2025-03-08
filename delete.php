<?php

include 'conn.php';

if(isset($_GET['remove_data'])){

    $removed_data = $_GET['remove_data'];
   
    $sql = "DELETE FROM `student` WHERE `id`='$removed_data'";

    $check_result = mysqli_query($conn , $sql);

    if($check_result){
        ?>
          <script>
            window.location.href = 'index.php';
          </script>
        <?php
    }

}