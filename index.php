<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information System</title>
    <style>
        .student-table{
            padding: 5px;
            background: lightcyan;
        }
        .student-table thead{
            background-color: gray;
        }
        .student-table td{
          padding: 20px;
        }

        .student-table .add-btn{
            background: red;
            color: white;
            font-size: 16px;
            border: 1px solid lightcyan;
            text-decoration: none;
            padding: 5px;
            margin-left: 4px;
        }

        .student-table .add-btn:focus{
            background: blue;
            color: white;
        }

        .student-table .upd-btn{
            text-decoration: none;
            background: green;
            padding: 10px;
            margin: 10px 10px;
            border: 1px solid gray;
        }
        .student-table .dlt-btn{
            text-decoration: none;
            padding: 10px;
            margin-right: 10px;
            background: red;
            color: white;
            border: 1px solid gray;
        }
    </style>
</head>
<body>

<!-- for PHP Codes -->
<!-- to check methods and error  -->
<?php

    // now it is time to get data from our database
    $conn = mysqli_connect('localhost','root','','info'); // my database name was info
    if(!$conn){
        die("database connection failed" . $conn);
    }


    if(isset($_POST['Add-it'])){
        $name = $_POST['Name'];
        $age = $_POST['Age'];
        $address = $_POST['Address'];
        //name and address should be text and age should be number
        $nameErr = "";
        $ageErr = "";
        $addressErr = "";
        $error = 0;
        if(!preg_match('/^[a-zA-Z]+$/',$name) || empty($name)){
            $nameErr = "Name is empty or it includes number" ;
            $error++;
        }

        if(!preg_match('/^[a-zA-Z]+$/',$address) || empty($address)){
            $addressErr = "Address is empty or it includes number" ;
            $error++;
        }

        if(!preg_match('/^\d+$/',$age) || empty($age)){
            $ageErr = "Age is not a number" ;
            $error++;
        }

        if($error == 0){
            //here we should add the student data to database
            //there was no mistake i think it is the variable
            $adding = "INSERT into students (name,age,address) values ('$name','$age','$address')"; //we dont need to add id
            $run = mysqli_query($conn,$adding);
            //worked

            echo "<script>
            alert('student added successfully');
            window.open('./index.php','_self');
            </script>";
        }else{
            echo "<script>
            alert('$nameErr   $ageErr   $addressErr');
            window.open('./index.php','_self');
            </script>";
        }

    }

    if(isset($_POST['update-it'])){
        $id=$_POST['id'];
        $name = $_POST['Name'];
        $age = $_POST['Age'];
        $address = $_POST['Address'];
        //name and address should be text and age should be number
        $nameErr = "";
        $ageErr = "";
        $addressErr = "";
        $error = 0;
        if(!preg_match('/^[a-zA-Z]+$/',$name) || empty($name)){
            $nameErr = "Name is empty or it includes number" ;
            $error++;
        }

        if(!preg_match('/^[a-zA-Z]+$/',$address) || empty($address)){
            $addressErr = "Address is empty or it includes number" ;
            $error++;
        }

        if(!preg_match('/^\d+$/',$age) || empty($age)){
            $ageErr = "Age is not a number" ;
            $error++;
        }

        if($error == 0){
            //here we should add the student data to database
            //there was no mistake i think it is the variable
            // not working
            $adding = "UPDATE students set name = '$name', age = '$age' , address = '$address' where id='$id'"; //we dont need to add id
            $run = mysqli_query($conn,$adding);
            //worked

            echo "<script>
            alert('student Updated successfully');
            window.open('./index.php','_self');
            </script>";
        }else{
            echo "<script>
            alert('$nameErr   $ageErr   $addressErr');
            window.open('./index.php','_self');
            </script>";
        }
    }

//deleting operation
    if(isset($_POST['deleteID'])){
        $delete = $_GET['deleteID']; //this should be from link
        echo $delete;
        $deleteQuery = "DELETE from students where id=$delete";
        $runDelete = mysqli_query($conn,$deleteQuery);
        echo "
        <script>
        alert('The student has been deleted');
        window.open('./index.php','_self');
        </script>"; 
        //now it is working
    }
