<?php
    session_start();
    include("connectdb.php");
    if(isset($_POST['submit'])){
        $name = $_POST['cname']; 
        // $pic = $_POST['pic'];

        $allowed = array('gif', 'png', 'jpg', 'jpeg', 'jfif');
        $filename = $_FILES['pic_w']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            echo "<script>";
            echo "alert('บันทึกข้อมูลสินค้าไม่สำเร็จ! ไฟล์รูปต้องเป็น jpg, gif, หรือ png เท่านั้น');";
            echo "window.location = 'index.php';"; // Redirect back to the form page
            echo "</script>";
            exit;
        
        }

        $sql = "INSERT INTO `user`(`id`, `name`, `pic`) 
            VALUES (NULL,'{$name}','$ext')" ;
        $result = mysqli_query($conn, $sql);
        if($result){
            $idd = mysqli_insert_id($conn); // Get the last inserted ID
            @copy($_FILES['pic_w']['tmp_name'], "images/".$idd.".".$ext);

            echo "<script>";
            echo "alert('You just posted a photo.');";
            echo "window.location = 'index.php';";
            echo "</script>";
        }
        else {
            echo "Failed: ".mysqli_error($conn);
        }
    }
    
    

?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fakebook</title>
     <!-- BTN BOOSTRAP-->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
     <style>
        body {
            padding: 1rem;
            margin: 2rem;
            box-sizing: border-box;
        }
     </style>
</head>
<body>
<h1 style=" color: blue;">fakebook</h1>
     <table class="table table-sm table-dark text-center">
        <form action="" method="post" enctype="multipart/form-data">
        <thead style="background: #33C7FF!important;" >
        
        <tr >
                <th scope="col">Details</th>
                <th colspan='2'>
                    Title: <input type="text" name="cname">
                    Picture : <input type="file" name="pic_w"  required>
                </th>
                <th scope="col">
                    <button type="submit" class="btn btn-primary my-2" name="submit">
                    Post
                    </button>
                </th>
                
        </tr>
        
    </thead>
    <tbody>
        </form>
        <?php
        include("connectdb.php");

        $sql = "SELECT * FROM `user`";
        $result = mysqli_query($conn,$sql);
        while ($row = mysqli_fetch_assoc($result)){
            ?>
        <tr colspan="2" >
                <!-- <td border="1">Details Posted</td> -->
                <td class="table-success" >
                    <p>Title:</p>
                    <span><?=$row['name'];?></span>

                </td>
                <td class="table-warning">
                    <?php
                        $p = $row['id'].".".$row['pic'];
                    ?>
                                            
                    Picture : <label>
                        <a href="images/<?=$p;?>">
                            <img src="images/<?=$p;?>" width="150">
                        </a></label> 
                </td>
                <td class="table-warning"> </td>
                <td class="table-danger">
                        <a href="delete.php?id=<?=$row['id'];?>&ext=<?=$row['pic'];?>" onclick="return confirm('Do You want to delete this product?')">
                            <button type="button" class="btn btn-danger my-2">Delete</button>
                        </a>
                    
                </td>
        </tr>
        <?php
        }
    ?>
    </tbody>
     </table>


</body>
</html>