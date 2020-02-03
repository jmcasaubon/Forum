<?php
    // On charge les données actuelles du sujet
    if (isset($_SESSION['topic'])) {
        $topic = $_SESSION['topic'] ;
?>
        <!-- Formulaire de modification d'un sujet existant -->
        <div class="center">
            <h1>Update Topic</h1>
            <form action="index.php?ctrl=Topic&action=doUpdate&id=<?=$topic['id_topic']?>" method="post">
                <p><input type="text" name="title" id="title" size="80" placeholder="Title of new topic" value="<?=$topic['title']?>" required></p>
                <p><textarea name="descr" id="descr" rows="12" cols="80" placeholder="Description..." required><?=$topic['description']?></textarea></p>
                <p><input class="button" type="submit" value="Update"></p>
            </form>
            <p class="error"><?=$result['data']?></p>
        </div>
<?php
    }
?>
