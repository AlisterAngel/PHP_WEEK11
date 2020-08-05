<?php
$title_of_page = "Gamer Table";
session_start();
if (!empty($_SESSION['user_id'])) {
    $register_required = "true";
}else{
    $register_required = "view";
}
require_once("header.php");

$keywords = null;

if (!empty($_GET['keywords'])) {
    $keywords = $_GET['keywords'];
}
?>
    <h1>Welcome To The Gamer Table <a href="gamer.php" title="Create A New Gamer"><img src="images/GamerTag.png"></a></h1>
    <form method="get" action="view-gamers.php">
        <label for="keywords">Enter Keywords to Search:</label>
        <div class="input">
            <input name="keywords" value=<?php echo "'".$keywords."'"; ?>/>
            <select name="search_type">
                <option value="OR">Any Keyword</option>
                <option value="AND">All Keywords</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Search</button>
    </form>
<?php
try {
    //connect to database
    require("db.php");

    $sql = "SELECT * FROM gamer";
    $word_list = null;

// check if the user entered keywords for searching
    if (!empty($keywords)) {
        // start the WHERE clause MAKING SURE to include spaces around the word WHERE
        $sql .= " WHERE ";

        // split the keywords into an array of individual words
        $word_list = explode(" ", $keywords);
        // loop through the word list and add each word to the where individually
        // read php docs on foreach to learn more about $key => $value. Here $key acts like a counter
        $search_type = $_GET['search_type'];
        foreach($word_list as $key => $word) {

            $word_list[$key] = "%" . $word . "%";

            // for the first word OMIT the word OR
            if ($key == 0) {
                $sql .= " firstName LIKE ?";
            }
            else {
                $sql .= " $search_type firstName LIKE ?";
            }

        }
    }

    // execute the query and store the results, passing the $word_list array as a parameter list to the execute() function
    $cmd = $db->prepare($sql);
    $cmd->execute($word_list);
    $gamer = $cmd->fetchAll();

    //Table
    echo '<table class="sortable"><thead><th>First Name</th><th>Last Name</th><th>Age</th><th>Type Of Gamer</th><th>Game</th>';

    session_start();
    if (!empty($_SESSION['user_id'])) {
        echo '<th>Edit</th><th>Delete</th>';
    }

    echo '</thead><tbody>';

    //add each row to the table
    foreach ($gamer as $value) {
        echo '<tr><td>' . $value['firstName'] . '</td>
            <td>' . $value['lastName'] . '</td>
            <td>' . $value['age'] . '</td>
            <td>' . $value['typeOfGamer'] . '</td>
            <td>' . $value['game'] . '</td>';

        session_start();
        if (!empty($_SESSION['user_id'])) {
            echo '<td><a href="gamer.php?gamer_id=' . $value['gamer_id'] . '" title="Edit">✍</a>
                <td><a href="delete-gamer.php?gamer_id=' . $value['gamer_id'] . '" title="Remove From List" onclick="return confirm(\'Are you sure you want to delete this gamer?\');">💣</a></td></tr>';
        }
    }

    echo '</tbody></table>';


    session_start();
    if (!empty($_SESSION['user_id'])) {


        echo "<img src='images/Loading.gif'/>";

        $sql = "Select * from gamerType;";
        $cmd = $db->prepare($sql);
        $cmd->execute();
        $gamerType = $cmd->fetchAll();

        //Table
        echo '<table class="sortable"><thead><th>Type</th><th>Description</th></thead><tbody>';

        //add each row to the table
        $CS = 0;
        foreach ($gamerType as $value) {
            echo '<tr style=' . (($CS % 2 == 0) ? '"color: #b514aa"' : '"color: #0ccef0"') . '><td>' . $value['type'] . '</td>
            <td>' . $value['description'] . '</td></tr>';
            $CS += 1;
        }

        echo '</tbody></table>';

        $db = null;
    }
}
catch (Exception $e) {
    header('location:error.php');
}

require_once("footer.php");
