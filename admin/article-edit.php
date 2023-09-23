<!--
    Admin Article Management Page
-->
<?php 
// Start a session
session_start();

// Check if the user is an admin (user_id == 1)
if ($_SESSION['user_id'] == 1) 
{
    // Include necessary backend and UI components
    include 'article-backend.php'; 
    include 'header.php';
    include 'navbar.php';
?>

<div class="d-flex align-items-start flex-wrap">
    <div class="flex-column">
        <div class="admin-element">
            <h4>Добавяне на статия</h4>
            <form method="post" action="article-edit.php" enctype='multipart/form-data'>
                Заглавие:<br>
                <input id="title" type="text" placeholder="Заглавие" name="title" value="<?php echo $title;?>" required>
                <br><br>
    
                Статия:<br>
                <input id="content" class="article-content" type="text" name="content" value="<?php echo $content;?>" required>
                <br><br>
    
                Снимка (Max size 1MB):<br>
                <input id="photo" type="file" name="photo" required>
                <br><br>
    
                <input type="submit" name="submit_article" value="Добавяне">    
            </form> 
        </div>  

        <div class="admin-element">
            <h4 class="mb-3">Изтриване</h4>
            <form method="post" action="article-edit.php">
                <select name="article_to_delete" class="m-1" required>
                    <option selected disabled>Изберете събитие</option>
                    <?php foreach($articles as $article): ?>
                    <option value="<?php echo htmlspecialchars($article['title']);?>"><?php echo htmlspecialchars($article['title']);?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" name="delete_article" value="Изтриване"> 
            </form> 
        </div> 
    </div>
    
    <div class="admin-element">
        <h4>Редактиране</h4>
        <form method="post" action="article-edit.php" enctype='multipart/form-data'>
            <select name="article_to_edit" class="mt-3 mb-4" required>
                <option selected disabled>Изберете събитие</option>
                <?php foreach($articles as $article): ?>
                <option value="<?php echo htmlspecialchars($article['title']);?>"><?php echo htmlspecialchars($article['title']);?></option>
                <?php endforeach; ?>
            </select>
            <br>
    
            Промяна на заглавие:<br>
            <input type="text" placeholder="Заглавие" name="edit_title" value="<?php echo $title;?>" >
            <br><br>
    
            Промяна на съдържание:<br>
            <input class="article-content" type="text" name="edit_content" value="<?php echo $content;?>" >
            <br><br>
    
            Снимка (Max size 1MB):<br>
            <input type="file" name="edit_photo" >
            <br><br>
    
            <input type="submit" name="edit_article" value="Редакция"> 
        </form> 
    </div> 
</div> 
</body>
</html>
<?php
    } else {
        // If the user is not an admin, redirect to the index page
        header('Location: ../index.php');
        exit();
    }
?>