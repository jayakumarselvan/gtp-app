<?php
    require_once("src/config.php");
    require_once("src/middleware.php");
    require_once("src/auth.php");
    authenticate();
    authorizeAdmin();
    
    $wishes = array();
    $wishes[] = array(
      "text" => "No wish found",
      "author" => "No Author"
    );
    if( isset( $_GET["userId"] ) && !empty( $_GET["userId"] ) ){
      $userId = $_GET["userId"];
      $userReceivedWishList = getMyReceivedWishList($userId);
      if ( !empty( $userReceivedWishList ) ){
        $wishes = array();
        foreach ($userReceivedWishList as $userReceivedWish) {
          $wishes[] = array(
            "text" => $userReceivedWish["wish"],
            "author" => $userReceivedWish["user_name"]
          );
          
        }
      }
    }

    require_once("header.php");
?>
<style>
    .wish-box {
      margin: 20px auto;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 10px;
      background-color: #fff; /* Default background */
      max-width: 1000px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      color: #fff; /* Default text color for contrast */
      min-height: 200px !important
    }

    .wish-author {
      text-align: right;
      display: none; /* Author hidden by default */
    }

    .buttons-container {
      margin-top: 20px; /* Space before buttons */
    }

    .wish-number {
      font-size: 0.9rem;
      color: #6c757d;
      /* margin-bottom: 10px; */
    }

    .wish-text{
      white-space: pre-wrap;
    }

    .button-box {
      text-align: center;
      margin-top: 20px; /* Space between the wish box and buttons */
    }

    
    .timer-row {
      max-width: 700px;
      margin-bottom: 15px; /* Add space between timers and the wish box */
    }

    .timer-info {
      font-size: 1rem;
      color: #555;
      margin: 0;
    }

    #timer {
      text-align: left; /* Align timer for the current wish to the left */
    }

    #fullTime {
      text-align: right; /* Align total time to the right */
    }

  </style>
<div class="container">

    <div class="row">
      <div class="col-md-5">
        <p id="timer" class="timer-info">Time for current wish: 0 sec</p> <!-- Timer for current wish -->
      </div>
      
      <div class="col-md-2">
        <p class="wish-number text-center" id="wishNumber"></p>
      </div>
      <div class="col-md-5">
        <p id="fullTime" class="timer-info">Total time: 0 sec</p> <!-- Total elapsed time -->
      </div>
    </div>
  
  <!-- Wish Box -->
  <div class="wish-box py-4" id="wishBox">
    
    <p class="wish-text fs-5" id="wishText" >Click "Next" to see the first wish!</p>
    <p class="wish-author" id="wishAuthor" style="display: none;">- Author</p>
  </div>

  <!-- Button Box -->
  <div class="button-box mt-3 text-center">
    <button class="btn btn-primary me-2" id="prevButton" disabled>Previous</button>
    <button class="btn btn-warning me-2" id="viewAuthorButton">View Author</button>
    <button class="btn btn-primary" id="nextButton">Next</button>
  </div>
</div>


