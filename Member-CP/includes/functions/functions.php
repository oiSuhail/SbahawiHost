<?php

    function getTitle() {
        
        global $pageTitle;

		if (isset($pageTitle)) {

			echo $pageTitle;	

		} else {

			echo "Unknown";

		}
	}

    function checkItem($select, $from, $value) {

    	global $con;

    	$statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

    	$statement->execute(array($value));

    	$count = $statement->rowCount();

    	return $count;

    }

    function checkItemTicket($select, $from, $select2, $value, $select3, $value2) {

    	global $con;

    	$statement = $con->prepare("SELECT $select FROM $from WHERE $select2 = ? AND $select3 = ?");

    	$statement->execute(array($value, $value2));

    	$count = $statement->rowCount();

    	return $count;

    }


    function countItems($item, $table) {

        global $con;

        $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");

        $stmt2->execute();

        return $stmt2->fetchColumn();
    }



    // Function To get the Latest Data in Database Tables


    function getLatest($select, $table, $select2, $where, $order, $limit = 5) {

        global $con;

        $getStmt = $con->prepare("SELECT $select FROM $table WHERE $select2 = $where ORDER BY $order DESC LIMIT $limit");

        $getStmt->execute();

        $rows = $getStmt->fetchAll();

        return $rows;

    }


    function redirectHome($theMsg, $url = null, $seconds = 3) {

        if ($url === null) {

            $url = "index.php";

            $theRedPage = "HomePage";

        } elseif ($url == "back") {
            
            $url = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ? $_SERVER['HTTP_REFERER'] : "index.php";

            $theRedPage = "Previous";
        
        }

    	echo $theMsg;

    	echo "<div class='alert alert-info'>You will Redirected to $theRedPage after $seconds Seconds.";

    	header("refresh:$seconds;url=$url");

    	exit();

    }

?>