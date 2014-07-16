<?php require 'functions/db.php'; ?>

<h1>Brute Force Password Database Creator</h1>

<form method="post" class="form-horizontal" role="form">

    Table Name<br />
    <input type="text" maxlength="200" id="txtTableName" name="txtTableName" value="passwordList" />
    <br /><br />
    Entry Length Size<br />
    <input type="text" maxlength="2" id="txtSize" name="txtSize" value="6" />
    <br /><br />
    <button type="submit" id="cmdSubmit" name="cmdSubmit">Create Password Database</button>

    <?php


    //If Post then save
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {

        echo "<br /><hr /><br /><b>Output</b><br />";

        $characters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');

        $link = Db::open();

        $query = "CREATE TABLE " . $_POST['txtTableName'] . " (PasswordID INT NOT NULL AUTO_INCREMENT, PasswordValue VARCHAR(" . $_POST['txtSize'] . ") NOT NULL, PRIMARY KEY (PasswordID))";

        $link -> query($query);

        echo "<br />Table Created (" . $query . ")<br />";

        $start = 1;
        $end = (int)$_POST['txtSize'];

        $len  = count($characters);
        $list = array();

        for($i = 1; $i < (1 << $len); $i++)
        {
            $c = '';
            for($j = 0; $j < $len; $j++)
                if($i & (1 << $j))
                    $c .= $a[$j];
            $list[] = $c;
        }

        print_r($list);

        //$query = "INSERT INTO " . $_POST['txtTableName'] . " (PasswordValue) VALUES ('" . $value . "')";
        //$link -> query($query);

        Db::close($link);

    }

    ?>


</form>

<script type="text/javascript">

    $(document).ready(function(){

        $('#txtTableName').focus();

    });

</script>
    