<script>
  const unShuffledWishes = <?= json_encode($wishes); ?>;
  // console.log("unShuffledWishes: ", <?= json_encode($wishes); ?>);
  const wishes = shuffleArray(unShuffledWishes);
  // console.log("wishes: ", wishes);

  // Timer variables
  let currentWishTime = 0; // Time for the current wish in seconds
  let totalElapsedTime = 0; // Total time in seconds
  let timerInterval;

  // DOM Elements
  const timerElement = document.getElementById("timer");
  const fullTimeElement = document.getElementById("fullTime");
  const wishBoxElement = document.getElementById("wishBox");
  const wishTextElement = document.getElementById("wishText");
  const wishAuthorElement = document.getElementById("wishAuthor");
  const wishNumberElement = document.getElementById("wishNumber");
  const prevButton = document.getElementById("prevButton");
  const nextButton = document.getElementById("nextButton");
  const viewAuthorButton = document.getElementById("viewAuthorButton");

  let currentIndex = 0;

  // Function to format time as HH:MM:SS
  function formatTime(seconds) {
    const hours = Math.floor(seconds / 3600).toString().padStart(2, "0");
    const minutes = Math.floor((seconds % 3600) / 60).toString().padStart(2, "0");
    const secs = (seconds % 60).toString().padStart(2, "0");
    return `${hours}:${minutes}:${secs}`;
  }

  // Function to start the timer for the current wish
  function startTimer() {
    clearInterval(timerInterval); // Clear any existing timer
    currentWishTime = 0; // Reset the current wish timer
    timerInterval = setInterval(() => {
      currentWishTime++;
      totalElapsedTime++;
      timerElement.textContent = `Time for current wish: ${formatTime(currentWishTime)}`;
      fullTimeElement.textContent = `Total time: ${formatTime(totalElapsedTime)}`;
    }, 1000);
  }

  // Function to display the current wish
  function displayWish() {
    const currentWish = wishes[currentIndex];
    wishTextElement.textContent = currentWish.text;
    wishAuthorElement.style.display = "none"; // Hide author initially
    wishNumberElement.textContent = `${currentIndex + 1}/${wishes.length}`; // Update wish number

    // Set a random background color
    const backgroundColors = [
      "#432E54", "#003161", "#2E073F", "#7A1CAC",
      "#32012F", "#481E14", "#1B4242", "#116D6E", "#AA5486",
      "#2D3250", "#557A46", "#643843", "#7D0633",
      "#003C43", "#874CCC", "#FF6500", "#367E18", 
    ];
    

    const backgroundColors_1 = [
      "#1B263B", // Dark Blue Gray
      "#102027", // Very Dark Teal
      "#4A4E69", // Independence (Purple Gray)
      "#0D4C92", // Midnight Blue
      "#112D4E", // Dark Royal Blue
      "#4E342E", // Dark Brown
      "#3D155F", // Deep Violet
      "#274156", // Steel Teal
      "#003638", // Rich Pine Green
      "#3F0E40", // Dark Purple
      "#6A0572", // Mulberry
      "#78281F", // Deep Red
      "#154360", // Prussian Blue
      "#512E5F", // Eggplant Purple
      "#1A5276", // Sapphire
      "#283747", // Deep Charcoal Blue
      "#145A32", // Dark Forest Green
      "#512B2B", // Brick Red
      "#784212", // Burnt Umber
      "#154734", // Pine Green
      "#3E2723", // Dark Mahogany
      "#1A1F71", // Navy Indigo
      "#432371", // Deep Purple
      "#5D4037", // Cocoa Brown
      "#4A235A"  // Amethyst
    ];


    const randomColor = backgroundColors[Math.floor(Math.random() * backgroundColors.length)];
    wishBoxElement.style.backgroundColor = randomColor;
    wishBoxElement.style.color = "#fff"; // Set text color for better contrast

    // Disable/Enable Previous and Next buttons
    prevButton.disabled = currentIndex === 0;
    nextButton.disabled = currentIndex === wishes.length - 1;

    // Start the timer for the current wish
    startTimer();
  }

  // Function to display the author
  function displayAuthor() {
    const currentWish = wishes[currentIndex];
    wishAuthorElement.textContent = `- ${currentWish.author}`;
    wishAuthorElement.style.display = "block"; // Show author
  }

  // Event listener for the "Next" button
  nextButton.addEventListener("click", () => {
    if (currentIndex < wishes.length - 1) {
      currentIndex++;
      displayWish();
    }
  });

  // Event listener for the "Previous" button
  prevButton.addEventListener("click", () => {
    if (currentIndex > 0) {
      currentIndex--;
      displayWish();
    }
  });

  // Event listener for the "View Author" button
  viewAuthorButton.addEventListener("click", displayAuthor);

  // Initial wish display
  displayWish();

  function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
      const randomIndex = Math.floor(Math.random() * (i + 1)); // Random index from 0 to i
      [array[i], array[randomIndex]] = [array[randomIndex], array[i]]; // Swap elements
    }
    return array;
  }

</script>


<?php
require_once("footer.php");
?>