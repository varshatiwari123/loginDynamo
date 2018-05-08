<!DOCTYPE html>
<html>
<head>
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
</head>
<!------ Include the above in your HEAD tag ---------->
<body>

<div class="container" >

<form class="well span4" style= "margin-left: 359px" method="post" >
  <div class="row">
    	<div class="span3">
	 	<div  >
		      <h1> FORM <h1>
		</div>
			  
		         <label>Email:</label>
                           <input type="text" name="Email" class="span4"    required >
                            <label>Name:</label>
                           <input type="text" name="Name"  class="span4"   required >
			
	
			
                          
	<button type="submit" name="submit"  style= "margin-left: 300px"  class="btn btn-primary ">Register</button>
		</div>
	</div>
</form>
</div>
    
</body>
</html>

<?php
require 'aws/aws-autoloader.php';



date_default_timezone_set('UTC');

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

$sdk = new Aws\Sdk([
    'region'   => 'us-east-2',
    'version'  => 'latest'
]);

$dynamodb = $sdk->createDynamoDb();
$marshaler = new Marshaler();
 
$tableName = 'Login2';


$Email = ($_POST["Email"]);
$Name = ($_POST["Name"]);

$item = $marshaler->marshalJson('
    {
      "Name": "' . $Name. '",
        "Email": "' . $Email . '"
	
        
    }
');

$params = [
    'TableName' => $tableName,
    'Item' => $item
];


try {
    $result = $dynamodb->putItem($params);
    echo "Added item: $Email - $Name\n";

} catch (DynamoDbException $e) {
    echo "Unable to add item:\n";
    echo $e->getMessage() . "\n";
}

?>
