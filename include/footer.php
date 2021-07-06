    <!-- Footer -->
    <footer class="footer">
        <div class="inner">
            <b><a href="/admin/login" style="text-decoration: none; color: rgba(255, 255, 255, 0.25);">&copy;</a> SDCore <?php echo date("Y"); ?>. All rights reserved. &middot; Data updated every 6 hours.</b> <?php if(isset($_SESSION['user'])) { echo "<span style='float: right;'>".$_SESSION['username']." &middot; <a href='../admin/' style='color: rgba(255, 255, 255, 0.5); text-decoration: none;'>Admin</a> &middot; <a href='../logout' style='color: rgba(255, 255, 255, 0.5); text-decoration: none;'>Sign Out</a></span>"; } ?>
        </div>
    </footer>

    <script src="https://kit.fontawesome.com/f9aca975cb.js" crossorigin="anonymous"></script>
</body>

</html>
