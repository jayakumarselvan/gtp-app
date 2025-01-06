<?php
    require_once("src/config.php");
    require_once("src/middleware.php");
    require_once("src/auth.php");
    authenticate();
    $userId = $_SESSION['user']["id"];
    $wishList = getMyWishes($userId);

    $userName = "Friend";
    $photoFrameFileName = "photo_frame";
    $subTitle = "Heartfelt 2025 Wishes from Your GTP Friends";

    if ( !empty($wishList) && isset($wishList[0]) && !empty($wishList[0]) && isset($wishList[0]["u_name"]) && !empty($wishList[0]["u_name"]) ){
        $userName = $wishList[0]["wu_name"];
        $photoFrameFileName = "GTP-2025-$userName-Wishes";
    }

    require_once("header.php");
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body, html {
        background: #f0f8ff;
    }

    .photo-frame {
        width: 900px;
        padding: 30px;
        background: linear-gradient(145deg, #ffffff, #e6e6e6);
        border: 8px solid #154985;
        border-radius: 20px;
        box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.3);
        margin: 20px auto;
        position: relative; /* Set position relative for absolute children */
    }

    .photo-frame h1 {
        font-size: 36px;
        text-align: center;
        margin: 0 0 10px 0;
        color: #2a4d69;
        font-family: "Arial", sans-serif;
    }

    .photo-frame h2 {
        font-size: 24px;
        text-align: center;
        margin: 0 0 20px 0;
        color: #5d737e;
        font-family: "Verdana", sans-serif;
    }

    .wish-container {
        margin: 20px 0;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    }

    .wish-container p {
        margin: 0;
        font-size: 18px;
        line-height: 1.6;
    }

    .wish-container .author {
        text-align: right;
        font-size: 16px;
        margin-top: 10px;
        font-style: italic;
    }

    .download-buttons {
        text-align: center;
        margin-top: 20px;
    }

    .download-buttons button {
        font-size: 16px;
        padding: 10px 20px;
        margin: 5px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        color: white;
    }

    .download-buttons .btn-image {
        background: #4CAF50;
    }

    .sub-title {
        color: #FF9800 !important;
    }

    /* Circle logo for watermark */
    .circle-logo {
        position: absolute;
        top: 10%;
        left: 10%;
        width: 100px;
        height: 100px;
        background-image: url('images/GTP-Circle.png'); /* Replace with your logo path */
        background-size: cover;
        border-radius: 50%;
        opacity: 0.3; /* Make it a watermark */
    }

    /* Rectangular logo at the bottom center */
    .rectangle-logo {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        width: 200px;
        height: 60px;
        background-image: url('images/logo.png'); /* Replace with your logo path */
        background-size: contain;
        background-repeat: no-repeat;
    }
</style>
<div class="container">
    <div class="photo-frame" id="photoFrame">
        <h1>Dear <?=$userName;?>,</h1>
        <h2 class="sub-title"><?=$subTitle;?></h2>
        <?php 
            if ( !empty($wishList) ){
                foreach($wishList as $wish){
                    ?>
                        <div class="wish-container">
                            <p><?=$wish["w_wish"];?></p>
                            <p class="author">- <?=$wish["wu_name"];?></p>
                        </div>
                    <?php
                }
            }
        ?>
        <br>
        <br>
        <div class="rectangle-logo"></div>
    </div>

    <div class="download-buttons">
        <button class="btn-image" onclick="downloadAsImage()">Download as Image</button>
    </div>
    </div>
</div>

<script>
    // Array containing background, font color, font style, and font family
    const styles = [
      { background: "#ACDDDE", font: "#000000", fontStyle: "normal", fontFamily: "Comic Sans MS" },
      { background: "#CAF1DE", font: "#000000", fontStyle: "normal", fontFamily: "Comic Sans MS" },
      { background: "#E1F8DC", font: "#000000", fontStyle: "normal", fontFamily: "Comic Sans MS" },
      { background: "#FEF8DD", font: "#000000", fontStyle: "normal", fontFamily: "Comic Sans MS" },
      { background: "#FFE7C7", font: "#000000", fontStyle: "normal", fontFamily: "Comic Sans MS" },
      { background: "#F7D8BA", font: "#000000", fontStyle: "normal", fontFamily: "Comic Sans MS" },
    ];

    // Apply styles in sequence
    function applyStyles() {
      const wishContainers = document.querySelectorAll('.wish-container');
      wishContainers.forEach((container, index) => {
        const style = styles[index % styles.length];
        container.style.background = style.background;
        container.style.color = style.font;
        container.style.fontStyle = style.fontStyle; // Apply font style
        container.style.fontFamily = style.fontFamily; // Apply font family
        if (style.fontStyle === "bold") {
          container.style.fontWeight = "bold";
        } else {
          container.style.fontWeight = "normal";
        }
      });
    }

    // Call the function to apply styles
    applyStyles();

    // Function to download the photo frame as an image
    function downloadAsImage() {
      const photoFrame = document.getElementById("photoFrame");
      html2canvas(photoFrame, {
        backgroundColor: null,
        scale: 2,
      }).then((canvas) => {
        const link = document.createElement("a");
        link.download = "<?=$photoFrameFileName;?>.png";
        link.href = canvas.toDataURL("image/png");
        link.click();
      });
    }
  </script>

<?php
require_once("footer.php");
?>