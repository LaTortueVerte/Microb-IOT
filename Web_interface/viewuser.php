<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="generator" content="Hugo 0.72.0">
    <title>Liste des utilisateurs</title>

    <link rel="canonical" href="https://v5.getbootstrap.com/docs/5.0/examples/blog/">
    <link rel="stylesheet" href="stylehome.css">


    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
        integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
        integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    
</head>

<body>
    <center>
        <h1>Vue sur la base de données : users</h1>
        <a href="adminpage.html"><button>Retour à la page précédente</button></a><br />
    <br />
        <table border="1" style="text-align: center;">
            <tr bgcolor='#CC99FF'>
                <th>Nom d'utilisateur</th>
                <th>Email</th>
                <th>Role</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>
            <?php
            include("conn.php"); //ajout de la connexion à la page PHP
            $sql = "Select * from users"; //add a new sql query
            $result = mysqli_query($conn, $sql); // affichage de l'ensemble de la table users (exécution de la requête $sql)
            if (mysqli_num_rows($result) <= 0) {
                die("<script>alert ('No data from database! ');</script>");
            }

            while ($rows = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $rows['user_name'] . "</td>";
                echo "<td>" . $rows['user_email'] . "</td>";
                echo "<td>" . $rows['user_role'] . "</td>";
                echo "<td><a href='edituser.php?iduser=" . $rows['user_ID'] . "'><button>Edit</button></a></td>";
                echo "<td><a href='deleteuser.php?iduser=" . $rows['user_ID'] . "'><button>Delete</button></a></td>";
                echo "</tr>";
            }
            ?>
        </table>

    </center>
</body>

</html>