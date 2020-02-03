<?php
    // On vérifie si on est en mode anonyme ou connecté (et on mémorise le pseudo en conséquence)
    if (isset($_SESSION['user']))
        $pseudo = $_SESSION['user']['pseudo'] ; 
    else
        $pseudo = null ;
    // On vérifie également si on a bien sélectionné un sujet avant d'afficher les messages correspondants (que l'on soit en mode anonyme ou connecté)
    if (isset($_SESSION['topic']))
        $topic = $_SESSION['topic'] ; 
    else 
        $topic = null ;
?>
<div>
    <table>
        <thead>
            <tr>
                <th class="center" colspan="2">Subject</th>
                <th class="center">Author</th>
                <th class="center">Description</th>
                <th class="center">Created at</th>
                <th class="center"># Posts</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="center nb-right"><i class="fas fa-<?=($topic['is_closed'] != '0') ? 'lock' : 'lock-open'?>"></i></td>
                <td class="center nb-left"><?=$topic['title']?></td>
                <td class="center"><?=ucwords($topic['pseudo'], "-_\t\r\n\f\v")?></td>
                <td class="left"><?=$topic['description']?></td>
                <td class="center"><?=date_format(new DateTime($topic['created_at']), "d/m/Y H:i")?></td>
                <td class="center"><?=$topic['nb_posts']?></td>
            </tr>
        </tbody>
    </table>
</div>
<!-- Formulaire d'ajout d'un nouveau message (dans un sujet) -->
<div class="center">
    <h1>Add New Post</h1>
    <form action="index.php?ctrl=Post&action=add&id=<?=$_SESSION['topic']['id_topic']?>" method="post">
        <p><textarea name="text" id="text" rows="12" cols="80" placeholder="Enter your contribution here..." required></textarea></p>
        <p><input class="button" type="submit" value="Send"></p>
    </form>
    <p class="error"><?=$result['data']?></p>
</div>