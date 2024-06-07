<header>
    <div class="navbar">
        <div class="icon" width="129" height="31">
            <a href="index.php">
                <img src="images/logo.svg" alt="ONAYOqU">
            </a>
        </div>
        <div class="links">
            <ul>
                <li><a href="#" >Main</a></li>
                <li><a href="universities.php" >Universities</a></li>
                <li><a href="#" >More</a></li>
            </ul>
        </div>
        <?php if (!empty($_SESSION['userlogin'])):?>
            <a href="../onayoqu/profilepage.php">
                <div class="profile-btn">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAABXElEQVR4nM2VPUtDMRSGH8QiCKKiqw6iv0BcpKP4cZ3dnVw7FUF3ETcHBaHgKDoq/gOnoqtbJx1qXXQQpXBRjpxIKEnuTdrBB86SvOd9Q25uAuUYAbaAO+Ae2AFGGQBzwCHwCnz31BtwrJoohoAMuAVyy7AJbGs1rfFctZn2ehkHakDLav4CroAVh34ROAM+LL307gLTScLAwuSbPDoWVhXBEnAOfPYExNKy+m2vP6aAumuiJKavrl5en34DDIUBHcfR9FUnJSC1SgcsuyY9VMsGVAbwDSoh0YGKugkBXe0VDy/PKvr9QSIx2/QUEplLbS0hYF17X0KiI2svGxHmDatPbl8vwxqS657OlzBfUG2u5uJRyKWu5rrgCpa5G9VeEMEs8K6NJ54QGTu1Hp8ZItm0jt4DsAGMaWU6Zo60zCWxCrQD10Lb8xhFMQns64rlUZKSh38PmOjX/P/zAxEMpSCI7/u4AAAAAElFTkSuQmCC">
                </div>
            </a>


        <?php else: ?>
            <a href="registrationform.php" class="registrationelement">
                <div class="registration-btn">
                    Register
                </div>
            </a>
        <?php endif; ?>
    </div>
</header>