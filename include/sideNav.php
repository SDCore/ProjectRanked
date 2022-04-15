<div class="sideNav">
    <a href="?PC" <?php if(platform() == "PC") { echo 'class="active"'; } ?>><i class="fab fa-steam"></i></a>
    <a href="?PlayStation" <?php if(platform() == "PS4") { echo 'class="active"'; } ?>><i class="fab fa-playstation"></i></a>
    <a href="?Xbox" <?php if(platform() == "X1") { echo 'class="active"'; } ?>><i class="fab fa-xbox"></i></a>
    <a href="?Switch" <?php if(platform() == "SWITCH") { echo 'class="active"'; } ?>><i class="fas fa-gamepad"></i></a>
</div>
