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
<form name="search" method="post" action="<?=$PHP_SELF?>">

 Seach for: <input type="text" name="find" /> in 
 <select name="field">
 <option value="name">Name</option>
 <option value="email">Email</option>
 <option value="company">Company</option>
 </select>
 <input type="hidden" name="searching" value="yes" />
 <input type="submit" name="search" value="Search" />

</form>

 <? 
 //This is only displayed if they have submitted the form 
 if ($searching =="yes") 
 { 
 echo "<h2>Results</h2><p>"; 
 
 //If they did not enter a search term we give them an error 
 if ($find == "") 
 { 
 echo "<p>You forgot to enter a search term"; 
 exit; 
 } 
 
 // Otherwise we connect to our Database 
 mysql_connect("mysql.yourhost.com", "user_name", "password") or die(mysql_error()); 
 mysql_select_db("database_name") or die(mysql_error()); 
 
 // We preform a bit of filtering 
 $find = strtoupper($find); 
 $find = strip_tags($find); 
 $find = trim ($find); 
 
 //Now we search for our search term, in the field the user specified 
 $data = mysql_query("SELECT * FROM users WHERE upper($field) LIKE'%$find%'"); 
 
 //And we display the results 
 while($result = mysql_fetch_array( $data )) 
 { 
 echo $result['fname']; 
 echo " "; 
 echo $result['lname']; 
 echo "<br>"; 
 echo $result['info']; 
 echo "<br>"; 
 echo "<br>"; 
 } 
 
 //This counts the number or results - and if there wasn't any it gives them a little message explaining that 
 $anymatches=mysql_num_rows($data); 
 if ($anymatches == 0) 
 { 
 echo "Sorry, but we can not find an entry to match your query<br><br>"; 
 } 
 
 //And we remind them what they searched for 
 echo "<b>Searched For:</b> " .$find; 
 } 
 ?> 
 
</body>
</html>
