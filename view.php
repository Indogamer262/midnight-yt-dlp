<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Midnight Downloader - View</title>
        
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
                height: 100%;
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
            .button-normal {
                padding: 12px;
                background-color: #504280;
                color: white;
                border: none;
                cursor: pointer;
                margin: auto;
                margin-top: 10px;
                display: block;
                text-decoration: none;
                width: 80%;
                box-sizing: border-box;
            }
            .button-normal:hover {
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
            .video-preview {
                max-height: 640px;
            }
            
            @media only screen and (max-width: 720px) {
                main {
                    margin-top: 30px;
                    width: 92%;
                }
            }
        </style>
    </head>
    <body>
        <header>
            <a href="." style="color: white;">Back to Downloader</a>
        </header>
        
        <main>
            <p class="montserrat-bold app-title">
                Midnight Video Download Tool<br>
                <span style="font-size: 14px;" class="montserrat-regular"><?php $filename = str_replace("/","_",$_GET["file"]); echo $filename; ?></span>
            </p>
            <div class="section-box montserrat-regular">
                File Preview<br>
                <?php
                    // continue if file is exist
                    if(file_exists("downloads/$filename")) {
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                        
                        if($ext == "mp4" || $ext == "webm") {
                            echo "<video class=\"video-preview\" width=\"80%\" controls>
                              <source src=\"downloads/" . rawurlencode($filename) . "\" type=\"video/$ext\">
                              Browser issue playback.
                            </video>";
                        }
                        else if($ext = "mkv") {
                            echo "<video class=\"video-preview\" width=\"80%\" controls>
                              <source src=\"downloads/" . rawurlencode($filename) . "\" type=\"video/webm\">
                              Browser issue playback.
                            </video>";
                        }
                        else if($ext == "mp3" || $ext == "m4a") {
                            if($ext == "mp3") {
                                $atype = "mpeg";
                            }
                            else if($ext == m4a) {
                                $atype = "aac";
                            }
                            echo "<audio controls>
                                <source src=\"downloads/" . rawurlencode($filename). "\" type=\"audio/$atype\">
                                Browser issue playback.
                            </audio>";
                        }
                        else {
                            echo '<div class="notice-box">Cannot preview, format is not supported!</div>';
                        }
                        
                        array_push($_SESSION["ytdl_viewed"], $filename);
                        echo "<br><a class=\"button-normal\" href=\"downloads/" . rawurlencode($filename) . "\" download>Download</a>";
                    }
                    else {
                        echo '<div class="notice-box">File don\'t exist</div>';
                    }
                ?>
            </div>
            
            <p class="montserrat-regular">GUI By 2472008 (Chris26)</p>
        </main>
    </body>
</html>