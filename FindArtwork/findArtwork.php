<html>
    <head> 
    <title>Search results</title>
    <meta name ="viewport" content = "width-device-width, initial-scale=1"/>
    <link rel ="stylesheet" href="findArtworkphp.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="findArtwork.js"></script>
    <style>
      .h1{
        position: relative;
        top: 70px;
        font-family: "Avenir", sans-serif;
        font-size: 50px;
        color: white;
        text-align: center;

        }

    table {
        background-color: white;
        border-collapse: collapse;
        width: 75%;
        margin-left: 12%;
        margin-bottom: 5%;
        position: absolute;
        }
    td {
        border-radius: 4px;
        text-align: left;
        padding: 8px;
        color: black;
        }
    th {
        border-radius: 4px;
        text-align: center;
        padding: 8px;
        background-color: #04001b;
        color: white;
    }


    tr:nth-child(even){background-color: rgba(206, 192, 176, 0.767);opacity: 0.8;};

    </style>
    </head>
    <body>
    <div class="tutto">
        <!-- menu bar -->
        <div class="w3-bar">
            <div class="element">
                <div class ="account">Account <img src="../Images/Microsoft_Account.svg.png" width="40" height="40">       

                <div class="dropdown-content">
                    <a href="../EditAccount/editAccount.php"> Edit Account </a>
                    <a href="../EditPassword/editPassword.php"> Edit Password</a>
                </div>  
                </div>
            </div>

            
            <input type="button" class="logo" id='btnHome' onclick="location.href='../WelcomeHomepage/welcomeHomepage.html'">
            
            <div class="menu">
                <a href="../Start visit/visit.php" class="element">Start visit or come back to your tour! 🗺️ </a>
                <a href ="../FindArtwork/findArtwork.html" class="element" >Look for an artwork 🔎</a>
                <a href ="../AddArtwork/addArtwork.php" class="element">Add an artwork 🖼️</a>
            </div>
        </div>
        
        <input type="button" class="link" onclick="location.href='findArtwork.html'">

        <div class="h1">🎨 Search results: </div>
        <br>
    <button class="btn btn-primary scroll-top" data-scroll="up" type="button">
    <i class="fa fa-chevron-up"></i>
    </button>
        
        <?php
            $dbconn = pg_connect("host=localhost port=5432
                dbname=smARTwandering user=postgres
                password=password")
            or die("Could not connect: " .pg_last_error());
            $nome = $_POST['searchName'];
            $autore = $_POST['searchAuthor'];
            $categoria = $_POST['category'];
            //interrogo il db per soddisfare ricerca

            if ($categoria!="all") {
                if ($nome!="" && $autore!="") {
                    $result = pg_query("SELECT nome, autore FROM opera where nome = '$nome' and categoria = '$categoria' and autore = '$autore'");
                }
                else if($nome!="" && $autore=="") {
                    $result = pg_query("SELECT nome, autore FROM opera where nome = '$nome' and categoria = '$categoria'");
                }
                else if($nome=="" && $autore!="") {
                    $result = pg_query("SELECT nome, autore FROM opera where autore = '$autore' and categoria = '$categoria'");
                }
                else if($nome=="" && $autore=="") {
                    $result = pg_query("SELECT nome, autore FROM opera where categoria = '$categoria'");
                }
            }
            else if ($categoria=="all" && $nome!=""){
                $result = pg_query("SELECT nome, autore FROM opera where nome = '$nome'");
            }
            else if ($categoria=="all" && $autore!=""){
                $result = pg_query("SELECT nome, autore FROM opera where autore = '$autore'");
            }
            else if ($categoria=="all" && $nome=="" && $autore==""){
                $result = pg_query("SELECT nome, autore FROM opera");
            }
            
            if(!($result)) { ?>
                <script> alert("An error occurred"); </script> <?php
                exit;
            }

            $conta = pg_num_rows($result);
            //se non trovo risultati
            if ($conta==0) { ?>
                <html><div class="contenitore">
                <span class="empty" align="center">
                    Oh no! No results found! <img src="../Images/delusa.gif" class="delusa">
                    <br>
                    You will be redirect back in <div class="empty_number" align="center" style="color: rgb(72, 168, 247);">5</div> seconds to try again!
                  
                    </html>
                <script>window.setTimeout ("location.href=('findArtwork.html')", 5000);</script>
                <?php

            }
            //se trovo risultati li organizzo in una tabella
            else{
                echo"<br>";
                echo "<br>";
                echo "
                    <table  cellpadding='0' cellspacing='1110' style='border-collapse: collapse'  width='532' height='23' id='AutoNumber1'>
                        <tr>
                        <th width='1000' height='23' align='center'>Artwork name</th>
                        <th width='1000' height='23' align='center'>Author</th>
                        <th width='1000' height='23' align='center'>Details</th>
                        </tr>";
            
                while ($row = pg_fetch_row($result)) {
                    $r0 = urlencode($row[0]);
                    $r1 = urlencode($row[1]);
                    echo "
                        <tr>
                        <td width='1000' height='23'>$row[0]</td>
                        <td width='1000' height='23'>$row[1]</td>
                        <td width='1000' height='23'><a href= ../ArtworkDetails/details.php?name=$r0&author=$r1> $row[0] Details </a></td>
                        </tr>";
                }
                echo "</table>";
            }
        

    
        ?>
       
            <!-- footer bar -->
            <div class="footer">
                <div id="social_sez" class="social_sez">
                    <h5>Follow us on:</h5>
                    <a href="https://www.facebook.com/Smart-Wandering-106566171072452/" class="fa fa-facebook"></a>
                    <a href="https://www.instagram.com/smartwanderinginrome/?hl=it" class="fa fa-instagram"></a>
                    <a href="#" class="fa fa-youtube-play"></a>
                </div>

                
                <div class="logo_sez" align="left">
                        <img id="foto_logo_sez" src="../Images/sapienza.png" alt="logo sapienza">
                </div>
                <div class="developers" class="footer_element">
                        <a href="../AboutUs/aboutUs.php" class="footer_element">About Us</a>
                        <a href="../ContactUs/contact_us.html" class="footer_element">Contact Us</a>
                </div>
            </div>
    </div>
    </body>
</html>