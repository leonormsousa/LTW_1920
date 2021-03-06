<section class="propertyShort">
    <?php 
        include_once("database/connection.php");
        include_once("database/habitations.php");
        $pictures=getHabitationPictures($habitation['idHabitacao']);

        if ($pictures != null){
            echo '<img src=' . $pictures[0]['urlImagem'] . ' alt=' . $pictures[0]['legenda'] . '>';
        }
        else{
            echo '<img src="images/ownerPicture.jpg" alt="Habitation Picture">';
        }

        $comments = getComments($habitation['idHabitacao']);
            $cleaning=0;
            $location=0;
            $value=0;
            $check_in=0;
            $rating=0;
            $n=0;
            foreach($comments as &$comment){
                $cleaning+= $comment['limpeza'];
                $location+= $comment['localizacao'];
                $value+= $comment['valor'];
                $check_in += $comment['checkIn'];
                $n++;
            }
            if ($n!=0){
                $location=$location/$n;
                $cleaning=$cleaning/$n;
                $value=$value/$n;
                $check_in=$check_in/$n;
                $rating=($location+$cleaning+$value+$check_in)/4;
            }
    ?>
    <div class="rightText">
        <h3><?=getNameType($habitation['idTipo'])['nome']?></h3>
        <h1><?=$habitation['nome']?></h1>     
        <div class="horizontalElements">
            <h3 id="rating"><?=$rating?> (<?=$n?> users)</h3>
            <a href="viewProperty.php?id=<?=$habitation['idHabitacao']?>" class="submit"> <p> View </p> </a>
            <a href="templates/forms/removeProperty_action.php?id=<?=$habitation['idHabitacao']?>" class="submit"><p>Remove</p></a>
            <a href="editProperty.php?id=<?=$habitation['idHabitacao']?>" class="submit"><p>Edit</p></a>
            <a href="listReservationsByProperty.php?id=<?=$habitation['idHabitacao']?>" class="submit"><p>View Reservations</p></a>
        </div>
    </div>
</section>