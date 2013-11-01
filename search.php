<html>
<head>
<Title>Search Form</Title>
<style type="text/css">
    body { background-color: #fff; border-top: solid 10px #000;
        color: #333; font-size: .85em; margin: 20; padding: 20;
        font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
    }
    h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
    h1 { font-size: 2em; }
    h2 { font-size: 1.75em; }
    h3 { font-size: 1.2em; }
    table { margin-top: 0.75em; }
    th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
    td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
</style>
</head>
<body>
<h1>Search for a registrant</h1>

    <form action="search.php" method="post">
    <input type="text" value="Enter Search Value" name="searchbox" maxlength="30">
    
    <input type="submit" value="Submit"/>
    </form>

 <?php
    // DB connection info
    //TODO: Update the values for $host, $user, $pwd, and $db
    //using the values you retrieved earlier from the portal.
    $host = "eu-cdbr-azure-west-b.cloudapp.net";
    $user = "b29e134ba5c0fe";
    $pwd = "59f51632";
    $db = "syseng2cwdb";
    // Connect to database.
    try {
        $conn = new PDO( "mysql:host=$host;dbname=$db", $user, $pwd);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch(Exception $e){
        die(var_dump($e));
    }

    if(!empty($_POST)) {
    try {

$sql_select = "SELECT FROM registration_tbl (name, email, company, date) 
                   VALUES (?,?,?,?)";
        $stmt = $conn->prepare($sql_select);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $email);
        $stmt->bindValue(3, $company);
        $stmt->bindValue(4, $date);
        $stmt->execute();


    
    $registrants = $stmt->fetchAll(); 
    if(count($registrants) > 0) {
        echo "<h2>Search results:</h2>";
        echo "<table>";
        echo "<tr><th>Name</th>";
        echo "<th>Email</th>";
	echo "<th>Company</th>";
        echo "<th>Date</th></tr>";
        foreach($registrants as $registrant) {
            echo "<tr><td>".$registrant['name']."</td>";
            echo "<td>".$registrant['email']."</td>";
	    echo "<td>".$registrant['company']."</td>";
            echo "<td>".$registrant['date']."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<h3>No one is currently registered.</h3>";
    }
    }
    catch(Exception $e) {
        die(var_dump($e));
    }
}
?>
</body>
</html>
