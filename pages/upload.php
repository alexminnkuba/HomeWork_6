<form action="index.php?page=2" method="POST" enctype="multipart/form-data">
    <label for="img"> Upload image from your device</label> <br>
        <input type="file" id="img" name="img" accept="image/*">  
        <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
        <br><br>
    <button type="submit" class="btn btn-primary">Upload</button>
</form>

<?php
if($_SERVER['REQUEST_METHOD'] === "POST") {
    $result = uploadFile("img");
    echo "<p class='mt-3 container col-6'>$result</p>";
}

?>