?>


<!-- now it is time to add update and delete button -->



    <h1 align="center">Student Information System</h1>

    <table border="1px" align="center" class="student-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Address</th>
                <th>Operations</th>
            </tr>
        </thead>

        <!-- we should get the data from database -->
        <tbody>
            <?php 
                $students = "SELECT * from students";
                $res = mysqli_query($conn,$students);
                $num_row = mysqli_num_rows($res);

                if($num_row > 0){
                    while($data = mysqli_fetch_assoc($res)){
                        echo "
                        <tr>
                        <td>" . $data['id'] ."</td>
                        <td>" . $data['name'] ."</td>
                        <td>" . $data['age'] ."</td>
                        <td>" . $data['address'] ."</td>
                        <td>
                            <form action='./index.php?deleteID=". $data['id'] ."' method='post' >
    
                                <a href='./index.php?updateID=". $data['id'] ."' class='upd-btn'>Update</a>

                                <input type='submit' value='Delete' name='deleteID' class='dlt-btn' />
                            </form>
                        </td>
                        </tr>
                        ";
                        // there are 2 way for deleting data
                        //these way is a bad idea because anyone with the link
                        //can delete data like this ,
                        //seei deleted without clicking the button
                        // for this we need to use post method
                        // <a href='./index.php?deleteID=" . $data['id'] . "' class='dlt-btn'>delete</a>
                        //you it didn't worked when i changed the link now i will do it with our old way
                    }
                }
                else{
                    echo "<tr>
                        <td colspan='4'>There is no data</td>
                    </tr>";
                }
            ?>
        </tbody>
        
            
            <tfoot>
                <tr>
                    <td colspan="5" align="center">
                        <!-- it was wrong -->
                        <!-- or you can add this-->
                        Add Student:<a href="./index.php?add-student" class="add-btn">Add</a> 
                    </td>
                </tr>
            </tfoot>
    </table>

    <!-- for adding students -->
        <?php 

            if(isset($_GET['add-student'])){
                
                ?>
                    <form action="" method="post" >
                            
                            <label for="name">Name:</label>
                            <input type="text" name="Name" id="name" />
                            <br />
                            <br />
                            
                            <label for="age">age:</label> 
                            <input type="text" name="Age" id="age"/>
                            <br />
                            <br />                            
                            <label for="address">Address:</label>
                            <input type="text" name="Address" id="address"/>
                            <br />
                            <br />

                            <input type="submit" name="Add-it" />
                    </form>
                <?php

            }
        ?>

<?PHP
    if(isset($_GET['updateID'])){
                $id = $_GET['updateID'];
                $student = "SELECT * from students where id='$id'";
                $resUpdate = mysqli_query($conn,$student);
                $numRow = mysqli_num_rows($resUpdate);
                if($numRow <= 0){
                    echo "No students";
                }
                else{
                    $studentData = mysqli_fetch_assoc($resUpdate);
                ?>
                    <form action="" method="post" >
                            <!-- for updating same student you need to now the id  -->
                            <input name="id" 
                            value="<?php echo $studentData['id'] ?>"
                            hidden
                            />


                            <label for="name">Name:</label>
                            <input type="text" name="Name" id="name" 
                            value="<?php echo $studentData['name'] ?>"/>
                            <br />
                            <br />
                            
                            <label for="age">age:</label> 
                            <input type="text" name="Age" id="age"
                            value="<?php echo $studentData['age'] ?>"/>
                            <br />
                            <br />                            
                            <label for="address">Address:</label>
                            <input type="text" name="Address" id="address"
                            value="<?php echo $studentData['address'] ?>"/>
                            <br />
                            <br />

                            <input type="submit" name="update-it" />
                    </form>
                <?php
                }
            }
        ?>




<!-- now it is finished i hope you got a best information about crud operations by php  -->
<!-- please dont forget like, comment, subscribe the chennal  , i wish you the best -->
<!-- good luck -->
<!-- this code will be available in my githup , link in the description  -->
</body>
</html>