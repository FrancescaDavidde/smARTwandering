<?php
    session_start();
?>

<?php
    $_SESSION = array();
    session_destroy();
    echo "<script>location.href='../Homepage/homepage.html'</script>";
?>