<?php


//The following try and catch statements are used to establish connection to the database while catching any errors when the conneciton fails
try {
        $db = new PDO('mysql:host=127.0.0.1;port=3306;dbname=employees', 'root', 'basel295');
       	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	

} catch(PDOException $e) {



	
	echo $e->getMessage()."<br>";

	die("Not connected.");
}

//sets the filename where the selected database information will be stored
$filename = 'employees.json';


//The SQL query that selects the top 5 paid employees using information including first name, last name, title, department and salary whiile displaying it in descending order based on the salaries
$myq = $db->query('SELECT employees.first_name, employees.last_name, titles.title,departments.dept_name, salaries.salary FROM employees
        INNER JOIN dept_emp ON employees.emp_no = dept_emp.emp_no 
        INNER JOIN titles ON employees.emp_no = titles.emp_no 
        INNER JOIN salaries ON employees.emp_no = salaries.emp_no 
        INNER JOIN departments ON dept_emp.dept_no = departments.dept_no 
        ORDER BY salaries.salary DESC LIMIT 5');


//using the fetch_All function, the resulting rows from the database query will be displayed in the form of an array. FETCH_ASSOC converts the standard array into an associative one for better viewing
$results = $myq->fetchAll(PDO::FETCH_ASSOC);

//displays the results on screen
echo '<pre>', print_r($results), '/<pre>';

//Converts the results of the query into a JSON string which is then written in to the designated file 
$json = json_encode($results);
file_put_contents($filename, $json);


?>

