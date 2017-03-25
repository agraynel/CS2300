    <!--
    CREDITS: All of the photos and background are from my roommate, Chuan Huang
        I downloaded from his loft: http://akimotoyasushi.lofter.com/
        Others were sent to me from him by e-mail
    -->

    <!-- header -->
    <?php 
    	include("header.php"); 
    	include("query.php");	
    ?>


    <div class="add_body">

        <div class="form_container">
            <h1>Add albums</h1>
            <form id = "add_form" name = "add_form" class = "form" method = "POST" action = "add.php" onsubmit = "return validateAlbum()">
                <div class="form_item">
                <h6>Album name: </h6>
                <input placeholder="Name your album" type="text" name="album_name" id = "album_name"/>
            </div>
            <div class="form_item">
                <h6>Introduction:</h6>
                <input placeholder="Introduce your album" type="text" name="album_intro" id = "album_intro"/>
            </div>
            <div class="form_item">
                <input id = "add_album" class="button" type = "submit" name = "add_album" value = "ADD"/> 
            </div>
            <!-- This is the place to sign the error!-->
            <h3 id="add_error_message" class="add_error_message"></h3>
            </form>
        </div>


        <div class="form_container">
            <h1>Upload photos</h1>
            <form method="post" id = "upload_photo" class = "form" enctype="multipart/form-data" onsubmit = "return validatePhoto()">
                <div class="form_item">
                    <h6>Photo name: </h6>
                    <input placeholder="Name your photo" type="text" name="photo_name" id = "photo_name">
                </div>
                <div class="form_item">
                    <h6>Browse: </h6>
                    <!--<input type="file" name="photo_file_upload" id = "photo_file_upload">
                        preview the upload image
                        http://stackoverflow.com/questions/4459379/preview-an-image-before-it-is-uploaded
                        thumbnails:
                        https://www.w3schools.com/css/tryit.asp?filename=trycss_ex_images_thumbnail
                    -->
                    <input type="file" name="photo_file_upload" id = "photo_file_upload" accept="image/*" onchange="loadFile(event)">         
                    <img id="output" class = "thumbnail" style="width:400px" src = "../assets/thumbnails.png" alt = "preview"/>
                    <script>
                        var loadFile = function(event) {
                            var reader = new FileReader();
                            reader.onload = function(){
                                var output = document.getElementById('output');
                                output.src = reader.result;
                            };
                            reader.readAsDataURL(event.target.files[0]);
                        };
                    </script>
                </div>
                <div class="form_item">
                    <h6>Introduction:</h6>
                <input placeholder="Introduce your photo" type="text" name="photo_intro" id = "photo_intro">
                </div>
                <div class="form_item">
                    <h6>Add to albums:</h6>
                    <?php 
                    //display all the albums here
                    $query = new Query();  
                    $all_albums = $query->get_all_albums(); 
                    foreach ($all_albums as $album){
                        $album_id = $album->get_id();
                        //this is the default album, will not displayed here. All photos will go into this album autimatically
                        if ($album_id == 1) continue;
                        echo "<input type = 'checkbox' name = 'display_albums[]' value =".$album_id.">". $album->get_name() ."<br>";  
                   } 
                    ?> 
                </div>
                <div class="form_item">
                    <input class = "button" type="submit" value="UPLOAD" name="upload" id = "upload">
                </div>
                <!-- This is the place to sign the error!-->
                <h3 id="add_error_message1" class="add_error_message"></h3>
            </form>
        </div>
    </div>


    <!-- CREDITS: lecture notes other course resources
    -->
    <?php 
        //add albums
        if (!empty($_POST['album_name']) && isset($_POST['add_album'])) {
            // filter: htmlentities
            //  because primary key is album_id, so we allow duplicate names 
            $name = htmlentities($_POST['album_name']);
            $intro = htmlentities($_POST['album_intro']);
            $album = new Albums(0, $name, 0, 0, $intro);
            $query1 = new Query();  
            $query1->insert_album($album);                     
        }

        //upload the photo
        if (isset($_POST['upload'])) {
            // filter: htmlentities 
            $name = htmlentities($_POST['photo_name']);
            $intro = htmlentities($_POST['photo_intro']);
            $file = $_FILES['photo_file_upload']; 
            $filename = $file['name'];
            //this is the file path to be added to the server
            $path = '../assets/'.$filename;
            //echo '<pre>'.print_r($path, true).'</pre>';
            //check if this file path has already exists! File paths do not allow duplicates.
            if (file_exists($path)) {
                echo '<script language="javascript">';
                //report file path exist error
                echo 'file_exist_error();';
                echo '</script>';
            } else {
                //I asked in Piazza and TA answered that I can set a default album.
                //All photos will go into the default album in query.php        
                $albums = array();
                if (isset($_POST['display_albums']))
                    foreach($_POST['display_albums'] as $album_id){
                        $albums[] = $album_id;
                    }
                //user will be implemented later in milestone 3
                $photo = new Photos(0, $name, 0, $filename, $intro, 1);
                move_uploaded_file($file['tmp_name'], "../assets/".$filename);
                $query3 = new Query();  
                $query3->upload($photo, $albums);
                echo '<script language="javascript">';
                echo 'photo_upload_text();';
                echo '</script>';
            }
        }
    ?>
    	</body>
    </html>
