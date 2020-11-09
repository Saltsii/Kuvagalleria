<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}

?>
<?php include('inc/header.php'); ?>

<?php
$xml = simplexml_load_file('data/galleria.xml')
?>

<?php foreach ($xml->picture as $pic): ?>
    <div class="container">
        <div class="gallery">
            <div class="zoom">
                <img src="uploads/<?php echo $pic->file;?>" alt="kuva"/>
            </div>
            <div class="desc">
                <h2><?php echo $pic->author; ?></h2>
                <p><?php echo $pic->date; ?></p>
                <a href="delete.php">Poista</a>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php include('inc/footer.php'); ?>
