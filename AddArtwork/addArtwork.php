<?php
    session_start();
?>

<!DOCTYPE html>
<html>

    <?php
        $is_admin = 0; 
        $email = $_SESSION['current_user'];
        //mi connetto al database
        $dbconn = pg_connect("host=localhost port=5432 dbname=smARTwandering user=postgres password=password") or die("Could not connect to postgres: " .preg_last_error());
        $query_admin = 'select admin from utente where email = $1';
        $user_admin = pg_fetch_array(pg_query_params($dbconn,$query_admin,array($email)), null , PGSQL_ASSOC)['admin']
                      or die ('Query failed: ' .preg_last_error());
        if ($user_admin == 't')
            $is_admin = 1; //se sono admin setto a 1 la variabile
    ?>

    <script>
        var admin = <?php echo $is_admin; ?>; //admin
        console.log(admin)
    </script>

    <head>
        <title>Add an artwork </title>
        <meta name ="viewport" content = "width-device-width, initial-scale=1"/>
        <link rel="stylesheet" href="style.css">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="addArtwork.css">
        <script type="text/javascript" lang="javascript" src="addArtwork.js"> </script>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body onload='return hide_if_is_not_admin();'> 
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
        <br>
        <br>
        <div class ="add">
           <h1> Add new artwork 🏛️</h1>
            <br>
            <form action="" method="POST" name="addArtwork" onsubmit="save_artwork()">
                <div id='userinfo'>
                    <div class="custom-select" style="width:200px;">
                        <select id='category' name="category">
                            <option value = "choose" selected> Choose a category </option>
                            <option value = "painting"> Painting </option>
                            <option value = "sculpture"> Sculpture </option>
                            <option value = "architecture"> Architecture </option>
                            <option value = "star"> * category </option> 
                        </select>
                    </div> <br>
                    <input type="text" id='name' name="name" size="30" maxlenght ="30" placeholder="Artwork title" required> <br>
                    <input type="text" id='author' name="author" placeholder="Artwork author" required> <br>    
                </div>

                <div id='admininfo'>
                    <input type="text" id='timePeriod' name="timePeriod" placeholder="TimePeriod" required><br>
    
                    <input type="text" id='dimensions' name="dimensions" placeholder="Dimensions" required><br>
    
                    <input type="text" id='vote' name="vote" placeholder="Vote (1-5)" required> <br>
                        
                    <input type="text" id='valutations' name="valutations" placeholder="Valutations" required><br> 
                                        
                    <input type="text" id='location' name="place" placeholder="Place and Address" required> <br>
                    
                    <input type="text" id='imm1' name="imm1" placeholder="https://image1.jpg" > <br>    
                    
                    <input type="text" id='imm2' name="imm2" placeholder="https://image2.jpg"> <br>    
    
                    <input type="text" id='imm3' name="imm3" placeholder="https://image3.jpg"> <br>    
                    
                    <input type="text" id='imm4' name="imm4" placeholder="https://image4.jpg"> <br>    
                    
                    <input type="text" id='imm5' name="imm5" placeholder="https://image5.jpg"> <br>    
                    
                    <input type="text" id='lat' name="latitude" placeholder="Latitude" required> <br>
                    
                    <input type="text" id='long' name="long" placeholder="Longitude" required> <br>
                    
                    <br>
                    <br> 
                    <br>
                </div>
                
                <input type="reset"value="Reset" id="reset_btn">
                <input type="submit" value="Submit" id="submit_btn">


                
            </form>
        </div>
        <div class="footer">
            <!-- footer bar -->
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
   
        <script>
           var selectitems, i, j, selectelem, divElem, itemElem, divItem;
            // seleziona tutti gli elementi del div
            selectitems = document.getElementsByClassName("custom-select");
            for (i = 0; i < selectitems.length; i++) {
              selectelem = selectitems[i].getElementsByTagName("select")[0];
              // per ogni select creo un div che si comporta come l'elemento stesso
              divElem = document.createElement("DIV");
              divElem.setAttribute("class", "select-selected");
              divElem.innerHTML = selectelem.options[selectelem.selectedIndex].innerHTML;
              // la select in questione deve essere figlia della select iniziale (se stessa)
              selectitems[i].appendChild(divElem);
              itemElem = document.createElement("DIV");
              itemElem.setAttribute("class", "select-items select-hide");
              // per ogni elemento di questa select creo un div che si comporti come l'elemento selezionato
              for (j = 1; j < selectelem.length; j++) {
                divItem = document.createElement("DIV");
                divItem.innerHTML = selectelem.options[j].innerHTML;
                divItem.addEventListener("click", function(e) {
                    // quando si clicca su un elemento deve essere aggiornato sia l'elemento che la select originale
                    var y, i, k, parent, sibling;
                    parent = this.parentNode.parentNode.getElementsByTagName("select")[0];
                    sibling = this.parentNode.previousSibling;
                    for (i = 0; i < parent.length; i++) {
                      if (parent.options[i].innerHTML == this.innerHTML) {
                        parent.selectedIndex = i;
                        sibling.innerHTML = this.innerHTML;
                        y = this.parentNode.getElementsByClassName("same-as-selected");
                        for (k = 0; k < y.length; k++) {
                          y[k].removeAttribute("class");
                        }
                        this.setAttribute("class", "same-as-selected");
                        break;
                      }
                    }
                    sibling.click();
                });
                itemElem.appendChild(divItem);
              }
              selectitems[i].appendChild(itemElem);
              divElem.addEventListener("click", function(e) {
                  // quando la select viene cliccata chiudo ogni altra select aperta ed apro solo questa
                  e.stopPropagation();
                  closeAllSelect(this);
                  this.nextSibling.classList.toggle("select-hide");
                  this.classList.toggle("select-arrow-active");
                });
            }
            function closeAllSelect(elmnt) {
              // chiudo tutti gli elementi aperti in altre select ad eccezione dell'elemento corrente
              var selectitems, y, i, arrNo = [];
              selectitems = document.getElementsByClassName("select-items");
              y = document.getElementsByClassName("select-selected");
              for (i = 0; i < y.length; i++) {
                if (elmnt == y[i]) {
                  arrNo.push(i)
                } else {
                  y[i].classList.remove("select-arrow-active");
                }
              }
              for (i = 0; i < selectitems.length; i++) {
                if (arrNo.indexOf(i)) {
                  selectitems[i].classList.add("select-hide");
                }
              }
            }
            // chiudo tutto sel l'utente clicca fuori da qualsiasi box
            document.addEventListener("click", closeAllSelect);
            </script>     
        </div>
        </body>
           
    
</html>