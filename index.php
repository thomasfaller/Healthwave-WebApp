<?php  
$connect = mysqli_connect("localhost", "root", "root", "healthwave_db");  
if (isset($_POST["submit"]))  
{  
  if (!empty($_POST["search"]))  
    {  
      $query = str_replace(" ", "+", $_POST["search"]);  
      header("location:index.php?search=" . $query);  
    }  
}  
?>  
<!DOCTYPE html>  
<html lang="en">  
<head>
  <meta charset="UTF-8">
  <meta name="author" content="Thomas Faller">
  <meta name="description" content="This a WebApp written in PHP linked to a mySQL table, built for Healthwave.">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Healtwave WebApp | Medicine Search</title>  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="/style.css" type="text/css"/>           
</head>  
      
<body>  
<a href="/index.php">
  <img id="logo" src="./assets/logo_.png" alt="healthwave logo">
</a>
<div class="container col-12 col-md-10 col-lg-6">  
  <form method="post">  
    <label>Enter Search Text</label>  
    <input onfocus="if(this.value!==''){this.value='';}" type="text" name="search" class="form-control" value="<?php if(isset($_GET[" search "])) echo $_GET["search"]; ?>" placeholder="Type the name of your item..."/>  
    <br />
    <div class="text-center">  
      <input type="submit" name="submit" class="btn btn-outline-info btn-lg" value="Search"/>
    </div>
  </form>  
  <br/>  
  <div class="table-responsive">  
    <table class="table table-bordered">  
      <?php  
        if (isset($_GET["search"]))  
          {  
            $condition = '';  
            $query = explode(" ", $_GET["search"]);  
            foreach($query as $text)  
              {  
                $condition .= "product_name LIKE '%".mysqli_real_escape_string($connect, $text)."%' OR ";  
              }  
            $condition = substr($condition, 0, -4);  
            $sql_query = "SELECT * FROM medicines WHERE " . $condition;
            $result = mysqli_query($connect, $sql_query);  
            if (mysqli_num_rows($result) > 0)  
              { 
                echo '<table class="table table-striped">';   
                echo '<thead>';
                echo '<tr>';
                echo '<th scope="col">Id</th>';
                echo '<th scope="col">Product</th>';
                echo '<th scope="col">Pack size</th>';
                echo '<th scope="col">Price</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while($row = mysqli_fetch_array($result))  
                  {   
                    echo '<tr>';
                    echo '<td>'.$row['id'].'</td>';
                    echo '<td>'.$row['product_name'].'</td>';
                    echo '<td>'.$row['pack_size'].'</td>';
                    echo '<td>'.$row['price'].' €</td>';
                    $_TOTAL += $row['price'];
                    echo '</tr>';
                  }
                echo '</tbody>';
                echo '</table>';
                echo '<table class="table table-striped">';
                echo '<thead>';
                echo '<tr>';
                echo '<th> </th>';
                echo '<th> </th>';
                echo '<th scope="col">TOTAL</th>';
                echo '<th scope="col">'.number_format((float)$_TOTAL, 2, '.', '').' €</th>';
                echo '</tr>';
                echo '</thead>';
                echo '</table>';
              }  
                else  
              {  
                echo '<label>Data not Found</label>';  
              }  
            }
        ?>  
    </table>  
  </div>
</div>  
</body>  
</html> 