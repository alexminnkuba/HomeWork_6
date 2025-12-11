<h3>GALLERY</h3>
<p>Choose extention to show images</p>

<form action="index.php?page=3" method="POST">
    <select name="ext">
        <?php
        $path = 'images/';
        if ($dir = opendir($path)) {
            $ext_arr = [];

            while ($fname = readdir($dir)) {
                $coma = strrpos($fname, '.');
                $ext = substr($fname, $coma);
                if (!in_array($ext, $ext_arr) && $ext != '.') {
                    $ext_arr[] = $ext;
                    echo "<option>$ext</option>";
                }
            }
        }
        closedir($dir);
        ?>
    </select>
    <button type="submit" class="btn btn-primary">Show</button>
</form>

<?php
$files_arr = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ext = htmlspecialchars($_POST['ext']);
    $files_arr = glob("images/*$ext");
}
?>

<?php if (!empty($files_arr)): ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Gallery content</h3>
        </div>
        <?php foreach ($files_arr as $fname): ?>
            <a href="<?= $fname ?>">
                <img src="<?= $fname ?>" alt="<?= $fname ?>" class="img-polaroid" height="100px">
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>