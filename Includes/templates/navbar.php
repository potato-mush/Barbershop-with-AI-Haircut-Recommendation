<?php session_start(); ?>
<?php include 'connect.php'; ?>

    
    <!-- START NAVBAR SECTION -->

    <header id="header" class="header-section">
        <div class="container">
            <nav class="navbar" style="display:flex; align-items:center; justify-content:space-between;">

    <!-- LOGO -->
    <a href="index.php" class="navbar-brand">
        <img src="Design/images/sana.png" alt="Logo">
    </a>

    <!-- MENU -->
    <ul style="display:flex; gap:30px; list-style:none; margin:0;">
        <li><a href="./#home-section">HOME</a></li>
        <li><a href="./#about">ABOUT</a></li>
        <li><a href="./#services">SERVICES</a></li>
        <li><a href="./#gallery">GALLERY</a></li>
        <li><a href="./#pricing">PRICING</a></li>
        <li><a href="./#contact-us">CONTACT</a></li>
    </ul>

    <!-- RIGHT SIDE -->
    <div style="display:flex; align-items:center; gap:15px; position:relative;">

        <a href="appointment.php" class="menu-btn">Make Appointment</a>

        <!-- White Bell -->
        <?php if(isset($_SESSION['user_id'])): 

    $user_id = $_SESSION['user_id'];
    
    // Auto mark notifications older than 1 day
$stmtExpire = $con->prepare("
    UPDATE notifications 
    SET is_read = 1 
    WHERE user_id = ? 
    AND is_read = 0 
    AND created_at <= NOW() - INTERVAL 1 DAY
");
$stmtExpire->execute([$_SESSION['user_id']]);

    // Get unread notification count
    $stmt = $con->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0");
    $stmt->execute([$user_id]);
    $notif_count = $stmt->fetchColumn();

?>
    <div style="position:relative;">
        <a href="#" id="notifBtn" class="notif-icon">
            <i class="fas fa-bell"></i>

            <?php if($notif_count > 0): ?>
                <span class="notif-badge" style="
                    position:absolute;
                    top:-3px;
                    right:-6px;
                    background:red;
                    color:white;
                    font-size:10px;
                    min-width:16px;
                    height:16px;
                    line-height:16px;
                    text-align:center;
                    border-radius:50%;
                    font-weight:bold;
                    transition: 0.2s ease;
                ">
                    <?php echo $notif_count; ?>
                </span>
            <?php endif; ?>
        </a>
    </div>
<?php endif; ?>

        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="logout.php" class="login-btn">Logout</a>
        <?php else: ?>
            <a href="login.php" class="login-btn">Login</a>
        <?php endif; ?>

        <!-- Notification Box -->
        <div id="notifBox" style="
    display:none;
    position:absolute;
    right:0;
    top:50px;
    background:white;
    width:300px;
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
    border-radius:8px;
    z-index:999;
    overflow:hidden;
">

<?php if(isset($_SESSION['user_id'])): 

    $stmt = $con->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    $notifications = $stmt->fetchAll();
?>

    <div class="notif-header">
    NOTIFICATIONS
</div>

<div class="notif-scroll">

        <?php if(count($notifications) > 0): ?>
            <?php foreach($notifications as $notif): ?>
                <div class="notif-item <?php echo $notif['is_read'] == 0 ? 'unread' : ''; ?>" 
                     data-id="<?php echo $notif['id']; ?>">
                    <?php echo $notif['message']; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="padding:15px;">No notifications yet.</div>
        <?php endif; ?>

    </div>

    <div class="notif-footer">
        <a href="appointment_status.php" class="menu-btn" style="padding:6px 10px; font-size:14px;">
            View My Appointment
        </a>
    </div>

<?php endif; ?>

</div>

    </div>

</nav>
        </div>
    </header>

	<div class="header-height" style="height: 80px;"></div>

    <!-- END NAVBAR SECTION -->

    <!-- START MOBILE NAVBAR -->
    
    <div id="menu_mobile" class="menu-mobile-menu-container">
        <ul class="mob-menu-top">
            <li class="menu-header">
                <a href="#">MENU</a>
            </li>
            <li style="display: inline-block;">
                <a class="mob-close-toggle" style="cursor: pointer;width: 75px;">
                    <i class="fas fa-times" style="color: white;"></i>
                </a>
            </li>
        </ul>
        <div class="menu-tab-div">
            <ul id="mobile-menu" class="menu">
                <li>
                    <a href="index.php#home-section" class="a-mob-menu">
                        HOME
                    </a>
                </li>
                <li>
                    <a href="index.php#about" class="a-mob-menu">
                        About Us
                    </a>
                </li>
                <li>
                    <a href="index.php#services" class="a-mob-menu">
                        Services
                    </a>
                </li>
                <li>
                    <a href="appointment.php" class="a-mob-menu">
                        Book Now
                    </a>
                </li>
                <li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <a href="logout.php" class="a-mob-menu">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="a-mob-menu">Login</a>
                    <?php endif; ?>
                </li>
                <li>
                    <a href="index.php#gallery" class="a-mob-menu">
                        GALLERY
                    </a>
                </li>
                <li>
                    <a href="index.php#pricing" class="a-mob-menu">
                        PRICING
                    </a>
                </li>
                <li>
                    <a href="index.php#contact-us" class="a-mob-menu">
                        Contact US
                    </a>
                </li>

            </ul>
        </div>
    </div>
   <script>
document.getElementById("notifBtn")?.addEventListener("click", function(e){
    e.preventDefault();
    var box = document.getElementById("notifBox");
    box.style.display = box.style.display === "block" ? "none" : "block";
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function(){

    document.querySelectorAll(".notif-item").forEach(function(item){

        item.addEventListener("click", function(){

            let notifId = this.getAttribute("data-id");

            fetch("mark_as_read.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "notif_id=" + notifId
            })
            .then(response => response.text())
            .then(data => {
    console.log(data);

    // Remove highlight
    this.classList.remove("unread");

    // Reduce badge manually
    let badge = document.querySelector(".notif-badge");
    if(badge){
        let count = parseInt(badge.innerText);

        if(count > 1){
            badge.innerText = count - 1;
        } else {
            badge.remove();
        }
    }
});
        });

    });

});
</script>

    <!-- END NAVBAR MOBILE -->