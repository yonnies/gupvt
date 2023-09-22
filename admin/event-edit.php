<!--
    Admin Article Management Page
-->
<?php 
session_start();
if ($_SESSION['user_id']==1) 
{
    include 'event-backend.php'; 
    include 'admin-header.php';
    include "admin-navbar.php"
?>

<div class="d-flex align-items-start flex-wrap">
<div class="flex-column">


<div class="admin-element">
    <h4>Добавяне на събитие</h4>
    <form method="post" action="event-edit.php" enctype='multipart/form-data'>
    
    Име на събитието:<br>
    <input id="name" type="text" placeholder="Кратко, точно име" name="name" value="<?php echo $name;?>" required>
    <br><br>
    
    Място:<br>
    <input id="place" type="text" placeholder="Място"  name="place" value="<?php echo $place;?>" required>
    <br><br>

    Начало:<br>
    <input id="date" type="date" placeholder="Дата"  name="datee" required>
    <input type="time" placeholder="Час"  name="timee" >
    <br><br>

    Линк към фейсбук:<br>
    <input id="link" type="text" placeholder="Link"  name="link" value="<?php echo $link;?>"required >
    <br><br>

    Снимка (Max size 1MB):<br>
    <input id="cover" type="file" name="cover" required >
    <br><br>
   
    <input type="submit" name="submit_event" value="Добавяне">

    
    </form> 
</div>  
<div class="admin-element">
    <h4 class="mb-3">Изтриване</h4>
    <form method="post" action="event-edit.php">
        <select name="event_to_delete" class="m-1" required>
            <option selected disabled>Изберете събитие</option>
        <?php foreach($events as $event): ?>
            <option value="<?php echo htmlspecialchars($event['title']);?>"><?php echo htmlspecialchars($event['title']);?></option>
        <?php endforeach; ?>
        </select>

        <input type="submit" name="delete_event" value="Изтриване"> 

    </form> 
</div> 
</div>
        
<div class="admin-element">
    <h4>Редактиране</h4>
    <form method="post" action="event-edit.php" enctype='multipart/form-data'>
    <select name="event_to_edit" class="mt-3 mb-4" required>
        <option selected disabled>Изберете събитие</option>
    <?php foreach($events as $event): ?>
        <option value="<?php echo htmlspecialchars($event['title']);?>"><?php echo htmlspecialchars($event['title']);?></option>
    <?php endforeach; ?>
    </select>
    <br>
    Промяна на име:<br>
    <input type="text" placeholder="Кратко, точно име" name="edit_title" value="<?php echo $title;?>" >
    <br><br>
    
    Промяна на локация:<br>
    <input type="text" placeholder="Локация"  name="edit_place" value="<?php echo $place;?>" >
    <br><br>

    Промяна на дата:<br>
    <input type="date" placeholder="Дата"  name="edit_date">
    <br><br>

    Промяна на час:<br>
    <input type="time" placeholder="Час"  name="edit_time">
    <br><br>

    Промяна на линк към фейсбук:<br>
    <input type="text" placeholder="Link"  name="edit_link" value="<?php echo $link;?>" >
    <br><br>

    Снимка (Max size 1MB):<br>
    <input type="file" name="edit_photo" >
    <br><br>
    <input type="submit" name="edit_event" value="Редакция"> 
    </form> 
</div> 
</div>
</body>
</html>
    <?php }
    else {
        header('Location: ../index.php');
exit();
    }
    ?>