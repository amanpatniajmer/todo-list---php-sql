<?php


include 'db.php';
switch ($_POST['submit']) {
    case 'Add':
        if (isset($_POST['submit']) && $_POST['task'] != '') {
            $task = $_POST['task'];
            $task=htmlentities($task);
            $query = "INSERT INTO tasks (task) VALUES ('$task')";
            $val = $db->query($query);
            if ($val) {
                echo "Successfully added";
                
            }
        }
        else{
            echo "Give valid input";
        }

        break;
    case 'Update':
        $old_task=$_POST['old_task'];
        $task=$_POST['new_task'];
        $id=$_POST['id'];
        $id=htmlentities($id);
        $old_task=htmlentities($old_task);
        $task=htmlentities($task);

        $query="UPDATE tasks SET task='$task' WHERE task='$old_task' AND id='$id'";
        
        $val = $db->query($query);
            if ($val) {
                echo "Successfully updated";
            }
        break;
    case 'Delete':
        $id=$_POST['id'];
        $query="DELETE FROM tasks WHERE id=".$id;
        if($db->query($query))
        echo "Successfully Deleted";
    break;
    default:
        echo "Not valid";
}
