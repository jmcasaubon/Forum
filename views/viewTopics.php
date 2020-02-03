<h1>Topic's List</h1>
<?php
    $topics=$result['data'] ;

    if (is_array($topics) && (count($topics) > 0)) {
        // On vérifie si on est en mode anonyme ou connecté (et on mémorise le pseudo en conséquence)
        if (isset($_SESSION['user']))
            $pseudo = $_SESSION['user']['pseudo'] ; 
        else
            $pseudo = null ;
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
                    <th class="center">Actions</th>
                </tr>
            </thead>
            <tbody>
<?php
            foreach($topics as $topic) {
?>
        <!-- Si le résultat est un tableau, on génère une ligne par sujet retourné -->
                <tr>
                    <td class="center nb-right">
<?php
                    if ($topic['pseudo'] == $pseudo) {
?>
                        <a href="index.php?ctrl=Topic&action=toggle&id=<?=$topic['id_topic']?>">
<?php
                    }
?>
                        <i class="fas fa-<?=($topic['is_closed'] != '0') ? 'lock' : 'lock-open'?>"></i>
<?php
                    if ($topic['pseudo'] == $pseudo) {
?>
                        </a>
<?php
                    }
?>
                    </td>
                    <td class="left nb-left"><a href="index.php?ctrl=Post&action=list&id=<?=$topic['id_topic']?>"><?=$topic['title']?></a></td>
                    <td class="center"><?=ucwords($topic['pseudo'], "-_\t\r\n\f\v")?></td>
                    <td class="left"><a href="index.php?ctrl=Post&action=list&id=<?=$topic['id_topic']?>"><?=strlen($topic['description'])>64?substr($topic['description'],0,61)."...":$topic['description']?></a></td>
                    <td class="left"><?=date_format(new DateTime($topic['created_at']), "d/m/Y H:i")?></td>
                    <td class="center"><?=$topic['nb_posts']?></td>
                    <td class="center">
<?php
                    if (($topic['is_closed'] == '0') && ($topic['pseudo'] == $pseudo)) {
?>
                        <a href="index.php?ctrl=Topic&action=update&id=<?=$topic['id_topic']?>"><i class="fas fa-pen-square"></i></a>
<?php
                    }
?>
                        &nbsp;
<?php
                    if (($topic['is_closed'] == '0') && ($topic['pseudo'] == $pseudo)) {
                        if ($topic['nb_posts'] == 0) {
?>
                        <a href="index.php?ctrl=Topic&action=delete&id=<?=$topic['id_topic']?>" class="del-topic">
<?php
                        }
?>
                        <i class="fas fa-trash-alt"></i>
<?php
                    
                        if ($topic['nb_posts'] == 0) {
?>
                        </a>
<?php
                        }
                    }
?>
                    </td>
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
        <p><strong>No topics yet !</strong></p>

<?php
    }
    if(isset($_SESSION['user'])) {
?>
        <a class="button" href="index.php?ctrl=Topic&action=new">Add New Topic</a>
<?php
    }
?>
