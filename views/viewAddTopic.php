<!-- Formulaire d'ajout d'un nouveau sujet -->
<div class="center">
    <h1>Add New Topic</h1>
    <form action="index.php?ctrl=Topic&action=add" method="post">
        <p><input type="text" name="title" id="title" size="80" placeholder="Title of new topic" required></p>
        <p><textarea name="descr" id="descr" rows="12" cols="80" placeholder="Description..." required></textarea></p>
        <p><input class="button" type="submit" value="Send"></p>
    </form>
    <p class="error"><?=$result['data']?></p>
</div>