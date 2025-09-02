<?php 
    $message = "";

    if(!empty($_POST["action"])) {
        $action = $_POST["action"];
        
        // execute delete if action is set to delete
        if($action == "delete") {
            $delfile = str_replace("/","_",$_POST["del-file"]);
            $deldir = "downloads/" . $delfile;
            if(!empty($delfile)) {
                if(unlink($deldir)) {
                    $message = "Succesfully delete $delfile!";
                }
                else {
                    $message = "$delfile didn't exist!";
                }
            }
        }
    }
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Midnight Downloader</title>
        
        <meta name="viewport" value="width=screen-width, scale=1.0">
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
        
        <style>
            .roboto-mono-regular {
              font-family: "Roboto Mono", monospace;
              font-optical-sizing: auto;
              font-weight: 400;
              font-style: normal;
            }
            .montserrat-regular {
              font-family: "Montserrat", sans-serif;
              font-optical-sizing: auto;
              font-weight: 400;
              font-style: normal;
            }
            .montserrat-bold {
              font-family: "Montserrat", sans-serif;
              font-optical-sizing: auto;
              font-weight: 700;
              font-style: normal;
            }
        
            html, body {
                margin: 0;
                box-sizing: border-box;
                background-color: #2c2d47;
            }
            header {
                color: white;
                background-color: #474747;
                padding: 20px;
            }
            main {
                color: white;
                position: relative;
                margin: auto;
                margin-top: 35px;
                width: 60%;
                text-align: center;
            }
            
            .app-title {
                font-size: 30px;
            }
            .section-box {
                border: 1px solid white;
            }
            .input-field {
                width: 50%;
                padding: 6px;
            }
            .field-submit {
                padding: 12px;
                background-color: #504280;
                color: white;
                border: none;
                cursor: pointer;
                margin: 10px;
            }
            .field-submit:hover {
                background-color: #615394;
            }
            .console {
                color: white;
                margin: auto;
                background-color: #474747;
                width: 95%;
            }
            .file-list {
                display: flex;
                background-color: #615394;
                padding: 12px;
                margin-bottom: 6px;
                text-align: left;
                justify-content: space-between;
            }
            .file-name {
                color: white;
                text-decoration: none;
            }
            
            .button-danger {
                padding: 6px;
                background-color: #8c0e12;
                color: white;
                text-decoration: none;
                cursor: pointer;
            }
            .button-danger:hover {
                background-color: #8c1e22;
            }
            
            .notice-box {
                padding: 10px;
                background-color: #d44c3d;
                border: 1px solid white;
                margin-bottom: 25px;
            }
        </style>
    </head>
    <body>
        <header>
            <a href=".." style="color: white;">Back to Midnight</a>
        </header>
        
        <main>
            <?php 
                if(!empty($message)) {
                    echo '<div class="notice-box montserrat-regular">';
                    echo $message;
                    echo '</div>';
                }
            ?>
            
            <p class="montserrat-bold app-title">
                Midnight Video Download Tool<br>
                <span style="font-size: 14px;" class="montserrat-regular">GUI By 2472008 (Chris26)</span>
            </p>
            <div class="section-box montserrat-regular">
                <form action="" method="POST">
                    <label for="video-source" class="montserrat-regular">Python Command:</label><br>
                    yt-dlp
                    <select id="video-type" name="video-type" style="padding: 6px;">
                        <option value="">auto</option>
                        <option value="-t mp4 ">mp4</option>
                        <option value="-t mp3 ">mp3</option>
                    </select>
                    <select id="video-quality" name="video-quality" style="padding: 6px;">
                        <option value="">best</option>
                        <option value="-S 'res:360' ">360p</option>
                        <option value="-S 'res:720' ">720p</option>
                        <option value="-S 'res:1080' ">1080p</option>
                        <option value="-S 'res:1440' ">1440p</option>
                    </select>
                    <input type="text" name="video-source" id="video-source" class="input-field" value="<?php echo $_POST["video-source"]; ?>">
                    
                    <br>
                    <input type="submit" value="Start Command" class="field-submit">
                </form>
                
                Console Output
                <textarea class="console roboto-mono-regular" rows="20" readonly><?php 
                    $url = str_replace(" & ","back",str_replace(" ; ","after",str_replace(" || ","atau",str_replace(" && ", "dan", $_POST["video-source"]))));
                    $type = str_replace(" & ","back",str_replace(" ; ","after",str_replace(" || ","atau",str_replace(" && ", "dan", $_POST["video-type"]))));
                    $quality = str_replace(" & ","back",str_replace(" ; ","after",str_replace(" || ","atau",str_replace(" && ", "dan", $_POST["video-quality"]))));
                    
                    // if url is defined, execute the command
                    if(!empty($url)) {
                        //echo passthru("source /home/christi5/virtualenv/public_subdomains/midnight/ytdl/3.11/bin/activate && yt-dlp -t $type $url");
                        //echo shell_exec("");
                        //echo shell_exec("cd .. && ls -all");
                        
                        while (@ ob_end_flush());
                        
                        //$proc = popen("source 3.11/bin/activate && cd downloads && ffmpeg -version", 'r');
                        $proc = popen("source 3.11/bin/activate && cd downloads && yt-dlp $type$quality$url", 'r');
                        while (!feof($proc))
                        {
                            echo fread($proc, 4096);
                            @ flush();
                        }
                    }
                    else {
                        echo "URL is empty, no command is executed";
                    }
                ?></textarea>
            </div>
            
            <p class="montserrat-bold" style="font-size: 20px;">Previously Downloaded Content:</p>
            <div class="section-box">
                <?php
                    foreach(array_diff(scandir("downloads"), array('.', '..', 'ffmpeg', 'ffprobe')) as $readname) {
                        echo '<div class="file-list montserrat-regular">';
                        echo "<a class=\"file-name\" href=\"downloads/$readname\" target=\"_blank\">$readname</a>";
                        echo "<form action=\"\" method=\"POST\"><input type=\"hidden\" name=\"del-file\" value=\"$readname\"><input type=\"submit\" class=\"button-danger\" name=\"action\" value=\"delete\"></form>";
                        echo "</div>";
                    }
                ?>
            </div>
        </main>
        
        <footer>
            
        </footer>
    </body>
</html>