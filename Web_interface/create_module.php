<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Module</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
</head>
<body>
    <h1>Créer un nouveau module</h1>
    <center>
      <center>
        <a href="create_module.php"><button>Retour à la page précédentee</button></a
        ><br />
      </center>
      <form action="create_module.php" method="post" class="form">
        <div class="just-space"></div>
        <div class="mb-3">
            <label for="namemodule" class="form-label">Nom du module</label>
            <input type="text" class="form-control" name="namemodule" id="namemodule" placeholder="Nom du module" required>
        </div>
        <br />
        <div class="mb-3">
            <label for="nbitem" class="form-label">Nombre de composants</label>
            <input type="number" class="form-control" name="nbitem" id="nbitem" placeholder="Nombre de composants" required>
        </div>
        <br />
        <div class="mb-3">
            <label for="modulerole" class="form-label">Type de carte 0 pour Arduino 1 pour FPGA</label>
            <input type="number" class="form-control" name="modulerole" id="modulerole" placeholder="Type de carte 0 pour Arduino 1 pour FPGA" required>
        </div>
        <center>
          <input type="submit" value="Add module" />&nbsp;&nbsp;
          <input type="reset" value="reset"/>
        </center>
        <br />
      </form>
    </center>
</body>
</html>



<?php 
    include "conn.php";
    

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $modulename = $_POST['namemodule'];
        $modulenbitem = $_POST['nbitem'];
        $modulerole = $_POST['modulerole'];

        echo $filename;
        $sql = "Insert into module (module_name, module_numb_attribute, module_role) VALUES ".
        " ('$modulename','$modulenbitem','$modulerole');";
        echo $sql;
        mysqli_query($conn, $sql);

        if(mysqli_affected_rows($conn) <= 0){
            die("‹script›alert ('Fail: unable to insert data!');window.history.go(-1);</script>");
        }
        echo "<script>window.location.href='create_module.php';</script>";
    }
?>



