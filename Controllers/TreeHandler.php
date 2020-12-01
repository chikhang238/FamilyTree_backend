<?php

class TreeHandler extends Controller{

    public static function return_tree(){
        $conn = self::connect();
        $tree_id = $_POST['tree_id'];
        $sql = "SELECT description.tree_id, node_id, first_name, last_name, 
        child_node_id, age, spouse_name, level, date_of_birth, death_date FROM relationship 
        RIGHT JOIN description ON par_node_id = node_id and 
        description.tree_id = relationship.tree_id WHERE description.tree_id = $tree_id";
        $result = $conn->query($sql);

        $dictionary = [];

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if(array_key_exists($row['node_id'],$dictionary)){
                    array_push($dictionary[$row['node_id']]['children'], $row['child_node_id']);
                }
                else{
                    $dictionary[$row['node_id']] = [];
                    $dictionary[$row['node_id']]['name'] = $row['first_name'].' '.$row['last_name'];
                    $dictionary[$row['node_id']]['age'] = $row['age'];
                    $dictionary[$row['node_id']]['spouse'] = $row['spouse_name'];
                    $dictionary[$row['node_id']]['level'] = $row['level'];
                    $dictionary[$row['node_id']]['id'] = $row['node_id'];
                    $dictionary[$row['node_id']]['birth'] = $row['date_of_birth'];
                    $dictionary[$row['node_id']]['death_date'] = $row['death_date'];
                    $dictionary[$row['node_id']]['children'] = [];
                    array_push($dictionary[$row['node_id']]['children'], $row['child_node_id']);
                }
            }
        }
        return $dictionary;
    }


    public static function insert_node(){
        $conn = self::connect();
        $tree_id = $_POST['tree_id'];
        $node_id = $_POST['node_id'];
        $relationship = $_POST['relationship'];
        $new_node_id = $_POST['new_node_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $date_of_birth = $_POST['date_of_birth'];
        
        if (!empty($_POST['birth_place'])) {
            $birth_place = "'".$_POST['birth_place']."'";
        } else {
            $birth_place = "NULL";
        }
        
        if (!empty($_POST['sex'])) {
            $sex = "'".$_POST['sex']."'";
        } else {
            $sex = "NULL";
        }
        
        if (!empty($_POST['status'])) {
            $status = "'".$_POST['status']."'";
        } else {
            $status = "NULL";
        }
        
        if (!empty($_POST['death_date'])) {
            $death_date = "'".$_POST['death_date']."'";
        } else {
            $death_date = "NULL";
        }
        
        if (!empty($_POST['death_place'])) {
            $death_place = "'".$_POST['death_place']."'";
        } else {
            $death_place = "NULL";
        }
        
        if (!empty($_POST['age'])) {
            $age = "'".$_POST['age']."'";
        } else {
            $age = "NULL";
        }
        
        if (!empty($_POST['spouse_name'])) {
            $spouse_name = "'".$_POST['spouse_name']."'";
        } else {
            $spouse_name = "NULL";
        }

        $sql = "SELECT level FROM description WHERE tree_id = $tree_id and node_id = $node_id";
        $sql1 = "SELECT root_level FROM tree WHERE tree_id = $tree_id";
        $result = $conn->query($sql);
        $result1 = $conn->query($sql1);
        if($result->num_rows == 1 and $result1->num_rows == 1){
            $node_level = (int)$result->fetch_assoc()['level'];
            $tree_root_level = (int)$result1->fetch_assoc()['root_level'];

            if(strcmp($relationship, "child") == 0){
                $sql2 = "INSERT INTO relationship (tree_id, par_node_id, child_node_id) VALUES 
                ($tree_id, $node_id, $new_node_id)";
                $new_node_lv = $node_level + 1;
            }
            else if(strcmp($relationship, "parent") == 0){
                $sql2 = "INSERT INTO relationship (tree_id, par_node_id, child_node_id)
                VALUES ($tree_id, $new_node_id, $node_id)";
                $new_node_lv = $node_level - 1;
                if ($new_node_lv < $tree_root_level){
                    $sql3 = "UPDATE tree SET root_id = $new_node_id, root_level = $new_node_lv
                    WHERE tree_id = $tree_id";
                    if($conn->query($sql3) === FALSE){
                        echo "Error: " . $sql3 . "<br>" . $conn->error;
                    }  
                }
            } 

            if($conn->query($sql2) === FALSE){
                echo "Error: " . $sql2 . "<br>" . $conn->error;
            }   
            
            $sql4 = "INSERT INTO description (tree_id, node_id, level, first_name, last_name,
            date_of_birth, birth_place, sex, status, death_date, death_place, age, spouse_name) VALUES 
            ($tree_id, $new_node_id, $new_node_lv, '".$first_name."', '".$last_name."', CAST('".$date_of_birth."' AS DATE), 
            $birth_place , $sex, $status, CAST($death_date AS DATE), $death_place, $age, $spouse_name)";

            if($conn->query($sql4) === FALSE){
                echo "Error: " . $sql4 . "<br>" . $conn->error;
            } 

        }

    }

}

?>