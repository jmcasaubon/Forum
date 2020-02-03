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
<h1>Post's List</h1>
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
<?php
    $posts=$result['data'] ;
    
    if (is_array($posts) && (count($posts) > 0)) {
?>
    <div>
        <table>
            <thead>
                <tr>
                    <th class="center">Author</th>
                    <th class="center">Text</th>
                    <th class="center">Submitted at</th>
                    <th class="center">Actions</th>
                </tr>
            </thead>
            <tbody>
<?php
            foreach($posts as $post) {
?>
        <!-- Si le résultat est un tableau, on génère une ligne par sujet retourné -->
                <tr>
                    <td class="center"><?=ucwords($post['pseudo'], "-_\t\r\n\f\v")?></td>
                    <td class="left"><?=$post['text']?></td>
                    <td class="left"><?=date_format(new DateTime($post['submitted_at']), "d/m/Y H:i")?></td>
<?php
                if (($topic['is_closed'] == '0') && ($post['pseudo'] == $pseudo)) {
?>
                    <td class="center">
                        <a href="index.php?ctrl=Post&action=update&id=<?=$post['id_post']?>"><i class="fas fa-pen-square"></i></a>
                        &nbsp;
                        <a href="index.php?ctrl=Post&action=delete&id=<?=$post['id_post']?>" class="del-post"><i class="fas fa-trash-alt"></i></a>
                    </td>
<?php
                } else {
?>
                    <td class="center">&nbsp;</td>
<?php
                }
?>
                </tr>
<?php
            }
?>
            </tbody>
        </table>
    </div>
<?php
    } else {
?>
        <!-- Sinon, on génère un simple message -->
        <p><strong>No posts yet !</strong></p>

<?php
    }
    if (isset($_SESSION['user']) && isset($_SESSION['topic']) && ($topic['is_closed'] == '0')) {
?>
        <a class="button" href="index.php?ctrl=Post&action=new&id=<?=$_SESSION['topic']['id_topic']?>">Add New Post</a>
<?php
    }
?>
