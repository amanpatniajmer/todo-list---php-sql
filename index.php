<!-- <?php
        include 'db.php';
        $query = "SELECT * FROM tasks";
        $result = $db->query($query);
        if (isset($_POST['submit'])) {
            $task = $_POST['task'];
            $query = "INSERT INTO tasks (task) VALUES ('$task')";
            $val = $db->query($query);
            if ($val) {
                echo "Successfull";
            }
        }
        ?> -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Index</title>
    <link rel="stylesheet" href="./index.css" class="rel">
    <script src="ajaxForm.js"></script>
</head>

<body>
    <div class="modal">



        <style>
            .container {
                background-color: #ececec;
                padding: 20px;
                width: 350px;
                margin: auto;
                border-radius: 10px;
            }

            form input[type=text],
            form button {
                width: 100%;
                padding: 12px 20px;
                margin: 8px 0;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }

            form input[type=submit] {
                width: 100%;
                background-color: royalblue;
                font-size: 16px;
                color: white;
                padding: 14px 20px;
                border: none;
                border-radius: 4px;
            }
        </style>

        <div class="container" id="add_modal">
            <h1>Add Task <span class="close">&times;</span></h1>
            <form action="handler.php" method="post" id="add_form">
                <label> Task Name: <input type="text" name="task" id="task" required></label>
                <input type="text" name="type" value="Add" style="display: none;">
                <label>

                    <input type="submit" name="submit" value="Add" id="add_formbtn">
                </label>
            </form>
        </div>


        <div class="container" id="update_modal">
            <h1>Update Task <span class="close">&times;</span></h1>
            <form action="handler.php" method="post" id="update_form">
            <label>#ID: <input type="text" name="id" id="id" readonly></label>
                <label>OLD Task Name: <input type="text" name="old_task" id="old_task" readonly></label>
                <label>NEW Task Name: <input type="text" name="new_task" id="new_task" required></label>
                <label>

                    <input type="submit" name="submit" value="Update" id="update_formbtn">
                </label>
            </form>
        </div>
    </div>



    <h1 class="center">TODO list</h1>
    <div id="all">
    <button id="add" type="button">Add task</button>
    <button id="del" type="button">Delete all tasks</button>
    <span id="info"></span>
    <button id="print" type="button">Print</button>


    <table id='ajax'>
    </table>
    </div>

</body>
<script>
    var info = document.getElementById('info');
    var modal = document.getElementsByClassName('modal')[0];
    var add_modal = document.getElementById('add_modal');
    var update_modal = document.getElementById('update_modal');


    var load = function load() {
        var d = document.getElementById('ajax');
        var xhr = new XMLHttpRequest();
        return new Promise(function(resolve,reject){
            xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                d.innerHTML = this.responseText;
                resolve(xhr);
            }
        }
        xhr.open("POST", "getall.php", true);
        xhr.send();
        })
    }

    function btn(){
        Array.from(document.getElementsByClassName('update_btn')).forEach(function(element) {
            element.addEventListener('click', function(e) {
                modal.style.display = 'block';
                update_modal.style.display = 'block';
                document.getElementById('old_task').setAttribute('value', e.target.dataset.value);
                document.getElementById('id').setAttribute('value', e.target.dataset.id);
                add_modal.style.display = 'none';
                document.getElementById('new_task').focus();
            })
        });
        Array.from(document.getElementsByClassName('delete_btn')).forEach(function(element){
            element.addEventListener('click',function(e){
                var formData=new FormData();
                formData.append('id',e.target.dataset.id);
                formData.append('submit','Delete');
                function send(){
                    var xhr=new XMLHttpRequest();
                    return new Promise(function(resolve,reject){
                        xhr.onreadystatechange=function(){
                        if(xhr.status>=200 & xhr.status<300){
                        info.innerHTML=this.responseText;
                        resolve(xhr);
                        }
                    }
                    xhr.open('post','./handler.php');
                    xhr.send(formData);
                })
                }
                send().then(function(e) {
                    load().then(function(response){btn();});
                }).catch(function(e) {
                    info.innerHTML = e.responseText;
                    load().then(function(response){btn();});
                })
            })
        });
    }
    window.onload = function() {
        load().then(function(response){btn();});
        ajaxForm('add_form', 'add_formbtn', 'info', 'post', load);
        ajaxForm( 'update_form', 'update_formbtn', 'info', 'post' ,load);

    };
    window.onsubmit = function() {
        modal.style.display = 'none';
    }

    document.getElementById('add').addEventListener('click', function() {
        modal.style.display = "block";
        add_modal.style.display = "block";
        update_modal.style.display = "none";
        document.getElementById('task').focus();
    });
    window.addEventListener('click', function(event) {
        if (event.target == modal)
            modal.style.display = "none";
    })


    var close = document.getElementsByClassName('close')[0].addEventListener('click', function() {
        modal.style.display = "none";
    })
    var close = document.getElementsByClassName('close')[1].addEventListener('click', function() {
        modal.style.display = "none";
    })


    document.getElementById('del').addEventListener('click', function() {
        function make_request(url) {
            var req = new XMLHttpRequest();
            return new Promise(function(resolve, reject) {
                req.onreadystatechange = function() {
                    if (req.readyState == 4 && req.status == 200) {
                        resolve(req);
                    }
                }
                req.open('post', url);
                req.send();
            })
        }
        make_request('./deleteAll.php').then(function(e) {
            info.innerHTML = e.responseText;
            load();
        }).catch(function(e) {
            info.innerHTML = e.responseText;
            load();
        })
    })
</script>

</html>