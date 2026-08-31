<div class="side-navbar col-nav p-2" id="sidenavbar">
    <div class="d-flex">
        <div class="burger-icon" style="padding-left: 15px">
            <button type="button" class="btn btn-main d-flex justify-content-between align-items-center"
                onclick="burgerToogle()">
                <close-icon class="burger-icon-data"></close-icon>
            </button>
        </div>
        <p class="webname" id="limit-word" data="Muhammad Rafi Arsya">Muhammad Rafi Arsya</p>
        <p class="webname-mobile">Muhammad Rafi Arsya</p>
    </div>

    <div class="navbar-section">
        <button id="menu" data-id="home" type="button"
            class="btn btn-main btn-max d-flex align-items-center <?php if ($page == "home") { echo "active"; } ?>"
            onclick="setActive(this)">
            <span class="menu-icon"><home-icon class="menu-icon-data"></home-icon></span>
            <span>Home</span>
        </button>
        <button id="menu" data-id="blog" type="button"
            class="btn btn-main btn-max d-flex align-items-center <?php if ($page == "blog") { echo "active"; } ?>"
            onclick="setActive(this)">
            <span class="menu-icon"><blog-icon class="menu-icon-data"></blog-icon></span>
            <span>Blog</span>
        </button>
    </div>

    <div class="navbar-section">
        <p class="text-silent navtitle">Me</p>
        <button id="menu" data-id="resume" type="button"
            class="btn btn-main btn-max d-flex align-items-center <?php if ($page == "resume") { echo "active"; } ?>"
            onclick="setActive(this)">
            <span class="menu-icon"><resume-icon class="menu-icon-data"></resume-icon></span>
            <span>Resume / CV</span>
        </button>
        <button id="menu" data-id="course" type="button"
            class="btn btn-main btn-max d-flex align-items-center <?php if ($page == "course") { echo "active"; } ?>"
            onclick="setActive(this)">
            <span class="menu-icon"><taken-icon class="menu-icon-data"></taken-icon></span>
            <span>Course &amp; Certificate</span>
        </button>
        <button id="menu" data-id="contact" type="button"
            class="btn btn-main btn-max d-flex align-items-center <?php if ($page == "contact") { echo "active"; } ?>"
            onclick="setActive(this)">
            <span class="menu-icon"><contact-icon class="menu-icon-data"></contact-icon></span>
            <span>Contact</span>
        </button>
    </div>

    <div class="navbar-section">
        <p class="text-silent navtitle">Projects</p>
        <button id="menu" data-id="thoughtlog" type="button"
            class="btn btn-main btn-max d-flex align-items-center <?php if ($page == "thoughtlog") { echo "active"; } ?>"
            onclick="setActive(this)">
            <span class="menu-icov2"><blog-icon class="menu-icon-data"></blog-icon></span>
            <span>ThoughtLog</span>
        </button>
        <button id="menu" data-id="idfest" type="button"
            class="btn btn-main btn-max d-flex align-items-center <?php if ($page == "idfest") { echo "active"; } ?>"
            onclick="setActive(this)">
            <span class="menu-icov2"><website-icon class="menu-icon-data"></website-icon></span>
            <span>IDFEST</span>
        </button>
        <button id="menu" data-id="cropdisease" type="button"
            class="btn btn-main btn-max d-flex align-items-center <?php if ($page == "cropdisease") { echo "active"; } ?>"
            onclick="setActive(this)">
            <span class="menu-icov2"><robot-icon class="menu-icon-data"></robot-icon></span>
            <span>Crop Disease Detector</span>
        </button>
        <button id="menu" data-id="aievaldashboard" type="button"
            class="btn btn-main btn-max d-flex align-items-center <?php if ($page == "aievaldashboard") { echo "active"; } ?>"
            onclick="setActive(this)">
            <span class="menu-icov2"><robot-icon class="menu-icon-data"></robot-icon></span>
            <span>AI Eval Dashboard</span>
        </button>
        <button id="menu" data-id="digitrecognition" type="button"
            class="btn btn-main btn-max d-flex align-items-center <?php if ($page == "digitrecognition") { echo "active"; } ?>"
            onclick="setActive(this)">
            <span class="menu-icov2"><robot-icon class="menu-icon-data"></robot-icon></span>
            <span>AI Digit Recognizer</span>
        </button>
        <button id="menu" data-id="project" type="button"
            class="btn btn-main btn-max d-flex align-items-center <?php if ($page == "project") { echo "active"; } ?>"
            onclick="setActive(this)">
            <span class="menu-icon"><project-icon class="menu-icon-data"></project-icon></span>
            <span>All Projects</span>
        </button>
    </div>

    <div class="navbar-section">
        <p class="text-silent navtitle">Social</p>
        <a href="https://github.com/rafiarsya07" target="_blank" rel="noopener noreferrer" type="button"
            class="btn btn-main btn-max d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <svg data-src="icon/github.svg" class="menu-ico"></svg>
                <span>GitHub</span>
            </div>
            <div><arrow-icon class="togo-icon"></arrow-icon></div>
        </a>
        <a href="https://www.linkedin.com/in/muhammad-rafi-arsya-557335394/" target="_blank" rel="noopener noreferrer" type="button"
            class="btn btn-main btn-max d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <svg data-src="icon/linkedin.svg" class="menu-ico"></svg>
                <span>LinkedIn</span>
            </div>
            <div><arrow-icon class="togo-icon"></arrow-icon></div>
        </a>
        <a href="https://www.instagram.com/rarsya.03/" target="_blank" rel="noopener noreferrer" type="button"
            class="btn btn-main btn-max d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <svg data-src="icon/instagram.svg" class="menu-ico"></svg>
                <span>Instagram</span>
            </div>
            <div><arrow-icon class="togo-icon"></arrow-icon></div>
        </a>
    </div>
</div>
